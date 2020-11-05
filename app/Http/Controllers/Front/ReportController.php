<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Exhibitor\ExhibitorRepository;
use App\Repositories\Visitor\VisitorRepository;
use Carbon;

class ReportController extends Controller
{
    protected $model;
    protected $visitor;

    public function __construct(ExhibitorRepository $model, VisitorRepository $visitor)
    {
        $this->model = $model;
        $this->visitor = $visitor;
    }

    public function daily_report()
    {
        $months_day = $this->dates_of_month();
        $dailyVisits = [];
        foreach ($months_day['date'] as $date) {
            $daily = $this->visitor->where('exhibitor_id', auth()->user()->exhibitor->id)->whereDate('created_at', $date)->get()->pluck('count');
            array_push($dailyVisits, $daily);
        }
        return view('front.report.daily', compact(
            'dailyVisits',
            'months_day'
        ));
    }

    public function dates_of_month()
    {
        $date = Carbon\Carbon::today();
        $num = date('m');
        $month = date('m');
        $year = date('Y');

        $start_date = "01-" . $month . "-" . $year;
        $start_time = strtotime($start_date);

        $end_time = strtotime($date);
        $day_name = [];
        $day_date = [];
        for ($i = $start_time; $i <= $end_time; $i += 86400) {
            $day = date('l', $i);
            $daydate = date('Y-m-d', $i);
            array_push($day_name, $day);
            array_push($day_date, $daydate);
        }
        return $data = ['day' => $day_name, 'date' => $day_date];
    }
}
