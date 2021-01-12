<?php


namespace Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\Feature\Status;

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
        ];
    }
}