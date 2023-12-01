@extends('layouts.app')
@section('page_title')
<title>Common Feedback</title>
@endsection

@section('content')
<div id="mail_send"></div>
<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-sm-6">
          @foreach($roundname as $r)
          @if($candidate->jobinterview->$current_round == $r->id )

          <h3>{{$r->round_name}}</h3>

          @endif
          @endforeach
        </div>
        <div class="col-12 col-sm-6">

        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-8">

        @if(Session::has('message'))
        <div class="alert alert alert-success" role="alert">
          {{session::get('message')}}

        </div>
        @endif
        <div class="card">
          <div class="card-body">
            <div class="form theme-form projectcreate">
              <div class="row">
                <h3 class="mb-1 f-22 txt-primary text-capitalize">{{$candidate->candetails->name}}</h3>
                <h6 class="f-14">Job Position : {{$candidate->jobdetails->position->position_name}}</h6>
                <h6 class="f-14 ">Job Code : {{$candidate->jobdetails->job_code}}</h6>
                @foreach($roundname as $r)
                @if($candidate->jobinterview->$current_round == $r->id )

                <h6 class="f-14 m-b-20">Current Round :{{$r->round_name}} </h6>

                @endif
                @endforeach
                
                @if($round_number != 2)
                <div class="col-md-3 mb-3">
                <a herf="#" class="btn btn-primary btn-sm" onClick="feedback({{$candidate->job_interview_id}},{{$candidate->job_id}},{{$round_number}})">Get Feedback</a>
                </div>
                @endif
                
                <form action="{{url ('common-interview-feedback') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                  @csrf

              </div>

                 <!-------- Photo ----------->

                 
                  <div class="col-sm-12">
                    <div class="mb-3 mt-3">
                      <label>Candidate Photo</label>
                      <input class="form-control  {{ $errors->has('can_image') ? ' has-error' : ''}}" type="file" name="can_image">
                      
                      @if ($errors->has('can_image'))
                      <div class="text-danger">{{ $errors->first('can_image') }}</div>
                      @endif
                    </div>
                  </div>
              <div class="row">
                <div class="col-sm-12">
                  <div class="mb-3">
                    <label>Comment*</label>
                    <textarea type="text" name="comments" rows="4" class="form-control"></textarea>
                    @if ($errors->has('comments'))
                    <div class="text-danger">{{ $errors->first('comments') }}</div>
                    @endif
                  </div>
                </div>
              </div>


              <div class="mb-3">
                <label>Status*</label>
                <select class="form-select {{ $errors->has('status') ? ' has-error' : ''}}" name="status">
                  <option value="">--Select--</option>
                  <option value="1">On Hold</option>
                  <option value="2">Selected</option>
                  <option value="3">Rejected</option>


                </select>
                @if ($errors->has('status'))
                <div class="text-danger">{{ $errors->first('status') }}</div>
                @endif
              </div>

              <input class="form-control" type="hidden" value="{{$candidate->candetails->id}}" name="can_id">
              <input class="form-control" type="hidden" value="{{$candidate->jobdetails->id}}" name="job_id">
              <input class="form-control" type="hidden" value="{{$candidate->id}}" name="schedule_update">
              <input class="form-control" type="hidden" value="{{$candidate->round}}" name="current_round">
              <input class="form-control" type="hidden" value="{{$candidate->job_interview_id}}" name="job_interview_id">
              <input class="form-control" type="hidden" value="{{$schedule_id}}" name="schedule_id">


              <div class="row">
                <div class="col">
                  <div class="text-left">

                    <input type="submit" class="btn btn-primary me-3" id="btn_submit" value="Submit Feedback">
                    <a href="{{url('interviewer')}}" class="btn btn-secondary me-3">Cancel</a>

                  </div>
                </div>


                </form>
              </div>
            </div>
          </div>
        </div>
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

$("#btn_submit").click(function(){

  $('#mail_send').append('<div class="loader-wrapper" style="opacity: 0.980147;"><div class="loader"><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-ball"></div></div></div>');
  //alert("The paragraph was clicked.");
});
</script>


@endsection