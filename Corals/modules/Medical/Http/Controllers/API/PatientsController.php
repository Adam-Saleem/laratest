<?php

namespace Corals\Modules\Medical\Http\Controllers\API;

use Corals\Foundation\Http\Controllers\APIBaseController;
use Corals\Modules\Medical\DataTables\PatientsDataTable;
use Corals\Modules\Medical\Http\Requests\PatientRequest;
use Corals\Modules\Medical\Models\Patient;
use Corals\Modules\Medical\Services\PatientService;
use Corals\Modules\Medical\Transformers\API\PatientPresenter;

class PatientsController extends APIBaseController
{
    protected $patientService;

    /**
     * PatientsController constructor.
     * @param PatientService $patientService
     * @throws \Exception
     */
    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
        $this->patientService->setPresenter(new PatientPresenter());

        parent::__construct();
    }

    /**
     * @param PatientRequest $request
     * @param PatientsDataTable $dataTable
     * @return mixed
     * @throws \Exception
     */
    public function index(PatientRequest $request, PatientsDataTable $dataTable)
    {
        $patients = $dataTable->query(new Patient());

        return $this->patientService->index($patients, $dataTable);
    }

    /**
     * @param PatientRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PatientRequest $request)
    {
        try {
            $patient = $this->patientService->store($request, Patient::class);

            return apiResponse($this->patientService->getModelDetails(), trans('Corals::messages.success.created', ['item' => $patient->name]));
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }

    /**
     * @param PatientRequest $request
     * @param Patient $patient
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(PatientRequest $request, Patient $patient)
    {
        try {
            return apiResponse($this->patientService->getModelDetails($patient));
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }

    /**
     * @param PatientRequest $request
     * @param Patient $patient
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(PatientRequest $request, Patient $patient)
    {
        try {
            $this->patientService->update($request, $patient);

            return apiResponse($this->patientService->getModelDetails(), trans('Corals::messages.success.updated', ['item' => $patient->name]));
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
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

            return apiResponse([], trans('Corals::messages.success.deleted', ['item' => $patient->name]));
        } catch (\Exception $exception) {
            return apiExceptionResponse($exception);
        }
    }
}
