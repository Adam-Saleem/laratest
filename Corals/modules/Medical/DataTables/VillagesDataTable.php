<?php

namespace Corals\Modules\Medical\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Medical\Models\Village;
use Corals\Modules\Medical\Transformers\VillageTransformer;
use Yajra\DataTables\EloquentDataTable;

class VillagesDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('medical.models.village.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new VillageTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Village $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Village $model)
    {
        return $model->newQuery()->with('city');
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
            'name' => ['title' => trans('Medical::attributes.village.name')],
            'city_name' => ['title' => trans('Medical::attributes.village.city_name')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }
}