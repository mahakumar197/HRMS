<?php

namespace App\Http\Controllers\rr;

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
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Route;
use App\Services\RRReportService;
use Illuminate\Support\Facades\Auth;

class projectmanagerRR extends Controller
{
    private $RRReportService;
    public function __construct(RRReportService $RRReportService)
    {
        $this->RRReportService = $RRReportService;
    }
    public function index(Request $request)
    {




        if ($request->from_date == '') {

           // $project_list = Projectmaster::with('teamassign')->get();

            $id = Auth::id();

            if(Auth::user()->role == 'project_manager'){
                $project_list = Projectmaster::with('teamassign')->where('user_id',$id)->select('id','project_name')->get();
            }
            elseif(Auth::user()->role == 'super_admin'){
                $project_list = Projectmaster::with('teamassign')->select('id','project_name')->get();

            }

            

            return view('report.rr.index', compact('project_list'));
        }

        if ($request->from_date != '' && $request->to_date != '') {


            $validate = $request->validate([

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

            // $today = Carbon::today() ;
            // dd($to);

            $month = $from->month;
            $year = $from->year;
            $num = $to->diffInDays($from) + 1;
            $d = $from->format('d');
            $d = (int)$d;

            if(Auth::user()->role == 'project_manager'){
                $project_list = Projectmaster::with('teamassign')->where('user_id',$id)->select('id','project_name')->get();
            }
            elseif(Auth::user()->role == 'super_admin'){
                $project_list = Projectmaster::with('teamassign')->select('id','project_name')->get();

            }
            
            $project_name = Projectmaster::where('id', $project)->select('project_name')->first();

            // $today = Carbon::today() ;       
            // $date=$today;
            ///$month=$today->month;
            // $year=$today->year;
            // $num = $today->daysInMonth;
            // $employee_info=$data['employee_info']=User::get();

            $employee_info = $data['employee_info'] = TeamAllocations::with('user')->where('project_id', $project)->whereDate('start_date','>=',$from)->whereDate('end_date','<=',$to)->where('billable','Yes')->select('user_id')->get();


          // dd($employee_info);
            $project_manager = Projectmaster::with(['userteam' => function ($user) {
                $user->select('name', 'id')->get();
            }])->where('id', $project)->get();




            if ($employee_info->isEmpty()) {



                return redirect()->back()->with('message', 'No Employee Found');
            }
            // dd($project_manager);
            if ($month >= 1 && $month <= 9) {
                $yymm = $year . '-' . '0' . $month;
            } else {
                $yymm = $year . '-' . $month;
            }

            $holiday = holidaymodel::whereMonth('holidaydate', $month)->select('holidaydate')->pluck('holidaydate')->toArray();

            foreach ($data['employee_info'] as $sl => $v_employee) {
                $key = 1;
                $x = 0;



                // for($i=$d;$i<=$num;$i++){

                for ($i = $from; $i <= $to; $i->modify('+1 day')) {

                    if ($i->isWeekday()) {




                        // if($i >= 1 && $i<=9){
                        //   $sdate = $yymm.'-'.'0'.$i;
                        //   }
                        //    else{
                        //   $sdate = $yymm.'-'.$i;
                        //  }

                        $i = $i->format('Y-m-d');

                        $sdate = $i;
                        //  dd($sdate);


                        $data['week_info'][date('W', strtotime($sdate))][$sdate] = $sdate;



                        if (!empty($holiday)) {
                            foreach ($holiday as $v_holiday) {
                                if ($v_holiday == $sdate) {
                                    $flag = 'h';
                                }
                            }
                        }


                        if (!empty($flag)) {
                            $data['attendance_info'][$v_employee->user_id][date('W', strtotime($sdate))][$sdate] = $this->RRReportService->getAttendances($v_employee->user_id, $sdate, $flag, $v_employee->name, $month,$project_name->project_name);
                        } else {
                            $data['attendance_info'][$v_employee->user_id][date('W', strtotime($sdate))][$sdate] = $this->RRReportService->getAttendances($v_employee->user_id, $sdate, $v_employee->name, $month, $project_name->project_name);
                        }

                        $cl[$v_employee->user_id] = $this->RRReportService->getleave($v_employee->user_id, $month);
                        $pl[$v_employee->user_id] = $this->RRReportService->getpl($v_employee->user_id, $month);
                        $unit_rate[$v_employee->user_id] = $this->RRReportService->getrate($v_employee->user_id);


                        //echo "<pre>";
                        /// print_r($data['attendance_info']);
                        // echo "</pre>";

                        $i = Carbon::parse($i);
                    }
                }

                 //dd($workingday);


            }

             // dd($data['attendance_info']);




        }


        return view('report.rr.index', compact('employee_info', 'data', 'cl', 'pl', 'unit_rate', 'from', 'project_list', 'project_manager'));
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
