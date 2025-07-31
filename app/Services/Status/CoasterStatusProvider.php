<?php

namespace App\Services\Status;

use App\DTO\CoasterStatusDTO;
use App\Factories\CoasterStatusDTOFactory;
use App\Repositories\CoasterRepository;
use App\Repositories\WagonRepository;
use React\Promise\PromiseInterface;
use function React\Promise\all;
use function React\Promise\resolve;

class CoasterStatusProvider
{
    public function __construct(
        private readonly CoasterRepository $coasterRepository,
        private readonly WagonRepository $wagonRepository,
    ) {}

    /**
     * @return PromiseInterface<CoasterStatusDTO[]>
     */
    public function getAll(): PromiseInterface
    {
        $coasters = $this->coasterRepository->findAll();

        $promises = array_map(function ($coaster) {
            return resolve(
                $this->wagonRepository->findAll($coaster->getId())
            )->then(fn(array $wagons) =>
            CoasterStatusDTOFactory::create($coaster, $wagons)
            );
        }, $coasters);

        return all($promises);
    }
}
