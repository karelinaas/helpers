<?php

namespace PhpCraftsman;

use Illuminate\Database\Eloquent\Concerns\QueriesRelationships;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

abstract class SortService
{

    /**
     * @var Builder|QueriesRelationships $builder
     */
    protected $builder;

    /**
     * @var Request $request
     */
    protected $request;

    public function __construct($builder, Request $request)
    {
        $this->builder = $builder;
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function apply()
    {
        $this->prepareSorting();

        $sortName = $this->sortName();

        if (!$sortName) {
            $this->builder->orderByDesc('id');
        }

        if (method_exists($this, $sortName)) {
            $sortDesc = $this->request->sortDesc ? 'desc' : 'asc';
            $this->$sortName($sortDesc);
        }

        $this->passedSorting();

        return $this->builder;
    }

    public function sortName()
    {
        return $this->request->isMethod('get') ? ($this->request->sortName ?? null) : null;
    }

    protected function prepareSorting()
    {

    }

    protected function passedSorting()
    {

    }
}
