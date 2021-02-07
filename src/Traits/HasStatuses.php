<?php

namespace PhpCraftsman\Traits;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use ReflectionParameter;

/**
 * Trait HasStatuses
 * @property int $status_id
 * @property int $type_id
 * @package App\Traits
 */
trait HasStatuses
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
     * @param array|string ...$names
     * @return bool
     * @throws Exception
     */
    public function hasStatus(...$names)
    {
        if (!$this instanceof Model) {
            throw new Exception("Only applicable to model.");
        }

        $statuses = app('status')->whereIn('name', Arr::flatten($names))->pluck('id');

        if ($statuses->isEmpty()) {
            $names = implode("|", $names);
            throw new Exception("The status `{$names}` is an invalid status.");
        }

        return  in_array($this->status_id, $statuses->toArray());
    }

    /**
     * @param Builder $builder
     * @param array|string ...$names
     * @return Builder
     * @throws Exception
     */
    public function scopeCurrentStatus(Builder $builder, ...$names): Builder
    {
        $statuses = app('status')->whereIn('name', Arr::flatten($names))->pluck('id');


        if ($statuses->isEmpty()) {
            $names = implode("|", $names);
            throw new Exception("The status `{$names}` is an invalid status.");
        }

        return $builder->whereIn('status_id', $statuses);
    }
}
