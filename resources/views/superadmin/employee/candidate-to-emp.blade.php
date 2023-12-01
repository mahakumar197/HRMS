@extends('layouts.app')
@section('page_title')
<title>Add Employee</title>
@endsection
@section('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
<style>
    .toggle {
        height: 47px;
        background: #fff;
        border-left: none;
        border-color: #efefef;
    }
</style>
@endsection
@section('content')
<div id="mail_send"></div>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>
                        Add Employee</h3>
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
                        @if(Session::has('message'))
                        <div class="alert alert alert-success" role="alert">
                            {{session::get('message')}}
                        </div>
                        @endif

                        <div class="form theme-form projectcreate ">
                            <form action="{{ url ('employee') }}" method="POST" enctype="multipart/form-data" id="emp" autocomplete="off">
                                @csrf

                                @if(Auth::user()->role == 'super_admin')
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Email Id*</label>
                                            <input class="form-control {{ $errors->has('email') ? ' has-error' : ''}}" name="email" type="text" placeholder="Email Id" value="{{old('email')}}">
                                            @if ($errors->has('email'))
                                            <div class="text-danger">{{ $errors->first('email') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Employee Code*</label>
                                            <input class="form-control  {{ $errors->has('employee_code') ? ' has-error' : ''}}" name="employee_code" type="text" placeholder="Employee Code" value="{{old('employee_code')}}">
                                            @if ($errors->has('employee_code'))
                                            <div class="text-danger">{{ $errors->first('employee_code') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Role*</label>
                                            <select class="form-select {{ $errors->has('role') ? ' has-error' : ''}}" name="role">
                                                <option value=''>Select</option>
                                                <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                                <option value="project_manager" {{ old('role') == 'project_manager' ? 'selected' : '' }}>Project Manager</option>
                                                <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Employee</option>
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
                                                <option value="hr">HR</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <hr class="mt-4 mb-4">

                                @endif


                                <!--------Emp First Name | Middle Name----------->
                                <div class="row">
                                    <div class="{{Auth::user()->sub_role == 'hr' ? 'col-sm-4' : 'col-sm-6'}}">
                                        <div class="mb-3">
                                            <label>First Name*</label>
                                            <input class="form-control  {{ $errors->has('name') ? ' has-error' : ''}} text-uppercase" name="name" type="text" placeholder="Employee Name" value="{{old('name', $candidate->name)}}">
                                            <input name="cid" type="hidden" value="{{$candidate->id}}">
                                            <input name="jid" type="hidden" value="{{$candidate->job_id}}">
                                            @if ($errors->has('name'))
                                            <div class="text-danger">{{ $errors->first('name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="{{Auth::user()->sub_role == 'hr' ? 'col-sm-4' : 'col-sm-6'}}">
                                        <div class="mb-3">
                                            <label>Middle Name</label>
                                            <input class="form-control  {{ $errors->has('middle_name') ? ' has-error' : ''}} text-uppercase" name="middle_name" type="text" placeholder="Middle Name" value="{{old('middle_name')}}">
                                            @if ($errors->has('middle_name'))
                                            <div class="text-danger">{{ $errors->first('middle_name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    @if(Auth::user()->sub_role == 'hr')
                                    <div class="{{Auth::user()->sub_role == 'hr' ? 'col-sm-4' : 'col-sm-6'}}">
                                        <div class="mb-3">
                                            <label>Last Name</label>
                                            <input class="form-control  {{ $errors->has('last_name') ? ' has-error' : ''}} text-uppercase" name="last_name" type="text" placeholder="Last Name" value="{{old('last_name')}}">
                                            @if ($errors->has('last_name'))
                                            <div class="text-danger">{{ $errors->first('last_name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    @endif

                                </div>
                                <!--------Emp email id | Emp designation ----------->
                                <div class="row">
                                    @if(Auth::user()->role == 'super_admin')
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Last Name</label>
                                            <input class="form-control  {{ $errors->has('last_name') ? ' has-error' : ''}}" name="last_name" type="text" placeholder="Last Name" value="{{old('last_name')}}">
                                            @if ($errors->has('last_name'))
                                            <div class="text-danger">{{ $errors->first('last_name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @if(Auth::user()->sub_role == 'hr')
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label>Role*</label>
                                            <select class="form-select {{ $errors->has('role') ? ' has-error' : ''}}" name="role">
                                                <option value=''>Select</option>
                                                <option value="project_manager" {{ old('role') == 'project_manager' ? 'selected' : '' }}>Project Manager</option>
                                                <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }} Selected>Employee</option>
                                            </select>

                                            @if ($errors->has('role'))
                                            <div class="text-danger">{{ $errors->first('role') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mb-3">
                                            <label>Sub Role</label>
                                            <select class="form-select" name="sub_role">
                                                <option value=''>Select</option>
                                                <option value="hr">HR</option>
                                            </select>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="{{Auth::user()->sub_role == 'hr' ? 'col-sm-4' : 'col-sm-6'}}">
                                        <div class="mb-3">
                                            <label>Designation*</label>
                                            <select class="form-select {{ $errors->has('designation_id') ? ' has-error' : ''}}" name="designation_id">
                                                <option value=''>Select</option>
                                                @foreach ($designation as $d)
                                                <option value="{{$d->id}}" {{ (collect(old('designation_id'))->contains($d->id)) ? 'selected':'' }}>{{ $d->designation}}</option>
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
                                            <input class="datepicker-here form-control digits  {{ $errors->has('joining_date') ? ' has-error' : ''}}" type="text" data-position="bottom right" name="joining_date" data-date-format="dd-mm-yyyy" placeholder="DD-MM-YYYY" data-language="en" value="{{$candidate_offer->joining_date != null ? Carbon::parse($candidate_offer->joining_date)->format('d M Y') : ''}}">
                                            @if ($errors->has('joining_date'))
                                            <div class="text-danger">{{ $errors->first('joining_date') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Date of Birth*</label>
                                            <input class=" datepicker-here form-control digits {{ $errors->has('birth_date') ? ' has-error' : ''}}" data-position="bottom right" name="birth_date" type="text" data-date-format="dd-mm-yyyy" placeholder="DD-MM-YYYY" data-language="en" value="{{$candidate->dob != null ? Carbon::parse($candidate->dob)->format('d M Y') : ''}}">
                                            @if (old('birth_date'))
                                            <input type="hidden" name="birth_date" value="{{ old('birth_date') }}">
                                            @endif
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
                                                        <input class="form-check-input" id="radio11" type="radio" name="gender" value="Male" {{$candidate->gender == 'Male' ?'checked':''}}>
                                                        <label class="form-check-label" for="radio11">Male</label>
                                                    </div>
                                                    <div class="form-check radio radio-primary {{ $errors->has('gender') ? ' radio-danger' : ''}}">
                                                        <input class="form-check-input" id="radio22" type="radio" name="gender" value="Female" {{$candidate->gender == 'Female' ?'checked':''}}>
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
                                                        <input class="form-check-input" id="radio33" type="radio" name="marital_status" value="Married" {{ old('marital_status') == 'Married' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="radio33">Married</label>
                                                    </div>
                                                    <div class="form-check radio radio-primary {{ $errors->has('marital_status') ? ' radio-danger' : ''}}">
                                                        <input class="form-check-input" id="radio44" type="radio" name="marital_status" value="Single" {{ old('marital_status') == 'Single' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="radio44">Single</label>

                                                    </div>
                                                </div>
                                                @if ($errors->has('marital_status'))
                                                <div class="text-danger">{{ $errors->first('marital_status') }}</div>
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
                                            <input class="form-control  {{ $errors->has('phone_number') ? ' has-error' : ''}}" type="number" placeholder="Phone Number" name="phone_number" value="{{old('phone_number', $candidate->phone_number)}}">
                                            @if ($errors->has('phone_number'))
                                            <div class="text-danger">{{ $errors->first('phone_number') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Emergency Contact No*</label>
                                            <input class="form-control  {{ $errors->has('emergency_contact') ? ' has-error' : ''}}" type="number" placeholder="Emergency Contact Number" name="emergency_contact" value="{{old('emergency_contact')}}">
                                            @if ($errors->has('emergency_contact'))
                                            <div class="text-danger">{{ $errors->first('emergency_contact') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                                <!-------- Residential Address | Same as Residential Address ----------->

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Residential Address*</label>
                                            <input class="form-control  {{ $errors->has('res_address') ? ' has-error' : ''}}" type="text" placeholder="Address" name="res_address" id="curAddressLine1" value="{{$candidate->address}}">
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
                                            <input class="form-control  {{ $errors->has('res_city') ? ' has-error' : ''}}" type="text" placeholder="City" name="res_city" id="curCity" value="{{$candidate->candidate_location}}">
                                            @if ($errors->has('res_city'))
                                            <div class="text-danger">{{ $errors->first('res_city') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Permanent Address*</label>
                                            <input class="form-control  {{ $errors->has('per_address') ? ' has-error' : ''}}" type="text" placeholder="Permanent Address" name="per_address" id="pAddressLine1" value="{{old('per_address')}}">
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
                                            <input class="form-control  {{ $errors->has('res_state') ? ' has-error' : ''}}" type="text" placeholder="State" name="res_state" id="curState" value="{{old('res_state')}}">
                                            @if ($errors->has('res_state'))
                                            <div class="text-danger">{{ $errors->first('res_state') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>City*</label>
                                            <input class="form-control  {{ $errors->has('per_city') ? ' has-error' : ''}}" type="text" placeholder="City" name="per_city" id="pCity" value="{{old('per_city')}}">
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
                                            <input class="form-control  {{ $errors->has('res_postal_code') ? ' has-error' : ''}}" type="number" placeholder="Postal Code" name="res_postal_code" id="curZipcode" value="{{old('res_postal_code')}}">
                                            @if ($errors->has('res_postal_code'))
                                            <div class="text-danger">{{ $errors->first('res_postal_code') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>State*</label>
                                            <input class="form-control  {{ $errors->has('per_state') ? ' has-error' : ''}}" type="text" placeholder="State" name="per_state" id="pState" value="{{old('per_state')}}">
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
                                            <input class="form-control  {{ $errors->has('nationality') ? ' has-error' : ''}}" type="text" placeholder="Nationality" name="nationality" value="{{$candidate->nationality}}" id="country">
                                            @if ($errors->has('nationality'))
                                            <div class="text-danger">{{ $errors->first('nationality') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Postal Code*</label>
                                            <input class="form-control  {{ $errors->has('per_postal_code') ? ' has-error' : ''}}" type="text" placeholder="Postal Code" name="per_postal_code" id="pzipcode" value="{{old('per_postal_code')}}">
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
                                            <input class="form-control  {{ $errors->has('dependency_name') ? ' has-error' : ''}}" type="text" placeholder="Dependency Name" name="dependency_name" value="{{old('dependency_name')}}">
                                            @if ($errors->has('dependency_name'))
                                            <div class="text-danger">{{ $errors->first('dependency_name') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Dependency*</label>
                                            <select class="form-select {{ $errors->has('dependency') ? ' has-error' : ''}}" name="dependency">
                                                <option value=''>Select</option>
                                                <option value="Father" {{ old('dependency') == 'Father' ? 'selected' : '' }}>Father</option>
                                                <option value="Husband" {{ old('dependency') == 'Husband' ? 'selected' : '' }}>Husband</option>
                                                <option value="Guardian" {{ old('dependency') == 'Guardian' ? 'selected' : '' }}>Guardian</option>
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
                                            <label>Highest Qualification*</label>
                                            <input class="form-control  {{ $errors->has('higest_qualification') ? ' has-error' : ''}}" type="text" placeholder="Highest Qualification" name="higest_qualification" value="{{$candidate->graduation_degree}}">
                                            @if ($errors->has('higest_qualification'))
                                            <div class="text-danger">{{ $errors->first('higest_qualification') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Employee Status*</label>
                                            <select class="form-select {{ $errors->has('employee_status') ? ' has-error' : ''}}" name="employee_status">
                                                <option value=''>Select</option>
                                                <option value="1" {{ old('employee_status') == '1' ? 'selected' : '' }} selected>Active</option>
                                                <option value="0" {{ old('employee_status') == '0' ? 'selected' : '' }}>InActive</option>
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
                                            <input class="form-control  {{ $errors->has('aadhar_number') ? ' has-error' : ''}}" type="text" placeholder="Aadhar Number" name="aadhar_number" value="{{old('aadhar_number')}}">
                                            @if ($errors->has('aadhar_number'))
                                            <div class="text-danger">{{ $errors->first('aadhar_number') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>PAN Number*</label>
                                            <input class="form-control  {{ $errors->has('pan_number') ? ' has-error' : ''}}" type="text" placeholder="PAN Number" name="pan_number" value="{{old('pan_number')}}">
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
                                            <input class="form-control  {{ $errors->has('experience') ? ' has-error' : ''}}" type="text" name="experience" value="{{$candidate->total_experience}}">
                                            @if ($errors->has('experience'))
                                            <div class="text-danger">{{ $errors->first('experience') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Previous Employer</label>
                                            <input class="form-control  {{ $errors->has('previous_employer') ? ' has-error' : ''}}" type="text" name="previous_employer" value="{{$candidate->current_company}}">
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
                                            <textarea class="form-control  {{ $errors->has('skill_set') ? ' has-error' : ''}}" id="exampleFormControlTextarea1" rows="3" name="skill_set">{{$candidate->skills}}</textarea>
                                            @if ($errors->has('skill_set'))
                                            <div class="text-danger">{{ $errors->first('skill_set') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Hobbies</label>
                                            <textarea class="form-control " id="exampleFormControlTextarea1" rows="3" name="hobbies">{{old('hobbies')}}</textarea>

                                        </div>
                                    </div>
                                </div>

                                <!-------- Photo ----------->

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Profile Photo*</label>
                                            <input class="form-control  {{ $errors->has('profile_image') ? ' has-error' : ''}}" type="file" name="profile_image">
                                            <div class="text-danger">*(Note: Please upload square typed image)</div>
                                            @if ($errors->has('profile_image'))
                                            <div class="text-danger">{{ $errors->first('profile_image') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <!--------------button----------------->

                                    <div class="row">
                                        <div class="col">
                                            <div class="text-end"><button class="btn btn-primary me-3" type="submit" id="btn_submit"> Add </button><a onclick="resetForm()" class="btn btn-danger me-3">Reset</a><a href="{{route('employee.index')}}" class="btn btn-secondary me-3">Cancel</a></div>
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
</div>
<!-- end page body-->
@endsection


@section('script')

<script>
    function setBillingAddress() {
        if ($("#sameas").is(":checked")) {
            $('#pAddressLine1').val($('#curAddressLine1').val());
            $('#pCity').val($('#curCity').val());
            $('#pState').val($('#curState').val());
            $('#pzipcode').val($('#curZipcode').val());
            $('#pAddressLine1').attr('readonly', 'readonly');
            $('#pCity').attr('readonly', 'readonly');
            $('#pState').attr('readonly', 'readonly');
            $('#pzipcode').attr('readonly', 'readonly');
        } else {
            $('#pAddressLine1').removeAttr('readonly');
            $('#pCity').removeAttr('readonly');
            $('#pState').removeAttr('readonly');
            $('#pzipcode').removeAttr('readonly');
            $('#pAddressLine1').val($('').val());
            $('#pCity').val($('').val());
            $('#pState').val($('').val());
            $('#pzipcode').val($('').val());
        }
    }

    $('#sameas').click(function() {
        setBillingAddress();
    })
</script>

<script>
    function resetForm() {
        document.getElementById("emp").reset();
    }
</script>


<script>
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

    togglePassword.addEventListener("click", function() {
        // toggle the type attribute
        const type = password.getAttribute("type") === "password" ? "text" : "password";
        password.setAttribute("type", type);

        // toggle the icon
        this.classList.toggle("bi-eye");
    });
    /*-------------------------------------------------*/
</script>

<script>
    $("#btn_submit").click(function() {

        $('#mail_send').append('<div class="loader-wrapper" style="opacity: 0.980147;"><div class="loader"><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-ball"></div></div></div>');
        //alert("The paragraph was clicked.");
    });
</script>



@endsection