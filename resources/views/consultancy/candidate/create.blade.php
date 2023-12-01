@extends('layouts.consultancy.con-app')

@section('page_title')
<title>Create Candidate</title>
@endsection
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">

            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-9 xl-60 box-col-7">
                <div class="card">
                    <div class="card-body b-l-primary">
                        <div class="media"><i data-feather="paperclip"></i>
                            <div class="media-body px-3">
                                <h3 class="f-w-600 fs-4">Create Candidate</h3>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-9 xl-60 box-col-7">
                <div class="card">
                    <div class="job-search">
                        <form class="form theme-form" action="{{url('consultancy/candidate')}}" method="POST" enctype="multipart/form-data" id='candidate' autocomplete="off">
                            @csrf
                            <div class="card-body pb-0">
                                <div class="media align-items-center">
                                    <script src="https://cdn.lordicon.com/fudrjiwc.js"></script>
                                    <lord-icon src="https://cdn.lordicon.com/jnlncdtk.json" trigger="hover" style="width:80px;height:80px">
                                    </lord-icon>
                                    <div class="media-body">
                                        <h4 class="f-w-700 mb-0"><a href="javascript:void(0)">{{$job->position->position_name}}</a></h4>
                                        <h6 class="mb-0">Job Code: {{$job->job_code}}</h6>
                                        <input class="form-control" hidden id="exampleFormControlInput1" type="text" name="job_id" value="{{$job->id}}">
                                    </div>
                                </div>
                                <div class="job-description">
                                    <h6 class="mb-3">Personal Details </h6>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Candidate Name*</label>
                                                <input class="form-control  {{ $errors->has('name') ? ' has-error' : ''}}" type="text" placeholder="Name" name="name" value="{{old('name')}}">
                                                @if ($errors->has('name'))
                                                <div class="text-danger">{{ $errors->first('name') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Candidate Email*</label>
                                                <input class="form-control  {{ $errors->has('email') ? ' has-error' : ''}}" type="text" placeholder="Email Id" name="email" value="{{old('email')}}">
                                                @if ($errors->has('email'))
                                                <div class="text-danger">{{ $errors->first('email') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Phone Number*</label>
                                                <input class="form-control  {{ $errors->has('phone_number') ? ' has-error' : ''}}" type="number" placeholder="Phone Number" name="phone_number" value="{{old('phone_number')}}">
                                                @if ($errors->has('phone_number'))
                                                <div class="text-danger">{{ $errors->first('phone_number') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Alternate Number</label>
                                                <input class="form-control  {{ $errors->has('alternate_phone_number') ? ' has-error' : ''}}" type="number" placeholder="Alternate Phone Number" name="alternate_phone_number" value="{{old('alternate_phone_number')}}">
                                                @if ($errors->has('alternate_phone_number'))
                                                <div class="text-danger">{{ $errors->first('alternate_phone_number') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Date Of Birth*</label>
                                                <input class="datepicker-here form-control {{ $errors->has('dob') ? ' has-error' : ''}}" readonly type="text" data-position="top right" placeholder="DD-MM-YYYY" name="dob" value="{{old('dob')}}">
                                                @if ($errors->has('dob'))
                                                <div class="text-danger">{{ $errors->first('dob') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="col" id="radio-group">
                                                <label class="col-form-label col-sm-3 pt-0">Gender*</label>
                                                <div class="m-t-15 m-checkbox-inline custom-radio-ml">
                                                    <div class="form-check radio radio-primary {{ $errors->has('gender') ? ' radio-danger' : ''}}">
                                                        <input class="form-check-input" id="radio11" type="radio" name="gender" value="Male" {{ old('gender') == 'Male' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="radio11">Male</label>
                                                    </div>
                                                    <div class="form-check radio radio-primary {{ $errors->has('gender') ? ' radio-danger' : ''}}">
                                                        <input class="form-check-input" id="radio22" type="radio" name="gender" value="Female" {{ old('gender') == 'Female' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="radio22">Female</label>
                                                    </div>
                                                </div>
                                                @if ($errors->has('gender'))
                                                <div class="text-danger">{{ $errors->first('gender') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Address</label>
                                                <input class="form-control  {{ $errors->has('address') ? ' has-error' : ''}}" type="text" placeholder="Address" name="address" value="{{old('address')}}">
                                                @if ($errors->has('address'))
                                                <div class="text-danger">{{ $errors->first('address') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Candidate Location*</label>
                                                <input class="form-control  {{ $errors->has('candidate_location') ? ' has-error' : ''}}" type="text" placeholder="Location" name="candidate_location" value="{{old('candidate_location')}}">
                                                @if ($errors->has('candidate_location'))
                                                <div class="text-danger">{{ $errors->first('candidate_location') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Nationality*</label>
                                                <input class="form-control  {{ $errors->has('nationality') ? ' has-error' : ''}}" type="text" id="country" placeholder="Nationality" name="nationality" value="{{old('nationality')}}">
                                                @if ($errors->has('nationality'))
                                                <div class="text-danger">{{ $errors->first('nationality') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="col" id="radio-group">
                                                <label class="col-form-label col-sm-3 pt-0">Marital Status*</label>
                                                <div class="m-t-15 m-checkbox-inline custom-radio-ml">
                                                    <div class="form-check radio radio-primary {{ $errors->has('marital_status') ? ' radio-danger' : ''}}">
                                                        <input class="form-check-input" id="radio1" type="radio" name="marital_status" value="Married" {{ old('marital_status') == 'Married' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="radio1">Married</label>
                                                    </div>
                                                    <div class="form-check radio radio-primary {{ $errors->has('marital_status') ? ' radio-danger' : ''}}">
                                                        <input class="form-check-input" id="radio2" type="radio" name="marital_status" value="Single" {{ old('marital_status') == 'Single' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="radio2">Single</label>
                                                    </div>
                                                </div>
                                                @if ($errors->has('marital_status'))
                                                <div class="text-danger">{{ $errors->first('marital_status') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="candidate_hr">
                                    <h6 class="mb-3">Job & Experience</h6>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Current Designation*</label>
                                                <input class="form-control  {{ $errors->has('current_position') ? ' has-error' : ''}}" name="current_position" type="text" placeholder="Current Designation" value="{{old('current_position')}}">
                                                @if ($errors->has('current_position'))
                                                <div class="text-danger">{{ $errors->first('current_position') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Current Company*</label>
                                                <input class="form-control  {{ $errors->has('current_company') ? ' has-error' : ''}}" name="current_company" type="text" placeholder="Current Company" value="{{old('current_company')}}">
                                                @if ($errors->has('current_company'))
                                                <div class="text-danger">{{ $errors->first('current_company') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Total Years of Experience*</label>
                                                <input class="form-control  {{ $errors->has('total_experience') ? ' has-error' : ''}}" name="total_experience" type="text" placeholder="Total Years of Experience" value="{{old('total_experience')}}">
                                                @if ($errors->has('total_experience'))
                                                <div class="text-danger">{{ $errors->first('total_experience') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Relevant Experience*</label>
                                                <input class="form-control  {{ $errors->has('relevant_experience') ? ' has-error' : ''}}" name="relevant_experience" type="text" placeholder="Relevant Experience" value="{{old('relevant_experience')}}">
                                                @if ($errors->has('relevant_experience'))
                                                <div class="text-danger">{{ $errors->first('relevant_experience') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Have you directly interacted with clients? | Client's Location*</label>
                                                <input class="form-control  {{ $errors->has('client_interaction_location') ? ' has-error' : ''}}" name="client_interaction_location" type="text" placeholder="Intraction with Clients" value="{{old('client_interaction_location')}}">
                                                @if ($errors->has('client_interaction_location'))
                                                <div class="text-danger">{{ $errors->first('client_interaction_location') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Are you an individual contributor?*</label>
                                                <input class="form-control  {{ $errors->has('individual_contributor') ? ' has-error' : ''}}" name="individual_contributor" type="text" placeholder="Individual Contributer" value="{{old('individual_contributor')}}">
                                                @if ($errors->has('individual_contributor'))
                                                <div class="text-danger">{{ $errors->first('individual_contributor') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Current CTC*</label>
                                                <input class="form-control  {{ $errors->has('current_ctc') ? ' has-error' : ''}}" name="current_ctc" type="text" placeholder="Current CTC" value="{{old('current_ctc')}}">
                                                @if ($errors->has('current_ctc'))
                                                <div class="text-danger">{{ $errors->first('current_ctc') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Expected CTC*</label>
                                                <input class="form-control  {{ $errors->has('expected_ctc') ? ' has-error' : ''}}" name="expected_ctc" type="text" placeholder="Expected CTC" value="{{old('expected_ctc')}}">
                                                @if ($errors->has('expected_ctc'))
                                                <div class="text-danger">{{ $errors->first('expected_ctc') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Candidate Negotiation Salary*</label>
                                                <input class="form-control  {{ $errors->has('negotiation_salary') ? ' has-error' : ''}}" name="negotiation_salary" type="text" placeholder="Candidate Negotiation Salary" value="{{old('negotiation_salary')}}">
                                                @if ($errors->has('negotiation_salary'))
                                                <div class="text-danger">{{ $errors->first('negotiation_salary') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Notice Period*</label>
                                                <input class="form-control  {{$errors->has('notice_period') ? ' has-error' : ''}}" name="notice_period" type="text" placeholder="Notice Period" value="{{old('notice_period')}}">
                                                @if ($errors->has('notice_period'))
                                                <div class="text-danger">{{ $errors->first('notice_period') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Language Known</label>
                                                <textarea class="form-control  {{$errors->has('language_known') ? ' has-error' : ''}}" id="exampleFormControlTextarea1" rows="3" name="language_known">{{old('language_known')}}</textarea>
                                                @if ($errors->has('language_known'))
                                                <div class="text-danger">{{ $errors->first('language_known') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Skills*</label>
                                                <textarea class="form-control {{$errors->has('skills') ? ' has-error' : ''}}" id="exampleFormControlTextarea1" rows="3" name="skills">{{old('skills')}}</textarea>
                                                @if ($errors->has('skills'))
                                                <div class="text-danger">{{ $errors->first('skills') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="col" id="radio-group">
                                                <label class="col-form-label col-sm-3 pt-0">If asked to report to the office will you report in a hybrid model?*</label>
                                                <div class="m-t-15 m-checkbox-inline custom-radio-ml">
                                                    <div class="form-check radio radio-primary {{ $errors->has('hybrid_model') ? ' radio-danger' : ''}}">
                                                        <input class="form-check-input" id="radio3" type="radio" name="hybrid_model" value="Yes" {{ old('hybrid_model') == 'Yes' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="radio3">Yes</label>
                                                    </div>
                                                    <div class="form-check radio radio-primary {{ $errors->has('hybrid_model') ? ' radio-danger' : ''}}">
                                                        <input class="form-check-input" id="radio4" type="radio" name="hybrid_model" value="No" {{ old('hybrid_model') == 'No' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="radio4">No</label>
                                                    </div>
                                                </div>
                                                @if ($errors->has('hybrid_model'))
                                                <div class="text-danger">{{ $errors->first('hybrid_model') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="candidate_hr">

                                    <h6 class="mb-3">Education</h6>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Graduation Degree*</label>
                                                <input class="form-control  {{ $errors->has('graduation_degree') ? ' has-error' : ''}}" name="graduation_degree" type="text" placeholder="Graduation Degree" value="{{old('graduation_degree')}}">
                                                @if ($errors->has('graduation_degree'))
                                                <div class="text-danger">{{ $errors->first('graduation_degree') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Graduation University*</label>
                                                <input class="form-control  {{ $errors->has('graduation_university') ? ' has-error' : ''}}" name="graduation_university" type="text" placeholder="Graduation University" value="{{old('graduation_university')}}">
                                                @if ($errors->has('graduation_university'))
                                                <div class="text-danger">{{ $errors->first('graduation_university') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <hr class="candidate_hr">

                                    <h6 class="mb-3">Upload Your Files</h6>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="mb-3">
                                                <label>Resume Upload(pdf)*</label>
                                                <input class="form-control  {{ $errors->has('resume_upload') ? ' has-error' : ''}}" type="file" name="resume_upload">
                                                @if ($errors->has('resume_upload'))
                                                <div class="text-danger">{{ $errors->first('resume_upload') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-sm-6 d-none">
                                            <div class="mb-3">
                                                <label>Consultancy*</label>
                                                <input class="form-control" readonly name="consultancy_id" type="text" value="{{Auth::guard('consultancy')->id()}}">
                                            </div>
                                        </div>
                                    </div>                                   
                                </div>
                            </div>
                            <div class="card-footer text-end">
                                <button class="btn btn-primary" type="submit">Submit</button>
                                <input class="btn btn-light" type="reset" value="Reset">
                                <a href="{{route('consultancy.home')}}" class="btn btn-secondary me-3">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>
@endsection
@section('script')
<script>
    function resetForm() {
        document.getElementById("candidate").reset();
    }
</script>
@endsection