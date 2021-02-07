<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use PhpCraftsman\Models\Type;
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
        $mock = Mockery::mock(Stub::class)->makePartial();

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
        $mock = Mockery::mock(Stub::class)->makePartial();

        $mock->shouldReceive('getAttribute')
            ->with('type_id')
            ->andReturn(Type::where('name','import')->first()->id);

        $this->assertTrue($mock->hasType([
            'export',
            'import',
        ]));
    }

}

class Stub extends Model
{
    use HasStatuses;

    /**
     * @return BelongsTo
     */
    public function type(): BelongsTo
    {
        return $this->belongsTo(Type::class);
    }
}
