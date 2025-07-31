<?php

namespace App\DTO;

readonly class StatusReportDTO
{
    public function __construct(
        protected string  $coasterId,
        protected string  $startHour,
        protected string  $endHour,
        protected int     $wagonCount,
        protected int     $availableStaff,
        protected int     $requiredStaff,
        protected int     $plannedClients,
        protected int     $maxClients,
        protected ?string $problem = null
    ) {}

    public function getCoasterId(): string
    {
        return $this->coasterId;
    }

    public function getStartHour(): string
    {
        return $this->startHour;
    }

    public function getEndHour(): string
    {
        return $this->endHour;
    }

    public function getWagonCount(): int
    {
        return $this->wagonCount;
    }

    public function getAvailableStaff(): int
    {
        return $this->availableStaff;
    }

    public function getRequiredStaff(): int
    {
        return $this->requiredStaff;
    }

    public function getPlannedClients(): int
    {
        return $this->plannedClients;
    }

    public function getMaxClients(): int
    {
        return $this->maxClients;
    }

    public function getProblem(): ?string
    {
        return $this->problem;
    }

    public function hasProblem(): bool
    {
        return $this->problem !== null;
    }
}
