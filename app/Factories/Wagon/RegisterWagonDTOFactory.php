<?php

namespace App\Factories\Wagon;

use App\Constants\WagonFields;
use App\DTO\Wagon\RegisterWagonDTO;

class RegisterWagonDTOFactory
{
    public static function create(array $data): RegisterWagonDTO
    {
        return new RegisterWagonDTO(
            id: $data[WagonFields::ID],
            coasterId: $data[WagonFields::COASTER_ID],
            seatCount: $data[WagonFields::SEAT_COUNT],
            speed: $data[WagonFields::SPEED]
        );
    }
}
