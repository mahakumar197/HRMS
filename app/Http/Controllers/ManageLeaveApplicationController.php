<?php

namespace App\Http\Controllers;

use App\Mail\leaveadmin;
use App\Mail\notifyuser;
use App\Models\LeaveApplication;
use App\Models\TeamAllocations;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ManageLeaveApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $current_month = Carbon::now()->month();
        if (Auth::user()->role != 'employee') {
            $id = Auth::user()->id;
            $leave_details = LeaveApplication::with('user.designation', 'leaveType')->whereHas('user', function ($user) use ($id) {
                $user->where('employee_status', '=', '1')->where('role', '=', 'employee')->whereHas('team', function ($team) use ($id) {
                    $team->where('is_primary_project', '=', 'yes')->whereHas('project', function ($project) use ($id) {
                        $project->where('user_id', $id);
                    });
                });
            })->get();
        }
        /*if(Auth::user()->role =='super_admin'){
            
        $leave_details =  LeaveApplication::whereHas('user',function($user){
            $user->where('role','!=','employee');
        })->get();
        }*/

        return view('projectmanager.manageleave.index', compact('leave_details'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

    public function approve(Request $request)
    {

     
        $validate = $request->validate(
            [

                'remarks' => 'max:100'
            ]

        );
        $id =  $request->id;

        //  dd($request->remarks);

        $application = LeaveApplication::with('user', 'leaveType')->find($id);


        // dd($application);
        $application->remarks = $request->remarks;
        $application->leaveStatus = Config::get('constants.application_status.approve');
        $application->save();
        $today = Carbon::now();
        $to_mail = User::where('id', $application->user_id)->select('email')->first();

        $super_admin = User::where('role', '=', 'super_admin')->where('id', '!=', '43')->Where('employee_status', '=', '1')->select('email')->get();


        $pm_search = TeamAllocations::where('user_id', $application->user_id)->where('is_primary_project', '=', 'yes')->with(['project' => function ($project) {
            $project->select('id', 'user_id','project_name')->get();
        }])->whereDate('start_date', '<=', $today)->whereDate('end_date', '>=', $today)->select('id', 'project_id')->get()->first();
        $pm_id = $pm_search->project->user_id;
        $pm = User::where('id', $pm_id)->select('name')->first();

        $details = ([
            '21q    ' => $application->leaveStatus,
            'start_date'   => Carbon::parse($application->startDate)->format('d-m-y'),
            'end_date' => Carbon::parse($application->endDate)->format('d-m-y'),
            'name' => $application->user->name,
            'last_name' => $application->user->last_name,
            'code' => $application->user->employee_code,
            'Leavetype' => $application->leaveType->name,
            'Leave_reason' => $application->leaveReason,
            'approved_by'   => $pm->name,
            'no_of_days'    => $application->noOfDayDeduct,
            'leaveStatus'   => $application->leaveStatus,
            'project_name'  => $pm_search->project->project_name,
 
        ]);


        Mail::to($to_mail->email)->send(new notifyuser($details));


        foreach ($super_admin as $sa) {


            Mail::to($sa->email)->send(new notifyuser($details));
            Log::info($sa->email);
        }

        return redirect()->back()->with('message', 'Leave has been approved');
    }

    public function reject(Request $request)
    {
        $validate = $request->validate(
            [

                'remarks' => 'max:100'
            ]

        );

        $id =  $request->id;

        $application = LeaveApplication::with('user', 'leaveType')->find($id);

        $application->remarks = $request->remarks;
        $application->leaveStatus = Config::get('constants.application_status.reject');
        $application->save();
        $today = Carbon::now();
        $to_mail = User::where('id', $application->user_id)->select('email')->first();

        // $super_admin = User::where('role','=','super_admin')->select('email')->get();
        $pm_search = TeamAllocations::where('user_id', $application->user_id)->where('is_primary_project', '=', 'yes')->with(['project' => function ($project) {
            $project->select('id', 'user_id','project_name')->get();
        }])->whereDate('start_date', '<=', $today)->whereDate('end_date', '>=', $today)->select('id', 'project_id')->get()->first();
        $pm_id = $pm_search->project->user_id;
        $pm = User::where('id', $pm_id)->select('name')->first();

        

        $details = ([
            'leaveStatus' => $application->leaveStatus,
            'start_date'   => Carbon::parse($application->startDate)->format('d-m-y'),
            'end_date' => Carbon::parse($application->endDate)->format('d-m-y'),
            'name' => $application->user->name,
            'last_name' => $application->user->last_name,
            'code' => $application->user->employee_code,
            'Leavetype' => $application->leaveType->name,
            'Leave_reason' => $application->leaveReason,
            'approved_by'   => $pm->name,
            'no_of_days'    => $application->noOfDayDeduct,
            'leaveStatus'   => $application->leaveStatus,
            'project_name'  => $pm_search->project->project_name,
        ]);




        Mail::to($to_mail->email)->send(new notifyuser($details));




        return redirect()->back()->with('message2', 'Leave has been Rejected');
    }



    public function cancel(Request $request)
    {


        $validate = $request->validate(
            [

                'remarks' => 'max:100'
            ]
        );

        $id =  $request->id;
        $application = LeaveApplication::with('user', 'leaveType')->find($id);
        $application->remarks = $request->remarks;
        $application->leaveStatus = Config::get('constants.application_status.cancle');
        $application->save();

        $to_mail = User::where('id', $application->user_id)->select('email')->first();
        $today = Carbon::now();
        $super_admin = User::where('role', '=', 'super_admin')->where('id', '!=', '43')->Where('employee_status', '=', '1')->select('email')->get();
        $pm_search = TeamAllocations::where('user_id', $application->user_id)->where('is_primary_project', '=', 'yes')->with(['project' => function ($project) {
            $project->select('id', 'user_id','project_name')->get();
        }])->whereDate('start_date', '<=', $today)->whereDate('end_date', '>=', $today)->select('id', 'project_id')->get()->first();
        $pm_id = $pm_search->project->user_id;
        $pm = User::where('id', $pm_id)->select('name')->first();

        $details = ([
            'leaveStatus' => $application->leaveStatus,
            'start_date'   => Carbon::parse($application->startDate)->format('d-m-y'),
            'end_date' => Carbon::parse($application->endDate)->format('d-m-y'),
            'name' => $application->user->name,
            'last_name' => $application->user->last_name,
            'code' => $application->user->employee_code,
            'Leavetype' => $application->leaveType->name,
            'Leave_reason' => $application->leaveReason,
            'approved_by'   => $pm->name,
            'no_of_days'    => $application->noOfDayDeduct,
            'leaveStatus'   => $application->leaveStatus,
            'project_name'  => $pm_search->project->project_name,
        ]);

   


        Mail::to($to_mail->email)->send(new notifyuser($details));


        foreach ($super_admin as $sa) {


            Mail::to($sa->email)->send(new notifyuser($details));
            Log::info($sa->email);
        }

        //$emp_applied = LeaveApplication::where('id',$id)->select('user_id','leave_type_id','id','noOfDayDeduct','leaveStatus')->first();

        //$entitlement = LeaveEntitlement::where('user_id',$emp_applied->user_id)->where('leave_type_id',$emp_applied->leave_type_id)->select('entitlement','user_id','leave_type_id')->first();

        //$add = $emp_applied->noOfDayDeduct + $entitlement->entitlement;
        //if($emp_applied->leaveStatus == '1'){
        //LeaveEntitlement::where('user_id',$emp_applied->user_id)->where('leave_type_id',$emp_applied->leave_type_id)->update(['entitlement'=>$add]);
        // }
        return redirect()->back()->with('message2', 'Leave has been Cancelled');
    }
}
