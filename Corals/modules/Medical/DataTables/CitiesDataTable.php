<?php

namespace Corals\Modules\Medical\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Medical\Models\City;
use Corals\Modules\Medical\Transformers\CityTransformer;
use Yajra\DataTables\EloquentDataTable;

class CitiesDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('medical.models.city.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new CityTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param City $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(City $model)
    {
        return $model->newQuery()->withCount('villages');
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id' => ['visible' => false],
            'name' => ['title' => trans('Medical::attributes.city.name')],
            'villages_count' => ['title' => trans('Medical::attributes.city.villages_count')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }
}