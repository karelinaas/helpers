<?php

namespace PhpCraftsman;

use Illuminate\Database\Eloquent\Builder;
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
     * @var Builder $builder
     */
    protected Builder $builder;

    /**
     * @var Request $request
     */
    protected Request $request;

    /**
     * SortService constructor.
     *
     * @param Builder $builder
     * @param Request $request
     */
    public function __construct(Builder $builder, Request $request)
    {
        $this->builder = $builder;
        $this->request = $request;
    }

    /**
     * Метод для применения сортировки.
     * The function for applying sorting.
     *
     * @return Builder
     */
    public function apply(): Builder
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
