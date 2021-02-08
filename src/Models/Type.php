<?php

namespace PhpCraftsman\Models;

use Database\Factories\TypeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Type
 *
 * @package PhpCraftsman\Models
 */
class Type extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'name',
        'title',
    ];
    use HasFactory;

    protected static function newFactory()
    {
        return TypeFactory::new();
    }
}