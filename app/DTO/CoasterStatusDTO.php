<?php

namespace App\DTO;

use App\DTO\Coaster\RegisterCoasterDTO;
use App\DTO\Wagon\RegisterWagonDTO;

readonly class CoasterStatusDTO
{
    public function __construct(
        protected RegisterCoasterDTO $coaster,
        /** @var RegisterWagonDTO[] */
        protected array              $wagons
    ) {}

    public function getCoaster(): RegisterCoasterDTO
    {
        return $this->coaster;
    }

    public function getWagons(): array
    {
        return $this->wagons;
    }
}
