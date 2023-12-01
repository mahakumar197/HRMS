@extends('layouts.consultancy.con-app')

@section('page_title')
<title>Interview Round</title>
@endsection

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>HR Feedback</h3>
                </div>
                <div class="col-12 col-sm-6">

                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="edit-profile">

                <div class="row">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="profile-title">
                                    <div class="media">
                                        <div class="media-body m-l-0">

                                             <h3 class="mb-1 f-22 txt-primary text-capitalize">{{$candidate_details->name}}</h3>
                                            <h6 class="f-14">{{$candidate_details->job->position->position_name}} </h6>
                                            <h6 class="f-14"> </h6>


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <h2>HR Feedback</h2>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label  {{ $errors->has('comments') ? ' has-error' : ''}}">Comments</label>
                                            <textarea class="form-control" rows="2" name="comments" disabled>{{$hr_feedback->comments}}</textarea>
                                              @if ($errors->has('comments'))
                                            <div class="text-danger">{{ $errors->first('comments') }}</div>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label {{ $errors->has('hr_round_status') ? ' has-error' : ''}}">
                                            Candidate Status</label>
                                            <select class="form-control btn-square" name="hr_round_status" disabled>
                                                <option value="">--Select--</option>
                                                <option value="1" {{$job_interview->round_1_status == '1' ? 'selected' : '' }}>On Hold</option>
                                                <option value="2"{{ $job_interview->round_1_status == '2' ? 'selected' : '' }}>Selected</option>
                                                <option value="3"{{ $job_interview->round_1_status == '3' ? 'selected' : '' }}>Rejected</option>

                                            </select>
                                            @if ($errors->has('hr_round_status'))
                                            <div class="text-danger">{{ $errors->first('hr_round_status') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </div>
</div>
@endsection
