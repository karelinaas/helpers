<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Tests\Factories\FilterModelFactory;
use Tests\TestCase;

class FilterTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testHasStatus()
    {
        $post = FilterModel::factory()->create([
            'status_id' => 55
        ]);

        $this->assertContains(6, FilterModel::all()->pluck('status_id')->toArray());
    }

}

class FilterModel extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return FilterModelFactory::new();
    }
}