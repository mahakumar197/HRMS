<?php

namespace App\Http\Controllers\yearleave;

use App\Http\Controllers\Controller;
use App\Models\attendance;
use App\Models\designation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\WorkingDay;
use App\Models\holidaymodel;
use App\Models\LeaveApplication;
use App\Models\Projectmaster;
use App\Models\TeamAllocations;
use App\Services\yearleavereportService;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;

class yearleave_report extends Controller
{
    private $yearleavereportService;
    public function __construct(yearleavereportService $yearleavereportService)
    {
        $this->yearleavereportService = $yearleavereportService;
    }
    public function index(Request $request)
    {

        if ($request->from_date == '') {

            // $project_list = Projectmaster::with('teamassign')->get();

            $id = Auth::id();


            if (Auth::user()->role == 'project_manager') {
                $project_list = Projectmaster::with('teamassign')->where('user_id', $id)->select('id', 'project_name')->get();
            } elseif (Auth::user()->role == 'super_admin') {
                $project_list = Projectmaster::with('teamassign')->select('id', 'project_name')->get();
            }

            return view('report.yearleave.index', compact('project_list'));
        }

        if ($request->from_date != '' && $request->to_date != '') {


            $validate = $request->validate(
                [

                    'from_date' => 'required|date',
                    'to_date' => 'required|date|after_or_equal:from_date'

                ],

                $message = [

                    'to_date.after_or_equal'    =>  'To Date should be greater than From Date.'
                ]
            );



            $id = Auth::id();

            $project = $request->projectid;
            $to = Carbon::parse($request->to_date);
            $from = Carbon::parse($request->from_date);

            // $today = Carbon::today();           

            $month = $from->month;
            $year = $from->year;
            $num = $to->diffInDays($from) + 1;
            $d = $from->format('d');
            $d = (int)$d;

            $month_to = $to->month;
            $to_year = $to->year;

            // $today = Carbon::today() ;

            $active_date = $to->format('Y-m-d');

            // $date=$today;
            ///$month=$today->month;
            // $year=$today->year;
            // $num = $today->daysInMonth;
            // $employee_info=$data['employee_info']=User::get();

            $employee_info = $data['employee_info'] = User::whereYear('exit_date', '>=', $year)->select('id', 'name','last_name', 'designation_id', 'exit_date', 'employee_code', 'joining_date')->orderBy('joining_date', 'ASC')->get();

            $relieved_employee = User::whereDate('exit_date', '>=', $from)
                ->whereDate('exit_date', '<=', $to)->select('id', 'name', 'exit_date')->orderBy('joining_date', 'ASC')->get();

            $ml_employee  = User::where('gender', '=', 'Female')->whereDate('ml_from_date', '!=', 'null')
                ->whereDate('ml_to_date', '!=', 'null')
                ->whereBetween('ml_to_date', [$from, $to])
                ->orWhereBetween('ml_from_date', [$from, $to])
                ->orWhere(function ($q) use ($from, $to) {
                    $q->where('ml_to_date', '>=', $to)->where('ml_from_date', '<=', $from);
                })
                ->select('id', 'name', 'ml_from_date', 'ml_to_date')->orderBy('joining_date', 'ASC')->get();


            if ($month >= 1 && $month <= 9) {
                $yymm = $year . '-' . '0' . $month;
            } else {
                $yymm = $year . '-' . $month;
            }



            foreach ($data['employee_info'] as $sl => $v_employee) {

                $pending_leave = LeaveApplication::whereMonth('startDate', '=', $month)->where('user_id', $v_employee->user_id)
                    ->whereMonth('endDate', '=', $month)->where('leaveStatus', '=', '0')->select('noOfDayDeduct')->sum('noOfDayDeduct');

                if ($pending_leave != null) {
                    // dd($pending_leave);

                    return redirect()->back()->with('message', 'Pending Leave Application Found');
                }

                $key = 1;
                $x = 0;

                // for($i=$d;$i<=$num;$i++){

                for ($i = $month; $i <= $month_to; $i++) {
                    $flag = '';

                    // if($i >= 1 && $i<=9){
                    //   $sdate = $yymm.'-'.'0'.$i;
                    //   }
                    //    else{
                    //   $sdate = $yymm.'-'.$i;
                    //  }

                    $sdate = $i;
                    //dd($sdate);

                    $data['week_info'][$sdate] = $sdate;


                    // if (!empty($flag)) {
                    // $data['attendance_info'][$v_employee->user_id][date('W', strtotime($sdate))][$sdate] = $this->RRReportService->getAttendances($v_employee->user_id, $sdate, $v_employee->name, $month,$project_name->project_name, $flag);


                    if ($flag != 'h') {

                        $data['cl'][$v_employee->id][$sdate] = $this->yearleavereportService->getcl($v_employee->id, $sdate, $year, $to_year);
                        $data['pl'][$v_employee->id][$sdate] = $this->yearleavereportService->getpl($v_employee->id, $sdate);
                        $data['sl'][$v_employee->id][$sdate] = $this->yearleavereportService->getsl($v_employee->id, $sdate);

                        //$data['attendance_info'][$v_employee->user_id][$sdate] = $this->yearleavereportService->getAttendances($v_employee->user_id, $sdate, $v_employee->name, $month);
                        //  $cl[$v_employee->user_id] = $this->yearleavereportService->getleave($v_employee->user_id, $month);
                        // $pl[$v_employee->user_id] = $this->yearleavereportService->getpl($v_employee->user_id, $month);
                        //  $sl_count[$v_employee->user_id] = $this->yearleavereportService->getsl($v_employee->user_id, $month);
                        //  $lop_count[$v_employee->user_id] = $this->yearleavereportService->getlop($v_employee->user_id, $month);
                        //  $unit_rate[$v_employee->user_id] = $this->yearleavereportService->getrate($v_employee->user_id);
                    }

                    //    $i = Carbon::parse($i);

                }
            }
        }


        return view('report.yearleave.index', compact('employee_info', 'data', 'from', 'year', 'relieved_employee', 'to', 'ml_employee'));
    }
}

/*$employee = User::with('designation','getattendance','leave')->select('id','name','designation_id','employee_status')->get();
   $attendance = attendance::whereMonth('attendance_date',$today->month)->with('finduser')->select('user_id','attendance_date','day_count')
                ->get()
                ->groupBy('user_id');

                //dd($attendance);

   $current_week = attendance::whereMonth('attendance_date',$today->month)
    ->get()->groupBy(function($date) {
        return Carbon::parse($date->attendance_date)->format('W');
    })->map(function ($items) {
        return $items->pluck('user_id', 'attendance_date');
    })->toArray();

    print_r($current_week);*/
