<?php

namespace Tests\Unit;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use PhpCraftsman\Models\Status;
use PhpCraftsman\Models\Type;
use PhpCraftsman\Traits\HasTypes;
use Tests\database\Models\TestModel;
use Tests\TestCase;

class HasTypeTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var TestModel
     */
    public TestModel $model;

    protected function setUp(): void
    {
        parent::setUp();

        Type::factory()->create([
            'name'  => 'export',
            'title' => 'Экспорт',
        ]);

        Type::factory()->create([
            'name'  => 'import',
            'title' => 'Импорт',
        ]);

        $this->app->instance('type', Type::all());

        $this->model = TestModel::create([
            'name'      => 'name',
            'type_id' => Type::where('name', 'export')->first()->id
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     * @throws Exception
     */
    public function testHasType()
    {
        $this->assertTrue($this->model->hasType('export'));
    }

    /**
     * A basic test example.
     *
     * @return void
     * @throws Exception
     */
    public function testHasTypes()
    {
        $this->assertTrue($this->model->hasType([
            'export',
            'import',
        ]));
    }

}
