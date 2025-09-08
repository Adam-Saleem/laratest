<?php

namespace Corals\Modules\Medical\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Medical\DataTables\PatientsDataTable;
use Corals\Modules\Medical\Http\Requests\PatientRequest;
use Corals\Modules\Medical\Models\Patient;
use Corals\Modules\Medical\Models\City;
use Corals\Modules\Medical\Models\Village;
use Corals\Modules\Medical\Services\PatientService;

class PatientsController extends BaseController
{
    protected $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;

        $this->resource_url = config('medical.models.patient.resource_url');

        $this->resource_model = new Patient();

        $this->title = trans('Medical::module.patient.title');
        $this->title_singular = trans('Medical::module.patient.title_singular');

        parent::__construct();
    }

    /**
     * @param PatientRequest $request
     * @param PatientsDataTable $dataTable
     * @return mixed
     */
    public function index(PatientRequest $request, PatientsDataTable $dataTable)
    {
        return $dataTable->render('Medical::patients.index');
    }

    /**
     * @param PatientRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(PatientRequest $request)
    {
        $patient = new Patient();
        $cities = City::all();
        $villages = Village::all();

        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular]),
        ]);

        return view('Medical::patients.create_edit')->with(compact('patient', 'cities', 'villages'));
    }

    /**
     * @param PatientRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(PatientRequest $request)
    {
        try {
            $patient = $this->patientService->store($request, Patient::class);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Patient::class, 'store');
        }

        return redirectTo(isset($patient) ? $patient->getShowURL() : $this->resource_url);
    }

    /**
     * @param PatientRequest $request
     * @param Patient $patient
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(PatientRequest $request, Patient $patient)
    {
        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.show_title', ['title' => $patient->getIdentifier()]),
            'showModel' => $patient,
        ]);

        return view('Medical::patients.show')->with(compact('patient'));
    }

    /**
     * @param PatientRequest $request
     * @param Patient $patient
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(PatientRequest $request, Patient $patient)
    {
        $cities = City::all();
        $villages = Village::all();

        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.update_title', ['title' => $patient->getIdentifier()]),
        ]);

        return view('Medical::patients.create_edit')->with(compact('patient', 'cities', 'villages'));
    }

    /**
     * @param PatientRequest $request
     * @param Patient $patient
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(PatientRequest $request, Patient $patient)
    {
        try {
            $this->patientService->update($request, $patient);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Patient::class, 'update');
        }

        return redirectTo($patient->getShowURL());
    }

    /**
     * @param PatientRequest $request
     * @param Patient $patient
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(PatientRequest $request, Patient $patient)
    {
        try {
            $this->patientService->destroy($request, $patient);

            $message = [
                'level' => 'success',
                'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular]),
            ];
        } catch (\Exception $exception) {
            log_exception($exception, Patient::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}
