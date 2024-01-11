<?php

namespace App\Map;

abstract class SelectMap
{
    public static ?array $pool;

    public static function forSelect(): array
    {
        return get_called_class()::$pool;
    }

    public static function getValue(string $id): ?string
    {
        try {
            return get_called_class()::$pool[$id];
        } catch (\Throwable $th) {
            return null;
        }
    }
}
