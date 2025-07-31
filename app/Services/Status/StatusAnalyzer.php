<?php

namespace App\Services\Status;

use App\DTO\CoasterStatusDTO;
use App\DTO\StatusReportDTO;
use DateTime;

class StatusAnalyzer
{
    public function analyze(CoasterStatusDTO $dto): StatusReportDTO
    {
        $coaster = $dto->getCoaster();

        $operatingTimeInSeconds = $this->calculateOperatingTimeInSeconds(
            $coaster->getHoursFrom(),
            $coaster->getHoursTo()
        );

        [$maxClientCapacity, $requiredStaff] = $this->calculateClientCapacityAndStaff(
            $dto,
            $operatingTimeInSeconds
        );

        $problem = $this->detectProblems(
            availableStaff: $coaster->getStaffCount(),
            requiredStaff: $requiredStaff,
            maxClientCapacity: $maxClientCapacity,
            plannedClients: $coaster->getDailyCustomerCount()
        );

        return $this->buildReport(
            $dto,
            $maxClientCapacity,
            $requiredStaff,
            $problem
        );
    }

    private function calculateOperatingTimeInSeconds(string $start, string $end): int
    {
        $from = DateTime::createFromFormat('H:i', $start);
        $to = DateTime::createFromFormat('H:i', $end);
        return $to->getTimestamp() - $from->getTimestamp();
    }

    private function calculateClientCapacityAndStaff(CoasterStatusDTO $dto, int $operatingTime): array
    {
        $coaster = $dto->getCoaster();
        $wagons = $dto->getWagons();

        $trackLength = $coaster->getTrackLength(); // in meters
        $clientCapacity = 0;
        $staff = 1; // 1 required for the coaster itself

        foreach ($wagons as $wagon) {
            $tripDuration = ($trackLength * 2) / $wagon->getSpeed(); // in seconds
            $totalTripTime = $tripDuration + 300; // 5-minute cooldown
            $tripCount = floor($operatingTime / $totalTripTime);

            $clientCapacity += $tripCount * $wagon->getSeatCount();
            $staff += 2; // 2 per wagon
        }

        return [$clientCapacity, $staff];
    }

    private function detectProblems(
        int $availableStaff,
        int $requiredStaff,
        int $maxClientCapacity,
        int $plannedClients
    ): ?string {
        $issues = [];

        if ($availableStaff < $requiredStaff) {
            $issues[] = 'Missing ' . ($requiredStaff - $availableStaff) . ' staff';
        } elseif ($availableStaff > 2 * $requiredStaff) {
            $issues[] = 'Excess ' . ($availableStaff - $requiredStaff) . ' staff';
        }

        if ($maxClientCapacity < $plannedClients) {
            $issues[] = "Insufficient capacity – only $maxClientCapacity clients per day";
        } elseif ($maxClientCapacity > 2 * $plannedClients) {
            $issues[] = "Overcapacity – up to $maxClientCapacity clients per day";
        }

        return empty($issues) ? null : implode(', ', $issues);
    }

    private function buildReport(
        CoasterStatusDTO $dto,
        int $maxClientCapacity,
        int $requiredStaff,
        ?string $problem
    ): StatusReportDTO {
        $coaster = $dto->getCoaster();

        return new StatusReportDTO(
            coasterId: $coaster->getId(),
            startHour: $coaster->getHoursFrom(),
            endHour: $coaster->getHoursTo(),
            wagonCount: count($dto->getWagons()),
            availableStaff: $coaster->getStaffCount(),
            requiredStaff: $requiredStaff,
            plannedClients: $coaster->getDailyCustomerCount(),
            maxClients: $maxClientCapacity,
            problem: $problem
        );
    }
}
