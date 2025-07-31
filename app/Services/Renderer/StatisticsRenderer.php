<?php

namespace App\Services\Renderer;

use App\DTO\StatusReportDTO;

class StatisticsRenderer
{
    /**
     * @param StatusReportDTO[] $reports
     */
    public function render(array $reports): void
    {
        $this->clearScreen();

        echo '[Time ' . date('H:i') . ']' . PHP_EOL . PHP_EOL;

        foreach ($reports as $report) {
            echo '[Coaster ' . $report->getCoasterId() . ']' . PHP_EOL;
            echo '1. Operating hours: ' . $report->getStartHour() . ' - ' . $report->getEndHour() . PHP_EOL;
            echo '2. Wagons: ' . $report->getWagonCount() . PHP_EOL;
            echo '3. Staff: ' . $report->getAvailableStaff() . ' / ' . $report->getRequiredStaff() . PHP_EOL;
            echo '4. Clients (planned / possible): ' . $report->getPlannedClients() . ' / ' . $report->getMaxClients() . PHP_EOL;
            echo '5. ' . ($report->hasProblem()
                    ? 'Problem: ' . $report->getProblem()
                    : 'Status: OK') . PHP_EOL;
            echo PHP_EOL;
        }
    }

    private function clearScreen(): void
    {
        // ANSI escape sequence to clear the screen
        echo chr(27) . "[2J" . chr(27) . "[;H";
    }
}
