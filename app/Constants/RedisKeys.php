<?php

namespace App\Constants;

class RedisKeys
{
    private static function prefix(): string
    {
        return getenv('REDIS_KEY_PREFIX') ?: 'dev';
    }

    public static function coaster(string $id): string
    {
        return self::prefix() . ":coaster:" . $id;
    }

    public static function coasterIndex(): string
    {
        return self::prefix() . ":coaster:*";
    }

    public static function wagon(string $coasterId, string $wagonId): string
    {
        return self::prefix() . ":wagon:" . $coasterId . ":" . $wagonId;
    }

    public static function wagonIndex(string $coasterId): string
    {
        return self::prefix() . ":wagon:*:" . $coasterId;
    }

    public static function coasterWagonSet(string $coasterId): string
    {
        return self::prefix() . ":coaster:" . $coasterId . ":wagons";
    }

}


