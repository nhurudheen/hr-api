<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ExtraExist implements Rule
{
    protected string $table;
    protected array $conditions;
    protected ?string $columnName;
    protected string $message;

    public function __construct(string $table, array $conditions = [], ?string $columnName = null)
    {
        $this->table = $table;
        $this->conditions = $conditions;
        $this->columnName = $columnName;
        $this->message = 'The selected value is invalid.';
    }

    public function passes($attribute, $value): bool
    {
        $columnToCheck = $this->columnName ?? $attribute;

        $query = DB::table($this->table)
            ->where($columnToCheck, $value)
            ->whereNull('deleted_at');

        foreach ($this->conditions as $column => $columnValue) {
            $query->where($column, $columnValue);
        }

        return $query->exists(); // Opposite of ExtraUnique
    }

    public function message(): string
    {
        return $this->message;
    }

    public function setMessage(string $customMessage): static
    {
        $this->message = $customMessage;
        return $this;
    }
}
