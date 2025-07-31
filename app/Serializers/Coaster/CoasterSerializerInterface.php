<?php

namespace App\Serializers\Coaster;

use App\DTO\Coaster\CoasterDTOInterface;

interface CoasterSerializerInterface
{
    public function serialize(CoasterDTOInterface $dto): string;
    public function deserialize(string $json): CoasterDTOInterface;

    public function checkDTO(CoasterDTOInterface $dto): bool;
}
