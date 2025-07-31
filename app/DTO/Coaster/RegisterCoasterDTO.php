<?php

namespace App\DTO\Coaster;

readonly class RegisterCoasterDTO implements CoasterDTOInterface
{
    public function __construct(
        protected string $id,
        protected int    $staffCount,
        protected int    $dailyCustomerCount,
        protected int    $trackLength,
        protected string $hoursFrom,
        protected string $hoursTo,
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getStaffCount(): int
    {
        return $this->staffCount;
    }

    public function getDailyCustomerCount(): int
    {
        return $this->dailyCustomerCount;
    }

    public function getTrackLength(): int
    {
        return $this->trackLength;
    }

    public function getHoursFrom(): string
    {
        return $this->hoursFrom;
    }

    public function getHoursTo(): string
    {
        return $this->hoursTo;
    }
}
