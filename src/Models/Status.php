<?php

namespace PhpCraftsman\Models;

use Database\Factories\StatusFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Status extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['name', 'title', 'description', 'type','value'];
    protected $casts = ['meta' => 'array'];

    /**
     * @return BelongsTo
     */
    public function parents(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'state_id');
    }

    /**
     * @return HasMany
     */
    public function children()
    {
        return $this->hasMany(Status::class, 'state_id')->with('children')->withoutGlobalScope('parents');
    }

    /**
     * @param $value
     * @return string
     */
    public function getNameAttribute($value): string
    {
        return strtolower($value);
    }

    protected static function newFactory()
    {
        return StatusFactory::new();
    }
}
