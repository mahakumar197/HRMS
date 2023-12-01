<?php

namespace App\Http\Controllers;

use App\Mail\HREmployeeMail;
use App\Mail\newemployee;
use App\Mail\teamallocationpm;
use App\Models\Candidate;
use Illuminate\Http\Request;
use App\Models\User;

use App\Models\designation;
use App\Models\Job;
use App\Models\JobOffer;
use App\Models\LeaveEntitlement;
use App\Models\LeaveType;
use App\Models\Projectmaster;
use App\Models\TeamAllocations;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\Types\Null_;

class employeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('superadmin.employee.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $designation = designation::all();
        return Auth::user()->role == 'super_admin' ?  view('superadmin.employee.create')->with('designation', $designation) : redirect()->route('job.index');
    }


    public function candidateToEmployee($id)
    {
        $designation = designation::all();
        $candidate = Candidate::where('id', $id)->first();
        $candidate_offer = JobOffer::where('can_id', $id)->select('joining_date')->first();
        if ($candidate->emp_id == null) {
            return view('superadmin.employee.candidate-to-emp', compact('candidate', 'candidate_offer'))->with('designation', $designation);
        } else {
            return redirect()->route('employee.index')->with('message', 'Employee Already Created');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (Auth::user()->role == 'super_admin') {

            $validate = $request->validate(
                [

                    'email'                     => 'bail|required|email|ends_with:swordgroup.in,s.com|unique:users',
                    'employee_code'             => 'required| alpha_num |unique:users',
                    'name'                      => 'required | alpha_spaces',
                    'middle_name'               => 'alpha_spaces |nullable',
                    'last_name'                 => 'nullable | alpha_spaces',
                    'designation_id'            => 'required',
                    'joining_date'              => 'required',
                    'birth_date'                => 'required |before_or_equal:' . \Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
                    'gender'                    => 'required',
                    'marital_status'            => 'required',
                    'phone_number'              => 'required|numeric |digits:10|unique:users',
                    'emergency_contact'         => 'required|numeric| digits:10 |unique:users',
                    'res_address'               => 'required',
                    'res_city'                  => 'required | alpha_spaces',
                    'per_address'               => 'required',
                    'res_state'                 => 'required | alpha_spaces',
                    'per_city'                  => 'required | alpha_spaces',
                    'res_postal_code'           => 'required|numeric|digits:6',
                    'per_state'                 => 'required | alpha_spaces',
                    'nationality'               => 'required | alpha',
                    'per_postal_code'           => 'required|numeric|digits:6',
                    'dependency_name'           => 'required |alpha_spaces',
                    'dependency'                => 'required',
                    'higest_qualification'      => 'required | alpha_spaces',
                    'employee_status'           => 'required',
                    'aadhar_number'             => 'required| numeric | unique:users',
                    'pan_number'                => 'required| alpha_num |unique:users',
                    'experience'                => 'required',
                    'skill_set'                 => 'required ',
                    'profile_image'             => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'role'                      => 'required',
                    'previous_employer'         => 'alpha_spaces |nullable',
                ],

                $message = [
                    'name.required'                   => 'The first name field is required.',
                    'name.alpha_spaces'               => 'The first name must only contain letters and space.',
                    'last_name.alpha_spaces'          => 'The last name must only contain letters and space.',
                    'middle_name.alpha_spaces'        => 'The middle name must only contain letters and space.',
                    'joining_date.required'           => 'The date of joining field is required.',
                    'birth_date.required'             => 'The date of birth field is required.',
                    'higest_qualification.required'   => 'The highest qualification field is required.',
                    'birth_date.before'               => 'Enter valid date of birth.',
                    'employee_code.alpha_num'         => 'The employee code must only contain letters and numbers, without space.',
                    'res_city.required'               => 'The city field is required',
                    'res_city.alpha'                  => 'The city must only contain letters, no space or special character or numbers.',
                    'res_state.alpha'                 => 'The state must only contain letters, no space or special character or numbers.',
                    'res_state.required'              => 'The state field is required.',
                    'res_address.required'            => 'The residential address is required.',
                    'res_postal_code.digits'          => 'The postal code must contain 6 digits.',
                    'res_postal_code.required'        => 'The postal code is required.',
                    'per_city.alpha'                  => 'The city must only contain letters, no space or special character or numbers.',
                    'per_state.alpha'                 => 'The state must only contain letters, no space or special character or numbers.',
                    'per_city.required'               => 'The city field is required.',
                    'per_state.required'              => 'The state field is required.',
                    'per_address.required'            => 'The permanent address is required.',
                    'per_postal_code.required'        => 'The postal code is required.',
                    'per_postal_code.digits'          => 'The postal code must contain 6 digits.',
                    'profile_image.required'          => 'The profile photo field is required.',
                    'email.required'                  => 'The email id field is required.',
                    'designation_id.required'         => 'The desigantion field is required.',
                    'role.required'                   => 'The role field is required.',
                    'experience.required'             => 'The experience field is required.',
                    'skill_set.required'              => 'The skill sets field is required.',
                    'previous_employer'               => 'The previous employer must only contain letters and space.',

                ]
            );
        }

        if (Auth::user()->sub_role == 'hr') {

            $validate = $request->validate(
                [
                    'name'                      => 'required | alpha_spaces',
                    'middle_name'               => 'alpha_spaces |nullable',
                    'last_name'                 => 'nullable | alpha_spaces',
                    'designation_id'            => 'required',
                    'joining_date'              => 'required',
                    'birth_date'                => 'required | before_or_equal:' . \Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
                    'gender'                    => 'required',
                    'marital_status'            => 'required',
                    'phone_number'              => 'required|numeric |digits:10|unique:users',
                    'emergency_contact'         => 'required|numeric| digits:10 |unique:users',
                    'res_address'               => 'required',
                    'res_city'                  => 'required | alpha_spaces',
                    'per_address'               => 'required',
                    'res_state'                 => 'required | alpha_spaces',
                    'per_city'                  => 'required | alpha_spaces',
                    'res_postal_code'           => 'required|numeric|digits:6',
                    'per_state'                 => 'required | alpha_spaces',
                    'nationality'               => 'required | alpha',
                    'per_postal_code'           => 'required|numeric|digits:6',
                    'dependency_name'           => 'required |alpha_spaces',
                    'dependency'                => 'required',
                    'higest_qualification'      => 'required ',
                    'employee_status'           => 'required',
                    'aadhar_number'             => 'required| numeric | unique:users',
                    'pan_number'                => 'required| alpha_num |unique:users',
                    'experience'                => 'required',
                    'skill_set'                 => 'required ',
                    'profile_image'             => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    'role'                      => 'required',
                    'previous_employer'         => 'alpha_spaces |nullable',
                ],

                $message = [
                    'name.required'                   => 'The first name field is required.',
                    'name.alpha_spaces'               => 'The first name must only contain letters and space.',
                    'last_name.alpha_spaces'          => 'The last name must only contain letters and space.',
                    'middle_name.alpha_spaces'        => 'The middle name must only contain letters and space.',
                    'joining_date.required'           => 'The date of joining field is required.',
                    'birth_date.required'             => 'The date of birth field is required.',
                    'higest_qualification.required'   => 'The highest qualification field is required.',
                    'birth_date.before'               => 'Enter valid date of birth.',
                    'employee_code.alpha_num'         => 'The employee code must only contain letters and numbers, without space.',
                    'res_city.required'               => 'The city field is required',
                    'res_city.alpha'                  => 'The city must only contain letters, no space or special character or numbers.',
                    'res_state.alpha'                 => 'The state must only contain letters, no space or special character or numbers.',
                    'res_state.required'              => 'The state field is required.',
                    'res_address.required'            => 'The residential address is required.',
                    'res_postal_code.digits'          => 'The postal code must contain 6 digits.',
                    'res_postal_code.required'        => 'The postal code is required.',
                    'per_city.alpha'                  => 'The city must only contain letters, no space or special character or numbers.',
                    'per_state.alpha'                 => 'The state must only contain letters, no space or special character or numbers.',
                    'per_city.required'               => 'The city field is required.',
                    'per_state.required'              => 'The state field is required.',
                    'per_address.required'            => 'The permanent address is required.',
                    'per_postal_code.required'        => 'The postal code is required.',
                    'per_postal_code.digits'          => 'The postal code must contain 6 digits.',
                    'profile_image.required'          => 'The profile photo field is required.',
                    'email.required'                  => 'The email id field is required.',
                    'designation_id.required'         => 'The desigantion field is required.',
                    'role.required'                   => 'The role field is required.',
                    'experience.required'             => 'The experience field is required.',
                    'skill_set.required'              => 'The skill sets field is required.',
                    'previous_employer'               => 'The previous employer must only contain letters and space.',

                ]
            );
        }


        $now = Carbon::today();
        $exit_date = $now->addYear(20)->format('Y-m-d');
        $image_path = time() . '.' . $request->profile_image->extension();
        $request->profile_image->move(public_path('image'), $image_path);
        $password = Hash::make($request->phone_number);

        $employee = new User;

        $employee->employee_code        = $request->employee_code;
        $employee->name                 = strtoupper($request->name);
        $employee->middle_name          = strtoupper($request->middle_name);
        $employee->last_name            = strtoupper($request->last_name);
        $employee->email                = $request->email;
        $employee->joining_date         = Carbon::parse($request->joining_date);
        $employee->birth_date           = Carbon::parse($request->birth_date);
        $employee->gender               = $request->gender;
        $employee->marital_status       = $request->marital_status;
        $employee->phone_number         = $request->phone_number;
        $employee->emergency_contact    = $request->emergency_contact;
        $employee->res_address          = $request->res_address;
        $employee->designation_id       = $request->designation_id;
        $employee->res_city             = $request->res_city;
        $employee->per_address          = $request->per_address;
        $employee->res_state            = $request->res_state;
        $employee->per_city             = $request->per_city;
        $employee->res_postal_code      = $request->res_postal_code;
        $employee->per_state            = $request->per_state;
        $employee->nationality          = $request->nationality;
        $employee->per_postal_code      = $request->per_postal_code;
        $employee->dependency_name      = $request->dependency_name;
        $employee->dependency           = $request->dependency;
        $employee->higest_qualification = $request->higest_qualification;
        $employee->employee_status      = $request->employee_status;
        $employee->aadhar_number        = $request->aadhar_number;
        $employee->pan_number           = $request->pan_number;
        $employee->experience           = $request->experience;
        $employee->skill_set            = $request->skill_set;
        $employee->password             = $password;
        $employee->image_path           = $image_path;
        $employee->role                 = $request->role;
        $employee->exit_date            = $exit_date;
        $employee->hobbies              = $request->hobbies;
        $employee->previous_employer    = $request->previous_employer;

        $employee->save();

        $ent_user = User::where('phone_number', '=', $request->phone_number)->select('id', 'name', 'email', 'middle_name', 'last_name', 'password', 'phone_number')->first();
        $emp_id = User::where('phone_number', '=', $request->phone_number)->select('id')->first();
        $emp_id = $emp_id->id;

        Candidate::where('id', $request->cid)->update(['emp_id' => $emp_id]);

        $leave_type_id = LeaveType::select('id')->get();

        foreach ($leave_type_id as $l) {

            $entitlement = new LeaveEntitlement;
            $entitlement->user_id = $ent_user->id;
            $entitlement->leave_type_id = $l->id;
            if ($entitlement->leave_type_id == 5) {
                $entitlement->entitlement = 100;
            } elseif ($entitlement->leave_type_id != 2 && $entitlement->leave_type_id != 6) {
                $entitlement->entitlement = 1;
            } elseif ($entitlement->leave_type_id == 2) {
                $entitlement->entitlement = 0;
            } elseif ($entitlement->leave_type_id == 6) {
                $entitlement->entitlement = 0;
            }

            $entitlement->year = Carbon::now()->year;
            $entitlement->save();
        }


        if ($request->email) {

            Mail::to($ent_user->email)->send(new newemployee($ent_user));
        } else {

            $job = Job::with('position', 'project')->where('id', '=', $request->jid)->select('job_code', 'position_id', 'project_id')->first();

            $hr_emp = [

                'name' => $ent_user->name,
                'last_name' => $ent_user->last_name,
                'phone_number' => $ent_user->phone_number,
                'job' => $job->job_code,
                'position' => $job->position->position_name,
                'project'  => $job->project->project_name,
                'id'       => $ent_user->id,
            ];
            $super_admin = User::where('role', '=', 'super_admin')->where('id', '!=', 43)->where('employee_status', '=', 1)->select('email')->get();
            foreach ($super_admin as $sa) {
                Mail::to($sa->email)->send(new HREmployeeMail($hr_emp));
            }
        }


        //Mail::to($ent_user->email)->send(new newemployee($ent_user));
        //Mail::to($ent_user->email)->send(new newemployee($ent_user));


        return redirect()->route('teamallocation.create')->with('message', 'Employee Created Successfully | Allocate Team For The Employee');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {       

        $emp = User::find($id);
        $employee = User::with('designation')->where('id', $id)->get()->first();
        $today = Carbon::now();
        $current_project = TeamAllocations::where('user_id', $id)->whereDate('end_date', '>=', $today)->with('project')->select('project_id')->get();
        $current_primary_project_id = TeamAllocations::where('user_id', $id)->where('is_primary_project', '=', 'yes')
            ->whereDate('start_date', '<=', $today)->whereDate('end_date', '>=', $today)->select('project_id')->first();

        if ($current_primary_project_id != null) {
            $reporting_to = Projectmaster::with('userteam')->where('id', $current_primary_project_id->project_id)->select('user_id', 'id')->first();           
        } else {
            $reporting_to = "-";
        }

        return view('projectmanager.employee-profile', compact('emp', 'employee', 'current_project', 'reporting_to', 'current_primary_project_id'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


        $designation = designation::all();

        $employee = User::find($id);
        $today = Carbon::now();
        $current_primary_project_id = TeamAllocations::where('user_id', $employee->id)->where('is_primary_project', '=', 'yes')
            ->whereDate('start_date', '<=', $today)->whereDate('end_date', '>=', $today)->select('project_id')->first();


        if ($current_primary_project_id != null) {
            $reporting_to = Projectmaster::with('userteam')->where('id', $current_primary_project_id->project_id)->select('user_id', 'id')->first();
        } else {
            $reporting_to = "-";
        }

        return view('superadmin.employee.edit', compact('employee', 'designation', 'current_primary_project_id', 'reporting_to'));
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

        $request_reliving_year = Carbon::parse($request->exit_date)->year;
        $current_year = Carbon::now()->year;

        if (Auth::user()->role == 'super_admin') {

            $validate = $request->validate(
                [
                    'email'                     => 'bail|required|email|unique:users,email,' . $id,
                    'employee_code'             => 'required |alpha_num | unique:users,employee_code,' . $id,
                    'name'                      => 'required | alpha_spaces',
                    'middle_name'               => 'nullable | alpha_spaces ',
                    'last_name'                 => 'nullable | alpha_spaces',
                    'designation_id'            => 'required',
                    'joining_date'              => 'required | date',
                    'birth_date'                => 'required | date |before_or_equal:' . \Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
                    'gender'                    => 'required',
                    'marital_status'            => 'required',
                    'phone_number'              => 'required|numeric|digits:10 | unique:users,phone_number,' . $id,
                    'emergency_contact'         => 'required|numeric|digits:10 | unique:users,emergency_contact,' . $id,
                    'res_address'               => 'required',
                    'res_city'                  => 'required',
                    'per_address'               => 'required',
                    'res_state'                 => 'required',
                    'per_city'                  => 'required',
                    'res_postal_code'           => 'required|numeric|digits:6',
                    'per_state'                 => 'required',
                    'nationality'               => 'required',
                    'per_postal_code'           => 'required|numeric|digits:6',
                    'dependency_name'           => 'required | alpha_spaces',
                    'dependency'                => 'required',
                    'higest_qualification'      => 'required | alpha_spaces',
                    'employee_status'           => 'required',
                    'aadhar_number'             => 'required| numeric | unique:users,aadhar_number,' . $id,
                    'pan_number'                => 'required| alpha_num | unique:users,pan_number,' . $id,
                    'experience'                => 'required',
                    'skill_set'                 => 'required',
                    'role'                      => 'required',
                    'previous_employer'         => 'alpha_spaces | nullable',

                ],
                $message = [
                    'name.required'                   => 'The first name field is required.',
                    'name.alpha_spaces'               => 'The first name must only contain letters and space.',
                    'last_name.alpha_spaces'          => 'The last name must only contain letters and space.',
                    'middle_name.alpha_spaces'        => 'The middle name must only contain letters and space.',
                    'joining_date.required'           => 'The date of joining field is required.',
                    'birth_date.required'             => 'The date of birth field is required.',
                    'higest_qualification.required'   => 'The highest qualification field is required.',
                    'birth_date.before'               => 'Enter valid date of birth',
                    'employee_code.alpha_num'         => 'The employee code must only contain letters and numbers, without space.',
                    'res_city.required'               => 'The city field is required.',
                    'res_city.alpha'                  => 'The city must only contain letters, no space or special character or numbers.',
                    'res_state.alpha'                 => 'The state must only contain letters, no space or special character or numbers.',
                    'res_state.required'              => 'The state field is required.',
                    'res_address.required'            => 'The residential address is required.',
                    'res_postal_code.digits'          => 'The postal code must contain 6 digits.',
                    'res_postal_code.required'        => 'The postal code is required.',
                    'per_city.alpha'                  => 'The city must only contain letters, no space or special character or numbers.',
                    'per_state.alpha'                 => 'The state must only contain letters, no space or special character or numbers.',
                    'per_city.required'               => 'The city field is required.',
                    'per_state.required'              => 'The state field is required.',
                    'per_address.required'            => 'The permanent address is required.',
                    'per_postal_code.required'        => 'The postal code is required.',
                    'per_postal_code.digits'          => 'The postal code must contain 6 digits.',
                    'profile_image.required'          => 'The profile photo field is required.',
                    'email.required'                  => 'The email id field is required.',
                    'designation_id.required'         => 'The desigantion field is required.',
                    'experience.required'             => 'The experience field is required.',
                    'skill_set.required'              => 'The skill sets field is required.',
                    'previous_employer'               => 'The previous employer must only contain letters and space.',
                ]

            );
        }

        if (Auth::user()->sub_role == 'hr') {

            $validate = $request->validate(
                [
                    'name'                      => 'required | alpha_spaces',
                    'middle_name'               => 'nullable | alpha_spaces ',
                    'last_name'                 => 'nullable | alpha_spaces',
                    'designation_id'            => 'required',
                    'joining_date'              => 'required | date',
                    'birth_date'                => 'required | date |before_or_equal:' . \Carbon\Carbon::now()->subYears(18)->format('Y-m-d'),
                    'gender'                    => 'required',
                    'marital_status'            => 'required',
                    'phone_number'              => 'required|numeric|digits:10 | unique:users,phone_number,' . $id,
                    'emergency_contact'         => 'required|numeric|digits:10 | unique:users,emergency_contact,' . $id,
                    'res_address'               => 'required',
                    'res_city'                  => 'required',
                    'per_address'               => 'required',
                    'res_state'                 => 'required',
                    'per_city'                  => 'required',
                    'res_postal_code'           => 'required|numeric|digits:6',
                    'per_state'                 => 'required',
                    'nationality'               => 'required',
                    'per_postal_code'           => 'required|numeric|digits:6',
                    'dependency_name'           => 'required | alpha_spaces',
                    'dependency'                => 'required',
                    'higest_qualification'      => 'required | alpha_spaces',
                    'employee_status'           => 'required',
                    'aadhar_number'             => 'required| numeric | unique:users,aadhar_number,' . $id,
                    'pan_number'                => 'required| alpha_num | unique:users,pan_number,' . $id,
                    'experience'                => 'required',
                    'skill_set'                 => 'required',
                    'role'                      => 'required',
                    'previous_employer'         => 'alpha_spaces | nullable',

                ],
                $message = [
                    'name.required'                   => 'The first name field is required.',
                    'name.alpha_spaces'               => 'The first name must only contain letters and space.',
                    'last_name.alpha_spaces'          => 'The last name must only contain letters and space.',
                    'middle_name.alpha_spaces'        => 'The middle name must only contain letters and space.',
                    'joining_date.required'           => 'The date of joining field is required.',
                    'birth_date.required'             => 'The date of birth field is required.',
                    'higest_qualification.required'   => 'The highest qualification field is required.',
                    'birth_date.before'               => 'Enter valid date of birth',
                    'employee_code.alpha_num'         => 'The employee code must only contain letters and numbers, without space.',
                    'res_city.required'               => 'The city field is required.',
                    'res_city.alpha'                  => 'The city must only contain letters, no space or special character or numbers.',
                    'res_state.alpha'                 => 'The state must only contain letters, no space or special character or numbers.',
                    'res_state.required'              => 'The state field is required.',
                    'res_address.required'            => 'The residential address is required.',
                    'res_postal_code.digits'          => 'The postal code must contain 6 digits.',
                    'res_postal_code.required'        => 'The postal code is required.',
                    'per_city.alpha'                  => 'The city must only contain letters, no space or special character or numbers.',
                    'per_state.alpha'                 => 'The state must only contain letters, no space or special character or numbers.',
                    'per_city.required'               => 'The city field is required.',
                    'per_state.required'              => 'The state field is required.',
                    'per_address.required'            => 'The permanent address is required.',
                    'per_postal_code.required'        => 'The postal code is required.',
                    'per_postal_code.digits'          => 'The postal code must contain 6 digits.',
                    'profile_image.required'          => 'The profile photo field is required.',
                    'email.required'                  => 'The email id field is required.',
                    'designation_id.required'         => 'The desigantion field is required.',
                    'experience.required'             => 'The experience field is required.',
                    'skill_set.required'              => 'The skill sets field is required.',
                    'previous_employer'               => 'The previous employer must only contain letters and space.',
                ]

            );
        }


        $employee = user::find($id);

        $e_email = $employee->email;

        if (Auth::user()->role == 'super_admin') {
            $employee->email                = $request->email;
            $employee->employee_code        = $request->employee_code;
        }
        $employee->name                 = strtoupper($request->name);
        $employee->middle_name          = strtoupper($request->middle_name);
        $employee->last_name            = strtoupper($request->last_name);
        $employee->joining_date         = Carbon::parse($request->joining_date);
        $employee->birth_date           = Carbon::parse($request->birth_date);
        $employee->gender               = $request->gender;
        $employee->marital_status       = $request->marital_status;
        $employee->phone_number         = $request->phone_number;
        $employee->emergency_contact    = $request->emergency_contact;
        $employee->res_address          = $request->res_address;
        $employee->designation_id       = $request->designation_id;
        $employee->res_city             = $request->res_city;
        $employee->per_address          = $request->per_address;
        $employee->res_state            = $request->res_state;
        $employee->per_city             = $request->per_city;
        $employee->res_postal_code      = $request->res_postal_code;
        $employee->per_state            = $request->per_state;
        $employee->nationality          = $request->nationality;
        $employee->per_postal_code      = $request->per_postal_code;
        $employee->dependency_name      = $request->dependency_name;
        $employee->dependency           = $request->dependency;
        $employee->higest_qualification = $request->higest_qualification;
        $employee->employee_status      = $request->employee_status;
        $employee->aadhar_number        = $request->aadhar_number;
        $employee->pan_number           = $request->pan_number;
        $employee->experience           = $request->experience;
        $employee->skill_set            = $request->skill_set;
        $employee->exit_date            = $request->exit_date;
        $employee->hobbies              = $request->hobbies;
        $employee->role                 = $request->role;
        $employee->sub_role             = $request->sub_role;
        $employee->previous_employer    = $request->previous_employer;
        $employee->maternity_leave      = $request->maternity_leave;
        $employee->update_by            = Auth::id();

        if ($request->ml_from_date != null && $request->ml_to_date != null) {
            $employee->ml_from_date         = Carbon::parse($request->ml_from_date);
            $employee->ml_to_date           = Carbon::parse($request->ml_to_date);
        }

        if (Auth::user()->role == 'super_admin' && $employee->isDirty('exit_date')) {

            if ($request_reliving_year <= $current_year) {

                TeamAllocations::where('user_id', $id)->where('end_date', '>=', $request->exit_date)->update(['end_date' => $request->exit_date]);
            }
        }

        $employee->update();


        if ($e_email == null) {

            Mail::to($employee->email)->send(new newemployee($employee));

            $team_alloc = TeamAllocations::with(['project' => function ($p) {

                $p->with(['userteam' => function ($u) {

                    $u->select('name', 'id', 'email','last_name');
                }])->select('project_name', 'id', 'user_id');
            }])->where('user_id', $id)->first();


            if ($team_alloc != null) {

                $teamdetail = ([

                    'startdate' => Carbon::parse($team_alloc->start_date)->format('d-m-Y'),
                    'name' => $employee->name,
                    'last_name'=>$employee->last_name,
                    'project_name' => $team_alloc->project->project_name,
                    'pm_name' => $team_alloc->project->userteam->name,


                ]);

                Mail::to($team_alloc->project->userteam->email)->send(new teamallocationpm($teamdetail));
            }
        }


        return redirect()->route('employee.index')->with('message', 'Employee Updated Successfully.');
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
