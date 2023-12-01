<?php

namespace App\Http\Controllers;

use App\Models\TeamAllocations;
use App\Models\User;
use App\Services\assignattendpm;
 
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 

class AssignAttendanceController extends Controller
{

    private $assignattendpm;
	public function __construct(assignattendpm $assignattendpm){
		$this->assignattendpm = $assignattendpm;
	}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       //if(Auth::user()->role == 'project_manager'){
        $today=Carbon::now();
        $ml_employee  = User::where('gender','=','Female')
        ->where('ml_from_date','<=',$today)->where('ml_to_date','>=',$today)       
        ->select('id')->get();
        $employee = User::orderby('name','asc')->whereHas('team',function($t) use($today){
            $t->whereHas('project',function($p){
                $p->where('user_id',Auth::user()->id);
            })->where('is_primary_project','=','yes')->where('end_date','>=',$today);
        })->where('employee_status','=','1')->whereNotIn('id',$ml_employee)->select('id','name','employee_code','last_name')->get();

      // }

      // elseif(Auth::user()->role == 'super_admin'){

      //  $employee = User::select('id','name')->get();

      // }


       return view('attendance.assignattendance', compact('employee'));
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
        $output = $this->assignattendpm->store($request);
          
        return redirect()->route('assignattendance.index');
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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

    public function filter(Request $request)
    {
                 
        $output = $this->assignattendpm->filteremp($request);
        
        return $output;
    }



    function empfetchAssAttend(Request $request)
    {

        $search = $request->search;

        if($search == ''){
            $employees = User::orderby('name','asc')->select('id','name','employee_code')->limit(5)->get();
        }else{
            $employees = User::orderby('name','asc')->select('id','name','employee_code')->where('name', 'like', '%' .$search . '%')->limit(5)->get();
        }
  
        

        $response = array();
        foreach($employees as $employee){

           $response[] = array("value"=>$employee->id,"label"=>$employee->name,"label2"=>$employee->employee_code);

        }
     
  
        return response()->json($response); 
    }


    function empfetchAssAttendEmpCode(Request $request)
    {

        $search = $request->search;

        if($search == ''){
            $employees = User::orderby('name','asc')->select('id','name','employee_code')->limit(5)->get();
        }else{
            $employees = User::orderby('name','asc')->select('id','name','employee_code')->where('employee_code', 'like', '%' .$search . '%')->limit(5)->get();
        }
  
        

        $response = array();
        foreach($employees as $employee){

           $response[] = array("value"=>$employee->id,"label"=>$employee->name,"label2"=>$employee->employee_code);

        }
     
  
        return response()->json($response); 
    }
    

}
