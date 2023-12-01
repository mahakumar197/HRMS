<?php

namespace App\Http\Controllers\yearleave;

use App\Http\Controllers\Controller;
use App\Models\LeaveApplication;
use App\Models\Projectmaster;
use App\Models\User;
use App\Services\leave_record_service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class leave_record extends Controller
{
    private $leave_record_service;

    public function __construct(leave_record_service $leave_record_service)
    {
        $this->leave_record_service = $leave_record_service;
    }

    public function index(Request $request)
    {


        if ($request->from_date == '') {



            return view('report.leave-record.index');
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


            $to = Carbon::parse($request->to_date);
            $from = Carbon::parse($request->from_date);

            // $today = Carbon::today() ;
            //  dd($to);

            $from_month = $from->month;
            $year = $from->year;
            $num = $to->diffInDays($from) + 1;
            $d = $from->format('d');
            $d = (int)$d;

            $to_month = $to->month;
            $to_year = $to->year;




            // $today = Carbon::today() ;

            $active_date = $to->format('Y-m-d');

            // $date=$today;
            ///$month=$today->month;
            // $year=$today->year;
            // $num = $today->daysInMonth;
            // $employee_info=$data['employee_info']=User::get();


            $employee_info = $data['employee_info'] = User::whereYear('exit_date', '>=', $year)->select('id', 'name','last_name' ,'designation_id', 'exit_date', 'employee_code', 'joining_date')->orderBy('joining_date', 'ASC')->get();

            $relieved_employee = User::whereDate('exit_date', '>=', $from)
                ->whereDate('exit_date', '<=', $to)->select('id', 'name', 'exit_date')->orderBy('joining_date', 'ASC')->get();

            $ml_employee  = User::where('gender', '=', 'Female')->whereDate('ml_from_date', '!=', 'null')
                ->whereDate('ml_to_date', '!=', 'null')
                ->whereBetween('ml_to_date', [$from, $to])
                ->orWhereBetween('ml_from_date', [$from, $to])
                ->orWhere(function ($q) use ($from, $to) {
                    $q->where('ml_to_date', '>=', $to)->where('ml_from_date', '<=', $from);
                })->select('id', 'name', 'ml_from_date', 'ml_to_date')->orderBy('joining_date', 'ASC')->get();




            foreach ($data['employee_info'] as $sl => $v_employee) {




                $pending_leave = LeaveApplication::whereMonth('startDate', '=', $from_month)->where('user_id', $v_employee->user_id)
                    ->whereMonth('endDate', '=', $to_month)->where('leaveStatus', '=', '0')->select('noOfDayDeduct')->sum('noOfDayDeduct');

                if ($pending_leave != null) {
                    // dd($pending_leave);

                    return redirect()->back()->with('message', 'Pending Leave Application Found');
                }




                $data['details'][$v_employee->id]  = $this->leave_record_service->getcl($v_employee->id, $from_month, $to_month, $v_employee->name, $v_employee->last_name, $v_employee->joining_date, $v_employee->employee_code, $relieved_employee, $year, $to_year);
                //$data['pl'][$v_employee->id]  = $this->yearleavereportService->getpl($v_employee->id,$sdate);
                //$data['sl'][$v_employee->id]  = $this->yearleavereportService->getsl($v_employee->id,$sdate);






            }



            // dd($data['details']);


        }


        return view('report.leave-record.index', compact('employee_info', 'data', 'from', 'year', 'relieved_employee', 'to', 'ml_employee'));
    }
}
