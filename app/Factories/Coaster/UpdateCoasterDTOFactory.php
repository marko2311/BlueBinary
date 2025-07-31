<?php

namespace App\Factories\Coaster;

use App\DTO\Coaster\UpdateCoasterDTO;
use App\Constants\CoasterFields;

class UpdateCoasterDTOFactory
{
    public static function create(string $id,array $data): UpdateCoasterDTO
    {
        return new UpdateCoasterDTO(
            id: $id,
            staffCount: $data[CoasterFields::STAFF_COUNT] ?? null,
            dailyCustomerCount: $data[CoasterFields::DAILY_CUSTOMER_COUNT] ?? null,
            hoursFrom: $data[CoasterFields::HOURS_FROM] ?? null,
            hoursTo: $data[CoasterFields::HOURS_TO] ?? null
        );
    }
}
