<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Projectmaster;
use App\Models\TeamAllocations;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class projects extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('superadmin.projectsmaster.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $today = Carbon::now();
        $ml_employee  = User::where('gender','=','Female')
        ->where('ml_from_date','<=',$today)->where('ml_to_date','>=',$today)       
        ->select('id')->get();
        $user = User::where('role', '!=',  'employee')->where('employee_status', '=', '1')->whereNotIn('id',$ml_employee)->select('id', 'name', 'employee_code','last_name')->get();

        return view('superadmin.projectsmaster.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d');


        $project = $request->validate(
            [

                'project_id'        => 'required|alpha_num|unique:projectmasters',
                'project_name'      => 'required|unique:projectmasters',
                'project_manager'   => 'required',
                'project_location'  => 'required | alpha',
                'start_date'        => 'required|date',
                'end_date'          => 'required| date |after:start_date',
                "billing_mode"      => "required",
                "currency"          => "required | alpha",

            ],
            $message = [
                'end_date.after'            =>  'The end date must be greater than start date.',
                'project_id.required'       =>  'The project code field is required.',
                'project_id.unique'         =>  'The project id has been already taken.',
                'project_id.alpha_num'      =>  'The project code must only contain letters and numbers.',
                'project_name.required'     =>  'The project title field is required.',
                'project_name.unique'       =>  'The project name has been already taken.',
                'project_name.alpha_spaces' =>  'The project title must only contain letters and space.',
                'project_location.alpha'    =>  'The location must only contain letters.',
                'project_location.required' =>  'The location field is required.',
            ]
        );

        $projectmaster = new Projectmaster;

        $projectmaster->project_id         = $request->project_id;
        $projectmaster->project_name       = $request->project_name;

        $projectmaster->location           = $request->project_location;
        $projectmaster->user_id            = $request->project_manager;
        $projectmaster->start_date         = $start_date;
        $projectmaster->end_date           = $end_date;
        $projectmaster->billing_mode       = $request->billing_mode;
        $projectmaster->currency           = $request->currency;
        $projectmaster->created_by         = Auth::id();
        $projectmaster->updated_by         = Auth::id();

        $projectmaster->save();
        return redirect()->route('projects.index')->with('message', 'Project Created Successfully.');
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
        $user = User::where('role', '!=',  'employee')->where('employee_status', '=', '1')->select('id', 'name','last_name')->get();
        $projectmaster = Projectmaster::find($id);
        return view('superadmin.projectsmaster.edit', compact('projectmaster', 'user'));
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

        $today = Carbon::now();
        $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d');


        $project = $request->validate(
            [



                'start_date'        => 'required|date',
                'end_date'          => 'required|after:start_date',
                "billing_mode"      => "required",
                "currency"          => "required",
                'project_manager'   => 'required',
                'project_location'  => 'required',


            ],
            $message = [
                'end_date.after'            =>  'The end date must be greater than start date.',
                'project_id.required'       =>  'The project code field is required.',
                'project_location.alpha'    =>  'The location must only contain letters.',
                'project_location.required' =>  'The location field is required.',
            ]
        );
        $projectmaster = Projectmaster::find($id);


        $projecthasteam = TeamAllocations::where('project_id', $id)->exists();
        $projecthasteamdate = TeamAllocations::where('project_id', $id)->select('end_date')->get();


        if ($projecthasteam == 'true') {
            /* if($request->project_manager != $projectmaster->user_id ){
                return back()->with('error', 'Trying To change Name Of Project Manager With  Team Assigned');
            }*/
            if ($request->project_location != $projectmaster->location) {
                return back()->with('error', 'Trying to change Location Of Project With  Team Assigned');
            }
            if ($request->currency != $projectmaster->currency) {
                return back()->with('error', 'Trying to change Currency of Project with Team Assigned');
            }
            if ($request->billing_mode != $projectmaster->billing_mode) {
                return back()->with('error', 'Trying to change Billing Mode Of Project With  Team Assigned');
            }
            if ($start_date != $projectmaster->start_date) {
                return back()->with('error', 'Trying to change Start Date Of Project With  Team Assigned');
            }
            foreach ($projecthasteamdate as $pro) {
                if ($end_date < $pro->end_date) {
                    return back()->with('error', 'Trying to change the End Date of the Project with Team Allocation having end date greater than the selected date.');
                }
            }
        }


        if ($id != $projectmaster->id) {
            return back()->with('error', 'Project Id Does not match');
        }

        if ($request->project_manager != $projectmaster->user_id) {            
           
            $projectmaster->user_id             = $request->project_manager;
            $projectmaster->old_project_manager = $projectmaster->getOriginal('user_id');
            $projectmaster->old_pm_end_date     = $today;
        }


        $projectmaster->location           = $request->project_location;
        $projectmaster->billing_mode       = $request->billing_mode;

        $projectmaster->currency           = $request->currency;
        $projectmaster->start_date         = $start_date;
        $projectmaster->end_date           = $end_date;
        $projectmaster->updated_by         = Auth::id();


        $projectmaster->update();
        return redirect()->route('projects.index')->with('message', 'Project Updated Successfully.');
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


    public function changeStatus($id)
    {
        $getStatus = Projectmaster::select('status')->where('id', $id)->first();
        if ($getStatus->status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        Projectmaster::where('id', $id)->update(['status' => $status]);
        TeamAllocations::with('project')->where('project_id', $id)->update(['status' => $status]);
        return redirect()->back()->with('message3', 'status changed');
    }
}
