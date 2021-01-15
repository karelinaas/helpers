<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use PhpCraftsman\Models\Status;
use PhpCraftsman\Traits\HasStatuses;
use Tests\TestCase;

class HasStatusTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Status::factory()->create();

        Status::factory()->create([
            'name' => 'process',
            'title' => 'В процессе',
        ]);

        $this->app->instance('status', Status::all());
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHasStatus()
    {
        $mock = Mockery::mock(EloquentStub::class)->makePartial();

        $mock->shouldReceive('getAttribute')
            ->with('status_id')
            ->andReturn(Status::where('name','waiting')->first()->id);

        $this->assertTrue($mock->hasStatus('waiting'));
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHasStatuses()
    {
        $mock = Mockery::mock(EloquentStub::class)->makePartial();

        $mock->shouldReceive('getAttribute')
            ->with('status_id')
            ->andReturn(Status::where('name','process')->first()->id);

        $this->assertTrue($mock->hasStatus([
            'waiting',
            'process',
        ]));
    }

}

class EloquentStub extends \Illuminate\Database\Eloquent\Model
{
    use HasStatuses;

    public function status()
    {
        return $this->belongsTo('Status');
    }
}
/*
class Status extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return StatusFactory::new();
    }
}*/