<?php

namespace Corals\Modules\Medical\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Medical\DataTables\CitiesDataTable;
use Corals\Modules\Medical\Http\Requests\CityRequest;
use Corals\Modules\Medical\Models\City;
use Corals\Modules\Medical\Services\CityService;

class CitiesController extends BaseController
{
    protected $cityService;

    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;

        $this->resource_url = config('medical.models.city.resource_url');

        $this->resource_model = new City();

        $this->title = trans('Medical::module.city.title');
        $this->title_singular = trans('Medical::module.city.title_singular');

        parent::__construct();
    }

    /**
     * @param CityRequest $request
     * @param CitiesDataTable $dataTable
     * @return mixed
     */
    public function index(CityRequest $request, CitiesDataTable $dataTable)
    {
        return $dataTable->render('Medical::cities.index');
    }

    /**
     * @param CityRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(CityRequest $request)
    {
        $city = new City();

        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular]),
        ]);

        return view('Medical::cities.create_edit')->with(compact('city'));
    }

    /**
     * @param CityRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CityRequest $request)
    {
        try {
            $city = $this->cityService->store($request, City::class);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, City::class, 'store');
        }

        return redirectTo(isset($city) ? $city->getShowURL() : $this->resource_url);
    }

    /**
     * @param CityRequest $request
     * @param City $city
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(CityRequest $request, City $city)
    {
        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.show_title', ['title' => $city->getIdentifier()]),
            'showModel' => $city,
        ]);

        return view('Medical::cities.show')->with(compact('city'));
    }

    /**
     * @param CityRequest $request
     * @param City $city
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(CityRequest $request, City $city)
    {
        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.update_title', ['title' => $city->getIdentifier()]),
        ]);

        return view('Medical::cities.create_edit')->with(compact('city'));
    }

    /**
     * @param CityRequest $request
     * @param City $city
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(CityRequest $request, City $city)
    {
        try {
            $this->cityService->update($request, $city);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, City::class, 'update');
        }

        return redirectTo($city->getShowURL());
    }

    /**
     * @param CityRequest $request
     * @param City $city
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(CityRequest $request, City $city)
    {
        try {
            $this->cityService->destroy($request, $city);

            $message = [
                'level' => 'success',
                'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular]),
            ];
        } catch (\Exception $exception) {
            log_exception($exception, City::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}