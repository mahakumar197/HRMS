<?php

namespace App\Http\Controllers;

use App\Mail\newemployee;
use Illuminate\Http\Request;
use App\Models\User;

use App\Models\designation;
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
        return view('superadmin.employee.create')->with('designation', $designation);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validate = $request->validate(
            [

                'email'                     => 'bail|required|email|ends_with:swordgroup.in,s.com|unique:users',
                'password'                  => 'required',
                'employee_code'             => 'required| alpha_num |unique:users',
                'name'                      => 'required | alpha_spaces',
                'middle_name'               => 'alpha_spaces |nullable',
                'last_name'                 => 'required | alpha_spaces',
                'designation_id'            => 'required',
                'joining_date'              => 'required',
                'birth_date'                => 'required',
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
                'experience'                => 'required | numeric',
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

        $now = Carbon::today();
        $exit_date = $now->addYear(20)->format('Y-m-d');

        $image_path = time() . '.' . $request->profile_image->extension();

        $request->profile_image->move(public_path('image'), $image_path);

        $employee = new User;

        $employee->employee_code = $request->employee_code;
        $employee->name                 = $request->name;
        $employee->middle_name          = $request->middle_name;
        $employee->last_name            = $request->last_name;
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
        $employee->password             = Hash::make($request->password);
        $employee->image_path           = $image_path;
        $employee->role                 = $request->role;
        $employee->exit_date            = $exit_date;
        $employee->hobbies              = $request->hobbies;
        $employee->previous_employer    = $request->previous_employer;


        $employee->save();

        $ent_user = User::where('email', '=', $request->email)->select('id', 'name', 'email', 'middle_name', 'last_name', 'password')->first();


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


        Mail::to($ent_user->email)->send(new newemployee($ent_user));


        return redirect()->route('employee.index')->with('message', 'Employee Created Successfully');
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
        $current_primary_project_id = TeamAllocations::where('user_id', Auth::user()->id)->where('is_primary_project', '=', 'yes')
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



        $validate = $request->validate(
            [

                'email'                     => 'bail|required|email|unique:users,email,' . $id,
                'employee_code'             => 'required |alpha_num | unique:users,employee_code,' . $id,
                'name'                      => 'required | alpha_spaces',
                'middle_name'               => 'nullable | alpha_spaces ',
                'last_name'                 => 'required | alpha_spaces',
                'designation_id'            => 'required',
                'joining_date'              => 'required | date',
                'birth_date'                => 'required | date |before:today',
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
                'experience'                => 'required |numeric',
                'skill_set'                 => 'required',
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

        $employee = user::find($id);




        $employee->employee_code = $request->employee_code;
        $employee->name                 = $request->name;
        $employee->middle_name          = $request->middle_name;
        $employee->last_name            = $request->last_name;
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
        $employee->exit_date            = $request->exit_date;
        $employee->hobbies              = $request->hobbies;
        $employee->previous_employer    = $request->previous_employer;
        $employee->maternity_leave      = $request->maternity_leave;

        if ($request->ml_from_date != null && $request->ml_to_date != null) {
            $employee->ml_from_date         = Carbon::parse($request->ml_from_date);
            $employee->ml_to_date           = Carbon::parse($request->ml_to_date);
        }


        if ($employee->isDirty('exit_date')) {

            if ($request_reliving_year <= $current_year) {

                TeamAllocations::where('user_id', $id)->where('end_date', '>=', $request->exit_date)->update(['end_date' => $request->exit_date]);
            }
        }

        $employee->update();


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
