<?php


namespace Tests\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Tests\Feature\EloquentStub;

class EloquentStubFactory extends Factory
{
    protected $model = EloquentStub::class;

    /**
     * @return array
     */
    public function definition()
    {
        return [];
    }
}