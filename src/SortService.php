<?php

namespace PhpCraftsman;

use Illuminate\Database\Eloquent\Concerns\QueriesRelationships;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

/**
 * Основа для сервисов сортировки.
 * The foundation for sorting services.
 *
 * @package App\Services\Filter
 */
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

    /**
     * SortService constructor.
     *
     * @param Builder|QueriesRelationships $builder
     * @param Request $request
     */
    public function __construct($builder, Request $request)
    {
        $this->builder = $builder;
        $this->request = $request;
    }

    /**
     * Метод для применения сортировки.
     * The function for applying sorting.
     *
     * @return Builder|QueriesRelationships
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

    /**
     * Метод возвращает поле, по которому проводится сортировка.
     * The function returns a field to sort by.
     *
     * @return mixed|null
     */
    public function sortName()
    {
        return $this->request->isMethod('get') ? ($this->request->sortName ?? null) : null;
    }

    /**
     * Метод, вызываемый до сортировки.
     * The function for preparing data before sorting.
     */
    protected function prepareSorting()
    {

    }

    /**
     * Метод, вызываемый после сортировки.
     * The function to call after sorting.
     */
    protected function passedSorting()
    {

    }
}

