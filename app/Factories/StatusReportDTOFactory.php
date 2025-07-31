<?php

namespace App\Factories;

use App\DTO\StatusReportDTO;

class StatusReportDTOFactory
{
    public function create(
        string $coasterId,
        string $startHour,
        string $endHour,
        int $wagonCount,
        int $availableStaff,
        int $requiredStaff,
        int $plannedClients,
        int $maxClients,
        ?string $problem = null
    ): StatusReportDTO {
        return new StatusReportDTO(
            coasterId: $coasterId,
            startHour: $startHour,
            endHour: $endHour,
            wagonCount: $wagonCount,
            availableStaff: $availableStaff,
            requiredStaff: $requiredStaff,
            plannedClients: $plannedClients,
            maxClients: $maxClients,
            problem: $problem
        );
    }
}
