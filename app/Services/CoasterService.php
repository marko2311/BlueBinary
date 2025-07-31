<?php

namespace App\Services;

use App\DTO\Coaster\RegisterCoasterDTO;
use App\DTO\Coaster\UpdateCoasterDTO;
use App\Repositories\CoasterRepository;
use RuntimeException;

class CoasterService
{
    public function __construct(
        private readonly CoasterRepository $repository
    ) {}

    public function registerCoaster(RegisterCoasterDTO $dto): void
    {
        if ($this->repository->exists($dto->getId())) {
            throw new RuntimeException("Coaster with ID {$dto->getId()} already exists.");
        }

        $this->repository->save($dto);
    }

    public function updateCoaster(UpdateCoasterDTO $dto): void
    {
        $existing = $this->repository->find($dto->getId());

        if (!$existing) {
            throw new RuntimeException("Cannot find registered coaster.");
        }

        $updated = new RegisterCoasterDTO(
            id: $dto->getId(),
            staffCount: $dto->getStaffCount() ?? $existing->getStaffCount(),
            dailyCustomerCount: $dto->getDailyCustomerCount() ?? $existing->getDailyCustomerCount(),
            trackLength: $existing->getTrackLength(),
            hoursFrom: $dto->getHoursFrom() ?? $existing->getHoursFrom(),
            hoursTo: $dto->getHoursTo() ?? $existing->getHoursTo(),
        );

        $this->repository->save($updated);
    }

    /**
     * @return RegisterCoasterDTO[]
     */
    public function getAllCoasters(): array
    {
        return $this->repository->findAll();
    }

    public function getCoaster(string $id): RegisterCoasterDTO
    {
        $coaster = $this->repository->find($id);

        if (!$coaster) {
            throw new RuntimeException("Coaster with ID $id not found.");
        }

        return $coaster;
    }

    public function deleteCoaster(string $id): void
    {
        if (!$this->repository->exists($id)) {
            throw new RuntimeException("Cannot delete non-existing coaster with ID $id");
        }

        $this->repository->delete($id);
    }
}
