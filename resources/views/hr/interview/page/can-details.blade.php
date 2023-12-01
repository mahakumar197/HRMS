<div class="job-search">
    <div class="media align-items-center">
        <script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
        <lord-icon src="https://cdn.lordicon.com/ajkxzzfb.json" trigger="hover" style="width:80px;height:80px">
        </lord-icon>
        <div class="media-body">
            <h6 class="f-w-600 f-28 m-0 p-0"><a href="job-details.html">{{$can_details->candetails->name}}</a></h6>
            <p class="f-18">{{$can_details->jobdetails->position->position_name}}</p>
        </div>
    </div>
</div>
<hr>


@if($can_details->round_1_status == 2 && $can_details->round_2_status == 2 &&
$can_details->round_3_status == 2 && $can_details->round_4_status == 2 )

<div class="card bg-success p-2 rounded-3">
    <h4 class="m-0 text-light text-center">Shortlisted</h4>
</div>

@endif


<div class="col-xl-12 card border rounded-3 ">

    <div class="card-header single-team h-calc mb-0" style="padding:20px!important">
        <div class="ribbon ribbon-bookmark ribbon-bottom-left ribbon-primary" style="top:30%"><span>Round 1 - {{$can_details->roundname1->round_name}}</span></div>
        <!--<div class="team-title">
            <span class="f-w-600 f-30 pull-right">{{$can_details->roundname1->round_name}}</span>
        </div>-->
    </div>

    @if(is_null($can_details->round_1_status))

    <div class="team-cap">
        <a href="#" class="btn btn-secondary int-btn mt-3" id="schedulejob_{{$can_details->id}}" job_id="{{$can_details->job_id}}" round="round_1" roundname="{{$can_details->roundname1->round_name}}">Schedule Now</a>
    </div>

    @else


    @switch($can_details->round_1_status)


    @case(0)

    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-warning f-20 pull-right">Scheduled</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_1")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewer_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" class="btn btn-warning int-btn" id="reschedulejob_{{$can_details->can_id}}" job_id="{{$can_details->job_id}}" round="round_1" roundname="{{$can_details->roundname1->round_name}}">Reschedule </a>
    </div>
    @break

    @case(1)

    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-warning f-20 pull-right">On Hold</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_1")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" id="feedback_round_1" class="btn btn-warning int-btn" job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_1_feedback}}" feedback_type="{{$can_details->round_1_feedback_type}}">View Feedback</a>
    </div>
    @break

    @case(2)

    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-success f-20 pull-right">Selected</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_1")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="{{url('data-hr-feedback')}}/{{$can_details->round_1_feedback}}" class="btn btn-success int-btn" target="_blank">View Feedback</a>
    </div>



    @break

    @case(3)
    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-danger f-20 pull-right">Rejected</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_1")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" id="feedback_round_1" class="btn btn-danger int-btn" job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_1_feedback}}" feedback_type="{{$can_details->round_1_feedback_type}}">View Feedback</a>
    </div>
    @break


    @default
    <h5>No Content!</h5>
    @endswitch

    @endif

</div>

<!-----------------------------------------------------------------Round 2--------------------------------------------------------------------------------------->
@if($can_details->round_1_status == 2 && $can_details->round_2 != null)
<div class="col-xl-12 card border rounded-3 ">
    <div class="card-header single-team h-calc mb-0" style="padding:20px!important">
        <div class="ribbon ribbon-bookmark ribbon-bottom-left ribbon-primary" style="top:30%"><span>Round 2 - {{$can_details->roundname2->round_name}}</span></div>
        <!--<div class="team-title">
            <span class="f-w-600 f-30 pull-right">{{$can_details->roundname1->round_name}}</span>
        </div>-->
    </div>
    @if(is_null($can_details->round_2_status))

    <div class="team-cap">
        <a href="#" class="btn btn-secondary int-btn mt-3" id="schedulejob_{{$can_details->id}}" job_id="{{$can_details->job_id}}" round="round_2" roundname="{{$can_details->roundname2->round_name}}">Schedule Now</a>
    </div>
    @else


    @switch($can_details->round_2_status)


    @case(0)

    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-warning f-20 pull-right">Scheduled</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_2")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" class="btn btn-warning int-btn" id="reschedulejob_{{$can_details->can_id}}" job_id="{{$can_details->job_id}}" round="round_2" roundname="{{$can_details->roundname2->round_name}}">Reschedule </a>

    </div>
    @break


    @case(1)

    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-warning f-20 pull-right">On Hold</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_2")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" id="feedback_round_2" class="btn btn-warning int-btn" job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_2_feedback}}" feedback_type="{{$can_details->round_2_feedback_type}}">View Feedback</a>
    </div>
    @break

    @case(2)

    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-success f-20 pull-right">Selected</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_2")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" id="feedback_round_2" class="btn btn-success int-btn" job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_2_feedback}}" feedback_type="{{$can_details->round_2_feedback_type}}">View Feedback</a>
    </div>



    @break

    @case(3)
    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-danger f-20 pull-right">Rejected</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_2")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" id="feedback_round_2" class="btn btn-danger int-btn" job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_2_feedback}}" feedback_type="{{$can_details->round_2_feedback_type}}">View Feedback</a>
    </div>
    @break


    @default
    <h5>No Content!</h5>
    @endswitch

    @endif

</div>
@endif
<!--------------------------------------------------------------------Round 3------------------------------------------------------------------------------------>

@if($can_details->round_2_status == 2 && $can_details->round_3 != null)
<div class="col-xl-12 card border rounded-3 ">
    <div class="card-header single-team h-calc mb-0" style="padding:20px!important">
        <div class="ribbon ribbon-bookmark ribbon-bottom-left ribbon-primary" style="top:30%"><span>Round 3 - {{$can_details->roundname3->round_name}}</span></div>
        <!--<div class="team-title">
            <span class="f-w-600 f-30 pull-right">{{$can_details->roundname1->round_name}}</span>
        </div>-->
    </div>
    @if(is_null($can_details->round_3_status))

    <div class="team-cap">
        <a href="#" class="btn btn-secondary int-btn mt-3" id="schedulejob_{{$can_details->id}}" job_id="{{$can_details->job_id}}" round="round_3" roundname="{{$can_details->roundname3->round_name}}">Schedule Now</a>
    </div>

    @else


    @switch($can_details->round_3_status)


    @case(0)

    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-warning f-20 pull-right">Scheduled</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_3")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" class="btn btn-warning int-btn" id="reschedulejob_{{$can_details->can_id}}" job_id="{{$can_details->job_id}}" round="round_3" roundname="{{$can_details->roundname3->round_name}}">Reschedule </a>

    </div>
    @break


    @case(1)

    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-warning f-20 pull-right">On Hold</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_3")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" id="feedback_round_3" class="btn btn-warning int-btn" job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_3_feedback}}" feedback_type="{{$can_details->round_3_feedback_type}}">View Feedback</a>
    </div>
    @break

    @case(2)

    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-success f-20 pull-right">Selected</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_3")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" id="feedback_round_3" class="btn btn-success int-btn" job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_3_feedback}}" feedback_type="{{$can_details->round_3_feedback_type}}">View Feedback</a>
    </div>



    @break

    @case(3)
    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-danger f-20 pull-right">Rejected</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_3")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" id="feedback_round_3" class="btn btn-danger int-btn" job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_3_feedback}}" feedback_type="{{$can_details->round_3_feedback_type}}">View Feedback</a>
    </div>
    @break


    @default
    <h5>No Content!</h5>
    @endswitch

    @endif

</div>
@endif


<!---------------------------------------------------------------------Round 4 ----------------------------------------------------------------------------------->
@if($can_details->round_3_status == 2 && $can_details->round_4 != null)
<div class="col-xl-12 card border rounded-3 ">
    <div class="card-header single-team h-calc mb-0" style="padding:20px!important">
        <div class="ribbon ribbon-bookmark ribbon-bottom-left ribbon-primary" style="top:30%"><span>Round 4 - {{$can_details->roundname4->round_name}}</span></div>
        <!--<div class="team-title">
            <span class="f-w-600 f-30 pull-right">{{$can_details->roundname1->round_name}}</span>
        </div>-->
    </div>
    @if(is_null($can_details->round_4_status))

    <div class="team-cap">
        <a href="#" class="btn btn-secondary int-btn mt-3" id="schedulejob_{{$can_details->id}}" job_id="{{$can_details->job_id}}" round="round_4" roundname="{{$can_details->roundname4->round_name}}">Schedule Now</a>
    </div>

    @else


    @switch($can_details->round_4_status)


    @case(0)

    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-warning f-20 pull-right">Scheduled</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_4")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" class="btn btn-warning int-btn" id="reschedulejob_{{$can_details->can_id}}" job_id="{{$can_details->job_id}}" round="round_4" roundname="{{$can_details->roundname4->round_name}}">Reschedule </a>

    </div>
    @break


    @case(1)

    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-warning f-20 pull-right">On Hold</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_4")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" id="feedback_round_4" class="btn btn-warning int-btn" job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_4_feedback}}" feedback_type="{{$can_details->round_4_feedback_type}}">View Feedback</a>
    </div>
    @break

    @case(2)

    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-success f-20 pull-right">Selected</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_4")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" id="feedback_round_4" class="btn btn-success int-btn" job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_4_feedback}}" feedback_type="{{$can_details->round_4_feedback_type}}">View Feedback</a>
    </div>



    @break

    @case(3)
    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-danger f-20 pull-right">Rejected</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_4")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" id="feedback_round_4" class="btn btn-danger int-btn" job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_4_feedback}}" feedback_type="{{$can_details->round_4_feedback_type}}">View Feedback</a>
    </div>
    @break


    @default
    <h5>No Content!</h5>
    @endswitch

    @endif

</div>
@endif

<!---------------------------------------------------------------------Round 5 ------------------------------------------------------------------------------------>
@if($can_details->round_4_status == 2 && $can_details->round_5 != null)
<div class="col-xl-12 card border rounded-3 ">
    <div class="card-header single-team h-calc mb-0" style="padding:20px!important">
        <div class="ribbon ribbon-bookmark ribbon-bottom-left ribbon-primary" style="top:30%"><span>Round 5 - {{$can_details->roundname5->round_name}}</span></div>
        <!--<div class="team-title">
            <span class="f-w-600 f-30 pull-right">{{$can_details->roundname1->round_name}}</span>
        </div>-->
    </div>
    @if(is_null($can_details->round_5_status))

    <div class="team-cap">
        <a href="#" class="btn btn-secondary int-btn mt-3" id="schedulejob_{{$can_details->id}}" job_id="{{$can_details->job_id}}" round="round_5" roundname="{{$can_details->roundname5->round_name}}">Schedule Now</a>
    </div>

    @else


    @switch($can_details->round_5_status)


    @case(0)

    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-warning f-20 pull-right">Scheduled</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_5")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" class="btn btn-warning int-btn" id="reschedulejob_{{$can_details->can_id}}" job_id="{{$can_details->job_id}}" round="round_5" roundname="{{$can_details->roundname5->round_name}}">Reschedule </a>

    </div>
    @break


    @case(1)

    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-warning f-20 pull-right">On Hold</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_5")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" id="feedback_round_5" class="btn btn-warning int-btn" job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_5_feedback}}" feedback_type="{{$can_details->round_5_feedback_type}}">View Feedback</a>
    </div>
    @break

    @case(2)

    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-success f-20 pull-right">Selected</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_5")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" id="feedback_round_5" class="btn btn-success int-btn" job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_5_feedback}}" feedback_type="{{$can_details->round_5_feedback_type}}">View Feedback</a>
    </div>



    @break

    @case(3)
    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-danger f-20 pull-right">Rejected</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_5")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" id="feedback_round_5" class="btn btn-danger int-btn" job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_5_feedback}}" feedback_type="{{$can_details->round_5_feedback_type}}">View Feedback</a>
    </div>
    @break


    @default
    <h5>No Content!</h5>
    @endswitch

    @endif

</div>
@endif

<!----------------------------------------------------------------------Round 6------------------------------------------------------------------------------------>
@if($can_details->round_5_status == 2 && $can_details->round_6 != null)
<div class="col-xl-12 card border rounded-3 ">
    <div class="card-header single-team h-calc mb-0" style="padding:20px!important">
        <div class="ribbon ribbon-bookmark ribbon-bottom-left ribbon-primary" style="top:30%"><span>Round 6 - {{$can_details->roundname6->round_name}}</span></div>
        <!--<div class="team-title">
            <span class="f-w-600 f-30 pull-right">{{$can_details->roundname1->round_name}}</span>
        </div>-->
    </div>
    @if(is_null($can_details->round_6_status))

    <div class="team-cap">
        <a href="#" class="btn btn-secondary int-btn mt-3" id="schedulejob_{{$can_details->id}}" job_id="{{$can_details->job_id}}" round="round_6" roundname="{{$can_details->roundname6->round_name}}">Schedule Now</a>
    </div>

    @else


    @switch($can_details->round_6_status)


    @case(0)

    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-warning f-20 pull-right">Scheduled</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_6")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" class="btn btn-warning int-btn" id="reschedulejob_{{$can_details->can_id}}" job_id="{{$can_details->job_id}}" round="round_6" roundname="{{$can_details->roundname6->round_name}}">Reschedule </a>

    </div>
    @break


    @case(1)

    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-warning f-20 pull-right">On Hold</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_6")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" id="feedback_round_6" class="btn btn-warning int-btn" job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_6_feedback}}" feedback_type="{{$can_details->round_6_feedback_type}}">View Feedback</a>
    </div>
    @break

    @case(2)

    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-success f-20 pull-right">Selected</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_6")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" id="feedback_round_6" class="btn btn-success int-btn" job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_6_feedback}}" feedback_type="{{$can_details->round_6_feedback_type}}">View Feedback</a>
    </div>



    @break

    @case(3)
    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-danger f-20 pull-right">Rejected</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_6")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" id="feedback_round_6" class="btn btn-danger int-btn" job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_6_feedback}}" feedback_type="{{$can_details->round_6_feedback_type}}">View Feedback</a>
    </div>
    @break


    @default
    <h5>No Content!</h5>
    @endswitch

    @endif

</div>
@endif
<!-----------------------------------------------------------------------Round 7 ---------------------------------------------------------------------------------->
@if($can_details->round_6_status == 2 && $can_details->round_7 != null)
<div class="col-xl-12 card border rounded-3 ">
    <div class="card-header single-team h-calc mb-0" style="padding:20px!important">
        <div class="ribbon ribbon-bookmark ribbon-bottom-left ribbon-primary" style="top:30%"><span>Round 7 - {{$can_details->roundname7->round_name}}</span></div>
        <!--<div class="team-title">
            <span class="f-w-600 f-30 pull-right">{{$can_details->roundname1->round_name}}</span>
        </div>-->
    </div>
    @if(is_null($can_details->round_7_status))

    <div class="team-cap">
        <a href="#" class="btn btn-secondary int-btn mt-3" id="schedulejob_{{$can_details->id}}" job_id="{{$can_details->job_id}}" round="round_7" roundname="{{$can_details->roundname7->round_name}}">Schedule Now</a>
    </div>

    @else


    @switch($can_details->round_7_status)


    @case(0)

    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-warning f-20 pull-right">Scheduled</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_7")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" class="btn btn-warning int-btn" id="reschedulejob_{{$can_details->can_id}}" job_id="{{$can_details->job_id}}" round="round_7" roundname="{{$can_details->roundname7->round_name}}">Reschedule </a>

    </div>
    @break


    @case(1)

    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-warning f-20 pull-right">On Hold</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_7")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" id="feedback_round_7" class="btn btn-warning int-btn" job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_7_feedback}}" feedback_type="{{$can_details->round_7_feedback_type}}">View Feedback</a>
    </div>
    @break

    @case(2)

    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-success f-20 pull-right">Selected</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_7")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" id="feedback_round_7" class="btn btn-success int-btn" job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_7_feedback}}" feedback_type="{{$can_details->round_7_feedback_type}}">View Feedback</a>
    </div>



    @break

    @case(3)
    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-danger f-20 pull-right">Rejected</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_7")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" id="feedback_round_7" class="btn btn-danger int-btn" job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_7_feedback}}" feedback_type="{{$can_details->round_7_feedback_type}}">View Feedback</a>
    </div>
    @break


    @default
    <h5>No Content!</h5>
    @endswitch

    @endif

</div>
@endif
<!-----------------------------------------------------------------------Round 8 ---------------------------------------------------------------------------------->
@if($can_details->round_7_status == 2 && $can_details->round_8 != null)
<div class="col-xl-12 card border rounded-3 ">
    <div class="card-header single-team h-calc mb-0" style="padding:20px!important">
        <div class="ribbon ribbon-bookmark ribbon-bottom-left ribbon-primary" style="top:30%"><span>Round 8 - {{$can_details->roundname8->round_name}}</span></div>
        <!--<div class="team-title">
            <span class="f-w-600 f-30 pull-right">{{$can_details->roundname1->round_name}}</span>
        </div>-->
    </div>
    @if(is_null($can_details->round_8_status))

    <div class="team-cap">
        <a href="#" class="btn btn-secondary int-btn mt-3" id="schedulejob_{{$can_details->id}}" job_id="{{$can_details->job_id}}" round="round_8" roundname="{{$can_details->roundname8->round_name}}">Schedule Now</a>
    </div>

    @else


    @switch($can_details->round_8_status)


    @case(0)

    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-warning f-20 pull-right">Scheduled</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_8")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" class="btn btn-warning int-btn" id="reschedulejob_{{$can_details->can_id}}" job_id="{{$can_details->job_id}}" round="round_8" roundname="{{$can_details->roundname8->round_name}}">Reschedule </a>

    </div>
    @break


    @case(1)

    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-warning f-20 pull-right">On Hold</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_8")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" id="feedback_round_8" class="btn btn-warning int-btn" job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_8_feedback}}" feedback_type="{{$can_details->round_8_feedback_type}}">View Feedback</a>
    </div>
    @break

    @case(2)

    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-success f-20 pull-right">Selected</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_8")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" id="feedback_round_8" class="btn btn-success int-btn" job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_8_feedback}}" feedback_type="{{$can_details->round_8_feedback_type}}">View Feedback</a>
    </div>



    @break

    @case(3)
    <div class="card-body single-team h-calc p-b-0 mb-0">
        <div class="d-flex align-items-center mb-10 blog-box blog-list row">
            <div class="blog-details">
                <h6 class="font-danger f-20 pull-right">Rejected</h6>
                @foreach($schedule as $sch)
                @if($sch->round == "round_8")
                <div class="blog-date"><span>{{Carbon\Carbon::parse($sch->schedule_date)->format('d')}}</span>{{Carbon\Carbon::parse($sch->schedule_date)->format('M Y')}}</div>
                <div class="blog-bottom-content">
                    <ul class="blog-social">
                        <li>@ Time</li>
                        <li>{{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</li>
                    </ul>
                    <hr>
                    <h6 class="font-primary">Interviewer</h6>
                    <div class="d-flex align-items-center mb-10">
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->employee->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->employee->name}}</span>
                            <p class="pera">{{$sch->employee->designation->designation}}</p>
                        </div>
                        @if($sch->interviewerr_2_id != null)
                        <div class="team-img">
                            <img src="{{ URL::to('/') }}/image/{{$sch->interviewer->image_path}}" alt="img" class="img-cover p-0">
                        </div>
                        <div class="team-title blog-social">
                            <span class="title font-600 f-16">{{$sch->interviewer->name}}</span>
                            <p class="pera">{{$sch->interviewer->designation->designation}}</p>
                        </div>
                        @endif
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="team-cap text-center">
        <a href="#" id="feedback_round_8" class="btn btn-danger int-btn" job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_8_feedback}}" feedback_type="{{$can_details->round_8_feedback_type}}">View Feedback</a>
    </div>
    @break


    @default
    <h5>No Content!</h5>
    @endswitch

    @endif

</div>
@endif
<!------------------------------------------------------------------------------------------------------------------------------------------------------------------------------>




<script>
    jQuery("[id^=schedulejob_]").click(function() {

        var id = $(this).attr('id').split('schedulejob_')[1];
        var job = $(this).attr("job_id");
        var round = $(this).attr("round");
        var roundname = $(this).attr("roundname");

        $.ajax({
            type: "GET",
            data: {
                'id': id,
                'job': job,
                'round': round,
                'roundname': roundname
            },
            url: "{{ url('job-schedule/create') }}",

            success: function(data) {
                $('#modal-content').html(data);
                $('#schedule_modal').modal('show');
            }
        });
    });

    //Re schedule Job //

    jQuery("[id^=reschedulejob_]").click(function() {

        var id = $(this).attr('id').split('reschedulejob_')[1];
        var job = $(this).attr("job_id");
        var round = $(this).attr("round");
        var roundname = $(this).attr("roundname");

        $.ajax({
            type: "GET",
            data: {
                'id': id,
                'job': job,
                'round': round,
                'roundname': roundname
            },
            url: "{{ url('job-re-schedule') }}",
            beforeSend: function() {

                $('#modal-content').empty();
            },
            success: function(data) {
                $('#modal-content').html(data);
                $('#schedule_modal').modal('show');
            }
        });
    });
</script>

<script>
    jQuery("[id^=feedback_round_]").click(function() {
        var round = $(this).attr('id').split('feedback_')[1];
        var job = $(this).attr("job_id");
        var can_id = $(this).attr("can_id");
        var round_id = $(this).attr("round_id");
        var feedback_type = $(this).attr("feedback_type");

        $.ajax({
            type: "GET",
            data: {
                'round': round,
                'job': job,
                'can_id': can_id,
                'round_id': round_id,
                'feedback_type': feedback_type
            },
            url: "{{ route('get-feedback-details') }}",
            success: function(data) {
                $('#modal-content').html(data);
                $('#schedule_modal').modal('show');
            }
        });
    });
</script>