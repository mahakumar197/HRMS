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
             //  dd($to);

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
            //dd($project_list->project_name);
            $active_date = $to->format('Y-m-d');

            // $date=$today;
            ///$month=$today->month;
            // $year=$today->year;
            // $num = $today->daysInMonth;
            // $employee_info=$data['employee_info']=User::get();

            
         
           $employee_info_all = $data['employee_info_all'] = TeamAllocations::with(['user'=> function($u){
              $u->with('designation')->select('id','name','designation_id','exit_date','employee_code','joining_date','ml_from_date','ml_to_date','last_name')->orderBy('joining_date','ASC')->get();
             }])->where('project_id', $project)->whereDate('start_date','<=',$from)->whereDate('end_date','>=',$to)->orWherebetween('start_date',[$from,$to])->where('billable','Yes')->whereHas('user',function($u) use($from,$to,$project){
                $u->whereDate('exit_date','>=',$from);
             })->select('user_id','project_id','billable','start_date','end_date')->get();

             
             $employee_info =  $data['employee_info'] = $data['employee_info_all']->filter(function ($value) use($from,$to,$project) {
              
                
                return    $value->project_id  == (int)$project && $value->billable == 'Yes';
            });

           
            $project_manager = Projectmaster::with(['userteam' => function ($user) {
                $user->select('name', 'id','last_name')->get();                
            }])->where('id', $project)->get();
            

            $ml_employee  = User::whereHas('team',function($t) use($from,$to,$project){
                $t->where('project_id', $project)->whereDate('start_date','<=',$from)->whereDate('end_date','>=',$to)->where('billable','Yes');
            })->where('gender','=','Female')
            ->whereBetween('ml_to_date',[$from, $to])
            ->orWhereBetween('ml_from_date',[$from, $to])
            ->orWhere(function($q) use($from,$to){
                    $q->where('ml_to_date','>=',$to)->where('ml_from_date','<=',$from);
            })        
            ->select('id','name','ml_from_date','ml_to_date')->orderBy('joining_date','ASC')->get();

             //dd($ml_employee);
     // dd($data['employee_info']);
             
            //check any exit employee found
            $exit_employee = array();

            $e = 0;
            foreach ($data['employee_info'] as $sl => $v_employee) {

                $exit_date = Carbon::parse($v_employee->user->exit_date);

               
                
            
                if ($from > $exit_date){
                  
              
                    $exit_employee[$e]['name'] = $v_employee->user->name;                    
                    $exit_employee[$e]['code'] = $v_employee->user->employee_code;

                    $e++;
                }

                
                
            }

            
             
            if( !empty($exit_employee))
            {
                 
                return view('report.rr.index', compact( 'from', 'project_list', 'project_manager','exit_employee'));
               // return redirect()->back()->with('message', 'some employee releved');
            }
            
           

            

            if ($employee_info->isEmpty()) {

                return redirect()->back()->with('message', 'No Employee Found');
            }
            
           

            if ($month >= 1 && $month <= 9) {
                $yymm = $year . '-' . '0' . $month;
            } else {
                $yymm = $year . '-' . $month;
            }

            $holiday = holidaymodel::whereMonth('holidaydate', $month)->where('holidaystatus','=','1')->select('holidaydate')->pluck('holidaydate')->toArray();

            foreach ($data['employee_info'] as $sl => $v_employee) {

               
               

                $pending_leave = LeaveApplication::whereMonth('startDate', '=', $month)->where('user_id',$v_employee->user_id)
                ->whereMonth('endDate', '=', $month)->where('leaveStatus','=','0')->select('noOfDayDeduct')->sum('noOfDayDeduct');

                if($pending_leave != null ){
                   // dd($pending_leave);

                   return redirect()->back()->with('message', 'Pending Leave Application Found');

                }

               
                $key = 1;
                $x = 0;

                // for($i=$d;$i<=$num;$i++){

                for ($i = $from; $i <= $to; $i->modify('+1 day')) {
                    $flag= '';

                   
    

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

                         
                        
                        // if (!empty($flag)) {

                            // $data['attendance_info'][$v_employee->user_id][date('W', strtotime($sdate))][$sdate] = $this->RRReportService->getAttendances($v_employee->user_id, $sdate, $v_employee->name, $month,$project_name->project_name, $flag);
                 
 
                            if ($flag != 'h'){
                             $data['attendance_info'][$v_employee->user_id][date('W', strtotime($sdate))][$sdate] = $this->RRReportService->getAttendances($v_employee->user_id, $sdate, $v_employee->name, $month, $project_name->project_name,$v_employee->user->exit_date,$v_employee->user->ml_from_date,$v_employee->user->ml_to_date,$v_employee->start_date,$v_employee->end_date);

                             $cl[$v_employee->user_id] = $this->RRReportService->getleave($v_employee->user_id, $month,$year);
                        $pl[$v_employee->user_id] = $this->RRReportService->getpl($v_employee->user_id, $month,$year);
                        $sl_count[$v_employee->user_id] = $this->RRReportService->getsl($v_employee->user_id, $month,$year);
                        $lop_count[$v_employee->user_id] = $this->RRReportService->getlop($v_employee->user_id, $month,$year);
                        $unit_rate[$v_employee->user_id] = $this->RRReportService->getrate($v_employee->user_id);
                            }



                        $i = Carbon::parse($i);

                    }
                }

                 //dd($workingday);


            }

          //   dd($data['attendance_info']);


 

        }

    

        return view('report.rr.index', compact('employee_info', 'data', 'cl', 'pl','sl_count', 'unit_rate', 'from', 'project_list', 'project_manager','lop_count','ml_employee'));
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
