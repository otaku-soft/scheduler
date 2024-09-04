<?php

namespace App\Services\WeeklyHours;
use App\Models\WeeklyHours;
use App\Models\StoreWeeklyHours;
use Illuminate\Database\Eloquent\Collection;
class WeeklyHoursService
{
    /**
     * @var WeeklyHours
     */
    private WeeklyHours $weeklyHours;
    /**
     * @var StoreWeeklyHours
     */
    private StoreWeeklyHours $storeWeeklyHours;

    /**
     * @var WeeklyHours|StoreWeeklyHours
     */
    private WeeklyHours | StoreWeeklyHours $weeklyHoursSelected;

    /**
     * @var int|null
     */
    private ?int $storeId;

    /**
     *
     */
    const DAYS = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    /**
     *
     */
    const VALIDATE_TIMES = [
        'startingTime' => 'required',
        'endingTime' => 'required',
        'endingTimeAfter' => 'after:startingTime'
    ];
    /**
     *
     */
    const END_OF_DAY_TIME = "12:00 AM";
    /**
     *
     */
    const END_OF_DAY_TIME_DB = "00:00:00";
    /**
     *
     */
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
     * @param WeeklyHours $weeklyHours
     * @param StoreWeeklyHours $storeWeeklyHours
     */
    public function __construct(WeeklyHours $weeklyHours, StoreWeeklyHours $storeWeeklyHours)
    {
        $this->weeklyHours = $weeklyHours;
        $this->storeWeeklyHours = $storeWeeklyHours;
        $this->weeklyHoursSelected = $weeklyHours;
    }

    /**
     * @return WeeklyHours|StoreWeeklyHours
     */
    public function instance() : WeeklyHours | StoreWeeklyHours
    {
        return $this->weeklyHoursSelected;
    }


    /**
     * @param int $storeId
     * @return void
     */
    public function setStoreId(int $storeId) : void
    {
        $this->weeklyHoursSelected = $this->storeWeeklyHours;
        $this->storeId = $storeId;
    }

    /**
     * @param $day
     * @return Collection|null
     */
    public function timelist($day) : ?Collection
    {
        $findParams = ["day" => $day];
        if ($this->weeklyHoursSelected instanceof StoreWeeklyHours)
        {
            $findParams["store_id"] = $this->storeId;
        }
        return $this->weeklyHoursSelected->where(["day" => $day])->orderBy("starting_time")->get();
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
     * @param $endingTime
     * @return string[]
     */
    public function validateTimesRules($endingTime) : array
    {
        $rules = self::VALIDATE_TIMES;
        if ($endingTime === "END_OF_DAY_TIME")
            unset($rules["endingTimeAfter"]);
        return $rules;
    }

    /**
     * @param string $day
     * @param string $startingTime
     * @param string $endingTime
     * @return bool
     * @throws \Exception
     */
    public function addTime(string $day, string $startingTime, string $endingTime) : bool
    {
        $findValidateParams = ["day" => $day];
        if ($this->weeklyHoursSelected instanceof StoreWeeklyHours)
            $findValidateParams['store_id'] = $this->storeId;

        if (!$this->validateTime($this->weeklyHoursSelected->where($findValidateParams)->get(), $startingTime, $endingTime))
            return false;

        if ($this->weeklyHoursSelected instanceof StoreWeeklyHours)
        {
            $weeklyHours = new StoreWeeklyHours();
            $weeklyHours->store_id = $this->storeId;
        }
        else
            $weeklyHours = new WeeklyHours();
        $weeklyHours->day = $day;
        $weeklyHours->starting_time = new \DateTime($startingTime);
        $weeklyHours->ending_time = new \DateTime($endingTime);
        $weeklyHours->save();
        return true;
    }

    /**
     * @param int $id
     * @param string $startingTime
     * @param string $endingTime
     * @return bool
     * @throws \Exception
     */
    public function editTime(int $id, string $startingTime, string $endingTime) : bool
    {
        $weeklyHours = $this->instance()->find($id);
        if (!$this->validateTime($this->instance()->where("id", "!=", $weeklyHours->id)->where("day", $weeklyHours->day)->get(), $startingTime, $endingTime))
            return false;
        $weeklyHours = $this->instance()->find($id);
        $weeklyHours->starting_time = new \DateTime($startingTime);
        $weeklyHours->ending_time = new \DateTime($endingTime);
        $weeklyHours->save();
        return true;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteTime(int $id) : bool
    {
        $time = $this->instance()->find($id);
        $time->delete();
        return true;
    }
}