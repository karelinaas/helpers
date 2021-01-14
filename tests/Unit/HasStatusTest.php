<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use PhpCraftsman\Traits\HasStatuses;
use Tests\Factories\EloquentStubFactory;
use Tests\Factories\StatusFactory;
use Tests\TestCase;

class HasStatusTest extends TestCase
{
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
        $post = EloquentStub::factory()->create([
            'status_id' => Status::where('name','waiting')->first()->id
        ]);

        $this->assertTrue($post->hasStatus('waiting'));
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHasStatuses()
    {
        $model = EloquentStub::factory()->create([
            'status_id' => Status::where('name','process')->first()->id
        ]);

        $this->assertTrue($model->hasStatus([
            'waiting',
            'process',
        ]));
    }

}

class EloquentStub extends \Illuminate\Database\Eloquent\Model
{
    use HasStatuses;
    use HasFactory;

    public function status()
    {
        return $this->belongsTo('Status');
    }

    protected static function newFactory()
    {
        return EloquentStubFactory::new();
    }
}

class Status extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return StatusFactory::new();
    }
}