<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use PhpCraftsman\SortService;
use Tests\TestCase;

class SortTest extends TestCase
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
        $queryBuilder = SortModel::query();
        $request = new Request();

        $request->replace(['sortName'=> 'email']);

        $queryBuilder = (new Sort($queryBuilder, $request))->apply();

        $this->assertSame('select * from "sort_models" order by "email" asc', $queryBuilder->toSql());
    }

}

class SortModel extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;

    protected $fillable = [
        'id'
    ];
}
class Sort extends SortService
{
    public function email($value)
    {
        $this->builder->orderBy('email', $value);
    }
}