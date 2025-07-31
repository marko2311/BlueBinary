<?php

namespace App\Factories\Coaster;

use App\Constants\CoasterFields;
use App\DTO\Coaster\RegisterCoasterDTO;

class RegisterCoasterDTOFactory
{
    public static function create(array $data): RegisterCoasterDTO
    {
        return new RegisterCoasterDTO(
            id: $data[CoasterFields::ID],
            staffCount: $data[CoasterFields::STAFF_COUNT],
            dailyCustomerCount: $data[CoasterFields::DAILY_CUSTOMER_COUNT],
            trackLength: $data[CoasterFields::TRACK_LENGTH],
            hoursFrom: $data[CoasterFields::HOURS_FROM],
            hoursTo: $data[CoasterFields::HOURS_TO],
        );
    }
}
