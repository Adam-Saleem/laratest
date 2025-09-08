<?php

namespace Corals\Modules\Medical\Http\Controllers;

use Corals\Foundation\Http\Controllers\BaseController;
use Corals\Modules\Medical\DataTables\VillagesDataTable;
use Corals\Modules\Medical\Http\Requests\VillageRequest;
use Corals\Modules\Medical\Models\Village;
use Corals\Modules\Medical\Models\City;
use Corals\Modules\Medical\Services\VillageService;

class VillagesController extends BaseController
{
    protected $villageService;

    public function __construct(VillageService $villageService)
    {
        $this->villageService = $villageService;

        $this->resource_url = config('medical.models.village.resource_url');

        $this->resource_model = new Village();

        $this->title = trans('Medical::module.village.title');
        $this->title_singular = trans('Medical::module.village.title_singular');

        parent::__construct();
    }

    /**
     * @param VillageRequest $request
     * @param VillagesDataTable $dataTable
     * @return mixed
     */
    public function index(VillageRequest $request, VillagesDataTable $dataTable)
    {
        return $dataTable->render('Medical::villages.index');
    }

    /**
     * @param VillageRequest $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(VillageRequest $request)
    {
        $village = new Village();
        $cities = City::all();

        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.create_title', ['title' => $this->title_singular]),
        ]);

        return view('Medical::villages.create_edit')->with(compact('village', 'cities'));
    }

    /**
     * @param VillageRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(VillageRequest $request)
    {
        try {
            $village = $this->villageService->store($request, Village::class);

            flash(trans('Corals::messages.success.created', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Village::class, 'store');
        }

        return redirectTo(isset($village) ? $village->getShowURL() : $this->resource_url);
    }

    /**
     * @param VillageRequest $request
     * @param Village $village
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(VillageRequest $request, Village $village)
    {
        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.show_title', ['title' => $village->getIdentifier()]),
            'showModel' => $village,
        ]);

        return view('Medical::villages.show')->with(compact('village'));
    }

    /**
     * @param VillageRequest $request
     * @param Village $village
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(VillageRequest $request, Village $village)
    {
        $cities = City::all();

        $this->setViewSharedData([
            'title_singular' => trans('Corals::labels.update_title', ['title' => $village->getIdentifier()]),
        ]);

        return view('Medical::villages.create_edit')->with(compact('village', 'cities'));
    }

    /**
     * @param VillageRequest $request
     * @param Village $village
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(VillageRequest $request, Village $village)
    {
        try {
            $this->villageService->update($request, $village);

            flash(trans('Corals::messages.success.updated', ['item' => $this->title_singular]))->success();
        } catch (\Exception $exception) {
            log_exception($exception, Village::class, 'update');
        }

        return redirectTo($village->getShowURL());
    }

    /**
     * @param VillageRequest $request
     * @param Village $village
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(VillageRequest $request, Village $village)
    {
        try {
            $this->villageService->destroy($request, $village);

            $message = [
                'level' => 'success',
                'message' => trans('Corals::messages.success.deleted', ['item' => $this->title_singular]),
            ];
        } catch (\Exception $exception) {
            log_exception($exception, Village::class, 'destroy');
            $message = ['level' => 'error', 'message' => $exception->getMessage()];
        }

        return response()->json($message);
    }
}