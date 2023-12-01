@extends('layouts.app')
@section('page_title')
<title>Feedback</title>
@endsection

@section('content')

<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-sm-6">
          <h3>Feedback</h3>
        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid starts-->
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-8">

        <div class="blog-box blog-details">

          <div class="card">
            <div class="card-body">
              <div class="blog-details">
                <ul class="blog-social">
                  <li>{{ $feedback->feedback_date}}</li>
                  <li><i class="fa fa-clock-o"></i>{{Carbon\Carbon::parse( $feedback->feedback_date)->diffForHumans(Carbon\Carbon::now())}}</li>
                </ul>
                <h4>
                  {{$feedback->hereismy}}
                </h4>
                <div class="single-blog-content-top">
                  <p>{!! $feedback->description !!}</p>
              
                </div>

                <img src="{{ URL::to('/') }}/feedback-image/{{ $feedback->feedback_image}}" alt="feedback"  width="50%">

              </div>
            </div>
          </div>
        </div>


      </div>
       
    </div>
  </div>
  <!-- Container-fluid Ends-->
</div>




@endsection