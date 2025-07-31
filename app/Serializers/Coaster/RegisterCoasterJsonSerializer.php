<?php

namespace App\Serializers\Coaster;

use App\Constants\CoasterFields;
use App\DTO\Coaster\RegisterCoasterDTO;
use App\Factories\Coaster\RegisterCoasterDTOFactory;
use App\DTO\Coaster\CoasterDTOInterface;

class RegisterCoasterJsonSerializer implements CoasterSerializerInterface
{
    public function serialize(CoasterDTOInterface $dto): string
    {
        /** @var RegisterCoasterDTO $dto */
        return json_encode([
            CoasterFields::ID => $dto->getId(),
            CoasterFields::STAFF_COUNT => $dto->getStaffCount(),
            CoasterFields::DAILY_CUSTOMER_COUNT => $dto->getDailyCustomerCount(),
            CoasterFields::TRACK_LENGTH => $dto->getTrackLength(),
            CoasterFields::HOURS_FROM => $dto->getHoursFrom(),
            CoasterFields::HOURS_TO => $dto->getHoursTo(),
        ]);
    }

    public function deserialize(string $json): RegisterCoasterDTO
    {
        $data = json_decode($json, true);

        return RegisterCoasterDTOFactory::create($data);
    }

    public function checkDTO(CoasterDTOInterface $dto): bool
    {
        return $dto instanceof RegisterCoasterDTO;

    }
}

