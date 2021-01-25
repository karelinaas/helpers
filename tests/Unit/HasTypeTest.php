<?php

namespace Tests\Unit;

use Database\Factories\TypeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use PhpCraftsman\Traits\HasStatuses;
use Tests\TestCase;

class HasTypeTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Type::factory()->create([
            'name' => 'export',
            'title' => 'Экспорт',
        ]);

        Type::factory()->create([
            'name' => 'import',
            'title' => 'Импорт',
        ]);

        $this->app->instance('type', Type::all());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHasStatus()
    {
        $mock = Mockery::mock(TypeStub::class)->makePartial();

        $mock->shouldReceive('getAttribute')
            ->with('type_id')
            ->andReturn(Type::where('name','export')->first()->id);

        $this->assertTrue($mock->hasType('export'));
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHasStatuses()
    {
        $mock = Mockery::mock(TypeStub::class)->makePartial();

        $mock->shouldReceive('getAttribute')
            ->with('type_id')
            ->andReturn(Type::where('name','import')->first()->id);

        $this->assertTrue($mock->hasType([
            'export',
            'import',
        ]));
    }

}

class TypeStub extends \Illuminate\Database\Eloquent\Model
{
    use HasStatuses;

    public function type()
    {
        return $this->belongsTo('Type');
    }
}

class Type extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return TypeFactory::new();
    }
}