<?php

namespace App\Services;

use App\DTO\Wagon\RegisterWagonDTO;
use App\Repositories\WagonRepository;
use RuntimeException;

class WagonService
{
    public function __construct(
        private readonly WagonRepository $repository
    ) {}

    public function registerWagon(string $coasterId, RegisterWagonDTO $dto): void
    {
        if ($this->repository->exists($coasterId, $dto->getId())) {
            throw new RuntimeException("Wagon '{$dto->getId()}' already exists for coaster '$coasterId'");
        }

        $this->repository->save($coasterId, $dto);
    }

    public function deleteWagon(string $coasterId, string $wagonId): void
    {
        if (!$this->repository->exists($coasterId, $wagonId)) {
            throw new RuntimeException("Wagon '$wagonId' not found for coaster '$coasterId'");
        }

        $this->repository->delete($coasterId, $wagonId);
    }
}
