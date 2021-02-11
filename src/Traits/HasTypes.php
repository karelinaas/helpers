<?php

namespace PhpCraftsman\Traits;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use ReflectionParameter;

/**
 * Trait HasTypes
 * @property int $status_id
 * @property int $type_id
 * @package App\Traits
 */
trait HasTypes
{
    /**
     * @param array|string ...$names
     * @return bool
     * @throws Exception
     */
    public function hasType(...$names)
    {
        if (!$this instanceof Model) {
            throw new Exception("Only applicable to model.");
        }

        $statuses = app('type')->whereIn('name', Arr::flatten($names))->pluck('id');

        if ($statuses->isEmpty()) {
            $names = implode("|", $names);
            throw new Exception("The status `{$names}` is an invalid status.");
        }

        return  in_array($this->type_id, $statuses->toArray());
    }

    /**
     * @param Builder $builder
     * @param array|string ...$names
     * @return Builder
     * @throws Exception
     */
    public function scopeCurrentType(Builder $builder, ...$names): Builder
    {
        $statuses = app('type')->whereIn('name', Arr::flatten($names))->pluck('id');


        if ($statuses->isEmpty()) {
            $names = implode("|", $names);
            throw new Exception("The type `{$names}` is an invalid status.");
        }

        return $builder->whereIn('type_id', $statuses);
    }
}
