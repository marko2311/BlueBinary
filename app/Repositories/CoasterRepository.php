<?php

namespace App\Repositories;

use App\Constants\RedisKeys;
use App\DTO\Coaster\RegisterCoasterDTO;
use App\Serializers\Coaster\CoasterSerializerResolver;
use App\Services\RedisClientService;

class CoasterRepository
{
    public function __construct(
        private readonly CoasterSerializerResolver $resolver,
        private readonly RedisClientService $redisService
    ) {}

    public function save(RegisterCoasterDTO $dto): void
    {
        $redis = $this->redisService->getClient();
        $redis->set(
            RedisKeys::coaster($dto->getId()),
            $this->resolver->resolve($dto)->serialize($dto)
        );
    }

    public function find(string $id): ?RegisterCoasterDTO
    {
        $redis = $this->redisService->getClient();

        $json = $redis->get(RedisKeys::coaster($id));
        return $json !== null ? $this->resolver->getRegisterCoasterJsonSerializer()->deserialize($json) : null;
    }

    public function findAll(): array
    {
        $redis = $this->redisService->getClient();

        $keys = $redis->keys(RedisKeys::coasterIndex());
        $coasters = $redis->mget($keys);

        $results = [];
        foreach ($coasters as $coaster) {
            $results[] = $this->resolver->getRegisterCoasterJsonSerializer()->deserialize($coaster);
        }

        return $results;
    }

    public function delete(string $id): void
    {
        $redis = $this->redisService->getClient();

        $redis->del(RedisKeys::coaster($id));
    }

    public function exists(string $id): bool
    {
        $redis = $this->redisService->getClient();

        return $redis->exists(RedisKeys::coaster($id)) === 1;
    }
}
