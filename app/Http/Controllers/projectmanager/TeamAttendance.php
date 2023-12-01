<?php

namespace App\Http\Controllers\projectmanager;

use App\Http\Controllers\Controller;
use App\Models\attendance;
use App\Models\designation;
use App\Models\Projectmaster;
use App\Models\TeamAllocations;
use App\Models\User;
use App\Services\TeamAttendanceService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeamAttendance extends Controller
{

 

    private $TeamAttendanceService;

    public function __construct(TeamAttendanceService $TeamAttendanceService){

        $this->TeamAttendanceService = $TeamAttendanceService;

    }
    public function index(){

        $primary =  Projectmaster::where('user_id', Auth::user()->id)->get();        

       
        return view('projectmanager.team.teamattendance',compact('primary'));
    }

    public function pmsearch(Request $request){ 

        
                        
        $current_project_id = $request ->project;
        $current_project_name =  Projectmaster::where('id',$request->project)->select('project_name')->first();
       
        $checkid = Auth::user()->id;
        $today = Carbon::now();

        $ml_employee  = User::where('gender','=','Female')
        ->where('ml_from_date','<=',$today)->where('ml_to_date','>=',$today)       
        ->select('id')->get();

        $employees = User::whereHas('team',function($team) use($current_project_id,$checkid,$today){
            $team ->where('is_primary_project','=','yes')->where('end_date','>=',$today)->where('project_id','=',$current_project_id)->whereHas('project',function($project) use($checkid){
                $project->where('user_id',$checkid);
            });
        })->with('designation')->where('employee_status','=','1')->whereNotIn('id',$ml_employee)->select('id','name','employee_code','image_path','designation_id','last_name')->get();

        $primary =  Projectmaster::where('user_id', Auth::user()->id)->get();
       
       
      

       return view('projectmanager.team.teamattendance',compact('employees','primary','current_project_name'));;
    }

    public function submitteam(Request $request)
    { 
       
        
        if(empty($request->user)){
            return back()->with('error', 'Select atleast one employee to submit the Team Attendance.');
        }

        $project = $request->current_project;
        $today = Carbon::now()->format('d-m-Y');
        $validate = $request->validate(
            [

                'attend_date' => "required|date|before_or_equal:$today",

            ],

            $messages = [
                'attend_date.before_or_equal' => 'Attendance for the future date is not allowed!',
            ]

        );

        

        $entered_user_id =  $this->TeamAttendanceService->submitattend($request);

       

         $data = User::findMany($entered_user_id);

         $primary =  Projectmaster::where('user_id', Auth::user()->id)->get();

        return redirect()->route('teamattendance')->with('message','Attendance Marked');

       // dd($primary);
       // return view('projectmanager.team.teamattendance',compact('primary','data','project'))->with('message', 'Attendance Marked');

        // return back()->with(['data' => $data])->with('message', 'Attendance Marked');

    }
}
