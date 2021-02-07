<?php

namespace PhpCraftsman;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

/**
 * Основа для сервисов фильтрации.
 * The foundation for filtering services.
 *
 * @package App\Services\Filter
 */
abstract class FilterService
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
     * FilterService constructor.
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
     * Метод для применения фильтров.
     * The function for applying filters.
     *
     * @return Builder
     */
    public function apply(): Builder
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

    /**
     * Метод для получения списка фильтров.
     * The function for getting the filters list.
     *
     * @return mixed|null
     */
    protected function filters()
    {
        return $this->request->isMethod('get') ? $this->request->input() : null;
    }

    /**
     * Метод, вызываемый до фильтрации.
     * The function for preparing data before filtering.
     */
    protected function prepareFiltering()
    {
    }

    /**
     * Метод, вызываемый после фильтрации.
     * The function to call after filtering.
     */
    protected function passedFiltering()
    {
    }
}
