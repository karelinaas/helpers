<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Request;
use PhpCraftsman\FilterService;
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
        $queryBuilder = FilterModel::query();
        $request = new Request();

        $request->replace(['search'=> 'test']);

        $queryBuilder = (new Filter($queryBuilder, $request))->apply();

        $this->assertSame('select * from "filter_models" where ("name" ilike ? or "version" ilike ?)', $queryBuilder->toSql());
    }

}

class FilterModel extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;

    protected $fillable = [
        'id'
    ];
}
class Filter extends FilterService
{
    public function search($value): void
    {
        $this->builder->where(function (EloquentBuilder $query) use ($value) {
            $query->where('name', 'ilike', '%' . trim($value) . '%')
                ->orWhere('version', 'ilike', '%' . trim($value) . '%');
        });
    }
}