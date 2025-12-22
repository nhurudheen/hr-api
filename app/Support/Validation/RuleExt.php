<?php

namespace App\Support\Validation;

use App\Rules\ExtraExist;
use App\Rules\ExtraUnique;

class RuleExt
{
    public static function extraUnique(string $table, array $conditions, ?string $column = null): ExtraUnique
    {
        return new ExtraUnique($table, $conditions, $column);
    }

    public static function extraExist(string $table, array $conditions, ?string $column = null): ExtraExist
    {
        return new ExtraExist($table, $conditions, $column);
    }
}
