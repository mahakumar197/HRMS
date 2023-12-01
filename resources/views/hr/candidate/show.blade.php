@extends('layouts.app')

@section('page_title')
<title>Candidate Profile</title>
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
                                <h3 class="f-w-600 fs-4">Candidate Profile</h3>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-xl-9 xl-60 box-col-7">
                <div class="card">
                    <div class="job-search">
                        <form class="form theme-form" id='candidate' autocomplete="off">

                            <div class="card-body pb-0">
                                <div class="media align-items-center">
                                    <script src="https://cdn.lordicon.com/fudrjiwc.js"></script>
                                    <lord-icon src="https://cdn.lordicon.com/jnlncdtk.json" trigger="hover" style="width:80px;height:80px">
                                    </lord-icon>
                                    <div class="media-body">
                                        <h4 class="f-w-700 mb-0"><a href="javascript:void(0)">{{$candidate->job->position->position_name}}</a></h4>
                                        <h6 class="mb-0">Job Code: {{$candidate->job->job_code}}</h6>
                                        <input class="form-control" hidden id="exampleFormControlInput1" type="text" name="job_id" value="{{$candidate->job->id}}">
                                    </div>
                                </div>
                                <div class="job-description">
                                    <h6 class="mb-3">Personal Details </h6>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Candidate Name</label>
                                                <input class="form-control" type="text" value="{{$candidate->name}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Candidate Email</label>
                                                <input class="form-control" type="text" placeholder="Email Id" value="{{$candidate->email}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Phone Number</label>
                                                <input class="form-control" type="number" value="{{$candidate->phone_number}}">

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Alternate Number</label>
                                                <input class="form-control" type="number" placeholder="Alternate Phone Number" value="{{$candidate->alternate_phone_number}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Date Of Birth</label>
                                                <input class="datepicker-here form-control" type="text" data-position="top right" placeholder="DD-MM-YYYY" value="{{Carbon\Carbon::parse($candidate->dob)->format('d-m-Y')}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="col" id="radio-group">
                                                <label class="col-form-label col-sm-3 pt-0">Gender</label>
                                                <div class="m-t-15 m-checkbox-inline custom-radio-ml">
                                                    <div class="form-check radio radio-primary ">
                                                        <input class="form-check-input" id="radio11" type="radio" value="Male" {{ $candidate->gender == 'Male' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="radio11">Male</label>
                                                    </div>
                                                    <div class="form-check radio radio-primary ">
                                                        <input class="form-check-input" id="radio22" type="radio" value="Female" {{ $candidate->gender == 'Female' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="radio22">Female</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Address</label>
                                                <input class="form-control " type="text" placeholder="Address" name="address" value="{{$candidate->address}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Candidate Location</label>
                                                <input class="form-control " type="text" placeholder="Location" name="candidate_location" value="{{$candidate->candidate_location}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Nationality</label>
                                                <input class="form-control" type="text" placeholder="Nationality" name="nationality" value="{{$candidate->nationality}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="col" id="radio-group">
                                                <label class="col-form-label col-sm-3 pt-0">Marital Status*</label>
                                                <div class="m-t-15 m-checkbox-inline custom-radio-ml">
                                                    <div class="form-check radio radio-primary">
                                                        <input class="form-check-input" id="radio1" type="radio" value="Married" {{ $candidate->marital_status == 'Married' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="radio1">Married</label>
                                                    </div>
                                                    <div class="form-check radio radio-primary}">
                                                        <input class="form-check-input" id="radio2" type="radio" value="Single" {{ $candidate->marital_status == 'Single' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="radio2">Single</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="candidate_hr">
                                    <h6 class="mb-3">Job & Experience</h6>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Current Designation</label>
                                                <input class="form-control" type="text" placeholder="Current Designation" value="{{$candidate->current_position}}">

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Current Company</label>
                                                <input class="form-control" type="text" placeholder="Current Company" value="{{$candidate->current_company}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Total Years of Experience</label>
                                                <input class="form-control" type="text" placeholder="Total Years of Experience" value="{{$candidate->total_experience}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Relevant Experience</label>
                                                <input class="form-control " type="text" placeholder="Relevant Experience" value="{{$candidate->relevant_experience}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Have you directly interacted with clients? | Client's Location</label>
                                                <input class="form-control" type="text" placeholder="Intraction with Clients" value="{{$candidate->client_interaction_location}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Are you an individual contributor?</label>
                                                <input class="form-control" type="text" placeholder="Individual Contributer" value="{{$candidate->individual_contributor}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Current CTC</label>
                                                <input class="form-control" type="text" placeholder="Current CTC" value="{{$candidate->current_ctc}}">

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Expected CTC</label>
                                                <input class="form-control" type="text" placeholder="Expected CTC" value="{{$candidate->expected_ctc}}">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Candidate Negotiation Salary</label>
                                                <input class="form-control" type="text" placeholder="Candidate Negotiation Salary" value="{{$candidate->negotiation_salary}}">

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Notice Period</label>
                                                <input class="form-control" type="text" placeholder="Notice Period" value="{{$candidate->notice_period}}">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Language Known</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3">{{$candidate->language_known}}</textarea>

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Skills</label>
                                                <textarea class="form-control " id="exampleFormControlTextarea1" rows="3">{{$candidate->skills}}</textarea>

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="col" id="radio-group">
                                                <label class="col-form-label col-sm-3 pt-0">If asked to report to the office will you report in a hybrid model?</label>
                                                <div class="m-t-15 m-checkbox-inline custom-radio-ml">
                                                    <div class="form-check radio radio-primary">
                                                        <input class="form-check-input" id="radio3" type="radio" value="Yes" {{$candidate->hybrid_model == 'Yes' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="radio3">Yes</label>
                                                    </div>
                                                    <div class="form-check radio radio-primary">
                                                        <input class="form-check-input" id="radio4" type="radio" value="No" {{ $candidate->hybrid_model == 'No' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="radio4">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="candidate_hr">
                                    <h6 class="mb-3">Education</h6>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Graduation Degree</label>
                                                <input class="form-control" type="text" placeholder="Graduation Degree" value="{{$candidate->graduation_degree}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label>Graduation University</label>
                                                <input class="form-control" type="text" placeholder="Graduation University" value="{{$candidate->graduation_university}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    $("#candidate :input").prop('disabled', true);
</script>
@endsection