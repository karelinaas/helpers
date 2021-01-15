<?php

namespace Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use PhpCraftsman\Models\Status;

class StatusFactory extends Factory
{
    protected $model = Status::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'waiting',
            'title' => 'В ожидании',
            'type' => 'status',
        ];
    }
}