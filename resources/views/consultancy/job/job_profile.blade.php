@extends('layouts.consultancy.con-app')
@section('page_title')
<title>{{'Job Profile - '}}{{$job->job_code}}</title>
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
        <div class="row">
            <div class="col-sm-12 box-col-12">
                <div class="card">
                    <div class="card-body  b-l-primary">
                        <div class="media">
                            <div class="media-body px-2">
                                <h3 class="f-w-600 fs-4">Job Profile : {{$job->job_code}}</h3>
                            </div>
                            <div class="text-end">
                                <a class="btn btn-secondary" href="{{route('consultancy.referral')}}">Back to Job Summary</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <div class="form theme-form ">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="col-form-label">Position Name</label>
                                        <input class="form-control" type="text" value="{{$job->position->position_name}}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label class="col-form-label">Job Code</label>
                                        <input class="form-control" type="text" value="{{$job->job_code}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label>Canditate Type</label>
                                        <input value='{{$job->candidate_type}}' type="text" class="form-control input-lg" disabled />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label>Location</label>
                                        <input class="form-control" type="text" value="{{$job->location}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label>Job Type</label>
                                        <input class="form-control" type="text" value="{{$job->job_type->job_type}}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3 bootstrap-touchspin">
                                        <label>Headcount</label>
                                        <input class="form-control" type="text" value="{{$job->headcount}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label>Minimum Salary</label>
                                        <input class="form-control" type="text" value="{{$job->minimum_salary}}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label>Maximum Salary</label>
                                        <input class=" form-control" type="text" value="{{$job->maximum_salary}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3 bootstrap-touchspin">
                                        <label>Experience Required</label>
                                        <input class="form-control" type="text" value="{{$job->experience_required}}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label>Importance</label>
                                        <input class="form-control" type="text" value="{{$job->importance}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label>Job Owner</label>
                                        <input class="form-control" type="text" value="{{$job->user->name}} {{$job->user->last_name}}" disabled>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label>Job Posted Date</label>
                                        <input class="form-control" type="text" value="{{Carbon::parse($job->job_posted_date)->format('d-m-Y')}}" disabled>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label>Essential Skills</label>
                                        @foreach($essential_skills as $es)
                                        <span class="badge badge-primary">
                                            <h6 class="m-0">{{$es->skillset}}</h6>
                                        </span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label>Desirable Skills</label>
                                        @if($desirable_skills != null)
                                        @foreach($desirable_skills as $ds)
                                        <span class="badge badge-secondary">
                                            <h6 class="m-0">{{$ds->skillset}}</h6>
                                        </span>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="row justify-content-center">
                            <h3>Job Description</h3>
                            <hr>
                        </div>
                    </div>
                    <div class="card-body scrollable-para">
                        <div class="scroll-bar-wrap">
                            <div class="both-side-scroll visible-scroll always-visible scroll-demo p-0">{!!$job->job_description!!}</div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>

@endsection