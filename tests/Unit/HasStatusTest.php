<?php

namespace Tests\Unit;

use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PhpCraftsman\Models\Status;
use Tests\database\Models\TestModel;
use Tests\TestCase;

class HasStatusTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var TestModel
     */
    public TestModel $model;

    protected function setUp(): void
    {
        parent::setUp();

        Status::factory()->create();

        Status::factory()->create([
            'name'  => 'process',
            'title' => 'В процессе',
        ]);

        $this->app->instance('status', Status::all());

        $this->model = TestModel::create([
            'name' => 'name',
            'status_id' => Status::where('name', 'process')->first()->id,
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     * @throws Exception
     */
    public function testHasStatus()
    {
        $this->assertTrue($this->model->hasStatus('process'));
    }

    /**
     * A basic test example.
     *
     * @return void
     * @throws Exception
     */
    public function testHasStatuses()
    {
        $this->assertTrue($this->model->hasStatus(['process', 'waiting']));
    }

    /**
     * A basic test example.
     *
     * @return void
     * @throws Exception
     */
    public function testSetStatus()
    {
        $this->assertTrue($this->model->hasStatus('process'));
        $this->assertTrue($this->model->setStatus('waiting'));

    }

}