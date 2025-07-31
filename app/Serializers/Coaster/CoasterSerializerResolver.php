<?php

namespace App\Serializers\Coaster;

use App\DTO\Coaster\CoasterDTOInterface;
use App\DTO\Coaster\RegisterCoasterDTO;
use App\DTO\Coaster\UpdateCoasterDTO;

class CoasterSerializerResolver
{
    public function resolve(CoasterDTOInterface $dto): CoasterSerializerInterface
    {
        return match (true) {
            $dto instanceof RegisterCoasterDTO => $this->getRegisterCoasterJsonSerializer(),
            $dto instanceof UpdateCoasterDTO   => $this->getUpdateCoasterJsonSerializer(),
            default => throw new \InvalidArgumentException('Unknown DTO type for serializer'),
        };
    }

    public function getUpdateCoasterJsonSerializer(): UpdateCoasterJsonSerializer
    {
        return new UpdateCoasterJsonSerializer();
    }

    public function getRegisterCoasterJsonSerializer(): RegisterCoasterJsonSerializer
    {
        return new RegisterCoasterJsonSerializer();
    }
}
