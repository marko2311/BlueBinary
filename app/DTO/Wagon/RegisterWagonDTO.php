<?php

namespace App\DTO\Wagon;

use App\DTO\Wagon\WagonDTOInterface;

readonly class RegisterWagonDTO implements WagonDTOInterface
{
    public function __construct(
        protected string $id,
        protected string $coasterId,
        protected int    $seatCount,
        protected float  $speed
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getCoasterId(): string
    {
        return $this->coasterId;
    }

    public function getSeatCount(): int
    {
        return $this->seatCount;
    }

    public function getSpeed(): float
    {
        return $this->speed;
    }
}
