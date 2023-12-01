<?php

namespace App\Http\Controllers;

use App\Mail\teamallocationpm;
use App\Models\attendance;
use App\Models\designation;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Projectmaster;
use App\Models\TeamAllocations;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use PHPUnit\TextUI\XmlConfiguration\Logging\TeamCity;

class teamallocation extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('superadmin.teamallocation.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $today = Carbon::now();
        $ml_employee  = User::where('gender', '=', 'Female')
            ->where('ml_from_date', '<=', $today)->where('ml_to_date', '>=', $today)
            ->select('id')->get();
        $employees = User::orderby('name', 'asc')->with('designation')->where('employee_status', '=', '1')->whereNotIn('id', $ml_employee)->select('id', 'name', 'last_name', 'employee_code', 'designation_id')->get();
        $projects = Projectmaster::where('status', '=', 1)->select('id', 'project_name')->get();

        return view('superadmin.teamallocation.create', compact('employees', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        //$checkUserRole = User::where('id', $request->userid)->select('role')->get()->first();
        //$getPm = Projectmaster::where('id', $request->projectid)->select('user_id')->get()->first();

        /*if ($checkUserRole->role == 'project_manager') {
            if ($getPm->user_id != $request->userid) {
                return back()->with('error2', 'Trying To Assign To Project Having Different Project Manager');
            }
        }*/


        $startdate = Carbon::parse($request->startdate)->format('Y-m-d'); // $request date format changed to 'Y-m-d' as the request date will be 'd-m-y'
        $enddate = Carbon::parse($request->enddate)->format('Y-m-d');
        $today = Carbon::now()->format('Y-m-d');


        $team = $request->validate(
            [

                "userid"                => "required",
                "startdate"             => "required |date",
                "worktype"              => "required",
                "enddate"               => "required |date|after:startdate",
                "billable"              => "required",
                "is_primary_project"    => "required",
                "shadow"                => "required",
                "unit_rate"             => "required",
                "projectid"             => "required",

            ],

            $message = [
                'userid.required'                => 'The employee name field is required.',
                'startdate.required'             => 'The start date field is required.',
                'enddate.required'               => 'The end date field is required.',
                'worktype.required'              => 'The full time/part time field is required.',
                'billable.required'              => 'The billable field is required.',
                'is_primary_project.required'    => 'The primary project field is required.',
                'shadow.required'                => 'The shadow eligible field is required.',
                'unit_rate.required'             => 'The unit rate field is required.',
                'projectid.required'             => 'The project field is required.',
                'enddate.after'                  => 'The end date must be greater than start date.',

            ]
        );




        $project_start_date = Projectmaster::where('id', $request->projectid)->get('start_date')->first();
        $project_end_date = Projectmaster::where('id', $request->projectid)->get('end_date')->first();
        $p_end = $project_end_date->end_date;
        $p_start = $project_start_date->start_date;

        if ($startdate < $p_start) {
            return back()->with('error2', 'Employee start date and end date must be within Project start date and end date.');
        }
        if ($enddate > $p_end) {
            return back()->with('error2', 'Employee start date and end date must be within Project start date and end date.');
        }

        $p_id = TeamAllocations::where('user_id', $request->userid)->pluck('project_id')->toArray();
        $p_type = TeamAllocations::where('user_id', $request->userid)->where('is_primary_project', '=', 'yes')->whereDate('end_date', '>=', $startdate)->pluck('is_primary_project')->toArray();

        $project_id = array_values($p_id);

        //compare request Project Type in array of Project Type
        $pType = $request->is_primary_project;
        $type_result = in_array($pType, $p_type);

        //compare request Project ID in array of Project ID
        $pId = $request->projectid;
        $result = in_array($pId, $project_id);


        if ($result == true) {

            return back()->with('error2', 'Duplicate record');
        } elseif ($type_result == true) {

            return back()->with('error2', 'Primary project already exist.');
        } else {



            $team = new TeamAllocations;

            $team->user_id              = $request->userid;
            $team->start_date           = $startdate;
            $team->work_type            = $request->worktype;
            $team->end_date             = $enddate;
            $team->billable             = $request->billable;
            $team->is_primary_project   = $request->is_primary_project;
            $team->shadow_eligible      = $request->shadow;
            $team->unit_rate            = $request->unit_rate;
            $team->project_id           = $request->projectid;

            $team->save();



            //email to project manager//


            $empname = user::where('id', '=', $request->userid)->select('name', 'email', 'last_name')->first();
            $project_name = Projectmaster::where('id', '=', $request->projectid)->with('userteam', function ($user) {
                $user->select('email', 'id', 'name');
            })->select('user_id', 'project_name')->first();


            if ($empname->email != null) {


                $teamdetail = ([

                    'startdate' => Carbon::parse($startdate)->format('d-m-Y'),
                    'name' => $empname->name,
                    'last_name' => $empname->last_name,
                    'project_name' => $project_name->project_name,
                    'pm_name'  => $project_name->userteam->name,
                ]);



                Mail::to($project_name->userteam->email)->send(new teamallocationpm($teamdetail));
            }


            return redirect()->route('teamallocation.index')->with('message', 'Team Allocation Created Successfully');
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

        $team = TeamAllocations::with(['project', 'user' => function ($query) {
            $query->with('designation')->select('id', 'name', 'designation_id', 'employee_code','last_name');
        }])->find($id);

        return view('superadmin.teamallocation.edit', compact('team'));
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

        $startdate = Carbon::parse($request->startdate)->format('Y-m-d'); // $request date format changed to 'Y-m-d' as the request date will be 'd-m-y'
        $enddate = Carbon::parse($request->enddate)->format('Y-m-d');

        $team = $request->validate(
            [


                "worktype"              => "required",
                "billable"              => "required",
                "is_primary_project"    => "required",
                "shadow"                => "required",
                "unit_rate"             => "required",
                "startdate"             => "required |date",
                "enddate"               => "required | date | after:startdate",

            ],
            $message = [
                'userid.required'                => 'The employee name field is required.',
                'startdate.required'             => 'The start date field is required.',
                'enddate.required'               => 'The end date field is required.',
                'worktype.required'              => 'The full time/part time field is required.',
                'billable.required'              => 'The billable field is required.',
                'is_primary_project.required'    => 'The primary project field is required.',
                'shadow.required'                => 'The shadow eligible field is required.',
                'unit_rate.required'             => 'The unit rate field is required.',
                'projectid.required'             => 'The project field is required.',
                'enddate.after'                  => 'The end date must be greater than start date.',

            ]
        );


        $today = Carbon::now()->format('Y-m-d');
        $project_start_date = Projectmaster::where('id', $request->projectid)->get('start_date')->first();
        $project_end_date = Projectmaster::where('id', $request->projectid)->get('end_date')->first();
        $p_end = $project_end_date->end_date;
        $p_start = $project_start_date->start_date;

        if ($startdate < $p_start) {
            return back()->with('error2', 'Employee start date and end date must be within Project start date and end date.');
        }
        if ($enddate > $p_end) {
            return back()->with('error2', 'Employee start date and end date must be within Project start date and end date.');
        }


        $team_end_date = TeamAllocations::where('user_id', $request->userid)->where('is_primary_project', '=', 'yes')->where('id', '!=', $id)
            ->orderBy('end_date', 'DESC')->get()->first();


        if ($team_end_date != null && $startdate <= $team_end_date->end_date && $request->is_primary_project == 'yes') {

            return back()->with('error2', 'Primary project already exist.');
        }

        $p_id = TeamAllocations::where('user_id', $request->userid)->where('id', '!=', $id)->pluck('project_id')->toArray();
        $p_type = TeamAllocations::where('user_id', $request->userid)->where('is_primary_project', '=', 'yes')->where('id', '!=', $id)
            ->whereDate('end_date', '>=', $today)->pluck('is_primary_project')->toArray();



        $project_id = array_values($p_id);


        //compare request Project Type in array of Project Type
        $pType = $request->is_primary_project;
        $type_result = in_array($pType, $p_type);


        //compare request Project ID in array of Project ID
        $pId = $request->projectid;
        $result = in_array($pId, $project_id);

        //check attendance for the team

        $team = TeamAllocations::where('id', $id)->first();
        $attend = attendance::whereHas('finduser', function ($u) use ($id) {
            $u->whereHas('team', function ($t) use ($id) {
                $t->where('id', $id);
            });
        })->whereDate('attendance_date', '>=', $team->start_date)->whereDate('attendance_date', '<=', $team->end_date)->orderBy('attendance_date', 'DESC')->take(1)->get()->first();


        if ($attend != null) {

            if ($startdate != $team->start_date) {
                return back()->with('error2', 'Attendace Exists! Start Date cannot be modified.');
            }

            if ($enddate <= $attend->attendance_date) {

                return back()->with('error2', 'Attendace Exists! Choose date greater than the attendance marked.');
            }
        }

        if ($result == true) {
            return back()->with('error2', 'Duplicate record');
        } elseif ($type_result == true) {

            return back()->with('error2', 'Primary project already exist.');
        }

        $team = TeamAllocations::find($id);

        //$team->user_id              = $request->userid;
        $team->work_type            = $request->worktype;
        //$team->project_id           = $request->projectid;
        $team->billable             = $request->billable;
        $team->is_primary_project   = $request->is_primary_project;
        $team->shadow_eligible      = $request->shadow;
        $team->unit_rate            = $request->unit_rate;
        $team->start_date           = $startdate;
        $team->end_date             = $enddate;
        $team->update();


        return redirect()->route('teamallocation.index')->with('message', 'Team Allocation Updated Successfully.');
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

        // $employees = User::orderby('name', 'asc')->with('designation')->where('employee_status','=','1')->whereNotIn('id',$ml_employee)->select('id', 'name', 'employee_code', 'designation_id')->limit(5)->get();


        $search = $request->search;

        if ($search == '') {
            $employees = User::orderby('name', 'asc')->with('designation')->where('employee_status', '=', '1')->whereNotIn('id', $ml_employee)->select('id', 'name', 'last_name', 'employee_code', 'designation_id')->limit(5)->get();
        } else {
            $employees = User::orderby('name', 'asc')->with('designation')->where('employee_status', '=', '1')->whereNotIn('id', $ml_employee)->select('id', 'name', 'last_name', 'employee_code', 'designation_id')->where('name', 'like', '%' . $search . '%')->limit(5)->get();
        }

        $response = array();
        foreach ($employees as $employee) {

            $response[] = array("value" => $employee->id, "label" => $employee->name, "label2" => $employee->employee_code, "designation" => $employee->designation->designation);
        }

        return response()->json($response);
    }

    function fetchProject(Request $request)
    {
        $today = Carbon::today();
        $search = $request->search;

        if ($search == '') {
            $projects = Projectmaster::orderby('project_name', 'asc')->where('end_date', '>=', $today)->select('id', 'project_name', 'start_date', 'end_date')->limit(5)->get();
        } else {
            $projects = Projectmaster::orderby('project_name', 'asc')->where('end_date', '>=', $today)->select('id', 'project_name', 'start_date', 'end_date')->where('project_name', 'like', '%' . $search . '%')->limit(5)->get();
        }

        $response = array();
        foreach ($projects as $project) {

            $response[] = array("value" => $project->id, "label" => $project->project_name, 'startDate' => $project->start_date, 'endDate' => $project->end_date);
        }

        return response()->json($response);
    }

    public function getDesignation(Request $request)
    {
        if ($request->employeeId) {
            $user = User::where('id', $request->employeeId)->select('id', 'designation_id')->first();
            if ($user) {
                return response()->json(['status' => 'success', 'data' => $user->designation->designation], 200);
            }
            return response()->json(['status' => 'failed', 'message' => 'No employees found'], 404);
        }
        return response()->json(['status' => 'failed', 'message' => 'Please select employee'], 500);
    }

    public function getProjectTimeline(Request $request)
    {
        if ($request->projectId) {
            $project = Projectmaster::where('id', $request->projectId)->select('start_date', 'end_date')->first();
            $date = ['startDate'=>Carbon::parse($project->start_date)->format('d-m-Y'), 'endDate'=> Carbon::parse($project->end_date)->format('d-m-Y')];
            if ($date) {
                return response()->json(['status' => 'success', 'data' => $date], 200);
            }
            return response()->json(['status' => 'failed', 'message' => 'No projects found'], 404);
        }
        return response()->json(['status' => 'failed', 'message' => 'Please select project'], 500);
    }
}
