<?php

namespace App\Serializers\Wagon;

use App\DTO\Wagon\WagonDTOInterface;
use App\DTO\Wagon\RegisterWagonDTO;

class WagonSerializerResolver
{
    public function resolve(WagonDTOInterface $dto): WagonSerializerInterface
    {
        return match (true) {
            $dto instanceof RegisterWagonDTO => $this->getRegisterWagonJsonSerializer(),
            default => throw new \InvalidArgumentException('Unknown DTO type for serializer'),
        };
    }

    public function getRegisterWagonJsonSerializer(): RegisterWagonJsonSerializer
    {
        return new RegisterWagonJsonSerializer();
    }
}
