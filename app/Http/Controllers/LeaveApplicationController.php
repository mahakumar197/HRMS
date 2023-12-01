<?php

namespace App\Http\Controllers;

use App\Models\attendance;
use App\Models\holidaymodel;
use App\Models\LeaveApplication;
use App\Models\LeaveApplicationSummary;
use App\Models\LeaveEntitlement;
use App\Models\LeaveType;
use App\Models\TeamAllocations;
use App\Models\User;
use App\Models\WorkingDay;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Services\leaveEventService;


class LeaveApplicationController extends Controller
{

    public $leaveEventService;

    public function __construct(leaveEventService $leaveEventService)
    {

        $this->leaveEventService = $leaveEventService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $joinDate = $user->joining_date;
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

                if ($thisYearEntitlement != null) {
                    $item = new LeaveApplicationSummary;
                    $item->leaveType = $thisYearEntitlement->leaveType;
                    $item->entitlement = $thisYearEntitlement->entitlement;
                    if ($thisYearEntitlement->entitlement - $thisYearApplicationSum < 0) {
                        $item->balance = 0;
                    } else {
                        $item->balance = $thisYearEntitlement->entitlement - $thisYearApplicationSum;
                    }
                    if ($thisYearApplicationSum_pending != 0) {
                        $item->pending = $thisYearApplicationSum_pending;
                    } else {
                        $item->pending = 0;
                    }
                    $item->used = $thisYearApplicationSum;
                    $entitlements->add($item);
                }
            }
        }

        $leave_details_emp =  LeaveApplication::where('user_id', $user->id)->get();


        return view('leave.index', compact('leave_details_emp', 'leaveType', 'entitlements', 'user', 'now'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $user = Auth::user();

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

                if ($thisYearEntitlement != null) {
                    $item = new LeaveApplicationSummary;
                    $item->leaveType = $thisYearEntitlement->leaveType;
                    $item->entitlement = $thisYearEntitlement->entitlement;
                    if ($thisYearEntitlement->entitlement - $thisYearApplicationSum < 0) {
                        $item->balance = 0;
                    } else {
                        $item->balance = $thisYearEntitlement->entitlement - $thisYearApplicationSum;
                    }
                    if ($thisYearApplicationSum_pending != 0) {
                        $item->pending = $thisYearApplicationSum_pending;
                    } else {
                        $item->pending = 0;
                    }
                    $item->used = $thisYearApplicationSum;
                    $entitlements->add($item);
                }
            }
        }

        $lop_visible = collect();
        foreach ($entitlements as $ent) {

            if ($ent->leaveType == "CL") {
                $lop_visible[$ent->leaveType] = $ent->balance;
            } elseif ($ent->leaveType == "PL") {
                $lop_visible[$ent->leaveType] = $ent->balance;
            } elseif ($ent->leaveType == "SL") {
                $lop_visible[$ent->leaveType] = $ent->balance;
            } else {
                $lop_visible[$ent->leaveType] = $ent->balance;
            }
        }


        $check_ml = User::where('id', '=', $user->id)->select('ml_from_date', 'ml_to_date')->first();

        if ($check_ml->ml_from_date != null && Carbon::now()->greaterThanOrEqualTo(Carbon::parse($check_ml->ml_from_date)) && $check_ml->ml_to_date != null && Carbon::now()->lessThanOrEqualTo(Carbon::parse($check_ml->ml_to_date))) {

            $ml_exists = 'true';
        } else {

            $ml_exists = 'false';
        }
        return view('leave.create', compact('leave_type', 'entitlements', 'ml_exists', 'lop_visible'));
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
                'leave_type_id'     => 'required|not_in:0',
                'startDate'         => 'required|date',
                'endDate'           => 'required|date|after_or_equal:startDate',
                'leaveReason'       => 'required | max:100',
                'fullDay'           => 'required'
            ],
            $message = [
                'endDate.after_or_equal'    =>  'To Date should be greater than From Date.',
                'leave_type_id.required'    =>  'The leave type field is required.',
                'startDate.required'        =>  'The from date field is required.',
                'endDate.required'          =>  'The to date field is required.',
                'leaveReason.required'      =>  'The leave reason field is required.',
                'fullDay.required'          =>  'The leave session field is required.'
            ]
        );


        $user = Auth::user();
        $startDate = Carbon::parse($request->startDate);
        $endDate = Carbon::parse($request->endDate);

        //Check Leave date//

        $end_of_month = Carbon::now()->endOfMonth();

        if ($startDate > $end_of_month) {
            return back()->with('error2', 'Future Month Leaves Are Not Allowed.');
        }

        //Check ML//

        $check_ml = User::where('id', '=', $request->use_id)->select('ml_from_date', 'ml_to_date')->first();

        if ($check_ml->ml_from_date != null && $startDate->greaterThanOrEqualTo(Carbon::parse($check_ml->ml_from_date)) && $check_ml->ml_to_date != null && $endDate->lessThanOrEqualTo(Carbon::parse($check_ml->ml_to_date))) {

            return back()->with('error2', 'You are on Maternity Leave.');
        }

        $check_primary_project = TeamAllocations::where('user_id', $user->id)->where('is_primary_project', '=', 'yes')->count();

        if ($check_primary_project == 0) {
            return back()->with('error2', 'You have no primary project');
        }

        if ($request->fullDay != 0.5) {
            $noOfDayApplied = $endDate->diffInDays($startDate) + 1;
        } else {
            $noOfDayApplied = $endDate->diffInDays($startDate) + 0.5;
        }


        //totalWorkingDays Calculation//

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

        //Total Holiday Calculation//

        $startDate = Carbon::parse($request->startDate);
        $endDate = Carbon::parse($request->endDate);
        $publicHolidays = holidaymodel::where('holidaystatus', '=', 1)->whereYear('holidaydate', Carbon::now()->year)->get();
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


        //  $checkLeave = LeaveApplication::where('user_id', Auth::user()->id)
        //     ->whereDate('startDate', '<=', $startDate)->whereDate('endDate', '>=', $endDate)
        //     ->where('leaveStatus', '<=', '1')->select('leaveStatus')->get()->first();


        $checkLeave_all  = LeaveApplication::where('user_id', Auth::user()->id)
            ->whereBetween('startDate', [$startDate, $endDate])
            ->orWhereBetween('endDate', [$startDate, $endDate])
            ->orWhere(function ($q) use ($startDate, $endDate) {
                $q->where('endDate', '>=', $endDate)->where('startDate', '<=', $startDate);
            })->select('leaveStatus', 'user_id', 'id')
            ->get();


        $checkLeave = $checkLeave_all->filter(function ($value) use ($user) {
            return $value->user_id  == $user->id;
        });

        $checkLeave = $checkLeave->first();

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


        if ($totalDeduct <= 0) {
            return back()->with('error2', 'Leave applied on a holiday.');
        }

        //Check Attendance

        $attendance = attendance::where('user_id', $user->id)->where('attendance_date', '=', Carbon::parse($request->startDate))->select('total_working_hours')->first();

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
            ->where('users.id', '=', $user->id)
            ->select(['leave_types.name',  'leave_entitlements.entitlement', 'leave_entitlements.year'])
            ->get();

        if (count($leaveEntitlement) > 0) {
            $leaveType = $leaveEntitlement->first();


            $myLeaveEntitlement = $leaveEntitlement
                ->where('year', '=', Carbon::now()->format('Y'))
                ->first();

            $totalLeaveApplied = LeaveApplication::where('user_id', $user->id)->whereIn('leaveStatus', [0, 1])
                ->where('leave_type_id', $request->leave_type_id)->whereYear('startDate', Carbon::now()->format('Y'))->sum('noOfDayDeduct');


            if ($leaveType->name == 'CL') {
                $lt = 'Casual Leave';
            } elseif ($leaveType->name == 'PL') {
                $lt = 'Privilege Leave';
            } elseif ($leaveType->name == 'SL') {
                $lt = 'Sick Leave';
            }
            $today = Carbon::now();
            $pm_search = TeamAllocations::where('user_id', Auth()->user()->id)->where('is_primary_project', '=', 'yes')->with(['project' => function ($project) {
                $project->select('id', 'user_id', 'project_name')->get();
            }])->whereDate('start_date', '<=', $today)->whereDate('end_date', '>=', $today)->select('id', 'project_id')->get()->first();

            $pm_id = $pm_search->project->user_id;
            $pm = User::where('id', $pm_id)->select('name')->first();

            if ($myLeaveEntitlement == null) {
                $lastLeaveEntitlement = $leaveEntitlement
                    ->sortByDesc('year')
                    ->first();
                if (($lastLeaveEntitlement->entitlement - $totalLeaveApplied) >= $totalDeduct) {
                    $id = $this->addLeave($request, $user, $noOfDayApplied, $totalWorkingDays, $totalPublicHoliday, $totalDeduct, $leaveType);

                    $user_details = ([
                        'emp_id'        => Auth()->user()->id,
                        'emp_name'      => Auth()->user()->name,
                        'last_name'     => Auth()->user()->last_name,
                        'start_date'    => $request->startDate,
                        'end_date'      => $request->endDate,
                        'leave_type_id' => $request->leave_type_id,
                        'no_of_days'    => $totalDeduct,
                        'leave_reason'  => $request->leaveReason,
                        'approved_by'   => $pm->name,
                        'project_name'  => $pm_search->project->project_name,
                    ]);
                    $event = $this->leaveEventService->mailevent($user_details);
                    return redirect()->route('leave.index')->with('message', 'Leave Applied');
                } else {
                    return back()->with('error2', 'Check ' . $lt . ' availability.');
                }
            } else {
                if (($myLeaveEntitlement->entitlement - $totalLeaveApplied) >= $totalDeduct) {

                    $id = $this->addLeave($request, $user, $noOfDayApplied, $totalWorkingDays, $totalPublicHoliday, $totalDeduct, $leaveType);

                    $user_details = ([
                        'emp_id'        => Auth()->user()->id,
                        'emp_name'      => Auth()->user()->name,
                        'last_name'     => Auth()->user()->last_name,
                        'start_date'    => $request->startDate,
                        'end_date'      => $request->endDate,
                        'leave_type_id' => $request->leave_type_id,
                        'no_of_days'    => $totalDeduct,
                        'leave_reason'  => $request->leaveReason,
                        'approved_by'   => $pm->name,
                        'project_name'  => $pm_search->project->project_name,
                    ]);

                    $event = $this->leaveEventService->mailevent($user_details);

                    return redirect()->route('leave.index')->with('message', 'Leave Applied');
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
            'name'              => $user->name . ' - ' . $leaveType->name,
            'fullDay'           => $request->fullDay,
            'user_id'           => $user->id,
            'leave_type_id'     => $request->leave_type_id,
            'noOfDayApplied'    => $noOfDayApplied,
            'noOfWorkingDay'    => $noOfWorkingDay,
            'noOfPublicHoliday' => $noOfPublicHoliday,
            'noOfDayDeduct'     => $totalDeduct,
            'leaveReason'       => $request->leaveReason,
            'leaveStatus'       => Config::get('constants.application_status.under_process'),

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
        $leave_application = LeaveApplication::find($id);
        $status = LeaveApplication::where('id', $id)->where('leaveStatus', '=', '1')->exists();
        if ($status == true && Auth::user()->role != 'super_admin') {
            abort(403);
        } else {


            $user = User::where('id', $leave_application->user_id)->first();
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

                    if ($thisYearEntitlement != null) {
                        $item = new LeaveApplicationSummary;
                        $item->leaveType = $thisYearEntitlement->leaveType;
                        $item->entitlement = $thisYearEntitlement->entitlement;
                        if ($thisYearEntitlement->entitlement - $thisYearApplicationSum < 0) {
                            $item->balance = 0;
                        } else {
                            $item->balance = $thisYearEntitlement->entitlement - $thisYearApplicationSum;
                        }
                        if ($thisYearApplicationSum_pending != 0) {
                            $item->pending = $thisYearApplicationSum_pending;
                        } else {
                            $item->pending = 0;
                        }
                        $item->used = $thisYearApplicationSum;
                        $entitlements->add($item);
                    }
                }
            }


            $leave = LeaveApplication::find($id);
            $leave_type = LeaveType::all();
            return view('leave.edit', compact('leave', 'leave_type', 'entitlements'));
        }
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

        $leave = LeaveApplication::find($id);

        if ($request->startDate != null) {
            $this->validate(
                $request,
                [
                    'leave_type_id'     => 'required|not_in:0',
                    'startDate'         => 'required|date',
                    'endDate'           => 'required|date|after_or_equal:startDate',
                    'leaveReason'       => 'required | max:100',
                ],
                $message = [
                    'endDate.after_or_equal'    =>  'To Date should be greater than From Date',
                    'leave_type_id.required'    =>  'The leave type field is required',
                    'startDate.required'        =>  'The start date field is required',
                    'endDate.required'          =>  'The end date field is required',
                    'leaveReason.required'      =>  'The leave reason field is required',
                ]
            );
        }
        if ($request->startDate == null) {

            $request->startDate = $leave->startDate;
            $request->endDate   = $leave->endDate;

            $this->validate(
                $request,
                [
                    'leave_type_id'     => 'required|not_in:0',
                    'leaveReason'       => 'required | max:100',
                ],
                $message = [
                    'leave_type_id.required'    =>  'The leave type field is required',
                    'leaveReason.required'      =>  'The leave reason field is required',
                ]
            );
        }

        $user = User::where('id', $request->use_id)->select('id', 'name')->first();

        if ($request->startDate == null) {

            $startDate = Carbon::parse($leave->startDate);
            $endDate = Carbon::parse($leave->endDate);
        } else {

            $startDate = Carbon::parse($request->startDate);
            $endDate = Carbon::parse($request->endDate);
        }


        if ($request->fullDay) {
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

        if ($request->startDate == null) {

            $startDate = Carbon::parse($leave->startDate);
            $endDate = Carbon::parse($leave->endDate);
        } else {

            $startDate = Carbon::parse($request->startDate);
            $endDate = Carbon::parse($request->endDate);
        }

        if ($totalWorkingDays == 0) {
            return back()->with('error2', 'Leave applied on a weekend.');
        }


        $publicHolidays = holidaymodel::where('holidaystatus', '=', 1)->whereYear('holidaydate', Carbon::now()->year)->get();

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

        /*$checkLeave = LeaveApplication::where('user_id', $user->id)
            ->whereDate('startDate', '<=', $startDate)->whereDate('endDate', '>=', $endDate)
            ->where('leaveStatus', '<=', '1')->where('id', '!=', $id)->get()->first();*/

        $checkLeave_all  = LeaveApplication::where('user_id', Auth::user()->id)
            ->whereBetween('startDate', [$startDate, $endDate])
            ->orWhereBetween('endDate', [$startDate, $endDate])
            ->orWhere(function ($q) use ($startDate, $endDate) {
                $q->where('endDate', '>=', $endDate)->where('startDate', '<=', $startDate);
            })->select('leaveStatus', 'user_id', 'id')
            ->get();


        $checkLeave = $checkLeave_all->filter(function ($value) use ($user, $id) {

            return $value->user_id  == $user->id && $value->id != $id;
        });



        $checkLeave = $checkLeave->first();


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

        $pm_search = TeamAllocations::where('user_id', $user->id)->where('is_primary_project', '=', 'yes')->with(['project' => function ($project) {
            $project->select('id', 'user_id')->get();
        }])->select('id', 'project_id')->get()->first();

        $pm_id = $pm_search->project->user_id;
        $pm = User::where('id', $pm_id)->select('name')->first();

        $joinDate = $user->joining_date;

        $diffYears = Carbon::now()->diffInYears($joinDate) + 1;

        $leaveEntitlement = DB::table('leave_entitlements')
            ->join('leave_types', 'leave_types.id', '=', 'leave_entitlements.leave_type_id')
            ->join('users', 'users.id', '=', 'leave_entitlements.user_id')
            ->where('leave_types.id', '=', $request->leave_type_id)
            ->where('users.id', '=', $user->id)
            ->select(['leave_types.name',  'leave_entitlements.entitlement', 'leave_entitlements.year'])
            ->get();


        if (count($leaveEntitlement) > 0) {
            $leaveType = $leaveEntitlement->first();

            $myLeaveEntitlement = $leaveEntitlement
                ->where('year', '=', Carbon::now()->format('Y'))
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
                    $id = $this->updateLeave($request, $user, $noOfDayApplied, $totalWorkingDays, $totalPublicHoliday, $totalDeduct, $leaveType, $id);

                    $user_details = ([

                        'emp_id'        => $user->id,
                        'emp_name'      => $user->name,
                        'last_name'     => Auth()->user()->last_name,
                        'start_date'    => $request->startDate,
                        'end_date'      => $request->endDate,
                        'leaveReason'   => $request->leaveReason,
                        'leave_type_id' => $request->leave_type_id,
                        'update_by'     => Auth::user()->id,
                        'no_of_days'    => $totalDeduct,
                        'leave_reason'  => $request->leaveReason,
                        'approved_by'   => $pm->name,
                        'project_name'  => $pm_search->project->project_name,
                    ]);

                    if (auth()->user()->id == $user->id) {
                        $event = $this->leaveEventService->mailevent($user_details);
                    }


                    if (Auth::user()->role == 'super_admin' && Auth::user()->id != $user->id) {
                        return redirect()->route('manageleave.index')->with('message', 'Leave Updated');
                    } else {

                        return redirect()->route('leave.index')->with('message', 'Leave Updated');
                    }
                } else {
                    return back()->with('error2', 'Check ' . $lt . ' availability.');
                }
            } else {
                if (($myLeaveEntitlement->entitlement - $totalLeaveApplied) >= $totalDeduct) {

                    $id = $this->updateLeave($request, $user, $noOfDayApplied, $totalWorkingDays, $totalPublicHoliday, $totalDeduct, $leaveType, $id);

                    $user_details = ([

                        'emp_id'        => $user->id,
                        'emp_name'      => $user->name,
                        'last_name'     => Auth()->user()->last_name,
                        'start_date'    => $request->startDate,
                        'end_date'      => $request->endDate,
                        'leaveReason'   => $request->leaveReason,
                        'leave_type_id' => $request->leave_type_id,
                        'update_by'     => Auth::user()->id,
                        'no_of_days'    => $totalDeduct,
                        'leave_reason'  => $request->leaveReason,
                        'approved_by'   => $pm->name,
                        'project_name'  => $pm_search->project->project_name,
                    ]);


                    if (auth()->user()->id == $user->id) {
                        $event = $this->leaveEventService->mailevent($user_details);
                    }

                    if (Auth::user()->role == 'super_admin' && Auth::user()->id != $user->id) {
                        return redirect()->route('manageleave.index')->with('message', 'Leave Updated');
                    } else {

                        return redirect()->route('leave.index')->with('message', 'Leave Updated');
                    }
                } else {
                    return back()->with('error2', 'Check ' . $lt . ' availability.');
                }
            }
        } else {
            return back()->with('message', trans('message.EntitlementNotDefine'));
        }
    }


    private function updateLeave(Request $request, $user, $noOfDayApplied, $noOfWorkingDay, $noOfPublicHoliday, $totalDeduct, $leaveType, $id)
    {
        $leave = LeaveApplication::find($id);

        $leave->leave_type_id       = $request->leave_type_id;
        $leave->startDate           = Carbon::parse($request->startDate);
        $leave->endDate             = Carbon::parse($request->endDate);
        $leave->fullDay             = $request->fullDay;
        $leave->leaveReason         = $request->leaveReason;
        $leave->noOfDayApplied      = $noOfDayApplied;
        $leave->noOfWorkingDay      = $noOfWorkingDay;
        $leave->noOfPublicHoliday   = $noOfPublicHoliday;
        $leave->noOfDayDeduct       = $totalDeduct;
        $leave->updated_by          = Auth::user()->id;
        $leave->update();
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

    public function cancel(Request $request)
    {

        $validate = $request->validate(
            [

                'remarks' => 'max:100'
            ]
        );

        $id =  $request->id;
        $application = LeaveApplication::find($id);
        $application->remarks = $request->remarks;
        $application->leaveStatus = Config::get('constants.application_status.cancle');
        $application->save();

        //$emp_applied = LeaveApplication::where('id',$id)->select('user_id','leave_type_id','id','noOfDayDeduct','leaveStatus')->first();

        //$entitlement = LeaveEntitlement::where('user_id',$emp_applied->user_id)->where('leave_type_id',$emp_applied->leave_type_id)->select('entitlement','user_id','leave_type_id')->first();

        //$add = $emp_applied->noOfDayDeduct + $entitlement->entitlement;
        //if($emp_applied->leaveStatus == '1'){
        //LeaveEntitlement::where('user_id',$emp_applied->user_id)->where('leave_type_id',$emp_applied->leave_type_id)->update(['entitlement'=>$add]);
        // }
        return redirect()->back()->with('message2', 'Leave has been Cancelled');
    }
}
