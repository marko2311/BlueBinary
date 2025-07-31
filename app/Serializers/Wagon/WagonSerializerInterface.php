<?php

namespace App\Serializers\Wagon;

use App\DTO\Wagon\WagonDTOInterface;

interface WagonSerializerInterface
{
    public function serialize(WagonDTOInterface $dto): string;
    public function deserialize(string $json): WagonDTOInterface;
}
