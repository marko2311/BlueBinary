<?php

namespace App\Services;

use React\EventLoop\LoopInterface;
use App\Services\Status\CoasterStatusProvider;
use App\Services\Status\StatusAnalyzer;
use App\DTO\StatusReportDTO;
use App\Services\Renderer\StatisticsRenderer;
use App\Services\Logger\ProblemLogger;

class MonitorService
{
    public function __construct(
        private readonly LoopInterface $loop,
        private readonly CoasterStatusProvider $statusProvider,
        private readonly StatusAnalyzer $analyzer,
        private readonly StatisticsRenderer $renderer,
        private readonly ProblemLogger $logger
    ) {}

    public function run(int $intervalSeconds = 5): void
    {
        $this->loop->addPeriodicTimer($intervalSeconds, function () {
            $this->checkSystemStatus();
        });
    }

    private function checkSystemStatus(): void
    {
        $this->statusProvider->getAll()->then(function (array $coasterStatuses) {
            $reports = array_map(fn($status) => $this->analyzer->analyze($status), $coasterStatuses);

            $this->renderer->render($reports);

            foreach ($reports as $report) {
                $this->logger->log($report);
            }
        });
    }
}
