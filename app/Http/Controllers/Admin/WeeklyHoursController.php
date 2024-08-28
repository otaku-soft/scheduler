<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class WeeklyHoursController extends Controller
{
    CONST DAYS = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
    public function hours()
    {
        return range(0,23);
    }
    public function minutes()
    {
        return range(0,59);
    }
    public function index()
    {
        return view('admin.weekly-hours.index', ["days" => self::DAYS,'hours' => $this->hours(),'minutes' => $this->minutes()]);
    }
}