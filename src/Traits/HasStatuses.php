<?php

namespace PhpCraftsman\Traits;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * Trait HasStatuses
 * @property int $status_id
 * @package App\Traits
 */
trait HasStatuses
{
    /**
     * @param mixed ...$names
     * @return bool
     * @throws Exception
     */
    public function hasStatus(...$names)
    {
        if (!$this instanceof Model) {
            throw new Exception("Only applicable to model.");
        }

        $names = is_array($names) ? Arr::flatten($names) : func_get_args();

        $statuses = app('status')->whereIn('name', $names)->pluck('id');

        if ($statuses->isEmpty()){
            $names = implode("|",$names);
            throw new Exception("The status `{$names}` is an invalid status.");
        }

        return  in_array($this->status_id, $statuses->toArray());
    }

    /**
     * @param Builder $builder
     * @param mixed ...$names
     * @return Builder
     * @throws Exception
     */
    public function scopeCurrentStatus(Builder $builder, ...$names): Builder
    {
        $names = is_array($names) ? Arr::flatten($names) : func_get_args();

        $statuses = app('status')->whereIn('name', $names)->pluck('id');

        if ($statuses->isEmpty()){
           $names = implode("|",$names);
           throw new Exception("The status `{$names}` is an invalid status.");
        }

        return $builder->whereIn('status_id', $statuses);
    }
}
