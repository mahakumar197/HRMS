<?php

namespace App\Http\Controllers;

use App\Models\attendance;
use App\Models\holidaymodel;
use App\Models\TeamAllocations;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\LeaveApplication;

class AttendanceContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $id = Auth::id();
        $emp_attend = attendance::where('user_id', $id)
            ->orderBy('attendance_date', 'DESC')
            ->get();

        $emp = auth()->user();

        return view('attendance.index', compact('emp_attend',  'emp'));
    }
    public function myAttendance()
    {
        return view('attendance.myattendance');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $now = Carbon::now();
        $id = Auth::id();
        $emp = auth()->user();
        $primary = TeamAllocations::where('user_id', $id)
            ->where('is_primary_project', '=', 'yes')
            ->where('status', '=', '1')
            ->whereDate('end_date', '>=', $now)
            ->with('project')
            ->get('project_id')
            ->first();

        $secondary = TeamAllocations::where('user_id', $id)
            ->where('is_primary_project', '=', 'no')
            ->whereDate('end_date', '>=', $now)
            ->with('project')
            ->get('project_id');

        $now = Carbon::now()->format('Y-m-d');
        $current_secondary = TeamAllocations::where('user_id', $id)->whereDate('end_date', '>=', $now)
            ->where('is_primary_project', '=', 'no')
            ->whereDate('start_date', '<=', $now)
            ->with('project')
            ->get('project_id')->count();


        $team_details = TeamAllocations::with('project')->get();
        $today = Carbon::now()->format('d-m-Y');

        $check_ml = User::where('id', '=', $id)->select('ml_from_date', 'ml_to_date')->first();


        if ($check_ml->ml_from_date != null && Carbon::now()->greaterThanOrEqualTo(Carbon::parse($check_ml->ml_from_date)) && $check_ml->ml_to_date != null && Carbon::now()->lessThanOrEqualTo(Carbon::parse($check_ml->ml_to_date))) {

            $ml_exists = 'true';
        } else {

            $ml_exists = 'false';
        }


        return view('attendance.create', compact('team_details', 'today', 'emp', 'primary', 'secondary', 'current_secondary', 'ml_exists'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $today = Carbon::now()->format('d-m-Y');

        $validate = $request->validate(
            [
                'attendance_date' => "required|date|before_or_equal:$today",
            ],

            $messages = [
                'attendance_date.before_or_equal' => 'Attendance for the future date is not allowed!',
            ]

        );


        $id = Auth::id();
        $r_ad = Carbon::parse($request->attendance_date)->format('Y-m-d');

        //Validate Attendance for Same Date //
        $attendance_date = attendance::where('user_id', $id)->pluck('attendance_date')->toArray();
        $a_date = array_values($attendance_date);
        $result = in_array($r_ad, $a_date);

        //Validate Maternity//

        $check_ml = User::where('id', '=', $id)->select('ml_from_date', 'ml_to_date')->first();
        if ($check_ml->ml_from_date != null && Carbon::parse($request->attendance_date)->greaterThanOrEqualTo(Carbon::parse($check_ml->ml_from_date)) && $check_ml->ml_to_date != null && Carbon::parse($request->attendance_date)->lessThanOrEqualTo(Carbon::parse($check_ml->ml_to_date))) {

            return back()->with('error2', 'You are on Maternity Leave.');
        }

        //Validate Holidays//
        $holiday = holidaymodel::where('holidaystatus', '=', '1')->pluck('holidaydate')->toArray();
        $h_date = array_values($holiday);
        $holiday_result = in_array($r_ad, $h_date);


        if ($holiday_result == true) {

            return back()->with('error2', 'Today is Holiday');
        }

        if (!empty($request->secondary)) {

            $att_value = array_sum(array_column($request->secondary, 'hours'));
        } else {
            $att_value = 0;
        }
        //calculate total number of hours//

        $att_value1 = array_sum(array_column($request->primary_project, 'hours'));
        $att_value3 = $att_value + $att_value1;


        //Validate Leave//
        $leaves = LeaveApplication::where('user_id', $id)->select('id', 'startDate', 'endDate', 'leaveStatus', 'noOfDayDeduct')->get();
        $check = '';


        foreach ($leaves as $leave) {

            $startDate = Carbon::parse($leave->startDate);
            $endDate = Carbon::parse($leave->endDate);
            $check = Carbon::parse($r_ad)->between($startDate, $endDate);
            //$leave = array();

            if ($r_ad == $startDate || $r_ad == $endDate || $check == true) {

                if ($leave->leaveStatus == 0 || $leave->leaveStatus == 1) {
                    if ($leave->noOfDayDeduct >= 1) {
                        return back()->with('error2', 'You are on Leave Today');
                    }
                    if ($leave->noOfDayDeduct == 0.5 && $att_value3 > 4) {
                        return back()->with('error2', 'You are on Leave for half a day');
                    } else if ($leave->noOfDayDeduct == 0.5 && $att_value3 < 4) {

                        return back()->with('error2', 'Minimum 4 Hours Required.');
                    }
                }
            }
        }

        if ($check == false) {
            //Minimum hours Validation//

            if ($att_value3 < 8 || $att_value3 > 24) {

                return back()->with('error2', 'Minimum working hours 8');
            }

            if ($att_value3 > 4 && $att_value3 < 8) {

                return back()->with('error2', 'Please Apply leave before entering the attendance');
            } elseif ($att_value3 == 4) {

                return back()->with('error2', 'Please Apply leave before entering the attendance');
            }
        }
        if ($result == true) {
            return back()->with('error2', 'Attendance Already Entered');
        } else {


            $sec = new attendance;
            $sec->user_id = Auth::id();
            $sec->primary_project = request('primary_project');
            $sec->secondary_project = request('secondary');
            $sec->attendance_date = Carbon::parse($request->attendance_date)->format('Y-m-d');
            $sec->work_from = $request->work_from;

            if ($att_value3 >= 8) {

                $sec->day_count = 1;
            } elseif ($att_value3 == 4) {

                $sec->day_count = 0.5;
            } else {

                return back()->with('error2', 'Please Apply leave before entering the attendance for Half a day ');
            }
            $sec->total_working_hours = $att_value3;
            $sec->save();

            switch (Auth::user()->role) {
                case 'super_admin':
                    return redirect()->route('myattendance')->with('message', 'Attendance Marked');
                    break;
                case 'project_manager':
                    return redirect()->route('myattendance')->with('message', 'Attendance Marked');
                    break;
                case 'employee':
                    return redirect()->route('attendance.index')->with('message', 'Attendance Marked');
                    break;
            }

            /* if (Auth::user()->role == 'super_admin') {
                return redirect()->route('myattendance')->with('message', 'Attendance Marked');
            } elseif (Auth::user()->role == 'project_manager') {
                return redirect()->route('myattendance')->with('message', 'Attendance Marked');
            } else {
                return redirect()->route('attendance.index')->with('message', 'Attendance Marked');
            }*/

            //return redirect()->route('myattendance')->with('message', 'Attendance Marked');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $emp_attend = attendance::find($id);

        $user_id = $emp_attend->user_id;
        $emp =  User::where('id', $user_id)->select('name','last_name', 'employee_code')->first();

        $now = Carbon::now()->format('Y-m-d');

        $secondary_projects = [];
        foreach ($emp_attend['secondary_project'] as $e) {
            $secondary_projects = $e["project"];
        }


        return view('attendance.edit', compact('emp_attend', 'emp', 'secondary_projects', 'user_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $userid = attendance::where('id', $id)->select('user_id')->first();
        $userid = $userid->user_id;


        if (!empty($request->secondary)) {
            $att_value = array_sum(array_column($request->secondary, 'hours'));
        } else {
            $att_value = 0;
        }


        $att_value1 = array_sum(array_column($request->primary_project, 'hours'));
        $att_value3 = $att_value + $att_value1;

        $req_date = Carbon::parse($request->attendance_date);

        $if_leave_exists = LeaveApplication::where('user_id', $userid)->whereDate('startDate', '<=', $req_date)
            ->whereDate('endDate', '>=', $req_date)->where('leaveStatus', '=', '1')->select('noOfDayDeduct', 'leaveStatus')->first();


        $sec = attendance::find($id);


        /*if (!empty($if_leave_exists)) {
           
            if ($att_value3 <= 4 && $if_leave_exists == null || $att_value3 > 24) {
                return back()->with('error2', 'Minimum working hours 8');
            } elseif ($att_value3 < 4 && $if_leave_exists->noOfDayDeduct == 0.5) {               
                return back()->with('error2', 'You have applied leave for half a day !, 4 hours attendance required.');
            } elseif ($att_value3 > 0 && $if_leave_exists->noOfDayDeduct >= 1) {
                return back()->with('error2', 'You have applied leave for fullday');
            }elseif($att_value3 > 4 && $if_leave_exists->noOfDayDeduct == 0.5){
                return back()->with('error2', 'You have applied leave for half a day');
            }
        }
        else{
            if ($att_value3 >= 8) {
                $sec->day_count = 1;
            } elseif ($att_value3 == 4) {
                $sec->day_count = 0.5;
            } else {
                return back()->with('error2', 'Please Apply leave before entering the attendance for Half a day');
            }
        }

        if ($att_value3 > 4 && $att_value3 < 8) {
            return back()->with('error2', 'Minimum Working Hours 8');
        }*/


        $sec->primary_project = request('primary_project');
        $sec->secondary_project = request('secondary');
        $sec->work_from = $request->work_from;
        $sec->total_working_hours = $att_value3;
        $sec->update();

        if (Auth::user()->role == 'super_admin' && Auth::user()->id == $userid) {
            return redirect()->route('myattendance')->with('message', 'Attendance Updated');
        } elseif (Auth::user()->role == 'project_manager' && Auth::user()->id == $userid) {
            return redirect()->route('myattendance')->with('message', 'Attendance Updated');
        } else {
            return redirect()->route('attendance.index')->with('message', 'Attendance Updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
