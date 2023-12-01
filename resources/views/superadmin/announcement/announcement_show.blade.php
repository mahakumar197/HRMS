@extends('layouts.app')
@section('page_title')
<title>Announcement</title>
@endsection

@section('content')

<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-sm-6">
          <h3>Announcement</h3>
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
                  <li>{{ $announcement->created_at->format('M d Y') }}</li>
                  <li><i class="fa fa-clock-o"></i>{{Carbon\Carbon::parse($announcement->created_at)->diffForHumans(Carbon\Carbon::now())}}</li>
                </ul>
                <h4>
                  {{$announcement->title}}
                </h4>
                <div class="single-blog-content-top">
                  <p>{!! $announcement->description !!}</p>
                  <!--<p>{{strip_tags(htmlspecialchars_decode($announcement->description))}}</p>-->
                </div>
              </div>
            </div>
          </div>
        </div>


      </div>
      <div class="col-xl-4 col-md-6 lg-50 box-col-12">
        <div>
          <div class="card">
            <div class="card-header pb-0">
              <div class="media">
                <div class="media-body">
                  <h5>Other Announcements</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="activity-media">
                @foreach ($announce as $announc)
                <div class="media">

                  <div class="media-body">
                    <h6>{{ $announc->title }}</h6>
                    <p>{{ Str::limit(strip_tags(htmlspecialchars_decode($announc->description)),100) }} <a href="/announcement-show/{{$announc->id}}" class='f-16' style="color:#ffc423"><i class="fa fa-angle-double-right"></i></a></p>

                  </div>
                </div>
                @endforeach
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