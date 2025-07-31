<?php

namespace App\Serializers\Coaster;

use App\Constants\CoasterFields;
use App\DTO\Coaster\RegisterCoasterDTO;
use App\DTO\Coaster\UpdateCoasterDTO;
use App\DTO\Coaster\CoasterDTOInterface;
use App\Factories\Coaster\UpdateCoasterDTOFactory;

class UpdateCoasterJsonSerializer implements CoasterSerializerInterface
{
    public function serialize(CoasterDTOInterface $dto): string
    {
        /** @var UpdateCoasterDTO $dto */
        return json_encode([
            CoasterFields::ID => $dto->getId(),
            CoasterFields::STAFF_COUNT => $dto->getStaffCount(),
            CoasterFields::DAILY_CUSTOMER_COUNT => $dto->getDailyCustomerCount(),
            CoasterFields::HOURS_FROM => $dto->getHoursFrom(),
            CoasterFields::HOURS_TO => $dto->getHoursTo(),
        ]);
    }

    public function deserialize(string $json): UpdateCoasterDTO
    {
        $data = json_decode($json, true);

        return UpdateCoasterDTOFactory::create($data['id'], $data);
    }

    public function checkDTO(CoasterDTOInterface $dto): bool
    {
        return $dto instanceof UpdateCoasterDTO;

    }
}

