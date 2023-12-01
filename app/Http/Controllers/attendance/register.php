<?php

namespace App\Http\Controllers\attendance;

use App\Http\Controllers\Controller;
use App\Models\holidaymodel;
use App\Models\LeaveApplication;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\attendanceregister;
use App\Services\register_report;
use Carbon\Carbon;

class register extends Controller
{
    private $register_report;

    public function __construct(register_report $register_report){
        $this->register_report = $register_report;
    }

    
    public function index(Request $request)
    {


        if ($request->from_date  == '') {

            
             
            return view('report.attendance-register.register');
        }

        if ($request->from_date != '' && $request->to_date) {


            $validate = $request->validate([

                'from_date' => 'required |date',
                'to_date' => 'required |date|after_or_equal:from_date'

            ],

                $message = [

                    'to_date.after_or_equal'    =>  'To Date should be greater than From Date.'
                ]
          );

           
            $to = Carbon::parse($request->to_date);
            $from = Carbon::parse($request->from_date);

            // $today = Carbon::today() ;
            // dd($from);

            $month = $from->month;
            $year = $from->year;
            $num = $to->diffInDays($from) + 1;
            $d = $from->format('d');
            $d = (int)$d;

            

            // $today = Carbon::today() ;
            // dd(gettype($d));


            // $date=$today;
            ///$month=$today->month;
            // $year=$today->year;
            // $num = $today->daysInMonth;
            
            //$employee_info=$data['employee_info']= User::where('employee_status','=','1')->orderBy('employee_code','ASC')->get();    
            $employee_info=$data['employee_info']= User::whereDate('exit_date','>=',$from)->select('id','joining_date','exit_date','name','employee_code','maternity_leave','ml_from_date','ml_to_date','designation_id','last_name','middle_name')->orderBy('joining_date','ASC')->get();    

            $relieved_employee = User::whereDate('exit_date', '>=', $from)
            ->whereDate('exit_date', '<=', $to)->select('id','name','exit_date')->orderBy('employee_code','ASC')->get();

            
            $ml_employee  = User::where('gender','=','Female')
            ->whereBetween('ml_to_date',[$from, $to])
            ->orWhereBetween('ml_from_date',[$from, $to])
            ->orWhere(function($q) use($from,$to){
                    $q->where('ml_to_date','>=',$to)->where('ml_from_date','<=',$from);
            })        
            ->select('id','name','ml_from_date','ml_to_date')->orderBy('joining_date','ASC')->get();
               
            
            if ($employee_info->isEmpty()) {

                return redirect()->back()->with('message', 'No Employee Found');
            }
            // dd($project_manager);
            if ($month >= 1 && $month <= 9) {
                $yymm = $year . '-' . '0' . $month;
            } else {
                $yymm = $year . '-' . $month;
            }

            $holiday = holidaymodel::whereMonth('holidaydate', $month)->whereYear('holidaydate', $year)->where('holidaystatus','=',1)->select('holidaydate')->pluck('holidaydate')->toArray();
            
             
        
            
            foreach ($data['employee_info'] as $sl => $v_employee) {
                $key = 1;
                $x = 0;

                
                //$emp_leave = LeaveApplication::where('user_id', $v_employee->id)->whereMonth('startDate',$month)->orderBy('startDate', 'ASC')->select('startDate')->pluck('startDate')->toArray();

               // dd($emp_leave);

                // for($i=$d;$i<=$num;$i++){

                for ($i = $from; $i <= $to; $i->modify('+1 day')) {

                    $flag='';

                    $join = Carbon::parse($v_employee->joining_date);
                    $end = Carbon::parse($v_employee->exit_date);

                    if($i->greaterThan ($end) ){

                        //dd('yes'. $v_employee->id);
                    
                        $i = $i->format('Y-m-d');

                        $sdate = $i;
                        //  dd($sdate);


                        $data['week_info'][date('W', strtotime($sdate))][$sdate] = $sdate;

                        $data['attendance_info'][$v_employee->id][date('W', strtotime($sdate))][$sdate] = $this->register_report->getempty($v_employee->id, $sdate); 
                        
                        

                        $cl[$v_employee->id] = $this->register_report->getleave($v_employee->id, $month);
                        $pl[$v_employee->id] = $this->register_report->getpl($v_employee->id, $month);
                        $unit_rate[$v_employee->id] =  $this->register_report->getrate($v_employee->id);

                        
                           
                        
                   
                        $i = Carbon::parse($i);

                    }elseif($i->lessThan ($join) ){
                        
                        $i = $i->format('Y-m-d');

                       $sdate = $i;
                       //  dd($sdate);


                       $data['week_info'][date('W', strtotime($sdate))][$sdate] = $sdate;

                       $data['attendance_info'][$v_employee->id][date('W', strtotime($sdate))][$sdate] = $this->register_report->getempty($v_employee->id, $sdate); 
                        $i = Carbon::parse($i);
                   

                  }elseif ($i->isWeekend()) {

                        $i = $i->format('Y-m-d');

                        $sdate = $i;
                        //  dd($sdate);


                        $data['week_info'][date('W', strtotime($sdate))][$sdate] = $sdate;

                        $data['attendance_info'][$v_employee->id][date('W', strtotime($sdate))][$sdate] = $this->register_report->getweekend($v_employee->id, $sdate); 
                        
                        $i = Carbon::parse($i);


                    }else{

                        
 

                        $i = $i->format('Y-m-d');

                        $sdate = $i;
                        //  dd($sdate);


                        $data['week_info'][date('W', strtotime($sdate))][$sdate] = $sdate;

                        

                        if (!empty($holiday)) {
                            foreach ($holiday as $v_holiday) {
                                if ($v_holiday == $sdate) {
                                    $flag = 'HOL';
                                    
                                    
                                }
                            }
                            
                        }


                           
                        
                        if (!empty($flag)) {

                            
                            
                            $data['attendance_info'][$v_employee->id][date('W', strtotime($sdate))][$sdate] = $this->register_report->getAttendances($v_employee->id, $sdate, $flag,$v_employee->ml_from_date,$v_employee->ml_to_date);
                        } else {
                            $data['attendance_info'][$v_employee->id][date('W', strtotime($sdate))][$sdate] = $this->register_report->getAttendances($v_employee->id, $sdate,$flag, $v_employee->ml_from_date,$v_employee->ml_to_date);
                        }
                       
                        $cl[$v_employee->id] = $this->register_report->getleave($v_employee->id, $month);
                        $pl[$v_employee->id] = $this->register_report->getpl($v_employee->id, $month);
                        $unit_rate[$v_employee->id] =  $this->register_report->getrate($v_employee->id);


                        //echo "<pre>";
                        /// print_r($data['attendance_info']);
                        // echo "</pre>";

                        $i = Carbon::parse($i);
                        // dd($data['attendance_info']);
                        
                }
                }
                  // dd($data['attendance_info']);
                //dd($workingday);
                

            }
     //dd($data['attendance_info']);

             // dd($data['attendance_info']);


        }

        return view('report.attendance-register.register', compact('employee_info', 'data', 'cl', 'pl', 'unit_rate', 'from','relieved_employee','ml_employee'));
    }

}