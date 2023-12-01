@extends('layouts.app')

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
                            <h2 class="mb-3">HR Feedback</h2>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <h4 class="mb-3">Comments:</h4>
                                        <p class="text-justify">{{$hr_feedback->comments}}</p>
                                    </div>

                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3 d-flex justify-content-between">
                                        <h4 class="mb-3">Candidate Status:</h4>
                                        @switch($job_interview->round_1_status)
                                        @case(1)
                                        <h6 class="txt-secondary f-w-600">On Hold</h6>
                                        @break

                                        @case(2)
                                        <h6 class="txt-success f-w-600">Selected</h6>
                                        @break

                                        @case(3)
                                        <h6 class="txt-danger f-w-600">On Hold</h6>
                                        @break

                                        @default
                                        <span>-</span>
                                        @endswitch
                                      
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <h2 class="mb-3">HR Questioner</h2>
                            <div class="mb-3 d-flex justify-content-between title-color">
                                <h5>Are you looking out for a change in job?</h5>
                                <h6 class="f-w-600">{{ $hr_feedback->looking_out_change_in_job == 'yes' ? 'Yes' : 'No' }}</h6>
                            </div>
                            <div class="mb-3 d-flex justify-content-between title-color">
                                <h5>Total Years Of Experience</h5>
                                <h6 class="f-w-600">{{$hr_feedback->tot_exp != null ? $hr_feedback->tot_exp : '-' }}</h6>
                            </div>
                            <div class="mb-3 d-flex justify-content-between title-color">
                                <h5>Relevant Years Of Experience</h5>
                                <h6 class="f-w-600">{{$hr_feedback->relevant_exp != null ? $hr_feedback->relevant_exp : '-' }}</h6>
                            </div>
                            <div class="mb-3 d-flex justify-content-between title-color">
                                <h5>Current CTC</h5>
                                <h6 class="f-w-600">{{$hr_feedback->current_ctc !=null ? $hr_feedback->current_ctc : '-'}}</h6>
                            </div>
                            <div class="mb-3 d-flex justify-content-between title-color">
                                <h5>Expected CTC</h5>
                                <h6 class="f-w-600">{{$hr_feedback->expected_ctc != null ? $hr_feedback->expected_ctc : '-'}}</h6>
                            </div>
                            <div class="mb-3 title-color">
                                <h5>Why do you want to look for a job change?</h5>
                                <p class="f-w-600 mt-3">{{$hr_feedback->why_look_for_job_change ? $hr_feedback->why_look_for_job_change : '-' }}</p>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3 d-flex justify-content-between title-color">
                                        <h5>Are you holding any other offer or <br> any offer in pipeline?</h5>
                                        <h6 class="f-w-600">{{ $hr_feedback->other_offer_in_pipeline != null ? $hr_feedback->other_offer_in_pipeline : '-' }}</h6>
                                    </div>

                                    <div class="mb-3 d-flex justify-content-between title-color">
                                        <h5>Which is your native place?</h5>
                                        <h6 class="f-w-600">{{$hr_feedback->native_place != null ? $hr_feedback->native_place : '-'}}</h6>
                                    </div>
                                    <div class="mb-3 title-color">
                                        <h5>Do you have any serious medical <br> issues which we should be aware of?</h5>
                                        <p class="f-w-600 mt-3">{{$hr_feedback->medical_issues != null ? $hr_feedback->medical_issues :'-'}}</p>
                                    </div>

                                    <div class="mb-3 d-flex justify-content-between title-color">
                                        <h5>What is your marital status?</h5>
                                        <h6 class="f-w-600">{{ $hr_feedback->marital_status == 'single' ? 'Single' : 'Married' }}</h6>
                                    </div>
                                    <div class="mb-3 title-color">
                                        <h5>Brief me about your family background?</h5>
                                        <p class="f-w-600 mt-3">{{$hr_feedback->family_background != null ? $hr_feedback->family_background : '-'}}</p>
                                    </div>
                                    <div class="mb-3 title-color">
                                        <h5>What are your strengths and weaknesses?</h5>
                                        <p class="f-w-600 mt-3">{{$hr_feedback->strengths_weaknesses != null ? $hr_feedback->strengths_weaknesses : '-'}}</p>
                                    </div>
                                    <div class="mb-3 d-flex justify-content-between title-color">
                                        <h5>Are you an individual contributor <br> or a team player?</h5>
                                        <h6 class="f-w-600">{{$hr_feedback->team_player != null ? $hr_feedback->team_player : '-'}}</h6>
                                    </div>
                                    <div class="mb-3 d-flex justify-content-between title-color">
                                        <h5>Have you directly interacted with clients?</h5>
                                        <h6 class="f-w-600">{{$hr_feedback->interacted_clients != null ? $hr_feedback->interacted_clients : '-'}}</h6>
                                    </div>
                                    <div class="mb-3 title-color">
                                        <h5>Which geography the clients were from?</h5>
                                        <p class="f-w-600 mt-3">{{$hr_feedback->clients_geography != null ? $hr_feedback->clients_geography :'-'}}</p>
                                    </div>
                                    <div class="mb-3 title-color">
                                        <h5>How do you feel about working over weekends or extended hours?</h5>
                                        <p class="f-w-600 mt-3">{{$hr_feedback->extended_working != null ? $hr_feedback->extended_working :'-'}}</p>
                                    </div>
                                    <div class="mb-3 title-color">
                                        <h5>What are other additional skills / technologies you are familiar with?</h5>
                                        <p class="f-w-600 mt-3">{{$hr_feedback->additional_skills != null ? $hr_feedback->additional_skills :'-'}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3 title-color">
                                        <h5>What methodology do you follow in your Project?</h5>
                                        <p class="f-w-600 mt-3">{{$hr_feedback->methodology != null ? $hr_feedback->methodology :'-'}}</p>
                                    </div>
                                    <div class="mb-3 title-color">
                                        <h5>What’s your absenteeism record like?</h5>
                                        <p class="f-w-600 mt-3">{{$hr_feedback->absenteeism != null ? $hr_feedback->absenteeism :'-'}}</p>
                                    </div>
                                    <div class="mb-3 title-color">
                                        <h5>How do you work under pressure,Can you <br> handle the pressure?</h5>
                                        <p class="f-w-600 mt-3">{{$hr_feedback->work_pressure != null ? $hr_feedback->work_pressure :'-'}}</p>
                                    </div>
                                    <div class="mb-3 title-color">
                                        <h5>How do you deal with feedback and criticism?</h5>
                                        <p class="f-w-600 mt-3">{{$hr_feedback->deal_criticism != null ? $hr_feedback->deal_criticism :'-'}}</p>
                                    </div>
                                    <div class="mb-3 title-color">
                                        <h5>Have you done any certifications?</h5>
                                        <p class="f-w-600 mt-3">{{$hr_feedback->certifications != null ? $hr_feedback->certifications :'-'}}</p>
                                    </div>
                                    <div class="mb-3 title-color">
                                        <h5>If you are asked to report to the office will <br> you report in a hybrid model?</h5>
                                        <p class="f-w-600 mt-3">{{ $hr_feedback->hybrid_report != 'null' ? $hr_feedback->hybrid_report : '-' }}</p>
                                    </div>
                                    <div class="mb-3 title-color">
                                        <h5>You have changed jobs/jumped ship too many times already, why so? (For immediate jumpers if required)</h5>
                                        <p class="f-w-600 mt-3">{{$hr_feedback->jumped_job != null ? $hr_feedback->jumped_job :'-'}}</p>
                                    </div>
                                    <div class="mb-3 title-color">
                                        <h5>What is your notice period?</h5>
                                        <p class="f-w-600 mt-3">{{$hr_feedback->notice_peroid != null ? $hr_feedback->notice_peroid :'-'}}</p>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>
                    <!-- Container-fluid Ends-->
                </div>
            </div>

        </div>
    </div>
</div>
@endsection