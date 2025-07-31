<?php

namespace App\Factories;

use App\DTO\Coaster\RegisterCoasterDTO;
use App\DTO\Wagon\RegisterWagonDTO;
use App\DTO\CoasterStatusDTO;

class CoasterStatusDTOFactory
{
    /**
     * @param RegisterCoasterDTO $coaster
     * @param RegisterWagonDTO[] $wagons
     * @return CoasterStatusDTO
     */
    public static function create(RegisterCoasterDTO $coaster, array $wagons): CoasterStatusDTO
    {
        return new CoasterStatusDTO($coaster, $wagons);
    }
}
