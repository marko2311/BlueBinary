<?php

namespace App\Repositories;

use App\DTO\Wagon\RegisterWagonDTO;
use App\Serializers\Wagon\RegisterWagonJsonSerializer;
use App\Services\RedisClientService;
use App\Constants\RedisKeys;

class WagonRepository
{
    public function __construct(
        private readonly RegisterWagonJsonSerializer $serializer,
        private readonly RedisClientService $redisService
    ) {}

    public function save(string $coasterId, RegisterWagonDTO $dto): void
    {
        $redis = $this->redisService->getClient();

        $redis->set(
            RedisKeys::wagon($coasterId, $dto->getId()),
            $this->serializer->serialize($dto)
        );
    }

    public function exists(string $coasterId, string $wagonId): bool
    {
        $redis = $this->redisService->getClient();
        return $redis->exists(RedisKeys::wagon($coasterId, $wagonId)) === 1;
    }

    public function delete(string $coasterId, string $wagonId): void
    {
        $redis = $this->redisService->getClient();

        $redis->del(RedisKeys::wagon($coasterId, $wagonId));
    }

    public function findAll(string $coasterId): array
    {
        $redis = $this->redisService->getClient();

        $keys = $redis->keys(RedisKeys::wagonIndex($coasterId));
        $records = $redis->mGet($keys);

        if (!is_array($records)) {
            return [];
        }
        $results = [];
        foreach ($records as $record) {
            if ($record !== false) {
                $results[] = $this->serializer->deserialize($record);
            }
        }

        return $results;
    }

    public function find(string $coasterId, string $wagonId): ?RegisterWagonDTO
    {
        $redis = $this->redisService->getClient();
        $json = $redis->get(RedisKeys::wagon($coasterId, $wagonId));

        return $json ? $this->serializer->deserialize($json) : null;
    }
}
