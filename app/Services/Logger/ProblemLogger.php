<?php

namespace App\Services\Logger;

use App\DTO\StatusReportDTO;

class ProblemLogger
{
    private string $logPath;

    public function __construct(string $logPath)
    {
        $this->logPath = $logPath;
    }

    public function log(StatusReportDTO $report): void
    {
        if (!$report->hasProblem()) {
            return;
        }

        $timestamp = date('[Y-m-d H:i:s]');
        $entry = sprintf(
            "%s Coaster %s - Problem: %s%s",
            $timestamp,
            $report->getCoasterId(),
            $report->getProblem(),
            PHP_EOL
        );

        file_put_contents($this->logPath, $entry, FILE_APPEND);
    }
}
