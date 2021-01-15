<?php

namespace PhpCraftsman;

use Illuminate\Database\Eloquent\Concerns\QueriesRelationships;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

abstract class FilterService
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
        $this->prepareFiltering();

        foreach ($this->filters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        $this->passedFiltering();

        return $this->builder;
    }

    protected function filters()
    {
        return $this->request->isMethod('get') ? $this->request->input() : null;
    }

    protected function prepareFiltering()
    {

    }

    protected function passedFiltering()
    {

    }
}
