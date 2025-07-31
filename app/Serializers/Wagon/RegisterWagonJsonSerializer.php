<?php

namespace App\Serializers\Wagon;

use App\Constants\WagonFields;
use App\DTO\Wagon\RegisterWagonDTO;
use App\DTO\Wagon\WagonDTOInterface;
use App\Factories\Wagon\RegisterWagonDTOFactory;

class RegisterWagonJsonSerializer implements WagonSerializerInterface
{
    public function serialize(WagonDTOInterface $dto): string
    {
        /** @var RegisterWagonDTO $dto */
        return json_encode([
            WagonFields::ID         => $dto->getId(),
            WagonFields::COASTER_ID => $dto->getCoasterId(),
            WagonFields::SEAT_COUNT => $dto->getSeatCount(),
            WagonFields::SPEED      => $dto->getSpeed(),
        ]);
    }

    public function deserialize(string $json): RegisterWagonDTO
    {
        $data = json_decode($json, true);

        return RegisterWagonDTOFactory::create($data);
    }

    public function checkDTO(WagonDTOInterface $dto): bool
    {
        return $dto instanceof RegisterWagonDTO;
    }
}
