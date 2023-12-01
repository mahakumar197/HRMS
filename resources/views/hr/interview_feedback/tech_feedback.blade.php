@extends('layouts.app')

@section('page_title')
<title>Interview Round</title>
@endsection

@section('style')
<link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/rating.css')}}">
@endsection

@section('content')
<div id="mail_send"></div>
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <h3>Tech Feedback</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="edit-profile">

            @if(Session::has('message'))
            <div class="alert alert alert-success" role="alert">
                {{session::get('message')}}

            </div>
            @endif

            @if(Session::has('error2'))
            <div class="alert alert alert-danger" role="alert">
                {{session::get('error2')}}

            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form class="form theme-form" action="{{url('tech-interview-feedback')}}" method="POST" autocomplete="off" enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-center">

                    <div class="col-xl-4 col-md-4">
                        <div class="card">
                            <div class="card-header pb-0">
                                <div class="profile-title">
                                    <div class="media">
                                        <div class="media-body m-l-0">
                                            <h3 class="mb-1 f-22 txt-primary">{{$candidate->candetails->name}}</h3>
                                            <h6 class="f-14">Job Position : {{$candidate->jobdetails->position->position_name}}</h6>
                                            <h6 class="f-14">Job Code : {{$candidate->jobdetails->job_code}}</h6>
                                            @foreach($roundname as $r)
                                            @if($candidate->jobinterview->$current_round == $r->id )
                                            <h6 class="f-14">Current Round :{{$r->round_name}}</h6>
                                            @endif
                                            @endforeach
                                            @if($round_number != 2)
                                            <a herf="#" onClick="feedback({{$candidate->job_interview_id}},{{$candidate->job_id}},{{$round_number}})" class="btn btn-primary">Get Feedback</a>

                                            @endif


                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">



                            </div>
                        </div>

                    </div>
                    @if(Auth::id() != $candidate->interviewer_2_id)
                    <div class="col-xl-8 col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <div class="media align-items-center">
                                    <script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
                                    <lord-icon src="https://cdn.lordicon.com/surjmvno.json" trigger="loop" delay="2000" style="width:80px;height:80px">
                                    </lord-icon>
                                    <div class="media-body m-l-0">

                                        <h3 class="mb-1 f-20 txt-primary">{{$candidate->candetails->name}}</h3>
                                        <p class="f-12 mb-0">{{$candidate->jobdetails->position->position_name}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="rating">
                            @php $i=0; @endphp
                            @foreach($e_skill as $es)


                            <div class="card ">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <h3 class="mb-1 f-20 txt-primary">{{$es->skillset}}</h3>
                                        </div>
                                        <div class="col-md-2">
                                            <h6 class="mb-1 f-20 txt-primary">Essential Skill</h6>
                                        </div>
                                        <div class="col-md-3 d-flex justify-content-end">
                                            <div class="rating-container digits">
                                                <select id="u-rating-1to12" name="inputs[{{$i}}][rating]" autocomplete="off">
                                                    <option value="1" selected="selected">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                </select>
                                            </div>

                                        </div>
                                        <div class="col-md-5">
                                            <div>
                                                <textarea class="form-control" rows="3" name="inputs[{{$i}}][comments]" placeholder="Comments">{{old('inputs[$i][comments]')}}</textarea>
                                                <input class="form-control" type="hidden" value="{{$es->id}}" name="inputs[{{$i}}][skill_id]">
                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php $i++ @endphp
                            @endforeach

                            @if($d_skill != null)
                            @foreach($d_skill as $ds)
                            @php $i++ @endphp
                            <div class="card ">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <h3 class="mb-1 f-20 txt-primary">{{$ds->skillset}}</h3>
                                        </div>
                                        <div class="col-md-2">
                                            <h6 class="mb-1 f-20 txt-primary">Desirable Skills</h6>
                                        </div>
                                        <div class="col-md-3 d-flex justify-content-end">
                                            <div class="rating-container digits">
                                                <select id="rating1" name="inputs[{{$i}}][rating]" autocomplete="off">
                                                    <option value="1" selected="selected">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div>
                                                <textarea class="form-control" rows="3" name="inputs[{{$i}}][comments]" placeholder="Comments">{{old('inputs[$i][comments]')}}</textarea>

                                                <input class="form-control" type="hidden" value="{{$ds->id}}" name="inputs[{{$i}}][skill_id]">


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @endforeach
                            @endif
                        </div>

                        <div class="card">
                            <div class="card-body">


                                <div class="mt-3">
                                    <label class="form-label {{ $errors->has('overall_comment') ? ' has-error' : ''}}">
                                        Overall Comment*</label>

                                    <textarea class="form-control" rows="4" name="overall_comment" placeholder=" Over all Comments">{{old('overall_comment')}}</textarea>
                                    @if ($errors->has("overall_comment"))
                                    <div class="text-danger">{{ $errors->first('overall_comment') }}</div>
                                    @endif

                                    <input class="form-control" type="hidden" value="{{$candidate->candetails->id}}" name="can_id">
                                    <input class="form-control" type="hidden" value="{{$candidate->jobdetails->id}}" name="job_id">
                                    <input class="form-control" type="hidden" value="{{$current_round}}" name="current_round">
                                    <input class="form-control" type="hidden" value="{{$candidate->job_interview_id}}" name="job_interview_id">

                                    <input class="form-control" type="hidden" value="{{$candidate->id}}" name="schedule_update">
                                    <input class="form-control" type="hidden" value="{{$schedule_id}}" name="schedule_id">

                                    <!-------- Photo ----------->

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3 mt-3">
                                                <label>Candidate Photo</label>
                                                <input class="form-control  {{ $errors->has('can_image') ? ' has-error' : ''}}" type="file" name="can_image">

                                                @if ($errors->has('can_image'))
                                                <div class="text-danger">{{ $errors->first('can_image') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mt-3">
                                                <label class="form-label {{ $errors->has('round_status') ? ' has-error' : ''}}">
                                                    Candidate Status*</label>
                                                <select class="form-control " name="round_status">
                                                    <option value="">--Select--</option>
                                                    <option value="1">On Hold</option>
                                                    <option value="2">Selected</option>
                                                    <option value="3">Rejected</option>

                                                </select>
                                                @if ($errors->has('round_status'))
                                                <div class="text-danger">{{ $errors->first('round_status') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="text-end m-t-20">
                                            <button class="btn btn-primary" type="submit" id="btn_submit">Submit Feedback</button>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    @else
                    <div class="col-xl-8 col-md-8"></div>
                    @endif               


            </form>
        </div>
    </div>
</div>
</div>

<div class="customizer-contain">

    <div class="tab-content" id="c-pills-tabContent">

        <div class="customizer-header">
            <i class="icofont-close icon-close" id="close-details"></i>
        </div>

        <div class="customizer-body custom-scrollbar">

            <div id="candetails">

            </div>

        </div>
    </div>
</div>




<div class="modal fade" id="schedule_modal" tabindex="-1" aria-labelledby="exampleModalCenter" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" id="modal-content">



        </div>
    </div>
</div>

@endsection
@section('script')
<script src="{{ asset('assets/js/rating/jquery.barrating.js')}}"></script>
<script src="{{ asset('assets/js/rating/rating-script.js')}}"></script>


<script>
    function resetForm() {
        document.getElementById("ann").reset();
    }
</script>

<script>
    function feedback(a, b, c) {

        $.ajax({
            type: "GET",
            data: {
                'a': a,
                'b': b,
                'c': c,

            },
            url: "{{ route('get-feedcan-details') }}",
            success: function(data) {

                $('#candetails').html(data);

                $(".customizer-contain").addClass("open");
                $(".customizer-links").addClass("open");

            }
        });
    }

    $("#close-details").on('click', function() {
        $(".customizer-contain").removeClass("open");

    });
</script>

<script>
    $("#btn_submit").click(function() {

        $('#mail_send').append('<div class="loader-wrapper" style="opacity: 0.980147;"><div class="loader"><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-ball"></div></div></div>');
        //alert("The paragraph was clicked.");
    });
</script>

@endsection