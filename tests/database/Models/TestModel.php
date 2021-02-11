<?php


namespace Tests\database\Models;

use Illuminate\Database\Eloquent\Model;
use PhpCraftsman\Traits\HasStatuses;
use PhpCraftsman\Traits\HasTypes;

class TestModel extends Model
{
    use HasStatuses;
    use HasTypes;

    protected $fillable = [
            'name',
            'status_id',
            'type_id',
        ];

    public function status()
    {
        return $this->belongsTo('Status');
    }
    public function type()
    {
        return $this->belongsTo('Type');
    }
}