<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait InjectRelationTrait
{
    protected function injectRelations(Collection $items, array $relations): Collection
    {
        return $items->map(function ($item) use ($relations) {
            foreach ($relations as $relation => $value) {
                if ($value) {
                    $item->setRelation($relation, $value);
                }
            }
            return $item;
        });
    }
}
