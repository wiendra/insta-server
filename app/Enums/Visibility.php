<?php

namespace App\Enums;

enum Visibility: string
{
    case Public = 'public';
    case Private = 'private';

    public function toNumber(): int
    {
        return match($this) {
            self::Public => 1,
            self::Private => 2,
        };
    }
}