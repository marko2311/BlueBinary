<?php

namespace App\Config;

use App\Repositories\CoasterRepository;
use App\Repositories\WagonRepository;
use App\Serializers\Coaster\CoasterSerializerResolver;
use App\Serializers\Wagon\RegisterWagonJsonSerializer;
use App\Serializers\Wagon\WagonSerializerResolver;
use App\Services\CoasterService;
use App\Services\RedisClientService;
use App\Services\WagonService;
use CodeIgniter\Config\BaseService;

class Services extends BaseService
{
    public static function redisClientService(bool $getShared = true): RedisClientService
    {
        if ($getShared) {
            return static::getSharedInstance('redisClientService');
        }

        return new RedisClientService();
    }

    public static function coasterRepository(bool $getShared = true): CoasterRepository
    {
        if ($getShared) {
            return static::getSharedInstance('coasterRepository');
        }

        return new CoasterRepository(
            service('registerCoasterSerializerResolver'),
            service('redisClientService')
        );
    }

    public static function coasterService(bool $getShared = true): CoasterService
    {
        if ($getShared) {
            return static::getSharedInstance('coasterService');
        }

        return new CoasterService(
            service('coasterRepository')
        );
    }

    public static function registerCoasterSerializerResolver(bool $getShared = true): CoasterSerializerResolver
    {
        if ($getShared) {
            return static::getSharedInstance('registerCoasterSerializerResolver');
        }

        return new CoasterSerializerResolver();
    }

    public static function registerWagonJsonSerializer(bool $getShared = true): RegisterWagonJsonSerializer
    {
        if ($getShared) {
            return static::getSharedInstance('registerWagonJsonSerializer');
        }

        return new RegisterWagonJsonSerializer();
    }

    public static function registerWagonSerializerResolver(bool $getShared = true): WagonSerializerResolver
    {
        if ($getShared) {
            return static::getSharedInstance('registerWagonSerializerResolver');
        }

        return new WagonSerializerResolver();
    }

    public static function wagonRepository(bool $getShared = true): WagonRepository
    {
        if ($getShared) {
            return static::getSharedInstance('wagonRepository');
        }

        return new WagonRepository(
            service('registerWagonJsonSerializer'),
            service('redisClientService')
        );
    }

    public static function wagonService(bool $getShared = true): WagonService
    {
        if ($getShared) {
            return static::getSharedInstance('wagonService');
        }

        return new WagonService(
            service('wagonRepository')
        );
    }

}
