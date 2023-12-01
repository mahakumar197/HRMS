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

<div class="card bg-success p-2 rounded-4">
    <h4 class="m-0 text-light text-center">Shortlisted</h4>
</div>


@endif
<div class="col-xl-12 border rounded-3 ">

    <div class="single-team h-calc">

        <div class="d-flex align-items-center mb-10 border-bottom">

            <div class="team-title">
                <span class="title font-600">Round- 1 : {{$can_details->roundname1->round_name}}</span>
                <p class="pera">time</p>
            </div>
            <hr />
        </div>

        @if(is_null($can_details->round_1_status))

        <div class="team-cap">
            <a href="#" class="btn btn-success" id="schedulejob_{{$can_details->id}}" job_id="{{$can_details->job_id}}" round="round_1" roundname="{{$can_details->roundname1->round_name}}">Schedule Now</a>

        </div>

        @else


        @switch($can_details->round_1_status)


        @case(0)



        <div class="d-flex align-items-center mb-10 border-bottom">
            <div class="team-img">
                <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
            </div>
            <div class="team-title">
                <span class="title font-600">Scheduled</span>
                @foreach($schedule as $sch)

                @if($sch->round = "round_1")
                <p class="pera">{{Carbon\Carbon::parse($sch->schedule_date)->format('d-m-Y')}}
                    : {{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</p>



                @endif

                @endforeach

            </div>
        </div>

        <div class="team-cap text-center">
            <a href="#" class="btn btn-outline-info " id="reschedulejob_{{$can_details->can_id}}" job_id="{{$can_details->job_id}}" round="round_1" roundname="{{$can_details->roundname1->round_name}}">ReSchedule </a>

        </div>
        @break


        @case(1)


        <div class="d-flex align-items-center mb-10 border-bottom">
            <div class="team-img">
                <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
            </div>
            <div class="team-title">
                <span class="title font-600">On Hold</span>


            </div>
        </div>


        <div class="team-cap text-center">
            <a href="#" id="feedback_round_1" class="btn btn-outline-info " job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_1_feedback}}" feedback_type="{{$can_details->round_1_feedback_type}}"> Feedback Form</a>

        </div>


        @break

        @case(2)



        <div class="d-flex align-items-center mb-10 border-bottom">
            <div class="team-img">
                <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
            </div>
            <div class="team-title">
                <span class="title font-600 text-success">Selected</span>


            </div>
        </div>


        <div class="team-cap text-center">
            <a href="#" id="feedback_round_1" class="btn btn-outline-info " job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_1_feedback}}" feedback_type="{{$can_details->round_1_feedback_type}}"> Feedback Form</a>

        </div>



        @break

        @case(3)
        <div class="d-flex align-items-center mb-10 border-bottom">
            <div class="team-img">
                <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
            </div>
            <div class="team-title">
                <span class="title font-600">Rejected</span>


            </div>
        </div>


        <div class="team-cap text-center">
            <a href="#" id="feedback_round_1" class="btn btn-outline-info " job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_1_feedback}}" feedback_type="{{$can_details->round_1_feedback_type}}"> Feedback Form</a>

        </div>
        @break




        @default
        <h5>no</h5>
        @endswitch

        @endif

    </div>
</div>

<!-- Round 2 -->

@if($can_details->round_1_status == 2)
<div class="col-10 border rounded-3 m-t-20">
    <div class="single-team h-calc">

        <div class="d-flex align-items-center mb-10 border-bottom">

            <div class="team-title">
                <span class="title font-600">Round- 2 : {{$can_details->roundname2->round_name}}</span>
                <p class="pera">time</p>
            </div>
            <hr />
        </div>

        @if(is_null($can_details->round_2_status))

        <div class="team-cap">
            <a href="#" class="btn btn-success" id="schedulejob_{{$can_details->id}}" job_id="{{$can_details->job_id}}" round="round_2" roundname="{{$can_details->roundname1->round_name}}">Schedule Now</a>

        </div>

        @else


        @switch($can_details->round_2_status)


        @case(0)



        <div class="d-flex align-items-center mb-10 border-bottom">
            <div class="team-img">
                <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
            </div>
            <div class="team-title">
                <span class="title font-600">Scheduled </span>
                @foreach($schedule as $sch)



                @if($sch->round == "round_2")

                <p class="pera">{{Carbon\Carbon::parse($sch->schedule_date)->format('d-m-Y')}}
                    : {{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</p>





            </div>
        </div>

        <div class="team-cap text-center">
            <a href="#" class="btn btn-outline-info " id="reschedulejob_{{$can_details->can_id}}" job_id="{{$can_details->job_id}}" round="round_2" roundname="{{$can_details->roundname2->round_name}}">ReSchedule </a>

        </div>

        @endif

        @endforeach
        @break


        @case(1)


        <div class="d-flex align-items-center mb-10 border-bottom">
            <div class="team-img">
                <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
            </div>
            <div class="team-title">
                <span class="title font-600">On Hold</span>


            </div>
        </div>


        <div class="team-cap text-center">
            <a href="#" id="feedback_round_2" class="btn btn-outline-info " job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_2_feedback}}" feedback_type="{{$can_details->round_2_feedback_type}}"> Feedback Form</a>

        </div>


        @break

        @case(2)



        <div class="d-flex align-items-center mb-10 border-bottom">
            <div class="team-img">
                <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
            </div>
            <div class="team-title">
                <span class="title font-600 text-success">Selected</span>


            </div>
        </div>


        <div class="team-cap text-center">
            <a href="#" id="feedback_round_2" class="btn btn-outline-info " job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_2_feedback}}" feedback_type="{{$can_details->round_2_feedback_type}}"> Feedback Form</a>

        </div>



        @break

        @case(3)
        <div class="d-flex align-items-center mb-10 border-bottom">
            <div class="team-img">
                <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
            </div>
            <div class="team-title">
                <span class="title font-600">Rejected</span>


            </div>
        </div>


        <div class="team-cap text-center">
            <a href="#" id="feedback_round_2" class="btn btn-outline-info " job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_2_feedback}}" feedback_type="{{$can_details->round_2_feedback_type}}"> Feedback Form</a>

        </div>
        @break


    </div>
</div>

@default
<h5>no</h5>
@endswitch

@endif

@endif
</div>
</div>
<!-- Round 3 -->

@if($can_details->round_2_status == 2)
<div class="col-10 border rounded-3 m-t-20">
    <div class="single-team h-calc">

        <div class="d-flex align-items-center mb-10 border-bottom">

            <div class="team-title">
                <span class="title font-600">Round- 3 : {{$can_details->roundname3->round_name}}</span>
                <p class="pera">time</p>
            </div>
            <hr />
        </div>

        @if(is_null($can_details->round_3_status))

        <div class="team-cap">
            <a href="#" class="btn btn-success" id="schedulejob_{{$can_details->id}}" job_id="{{$can_details->job_id}}" round="round_3" roundname="{{$can_details->roundname3->round_name}}">Schedule Now</a>

        </div>

        @else


        @switch($can_details->round_3_status)


        @case(0)



        <div class="d-flex align-items-center mb-10 border-bottom">
            <div class="team-img">
                <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
            </div>
            <div class="team-title">
                <span class="title font-600">Scheduled </span>
                @foreach($schedule as $sch)



                @if($sch->round == "round_3")

                <p class="pera">{{Carbon\Carbon::parse($sch->schedule_date)->format('d-m-Y')}}
                    : {{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</p>





            </div>
        </div>

        <div class="team-cap text-center">
            <a href="#" class="btn btn-outline-info " id="reschedulejob_{{$can_details->can_id}}" job_id="{{$can_details->job_id}}" round="round_3" roundname="{{$can_details->roundname3->round_name}}">ReSchedule </a>

        </div>

        @endif

        @endforeach
        @break


        @case(1)


        <div class="d-flex align-items-center mb-10 border-bottom">
            <div class="team-img">
                <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
            </div>
            <div class="team-title">
                <span class="title font-600">On Hold</span>


            </div>
        </div>


        <div class="team-cap text-center">
            <a href="#" id="feedback_round_3" class="btn btn-outline-info " job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_3_feedback}}" feedback_type="{{$can_details->round_3_feedback_type}}"> Feedback Form</a>

        </div>


        @break

        @case(2)



        <div class="d-flex align-items-center mb-10 border-bottom">
            <div class="team-img">
                <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
            </div>
            <div class="team-title">
                <span class="title font-600 text-success">Selected</span>


            </div>
        </div>


        <div class="team-cap text-center">
            <a href="#" id="feedback_round_3" class="btn btn-outline-info " job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_3_feedback}}" feedback_type="{{$can_details->round_3_feedback_type}}"> Feedback Form</a>

        </div>



        @break

        @case(3)
        <div class="d-flex align-items-center mb-10 border-bottom">
            <div class="team-img">
                <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
            </div>
            <div class="team-title">
                <span class="title font-600">Rejected</span>


            </div>
        </div>


        <div class="team-cap text-center">
            <a href="#" id="feedback_round_3" class="btn btn-outline-info " job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_3_feedback}}" feedback_type="{{$can_details->round_3_feedback_type}}"> Feedback Form</a>

        </div>
        @break


    </div>
</div>

@default
<h5>no</h5>
@endswitch

@endif

@endif
</div>
</div>


<!-- Round 4 -->

@if($can_details->round_3_status == 2)
<div class="col-10 border rounded-3 m-t-20">
    <div class="single-team h-calc">

        <div class="d-flex align-items-center mb-10 border-bottom">

            <div class="team-title">
                <span class="title font-600">Round- 4 : {{$can_details->roundname4->round_name}}</span>
                <p class="pera">time</p>
            </div>
            <hr />
        </div>

        @if(is_null($can_details->round_4_status))

        <div class="team-cap">
            <a href="#" class="btn btn-success" id="schedulejob_{{$can_details->id}}" job_id="{{$can_details->job_id}}" round="round_4" roundname="{{$can_details->roundname4->round_name}}">Schedule Now</a>

        </div>

        @else


        @switch($can_details->round_4_status)


        @case(0)



        <div class="d-flex align-items-center mb-10 border-bottom">
            <div class="team-img">
                <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
            </div>
            <div class="team-title">
                <span class="title font-600">Scheduled </span>
                @foreach($schedule as $sch)



                @if($sch->round == "round_4")

                <p class="pera">{{Carbon\Carbon::parse($sch->schedule_date)->format('d-m-Y')}}
                    : {{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</p>





            </div>
        </div>

        <div class="team-cap text-center">
            <a href="#" class="btn btn-outline-info " id="reschedulejob_{{$can_details->can_id}}" job_id="{{$can_details->job_id}}" round="round_4" roundname="{{$can_details->roundname4->round_name}}">ReSchedule </a>

        </div>

        @endif

        @endforeach
        @break


        @case(1)


        <div class="d-flex align-items-center mb-10 border-bottom">
            <div class="team-img">
                <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
            </div>
            <div class="team-title">
                <span class="title font-600">On Hold</span>


            </div>
        </div>


        <div class="team-cap text-center">
            <a href="#" id="feedback_round_4" class="btn btn-outline-info " job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_4_feedback}}" feedback_type="{{$can_details->round_4_feedback_type}}"> Feedback Form</a>

        </div>


        @break

        @case(2)



        <div class="d-flex align-items-center mb-10 border-bottom">
            <div class="team-img">
                <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
            </div>
            <div class="team-title">
                <span class="title font-600 text-success">Selected</span>


            </div>
        </div>


        <div class="team-cap text-center">
            <a href="#" id="feedback_round_4" class="btn btn-outline-info " job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_4_feedback}}" feedback_type="{{$can_details->round_4_feedback_type}}"> Feedback Form</a>

        </div>



        @break

        @case(3)
        <div class="d-flex align-items-center mb-10 border-bottom">
            <div class="team-img">
                <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
            </div>
            <div class="team-title">
                <span class="title font-600">Rejected</span>


            </div>
        </div>


        <div class="team-cap text-center">
            <a href="#" id="feedback_round_4" class="btn btn-outline-info " job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_4_feedback}}" feedback_type="{{$can_details->round_4_feedback_type}}"> Feedback Form</a>

        </div>
        @break


    </div>
</div>

@default
<h5>no</h5>
@endswitch

@endif

@endif
</div>
</div>


<!-- Round 5 -->

@if($can_details->round_4_status == 2 && $can_details->round_5 != null)
<div class="col-10 border rounded-3 m-t-20">
    <div class="single-team h-calc">

        <div class="d-flex align-items-center mb-10 border-bottom">

            <div class="team-title">
                <span class="title font-600">Round- 5 : {{$can_details->roundname5->round_name}}</span>
                <p class="pera">time</p>
            </div>
            <hr />
        </div>

        @if(is_null($can_details->round_5_status))

        <div class="team-cap">
            <a href="#" class="btn btn-success" id="schedulejob_{{$can_details->id}}" job_id="{{$can_details->job_id}}" round="round_5" roundname="{{$can_details->roundname5->round_name}}">Schedule Now</a>

        </div>

        @else


        @switch($can_details->round_5_status)


        @case(0)



        <div class="d-flex align-items-center mb-10 border-bottom">
            <div class="team-img">
                <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
            </div>
            <div class="team-title">
                <span class="title font-600">Scheduled </span>
                @foreach($schedule as $sch)



                @if($sch->round == "round_5")

                <p class="pera">{{Carbon\Carbon::parse($sch->schedule_date)->format('d-m-Y')}}
                    : {{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</p>





            </div>
        </div>

        <div class="team-cap text-center">
            <a href="#" class="btn btn-outline-info " id="reschedulejob_{{$can_details->can_id}}" job_id="{{$can_details->job_id}}" round="round_5" roundname="{{$can_details->roundname5->round_name}}">ReSchedule </a>

        </div>

        @endif

        @endforeach
        @break


        @case(1)


        <div class="d-flex align-items-center mb-10 border-bottom">
            <div class="team-img">
                <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
            </div>
            <div class="team-title">
                <span class="title font-600">On Hold</span>


            </div>
        </div>


        <div class="team-cap text-center">
            <a href="#" id="feedback_round_5" class="btn btn-outline-info " job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_5_feedback}}" feedback_type="{{$can_details->round_5_feedback_type}}"> Feedback Form</a>

        </div>


        @break

        @case(2)



        <div class="d-flex align-items-center mb-10 border-bottom">
            <div class="team-img">
                <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
            </div>
            <div class="team-title">
                <span class="title font-600 text-success">Selected</span>


            </div>
        </div>


        <div class="team-cap text-center">
            <a href="#" id="feedback_round_5" class="btn btn-outline-info " job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_5_feedback}}" feedback_type="{{$can_details->round_5_feedback_type}}"> Feedback Form</a>

        </div>



        @break

        @case(3)
        <div class="d-flex align-items-center mb-10 border-bottom">
            <div class="team-img">
                <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
            </div>
            <div class="team-title">
                <span class="title font-600">Rejected</span>


            </div>
        </div>


        <div class="team-cap text-center">
            <a href="#" id="feedback_round_5" class="btn btn-outline-info " job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_5_feedback}}" feedback_type="{{$can_details->round_5_feedback_type}}"> Feedback Form</a>

        </div>
        @break


    </div>
</div>

@default
<h5>no</h5>
@endswitch

@endif

@endif
</div>
</div>

<!-- Round 6 -->

@if($can_details->round_5_status == 2 && $can_details->round_6 != null)
<div class="col-10 border rounded-3 m-t-20">
    <div class="single-team h-calc">

        <div class="d-flex align-items-center mb-10 border-bottom">

            <div class="team-title">
                <span class="title font-600">Round- 6 : {{$can_details->roundname6->round_name}}</span>
                <p class="pera">time</p>
            </div>
            <hr />
        </div>

        @if(is_null($can_details->round_6_status))

        <div class="team-cap">
            <a href="#" class="btn btn-success" id="schedulejob_{{$can_details->id}}" job_id="{{$can_details->job_id}}" round="round_6" roundname="{{$can_details->roundname6->round_name}}">Schedule Now</a>

        </div>

        @else


        @switch($can_details->round_6_status)


        @case(0)



        <div class="d-flex align-items-center mb-10 border-bottom">
            <div class="team-img">
                <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
            </div>
            <div class="team-title">
                <span class="title font-600">Scheduled </span>
                @foreach($schedule as $sch)



                @if($sch->round == "round_6")

                <p class="pera">{{Carbon\Carbon::parse($sch->schedule_date)->format('d-m-Y')}}
                    : {{Carbon\Carbon::parse($sch->schedule_time)->format('h:i A')}}</p>





            </div>
        </div>

        <div class="team-cap text-center">
            <a href="#" class="btn btn-outline-info " id="reschedulejob_{{$can_details->can_id}}" job_id="{{$can_details->job_id}}" round="round_6" roundname="{{$can_details->roundname6->round_name}}">ReSchedule </a>

        </div>

        @endif

        @endforeach
        @break


        @case(1)


        <div class="d-flex align-items-center mb-10 border-bottom">
            <div class="team-img">
                <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
            </div>
            <div class="team-title">
                <span class="title font-600">On Hold</span>


            </div>
        </div>


        <div class="team-cap text-center">
            <a href="#" id="feedback_round_6" class="btn btn-outline-info " job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_6_feedback}}" feedback_type="{{$can_details->round_6_feedback_type}}"> Feedback Form</a>
        </div>
        @break
        @case(2)
        <div class="d-flex align-items-center mb-10 border-bottom">
            <div class="team-img">
                <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
            </div>
            <div class="team-title">
                <span class="title font-600 text-success">Selected</span>
            </div>
        </div>
        <div class="team-cap text-center">
            <a href="#" id="feedback_round_6" class="btn btn-outline-info " job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_6_feedback}}" feedback_type="{{$can_details->round_6_feedback_type}}"> Feedback Form</a>
        </div>
        @break
        @case(3)
        <div class="d-flex align-items-center mb-10 border-bottom">
            <div class="team-img">
                <img src="https://initcard.sai4ul.com/assets/images/team/user4.jpg" alt="img" class="img-cover">
            </div>
            <div class="team-title">
                <span class="title font-600">Rejected</span>
            </div>
        </div>
        <div class="team-cap text-center">
            <a href="#" id="feedback_round_6" class="btn btn-outline-info " job_id="{{$can_details->job_id}}" can_id="{{$can_details->can_id}}" round_id="{{$can_details->round_6_feedback}}" feedback_type="{{$can_details->round_6_feedback_type}}"> Feedback Form</a>
        </div>
        @break
    </div>
</div>

@default
<h5>no</h5>
@endswitch

@endif

@endif
</div>
</div>

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