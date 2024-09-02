<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use App\Models\WeeklyHours;

class WeeklyHoursController extends Controller
{

    const DAYS = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    const VALIDATE_TIMES = [
        'startingTime' => 'required',
        'endingTime' => 'required',
        'endingTimeAfter' => 'after:startingTime'
    ];
    const END_OF_DAY_TIME = "12:00 AM";
    const END_OF_DAY_TIME_DB = "00:00:00";
    const END_OF_DAY_COMPARE_VALUE = "23:59:59";

    /**
     * @return array
     */
    public function hours() : array
    {
        return range(0, 23);
    }

    /**
     * @return array
     */
    public function minutes() : array
    {
        return range(0, 59);
    }

    /**
     * @param $endingTime
     * @return string[]
     */
    public function validateTimes($endingTime) : array
    {
        $rules = self::VALIDATE_TIMES;
        if ($endingTime === "END_OF_DAY_TIME")
            unset($rules["endingTimeAfter"]);
        return $rules;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function addTime(Request $request)
    {
        $request->validate($this->validateTimes($request->get("endingTime")));
        if (!$this->validateTime(WeeklyHours::where("day", $request->get("day"))->get(), $request->get("startingTime"), $request->get("endingTime")))
            return new JsonResponse(["success" => false]);
        $weeklyHours = new WeeklyHours();
        $weeklyHours->day = $request->get("day");
        $weeklyHours->starting_time = new \DateTime($request->get("startingTime"));
        $weeklyHours->ending_time = new \DateTime($request->get("endingTime"));
        $weeklyHours->save();
        return new JsonResponse(["success" => true]);
    }

    /**
     * @param $hours
     * @param $startingTime
     * @param $endingTime
     * @return bool
     * @throws \Exception
     */
    public function validateTime($hours, $startingTime, $endingTime) : bool
    {
        $startingTime = new \DateTime($startingTime);
        $endingTime = new \DateTime($endingTime);
        foreach ($hours as $hour)
        {
            $dbStartingTime = new \DateTime($hour->starting_time);
            if ($hour->ending_time === self::END_OF_DAY_TIME_DB)
                $hour->ending_time = self::END_OF_DAY_COMPARE_VALUE;
            $dbEndingTime = new \DateTime($hour->ending_time);
            if ($startingTime >= $dbStartingTime && $startingTime < $dbEndingTime)
                return false;
            if ($endingTime > $dbStartingTime && $endingTime <= $dbEndingTime)
                return false;
        }
        return true;
    }

    /**
     * @param Request $request
     * @return View
     */
    public function timelist(Request $request): View
    {
        $times = WeeklyHours::where(["day" => $request->get("day")])->orderBy("starting_time")->get();
        return view('admin.weekly-hours.timelist', ["times" => $times]);

    }

    /**
     * @param Request $request
     * @return View
     */
    public function editTimeModal(Request $request) : View
    {
        $time = WeeklyHours::find($request->get("id"));
        return view('admin.weekly-hours.edit-time-modal', ["time" => $time]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function editTime(Request $request)
    {
        $request->validate($this->validateTimes($request->get("endingTime")));
        $weeklyHours = WeeklyHours::find($request->get("id"));
        if (!$this->validateTime(WeeklyHours::where("id", "!=", $weeklyHours->id)->where("day", $weeklyHours->day)->get(), $request->get("startingTime"), $request->get("endingTime")))
            return new JsonResponse(["success" => false]);
        $weeklyHours = WeeklyHours::find($request->get("id"));
        $weeklyHours->starting_time = new \DateTime($request->get("startingTime"));
        $weeklyHours->ending_time = new \DateTime($request->get("endingTime"));
        $weeklyHours->save();
        return new JsonResponse(["success" => true]);
    }

    /**
     * @param Request $request
     * @return View
     */
    public function deleteTimeModal(Request $request) : View
    {
        $time = WeeklyHours::find($request->get("id"));
        return view('admin.weekly-hours.delete-time-modal', ["time" => $time]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteTime(Request $request): JsonResponse
    {
        $time = WeeklyHours::find($request->get("id"));
        $time->delete();
        return new JsonResponse(["success" => true]);
    }

    /**
     * @return View
     */
    public function index() : View
    {
        return view('admin.weekly-hours.index', ["days" => self::DAYS, 'hours' => $this->hours(), 'minutes' => $this->minutes()]);
    }
}