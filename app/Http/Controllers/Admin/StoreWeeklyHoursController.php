<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Services\WeeklyHours\WeeklyHoursService;
use App\Models\StoreWeeklyHours;
class StoreWeeklyHoursController extends Controller
{
    /**
     * @var WeeklyHoursService
     */
    private WeeklyHoursService $weeklyHoursService;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addTime(Request $request)
    {
        $this->weeklyHoursService->setStoreId($request->get("storeId"));
        $request->validate($this->weeklyHoursService->validateTimesRules($request->get("endingTime")));
        return new JsonResponse(["success" => $this->weeklyHoursService->addTime($request->get("day"),$request->get("startingTime"),$request->get("endingTime"))]);
    }


    /**
     * @param Request $request
     * @return View
     */
    public function timelist(Request $request): View
    {
        $this->weeklyHoursService->setStoreId($request->get("storeId"));
        $times = $this->weeklyHoursService->timelist($request->get("day"));
        return view('admin.weekly-hours.timelist', ["times" => $times,"storeId" => $request->get("storeId")]);

    }

    /**
     * @param Request $request
     * @return View
     */
    public function editTimeModal(Request $request) : View
    {
        $this->weeklyHoursService->setStoreId($request->get("storeId"));
        $time = $this->weeklyHoursService->instance()->find($request->get("id"));
        return view('admin.weekly-hours.edit-time-modal', ["time" => $time]);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function editTime(Request $request) : JsonResponse
    {
        $this->weeklyHoursService->setStoreId($request->get("storeId"));
        $request->validate($this->weeklyHoursService->validateTimesRules($request->get("endingTime")));
        return new JsonResponse(["success" => $this->weeklyHoursService->editTime($request->get("id"),$request->get("startingTime"),$request->get("endingTime"))]);
    }


    /**
     * @param Request $request
     * @return View
     */
    public function deleteTimeModal(Request $request) : View
    {
        $this->weeklyHoursService->setStoreId($request->get("storeId"));
        $time = $this->weeklyHoursService->instance()->find($request->get("id"));
        return view('admin.weekly-hours.delete-time-modal', ["time" => $time]);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteTime(Request $request): JsonResponse
    {
        $this->weeklyHoursService->setStoreId($request->get("storeId"));
        return new JsonResponse(["success" => $this->weeklyHoursService->deleteTime($request->get("id"))]);
    }


    /**
     * @return View
     */
    public function index($storeId) : View
    {
        $routes =
            [
                "timelist" => "storeWeeklyHours_timelist",
                "addTime" => "storeWeeklyHours_addTime",
                "editTimeModal" => "storeWeeklyHours_editTimeModal",
                "editTime" => "storeWeeklyHours_editTime",
                "deleteTimeModal" => "storeWeeklyHours_deleteTimeModal",
                "deleteTime" => "storeWeeklyHours_deleteTime"

            ];
        return view('admin.weekly-hours.index', ["days" => $this->weeklyHoursService::DAYS, 'hours' => $this->weeklyHoursService->hours(), 'minutes' => $this->weeklyHoursService->minutes(),"routes" => $routes,"storeId" => $storeId]);
    }

    /**
     * @param WeeklyHoursService $weeklyHoursService
     */
    public function __construct(WeeklyHoursService $weeklyHoursService)
    {
        $this->weeklyHoursService = $weeklyHoursService;
    }
}