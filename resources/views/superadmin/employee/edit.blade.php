@extends('layouts.app')
@section('page_title')
<title>Edit Employee</title>
@endsection
@section('content')
<div id="mail_send"></div>
<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-sm-6">
          <h3> Edit Employee</h3>
        </div>
        <div class="col-12 col-sm-6">

        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid starts-->
  <div class="container-fluid">

    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            @if(Session::has('error2'))
            <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down">
                <path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path>
              </svg>
              <p> {{session::get('error2')}}</p>
              <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
            </div>
            @endif

            @if(Session::has('message'))
            <div class="alert alert-success dark alert-dismissible fade show" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up">
                <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
              </svg>
              <p> {{session::get('message')}}</p>
              <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
            </div>
            @endif

            @if(Session::has('message'))
            <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
              <p> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up">
                  <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                </svg>
                {{session::get('message')}}
              </p>
              <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
            </div>
            @endif

            <div class="form theme-form projectcreate">
              <form action="{{url ('employee/'.$employee->id) }}" method="POST" autocomplete="off">
                @csrf
                @method('PUT')
                <!--------Emp code emp code | First Name----------->
                @if(Auth::user()->role == 'super_admin')
                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Email Id*</label>
                      <input class="form-control {{ $errors->has('email') ? ' has-error' : ''}}" name="email" type="text" placeholder="Email Id" value="@if($employee->email) {{$employee->email}} @else {{old('email')}} @endif ">
                      @if ($errors->has('email'))
                      <div class="text-danger">{{ $errors->first('email') }}</div>
                      @endif
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Date of Relieving</label>
                      <input class=" form-control" name="exit_date" type="date" data-language="en" value="{{$employee->exit_date}}">
                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Employee Code*</label>
                      <input class="form-control {{ $errors->has('employee_code') ? ' has-error' : ''}}" name="employee_code" type="text" placeholder="Employee Code" 
                        value="@if($employee->employee_code) {{$employee->employee_code}} @else {{old('employee_code')}} @endif ">
                      @if ($errors->has('employee_code'))
                      <div class="text-danger">{{ $errors->first('employee_code') }}</div>
                      @endif
                    </div>
                  </div>
                </div>
                <hr class="mt-4 mb-4">

                @endif


                
                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Role*</label>
                      <!--@if($employee->role == 'super_admin')
                      <input class="form-control" type="text" value="Super Admin">
                      @elseif($employee->role == 'project_manager')
                      <input class="form-control" type="text" value="Project Manager">
                      @elseif($employee->role == 'employee')
                      <input class="form-control" type="text" value="Employee">
                      @endif-->
                      <select class="form-select {{ $errors->has('name') ? ' has-error' : ''}}" name="role">
                        <option value=' '>Select</option>
                        <option value="super_admin" {{$employee->role == 'super_admin'  ?'selected ':'' }}>Super Admin</option>
                        <option value="project_manager" {{$employee->role == 'project_manager'  ?'selected':'' }}>Project Manager</option>
                        <option value="employee" {{$employee->role == 'employee'  ?'selected':'' }}>Empolyee</option>
                      </select>
                      @if ($errors->has('role'))
                      <div class="text-danger">{{ $errors->first('role') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Sub Role</label>                      
                      <select class="form-select" name="sub_role">
                        <option value=''>Select</option>
                        <option value="hr" {{$employee->sub_role == 'hr'  ?'selected ':'' }}>HR</option>                        
                      </select>
                    </div>
                  </div>
                </div>


                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>First Name*</label>
                      <input class="form-control {{ $errors->has('name') ? ' has-error' : ''}} text-uppercase" name="name" type="text" placeholder="Employee Name *" value="{{$employee->name }}">
                      @if ($errors->has('name'))
                      <div class="text-danger">{{ $errors->first('name') }}</div>
                      @endif
                    </div>
                  </div>

                  <!--------Emp Middle Name | Last Name----------->

                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Middle Name</label>
                      <input class="form-control {{ $errors->has('middle_name') ? ' has-error' : ''}} text-uppercase" name="middle_name" type="text" placeholder="Middle Name" value="{{ $employee->middle_name }}">
                      @if ($errors->has('middle_name'))
                      <div class="text-danger">{{ $errors->first('middle_name') }}</div>
                      @endif
                    </div>
                  </div>

                </div>


                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Last Name</label>
                      <input class="form-control {{ $errors->has('last_name') ? ' has-error' : ''}} text-uppercase" name="last_name" type="text" placeholder="Last Name" value="{{$employee->last_name }}">
                      @if ($errors->has('last_name'))
                      <div class="text-danger">{{ $errors->first('last_name') }}</div>
                      @endif
                    </div>
                  </div>

                  <!--------Emp email id | Emp designation ----------->


                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Designation*</label>
                      <select class="form-select {{ $errors->has('designation_id') ? ' has-error' : ''}}" name="designation_id">
                        <option value="">Select</option>
                        @foreach ($designation as $d)

                        <option value="{{$d->id}}" {{$d->id == $employee->designation_id ?'selected':''}}>{{ $d->designation}}</option>

                        @endforeach
                      </select>
                      @if ($errors->has('designation_id'))
                      <div class="text-danger">{{ $errors->first('designation_id') }}</div>
                      @endif
                    </div>
                  </div>
                </div>

                <!--------date of joining | Date Of Birth ----------->

                <div class="row">

                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Date of Joining*</label>
                      <input class="datepicker-here form-control digits {{ $errors->has('joining_date') ? ' has-error' : ''}}" type="text" name="joining_date" data-position="bottom right" data-language="en" value="{{Carbon\Carbon::parse($employee->joining_date)->format('d-m-Y')}}">

                      @if ($errors->has('joining_date'))
                      <div class="text-danger">{{ $errors->first('joining_date') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Date of Birth*</label>
                      <input class=" datepicker-here form-control digits {{ $errors->has('birth_date') ? ' has-error' : ''}}" name="birth_date" type="text" data-position="bottom right" data-language="en" value="{{Carbon\Carbon::parse($employee->birth_date)->format('d-m-Y')}}">
                      @if ($errors->has('birth_date'))
                      <div class="text-danger">{{ $errors->first('birth_date') }}</div>
                      @endif
                    </div>
                  </div>

                </div>

                <!--------Gender | Marital Status ----------->

                <div class="row">
                  <div class="col-sm-6">
                    <fieldset class="mb-3">
                      <div class="row">
                        <label class="col-form-label col-sm-3 pt-0">Gender*</label>
                        <div class="col-sm-9">
                          <div class="form-check radio radio-primary {{ $errors->has('gender') ? ' radio-danger' : ''}}">
                            <input class="form-check-input" id="radio11" type="radio" name="gender" value="Male" {{$employee->gender == 'Male' ?'checked':''}}>
                            <label class="form-check-label" for="radio11">Male</label>
                          </div>
                          <div class="form-check radio radio-primary {{ $errors->has('gender') ? ' radio-danger' : ''}}">
                            <input class="form-check-input" id="radio22" type="radio" name="gender" value="Female" {{$employee->gender == 'Female' ?'checked':''}}>
                            <label class="form-check-label" for="radio22">Female</label>
                          </div>
                        </div>
                        @if ($errors->has('gender'))
                        <div class="text-danger">{{ $errors->first('gender') }}</div>
                        @endif
                      </div>
                    </fieldset>
                  </div>

                  <div class="col-sm-6">
                    <fieldset class="mb-3">
                      <div class="row">
                        <label class="col-form-label col-sm-3 pt-0">Marital Status*</label>
                        <div class="col-sm-9">
                          <div class="form-check radio radio-primary {{ $errors->has('marital_status') ? ' radio-danger' : ''}}">
                            <input class="form-check-input" id="radio33" type="radio" name="marital_status" value="Married" {{$employee->marital_status == 'Married' ?'checked':''}}>
                            <label class="form-check-label" for="radio33">Married</label>
                          </div>
                          <div class="form-check radio radio-primary {{ $errors->has('marital_status') ? ' radio-danger' : ''}}">
                            <input class="form-check-input" id="radio44" type="radio" name="marital_status" value="Single" {{$employee->marital_status == 'Single' ?'checked':''}}>
                            <label class="form-check-label" for="radio44">Single</label>
                          </div>
                        </div>
                        @if ($errors->has('marital_status[]'))
                        <div class="text-danger">{{ $errors->first('marital_status[]') }}</div>
                        @endif
                      </div>
                    </fieldset>
                  </div>
                </div>

                <!-------- Phone Number | Reporting To ----------->

                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Phone Number*</label>
                      <input class="form-control {{ $errors->has('phone_number') ? ' has-error' : ''}}" type="number" placeholder="Phone Number" name="phone_number" value="{{$employee->phone_number }}">
                      @if ($errors->has('phone_number'))
                      <div class="text-danger">{{ $errors->first('phone_number') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Emergency Contact No*</label>
                      <input class="form-control {{ $errors->has('emergency_contact') ? ' has-error' : ''}}" type="number" placeholder="Emergency Contact Number" name="emergency_contact" value="{{$employee->emergency_contact}}">
                      @if ($errors->has('emergency_contact'))
                      <div class="text-danger">{{ $errors->first('emergency_contact') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="mb-3">

                      <label>Reporting To*</label>
                      <input type="text" name="reporting_to" disabled class="form-control" placeholder="@if($current_primary_project_id != null){{ $reporting_to->userteam->name }} @else {{ $reporting_to }} @endif" />


                    </div>
                  </div>
                </div>

                <!-------- Residential Address | Same as Residential Address ----------->

                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Residential Address*</label>
                      <input class="form-control {{ $errors->has('res_address') ? ' has-error' : ''}}" type="text" placeholder="Address" name="res_address" id="curAddressLine1" value="{{$employee->res_address }}">
                      @if ($errors->has('res_address'))
                      <div class="text-danger">{{ $errors->first('res_address') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <label class="col-sm-4 col-form-label pb-0"></label>
                    <div class="col-sm-9">
                      <div class="mb-0">
                        <div class="form-check form-check-inline checkbox checkbox-primary">
                          <input class="form-check-input" id="sameas" type="checkbox">
                          <label class="form-check-label" for="sameas">Same As Residential Address</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-------- City   |  Permenant Address ----------->
                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>City*</label>
                      <input class="form-control {{ $errors->has('res_city') ? ' has-error' : ''}}" type="text" placeholder="City *" name="res_city" id="curCity" value="{{$employee->res_city }}">
                      @if ($errors->has('res_city'))
                      <div class="text-danger">{{ $errors->first('res_city') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Permanent Address*</label>
                      <input class="form-control {{ $errors->has('per_address') ? ' has-error' : ''}}" type="text" placeholder="Permanent Address *" name="per_address" id="pAddressLine1" value="{{$employee->per_address }}">
                      @if ($errors->has('per_address'))
                      <div class="text-danger">{{ $errors->first('per_address') }}</div>
                      @endif
                    </div>
                  </div>
                </div>

                <!-------- State | City ----------->
                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>State*</label>
                      <input class="form-control {{ $errors->has('res_state') ? ' has-error' : ''}}" type="text" placeholder="State *" name="res_state" id="curState" value="{{$employee->res_state }}">
                      @if ($errors->has('res_state'))
                      <div class="text-danger">{{ $errors->first('res_state') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>City*</label>
                      <input class="form-control {{ $errors->has('per_city') ? ' has-error' : ''}}" type="text" placeholder="City *" name="per_city" id="pCity" value="{{$employee->res_city }}">
                      @if ($errors->has('per_city'))
                      <div class="text-danger">{{ $errors->first('per_city') }}</div>
                      @endif
                    </div>
                  </div>
                </div>
                <!-------- Postal Code | State ----------->
                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Postal Code*</label>
                      <input class="form-control {{ $errors->has('res_postal_code') ? ' has-error' : ''}}" type="number" placeholder="Postal Code *" name="res_postal_code" id="curZipcode" value="{{$employee->res_postal_code }}">
                      @if ($errors->has('res_postal_code'))
                      <div class="text-danger">{{ $errors->first('res_postal_code') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>State*</label>
                      <input class="form-control {{ $errors->has('per_state') ? ' has-error' : ''}}" type="text" placeholder="State *" name="per_state" id="pState" value="{{$employee->per_state }}">
                      @if ($errors->has('per_state'))
                      <div class="text-danger">{{ $errors->first('per_state') }}</div>
                      @endif
                    </div>
                  </div>
                </div>

                <!-------- Nationality | Postal Code ----------->
                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Nationality*</label>
                      <input class="form-control {{ $errors->has('nationality') ? ' has-error' : ''}}" type="text" placeholder="Nationality *" name="nationality" value="{{$employee->nationality }}" id="country">
                      @if ($errors->has('nationality'))
                      <div class="text-danger">{{ $errors->first('nationality') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Postal Code*</label>
                      <input class="form-control {{ $errors->has('per_postal_code') ? ' has-error' : ''}}" type="text" placeholder="Postal Code *" name="per_postal_code" value="{{$employee->per_postal_code }}">
                      @if ($errors->has('per_postal_code'))
                      <div class="text-danger">{{ $errors->first('per_postal_code') }}</div>
                      @endif
                    </div>
                  </div>
                </div>

                <!-------- Dependency name | Dependency ----------->
                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Dependency Name*</label>
                      <input class="form-control {{ $errors->has('dependency_name') ? ' has-error' : ''}}" type="text" placeholder="Dependency Name *" name="dependency_name" value="{{$employee->dependency_name }}">
                      @if ($errors->has('dependency_name'))
                      <div class="text-danger">{{ $errors->first('dependency_name') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Dependency*</label>
                      <select class="form-select {{ $errors->has('dependency') ? ' has-error' : ''}}" name="dependency">
                        <option value="">Select</option>
                        <option value="Father" {{$employee->dependency == 'Father' ?'selected':''}}>Father</option>
                        <option value="Husband" {{$employee->dependency == 'Husband' ?'selected':'' }}>Husband</option>
                        <option value="Guardian" {{$employee->dependency == 'Guardian' ?'selected':'' }}>Guardian</option>
                      </select>
                      @if ($errors->has('dependency'))
                      <div class="text-danger">{{ $errors->first('dependency') }}</div>
                      @endif
                    </div>
                  </div>
                </div>

                <!-------- Higest Qualification | Employee Status ----------->

                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Higest Qualification*</label>
                      <input class="form-control {{ $errors->has('higest_qualification') ? ' has-error' : ''}}" type="text" placeholder="Heigest Qualification *" name="higest_qualification" value="{{$employee->higest_qualification}}">
                      @if ($errors->has('higest_qualification'))
                      <div class="text-danger">{{ $errors->first('higest_qualification') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Employee Status*</label>
                      <select class="form-select {{ $errors->has('employee_status') ? ' has-error' : ''}}" name="employee_status">
                        <option value="">Select</option>
                        <option value="1" {{$employee->employee_status == '1' ?'selected':''}}>Active</option>
                        <option value="0" {{$employee->employee_status == '0' ?'selected':''}}>InActive</option>
                      </select>
                      @if ($errors->has('employee_status'))
                      <div class="text-danger">{{ $errors->first('employee_status') }}</div>
                      @endif
                    </div>
                  </div>
                </div>

                <!-------- Aadhar Number | Pan Number ----------->

                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Aadhar Number*</label>
                      <input class="form-control {{ $errors->has('aadhar_number') ? ' has-error' : ''}}" type="text" placeholder="Aadhar Number *" name="aadhar_number" value="{{$employee->aadhar_number }}">
                      @if ($errors->has('aadhar_number'))
                      <div class="text-danger">{{ $errors->first('aadhar_number') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>PAN Number*</label>
                      <input class="form-control {{ $errors->has('pan_number') ? ' has-error' : ''}}" type="text" placeholder="PAN Number *" name="pan_number" value="{{$employee->pan_number }}">
                      @if ($errors->has('pan_number'))
                      <div class="text-danger">{{ $errors->first('pan_number') }}</div>
                      @endif
                    </div>
                  </div>
                </div>

                <!-------- Experience | Previous Employer ----------->

                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Work Experience*</label>
                      <input class="form-control  {{ $errors->has('experience') ? ' has-error' : ''}}" type="text" name="experience" value="{{$employee->experience }}">
                      @if ($errors->has('experience'))
                      <div class="text-danger">{{ $errors->first('experience') }}</div>
                      @endif

                    </div>
                  </div>

                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Previous Employer</label>
                      <input class="form-control  {{ $errors->has('previous_employer') ? ' has-error' : ''}}" type="text" name="previous_employer" value="{{$employee->previous_employer}}">
                      @if ($errors->has('previous_employer'))
                      <div class="text-danger">{{ $errors->first('previous_employer') }}</div>
                      @endif
                    </div>
                  </div>

                </div>

                <!-------- Skill Set | Hobbies ----------->

                <div class="row">

                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Skill Sets*</label>
                      <textarea class="form-control {{ $errors->has('skill_set') ? ' has-error' : ''}}" id="exampleFormControlTextarea1" rows="3" name="skill_set">{{$employee->skill_set }}</textarea>
                      @if ($errors->has('skill_set'))
                      <div class="text-danger">{{ $errors->first('skill_set') }}</div>
                      @endif

                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Hobbies</label>
                      <textarea class="form-control " id="exampleFormControlTextarea1" rows="3" name="hobbies">{{$employee->hobbies}}</textarea>

                    </div>
                  </div>
                </div>

                @if(Auth::user()->role == 'super_admin')

                @if($employee->gender == 'Female')

                <!--------Gender | Marital Status ----------->

                <div class="row">
                  <div class="col-sm-6">
                    <div class="col-sm-6">
                      <label class="col-sm-4 col-form-label pb-0"></label>
                      <div class="col-sm-9">
                        <div class="mb-0">
                          <div class="form-check form-check-inline checkbox checkbox-primary">
                            <input class="form-check-input showdate" id="sameas1" name="maternity_leave" type="checkbox" {{$employee->maternity_leave == 'on' ?'checked':''}}>
                            <label class="form-check-label" for="sameas1">On Maternity Leave</label>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>


                </div>

                <div class="row showCta" style="{{$employee->maternity_leave == 'on' ?'':'display: none'}}">
                  <div class="mb-3 col-md-6 ">
                    <label for="ml_from_date">ML From Date*</label>
                    <input class="form-control {{ $errors->has('ml_from_date') ? ' has-error' : ''}} " placeholder="From Date" id="ml_from_date" type="date" name="ml_from_date" value="{{$employee->ml_from_date}}">
                    @if ($errors->has('ml_from_date'))
                    <div class="text-danger">{{ $errors->first('ml_from_date') }}</div>
                    @endif
                  </div>


                  <div class="mb-3 col-md-6 ">
                    <label for="ml_to_date">ML To Date</label>
                    <input class=" form-control  {{ $errors->has('ml_to_date') ? ' has-error' : ''}} " id="ml_to_date" type="date" name="ml_to_date" placeholder="To Date" readonly value="{{$employee->ml_to_date}}">
                    @if ($errors->has('endDate'))
                    <div class="text-danger">{{ $errors->first('endDate') }}</div>
                    @endif
                  </div>

                </div>

                @endif

                @endif

                <!--------------button----------------->

                <div class="row">
                  <div class="col">
                    <div class="text-end"><button class="btn btn-primary me-3" type="submit" id="btn_update">Update</button><a href="{{ route('employee.index') }}" class="btn btn-secondary" type="submit">Cancel</a></div>
                  </div>
                </div>
                <form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid Ends-->
</div>
<!-- end page body-->
@endsection




@section('script')
<script>
  $('#sameas2').click(function() {
    if (this.checked) {

      $('.showCta').toggle(this.id === 'radio_ml1');
    }

  }).change();
</script>

<script>
  $(function() {

    var values = [];
    $('.showdate').on('click', function() {

      if ($(this).is(":checked")) {
        $(".showCta").show();

      } else {
        $(".showCta").hide();
      }


    });
  });
</script>

<script>
  $(document).ready(function() {
    $('#ml_from_date').change(function() {
      var period = this.value;
      var start_date = new Date($('#ml_from_date').val());
      //console.log(start_date);

      var result_date = new Date(start_date.getFullYear(), start_date.getMonth() + 6, start_date.getDate() - 1);
      result_date = moment(result_date).format('Y-MM-DD');
      $('#ml_to_date').val(result_date);

    })

  });
</script>

<script>

$("#btn_update").click(function(){

  $('#mail_send').append('<div class="loader-wrapper" style="opacity: 0.980147;"><div class="loader"><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-ball"></div></div></div>');
  //alert("The paragraph was clicked.");
});
</script>



@endsection