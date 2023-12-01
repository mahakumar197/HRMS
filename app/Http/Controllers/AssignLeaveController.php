<?php

namespace App\Http\Controllers;

use App\Models\attendance;
use Illuminate\Http\Request;
use App\Models\holidaymodel;
use App\Models\LeaveApplication;
use App\Models\LeaveApplicationSummary;
use App\Models\LeaveEntitlement;
use App\Models\LeaveType;
use App\Models\User;
use App\Models\WorkingDay;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\Environment\Console;

class AssignLeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $leave_type = LeaveType::get();
        $today = Carbon::now();
        $ml_employee  = User::where('gender', '=', 'Female')
            ->where('ml_from_date', '<=', $today)->where('ml_to_date', '>=', $today)
            ->select('id')->get();
        $employees = User::orderby('name', 'asc')->whereHas('team', function ($t) {
            $t->whereHas('project', function ($p) {
                $p->where('user_id', Auth::id());
            })->where('is_primary_project', '=', 'yes');
        })->where('employee_status', '=', '1')->whereNotIn('id', $ml_employee)->select('id', 'name', 'employee_code','last_name')->get();
        $entitlements = [];
        return view('leave.assignLeave', compact('leave_type', 'employees', 'entitlements'));
    }

    public function getEmpLeaveBalance(Request $request)
    {
        if ($request->employeeId) {
            $user = User::where('id', $request->employeeId)->select('id')->first();

            $leave_type = LeaveType::get();
            $now = Carbon::now()->format('Y-m-d');
            $currentYear = Carbon::now()->year;
            $leaveTypes = LeaveType::all();

            $allEntitlements = LeaveEntitlement::leftjoin('leave_types', 'leave_types.id', '=', 'leave_entitlements.leave_type_id')
                ->where('user_id', '=', $user->id)
                ->select(['leave_types.name as leaveType', 'year', 'leave_types.id as leaveTypeId', 'leave_entitlements.id', 'year', 'entitlement'])
                ->get();


            $all_leave_applications = LeaveApplication::where('user_id', '=', $user->id)
                ->whereYear('startDate', Carbon::now()->format('Y'))
                ->where('leaveStatus', '=', '1')
                ->select(['leave_type_id', 'noOfDayDeduct', 'startDate', 'endDate'])
                ->get();

            $pending_leave_applications = LeaveApplication::whereYear('startDate', Carbon::now()->format('Y'))
                ->where('user_id', '=', $user->id)
                ->where('leaveStatus', '=', '0')
                ->select(['leave_type_id', 'noOfDayDeduct', 'startDate', 'endDate'])
                ->get();

            $entitlements = collect();
            foreach ($leaveTypes as $leaveType) {
                if ($leaveType->id != 6) {
                    $thisYearEntitlement = $allEntitlements
                        ->where('year', '=', $currentYear)
                        ->where('leaveTypeId', '=', $leaveType->id)
                        ->first();

                    $thisYearApplicationSum = $all_leave_applications
                        ->where('leave_type_id', '=', $leaveType->id)
                        ->sum('noOfDayDeduct');

                    $thisYearApplicationSum_pending = $pending_leave_applications
                        ->where('leave_type_id', '=', $leaveType->id)
                        ->sum('noOfDayDeduct');

                    if ($thisYearEntitlement != null && $thisYearEntitlement->leaveType != 'LOP') {
                        $item = new LeaveApplicationSummary;
                        $item->leaveType = $thisYearEntitlement->leaveType;
                        if ($thisYearEntitlement->entitlement - $thisYearApplicationSum < 0) {
                            $item->balance = 0;
                        } else {
                            $item->balance = $thisYearEntitlement->entitlement - $thisYearApplicationSum;
                        }
                        $entitlements->add($item);
                    }
                }
            }

            $leaveBalance = $entitlements->mapWithKeys(function ($item) {
                return [$item['leaveType'] => $item['balance']];
            });

            if ($leaveBalance) {
                return response()->json(['status' => 'success', 'data' => $leaveBalance], 200);
            }
            return response()->json(['status' => 'failed', 'message' => 'No projects found'], 404);
        }
        return response()->json(['status' => 'failed', 'message' => 'Please select project'], 500);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate(
            $request,
            [
                'leave_type_id'     =>  'required|not_in:0',
                'startDate'         =>  'required|date',
                'endDate'           =>  'required|date|after_or_equal:startDate',
                'leaveReason'       =>  'required',
                'fullDay'           =>  'required',
                'user_id'           =>   'required',
            ],
            $message = [
                'fullDay.required' => 'Select Leave Days'
            ]
        );
        $user = User::where('id', $request->user_id)->get()->first();


        $startDate = Carbon::parse($request->startDate);
        $endDate = Carbon::parse($request->endDate);

        $check_ml = User::where('id', '=', $request->user_id)->select('ml_from_date', 'ml_to_date')->first();



        if ($check_ml->ml_from_date != null && $startDate->greaterThanOrEqualTo(Carbon::parse($check_ml->ml_from_date)) && $check_ml->ml_to_date != null && $endDate->lessThanOrEqualTo(Carbon::parse($check_ml->ml_to_date))) {

            return back()->with('error2', 'Employee is on Maternity Leave.');
        }


        if ($request->fullDay != 0.5) {
            $noOfDayApplied = $endDate->diffInDays($startDate) + 1;
        } else {
            $noOfDayApplied = $endDate->diffInDays($startDate) + 0.5;
        }


        $totalWorkingDayList = WorkingDay::select(['day', 'fullDay'])->get();



        if (count($totalWorkingDayList) == 0) {

            return redirect()->back()->with('message1', 'No Working Days');
        }

        $totalWorkingDays = 0;


        for ($date = $startDate; $date <= $endDate; $date->modify('+1 day')) {
            $dayOfWeek = $date->dayOfWeek;

            $day = $totalWorkingDayList->where('day', $dayOfWeek)->first();

            if ($day != null) {
                if ($day->fullDay) {
                    $totalWorkingDays++;
                } else {
                    $totalWorkingDays = $totalWorkingDays + 0.5;
                }
            }
        }


        if ($totalWorkingDays == 0) {
            return back()->with('error2', 'Leave applied on a weekend.');
        }

        $startDate = Carbon::parse($request->startDate);
        $endDate = Carbon::parse($request->endDate);
        $publicHolidays = holidaymodel::get();
        $totalPublicHoliday = 0;

        foreach ($publicHolidays as $publicHoliday) {

            $start_holiday = Carbon::parse($publicHoliday->holidaydate);
            $end_holiday = Carbon::parse($publicHoliday->holidaydate);



            for ($date = $start_holiday; $date <= $end_holiday; $date->modify('+1 day')) {

                $dayOfWeek = $date->dayOfWeek;

                if ($date->gte($startDate) and $date->lte($endDate)) {

                    $day = $totalWorkingDayList->where('day', $dayOfWeek)->first();

                    if ($day != null) {
                        if ($day->fullDay) {
                            if ($publicHoliday->fullDay) {
                                $totalPublicHoliday++;
                            } else {
                                $totalPublicHoliday = $totalPublicHoliday + 0.5;
                            }
                        } else {
                            $totalPublicHoliday = $totalPublicHoliday + 0.5;
                        }
                    }
                }
            }
        }

        $checkLeave = LeaveApplication::where('user_id', $request->user_id)->whereDate('startDate', '<=', $startDate)->whereDate('endDate', '>=', $endDate)->where('leaveStatus', '<=', '1')->select('leaveStatus')->get()->first();


        if (!empty($checkLeave) && $checkLeave->leaveStatus == '0') {

            return back()->with('error2', 'Leave Already Exists | Status Pending');
        }
        if (!empty($checkLeave) && $checkLeave->leaveStatus == '1') {

            return back()->with('error2', 'Leave Already Exists | Status Approved');
        }


        $fullDay = 0.5; //half day
        if ($request->fullDay == '1') {
            $fullDay = 1;
        } elseif ($request->fullDay == '2') {
            $fullDay = 1;
        }

        $totalDeduct = ($totalWorkingDays - $totalPublicHoliday) * $fullDay;
        if ($totalDeduct < 0) {
            return back()->with('error2', 'Leave applied on a holiday.');
        }


        //Check Attendance

        $attendance = attendance::where('user_id', $request->user_id)->where('attendance_date', '=', Carbon::parse($request->startDate))->select('total_working_hours')->first();

        if (!empty($attendance)) {

            if ($fullDay >= 1 && $attendance->total_working_hours > 0) {

                return back()->with('error2', 'You have marked attendance for full day, update hours to 0 before applying full day leave.');
            }
            if ($fullDay = 0.5 && $attendance->total_working_hours > 4) {

                return back()->with('error2', 'You have marked attendance for full day, update hours to 4 before applying half a day leave.');
            }
        }


        $joinDate = $user->joining_date;
        $diffYears = Carbon::now()->diffInYears($joinDate) + 1;


        $leaveEntitlement = DB::table('leave_entitlements')
            ->join('leave_types', 'leave_types.id', '=', 'leave_entitlements.leave_type_id')
            ->join('users', 'users.id', '=', 'leave_entitlements.user_id')
            ->where('leave_types.id', '=', $request->leave_type_id)
            ->where('users.id', '=', $request->user_id)
            ->select(['leave_types.name',  'leave_entitlements.entitlement', 'leave_entitlements.year'])
            ->get();


        if (count($leaveEntitlement) > 0) {

            $leaveType = $leaveEntitlement->first();
            $myLeaveEntitlement = $leaveEntitlement
                ->where('year', '=', $diffYears)
                ->first();
            if ($leaveType->name == 'CL') {
                $lt = 'Casual Leave';
            } elseif ($leaveType->name == 'PL') {
                $lt = 'Privilege Leave';
            } elseif ($leaveType->name == 'SL') {
                $lt = 'Sick Leave';
            }

            $totalLeaveApplied = LeaveApplication::where('user_id', $user->id)->whereIn('leaveStatus', [0, 1])
                ->where('leave_type_id', $request->leave_type_id)->whereYear('startDate', Carbon::now()->format('Y'))->sum('noOfDayDeduct');

            if ($myLeaveEntitlement == null) {
                $lastLeaveEntitlement = $leaveEntitlement
                    ->sortByDesc('year')
                    ->first();

                if (($lastLeaveEntitlement->entitlement - $totalLeaveApplied) >= $totalDeduct) {
                    $id = $this->addLeave($request, $user, $noOfDayApplied, $totalWorkingDays, $totalPublicHoliday, $totalDeduct, $leaveType);
                    return redirect()->route('manageleave.index')->with('message', 'Leave Assigned');
                } else {
                    return back()->with('error2', 'Check ' . $lt . ' availability.');
                }
            } else {
                if (($myLeaveEntitlement->entitlement - $totalLeaveApplied) >= $totalDeduct) {
                    $id = $this->addLeave($request, $user, $noOfDayApplied, $totalWorkingDays, $totalPublicHoliday, $totalDeduct, $leaveType);
                    return redirect()->route('manageleave.index')->with('message', 'Leave Assigned');
                } else {
                    return back()->with('error2', 'Check ' . $lt . ' availability.');
                }
            }
        } else {
            return back()->with('message', trans('message.EntitlementNotDefine'));
        }
    }
    private function addLeave(Request $request, $user, $noOfDayApplied, $noOfWorkingDay, $noOfPublicHoliday, $totalDeduct, $leaveType)
    {

        $id = LeaveApplication::Create([
            'startDate'         => Carbon::parse($request->startDate),
            'endDate'           => Carbon::parse($request->endDate),
            'name'              => $request->name . ' - ' . $leaveType->name,
            'fullDay'           => $request->fullDay,
            'user_id'           => $request->user_id,
            'leave_type_id'     => $request->leave_type_id,
            'noOfDayApplied'    => $noOfDayApplied,
            'noOfWorkingDay'    => $noOfWorkingDay,
            'noOfPublicHoliday' => $noOfPublicHoliday,
            'noOfDayDeduct'     => $totalDeduct,
            'leaveReason'       => $request->leaveReason,
            'leaveStatus'       => Config::get('constants.application_status.under_process'),
            'assignedBy'        => Auth::user()->id,

        ])->id;
        return $id;
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
        //
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
        //
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

    function fetchEmployee(Request $request)
    {

        $today = Carbon::now();
        $ml_employee  = User::where('gender', '=', 'Female')
            ->where('ml_from_date', '<=', $today)->where('ml_to_date', '>=', $today)
            ->select('id')->get();

        $search = $request->search;

        if (Auth::user()->role == 'project_manager') {


            if ($search == '') {

                $employees = User::orderby('name', 'asc')->whereHas('team', function ($t) {
                    $t->whereHas('project', function ($p) {
                        $p->where('user_id', Auth::id());
                    })->where('is_primary_project', '=', 'yes');
                })->where('employee_status', '=', '1')->whereNotIn('id', $ml_employee)->select('id', 'name', 'employee_code')->get();
            } else {
                $employees = User::orderby('name', 'asc')->whereHas('team', function ($t) {
                    $t->whereHas('project', function ($p) {
                        $p->where('user_id', Auth::id());
                    })->where('is_primary_project', '=', 'yes');
                })->where('employee_status', '=', '1')->whereNotIn('id', $ml_employee)->select('id', 'name', 'employee_code')->where('name', 'like', '%' . $search . '%')->limit(5)->get();
            }
        } elseif (Auth::user()->role == 'super_admin') {

            if ($search == '') {

                $employees = User::orderby('name', 'asc')->whereHas('team', function ($t) {
                    $t->whereHas('project', function ($p) {
                        $p->where('user_id', Auth::id());
                    })->where('is_primary_project', '=', 'yes');
                })->where('employee_status', '=', '1')->whereNotIn('id', $ml_employee)->select('id', 'name', 'employee_code')->get();
            } else {
                $employees = User::orderby('name', 'asc')->whereHas('team', function ($t) {
                    $t->whereHas('project', function ($p) {
                        $p->where('user_id', Auth::id());
                    })->where('is_primary_project', '=', 'yes');
                })->where('employee_status', '=', '1')->whereNotIn('id', $ml_employee)->select('id', 'name', 'employee_code')->where('name', 'like', '%' . $search . '%')->limit(5)->get();
            }
        }

        $response = array();
        foreach ($employees as $employee) {

            $response[] = array("value" => $employee->id, "label" => $employee->name, "label2" => $employee->employee_code);
        }

        return response()->json($response);
    }
}
