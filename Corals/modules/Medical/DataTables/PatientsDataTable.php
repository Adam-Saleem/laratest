<?php

namespace Corals\Modules\Medical\DataTables;

use Corals\Foundation\DataTables\BaseDataTable;
use Corals\Modules\Medical\Models\Patient;
use Corals\Modules\Medical\Transformers\PatientTransformer;
use Yajra\DataTables\EloquentDataTable;

class PatientsDataTable extends BaseDataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->setResourceUrl(config('medical.models.patient.resource_url'));

        $dataTable = new EloquentDataTable($query);

        return $dataTable->setTransformer(new PatientTransformer());
    }

    /**
     * Get query source of dataTable.
     * @param Patient $model
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function query(Patient $model)
    {
        return $model->newQuery()->with(['city', 'village']);
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
            'name' => ['title' => trans('Medical::attributes.patient.name')],
            'id_number' => ['title' => trans('Medical::attributes.patient.id_number')],
            'age' => ['title' => trans('Medical::attributes.patient.age')],
            'gender' => ['title' => trans('Medical::attributes.patient.gender')],
            'phone' => ['title' => trans('Medical::attributes.patient.phone')],
            'address' => ['title' => trans('Medical::attributes.patient.address')],
            'marital' => ['title' => trans('Medical::attributes.patient.marital')],
            'created_at' => ['title' => trans('Corals::attributes.created_at')],
            'updated_at' => ['title' => trans('Corals::attributes.updated_at')],
        ];
    }
}
