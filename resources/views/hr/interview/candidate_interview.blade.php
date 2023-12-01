@extends('layouts.candidate-interview')
@section('page_title')
<title>Interview</title>
@endsection

@section('content')
<div id="mail_send"></div>

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row align-items-center">
                <div class="col-12 col-sm-6">
                    <h3>Candidate Interview</h3>
                </div>
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('job.index')}}" data-bs-original-title="" title=""> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg> Job Summary</a></li>
                        <li class="breadcrumb-item"><a href="{{url('cancreate/'.$job_id)}}" data-bs-original-title="" title=""> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="8.5" cy="7" r="4"></circle>
                                    <line x1="20" y1="8" x2="20" y2="14"></line>
                                    <line x1="23" y1="11" x2="17" y2="11"></line>
                                </svg> Candidate Create</a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid blog-page">
        <div class="page-title">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="card">
                        <div class="blog-box blog-list row">
                            <div class="col-xl-6 col-12">
                                <div class="blog-wrraper"><a href="blog-single.html"><img class="img-fluid sm-100-wp p-0" src="{{asset('assets/css/images/ui/interview.png')}}" alt=""></a></div>
                            </div>
                            <div class="col-xl-6 col-12">
                                <div class="blog-details">
                                    <div class="blog-date pb-2"><span><a href="{{route('job.index')}}" class="color-purple f-26">{{$job->job_code}}</a></span></div>
                                    <ul class="blog-social mt-2">
                                        <li>
                                            <h6>{{$job->position->position_name}}</h6>
                                        </li>
                                        <li>
                                            <h6>{{$job->project->project_name}}</h6>
                                        </li>
                                    </ul>


                                    <div class="blog-bottom-content">
                                        <ul class="blog-social">
                                            <li>Job Owner: {{$job->user->name}} {{$job->user->last_name}}</li>
                                        </ul>
                                        <hr>
                                        <p>Job Posted On: {{Carbon::parse($job->job_posted_date)->format('d M Y')}}</p>
                                        <ul class="blog-social">
                                            <li>
                                                <p>Headcount : {{$job->headcount}}</p>
                                            </li>
                                            <li>
                                                <p>Remaining Count : {{$remaining_count}}</p>
                                            </li>
                                        </ul>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="row justify-content-end">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header card-bg-pink p-2 text-center text-light">
                                    Recruited
                                </div>
                                <div class="card-body p-2 text-center blog-box">
                                    <h6 class="blog-date">TOTAL</h6>
                                    <h6 class="font-weight-bold blog-date text-pink example-popover" style="cursor: pointer;" data-bs-trigger="hover" data-container="body" @if(! $recruited_list->isEmpty()) data-bs-toggle="popover" @endif data-bs-placement="bottom" title="" data-offset="-20px -20px" 
                                    data-bs-content="@foreach($recruited_list as $rl)
                                    
                                    {{$rl->candetails->name}}
                                    @if( !$loop->last)
                                    ,
                                    @endif
                                    @endforeach" data-bs-original-title="Recruited {{$recruited}}"><span>{{$recruited}}</span></h6>
                                  
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header card-bg-green p-2 text-center text-light">
                                    Shortlisted
                                </div>
                                <div class="card-body p-2 text-center blog-box">
                                    <h6 class="blog-date">TOTAL</h6>
                                    <h6 class="font-weight-bold blog-date text-green example-popover" style="cursor: pointer;" data-bs-trigger="hover" data-container="body" @if(! $selected_candidate->isEmpty()) data-bs-toggle="popover" @endif data-bs-placement="bottom" title="" data-offset="-20px -20px" 
                                    data-bs-content="@foreach($selected_candidate as $sc)                                    
                                    {{$sc->name}}
                                    @if( !$loop->last)
                                    ,
                                    @endif
                                    @endforeach" data-bs-original-title="Shortlisted {{$selected}}"><span>{{$selected}}</span></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header card-bg-yellow p-2 text-center text-light">
                                    Pipeline
                                </div>
                                <div class="card-body p-2 text-center blog-box">
                                    <h6 class="blog-date">TOTAL</h6>                                  
                                    <h6 class="font-weight-bold blog-date text-yellow example-popover" style="cursor: pointer;" data-bs-trigger="hover" data-container="body" @if(! $pipeline_can->isEmpty()) data-bs-toggle="popover" @endif data-bs-placement="bottom" title="" data-offset="-20px -20px" 
                                    data-bs-content="@foreach($pipeline_can as $pc)                                                                        
                                    {{$pc->name}}
                                    @if( !$loop->last)
                                    ,
                                    @endif
                                    @endforeach" data-bs-original-title="Pipeline {{$pipeline}}"><span>{{$pipeline}}</span></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header card-bg-pink p-2 text-center text-light">
                                    Dropped
                                </div>
                                <div class="card-body p-2 text-center blog-box">
                                    <h6 class="blog-date">TOTAL</h6>
                                    <h6 class="font-weight-bold blog-date text-pink example-popover" style="cursor: pointer;" data-bs-trigger="hover" data-container="body" @if(! $rejected_candidate->isEmpty()) data-bs-toggle="popover" @endif data-bs-placement="bottom" title="" data-offset="-20px -20px" 
                                    data-bs-content="@foreach($rejected_candidate as $rc)                                    
                                    {{$rc->name}}
                                    @if( !$loop->last)
                                    ,
                                    @endif
                                    @endforeach" data-bs-original-title="Rejected {{$rejected_count}}"><span>{{$rejected_count}}</span></h6>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

            </div>

        </div>
    </div>
    <div class="container-fluid pt-5">
        <div class="card-body">
            @if(Session::has('message'))
            <div class="alert alert alert-success" role="alert">
                {{session::get('message')}}
            </div>
            @endif
            @if(Session::has('error'))
            <div class="alert alert alert-danger" role="alert">
                {{session::get('error')}}
            </div>
            @endif
            <div class="table-responsive">
                <table class="basic-1 display1 gfg" id="jobinterview_datatable" style="border-collapse: separate!important;">
                    <thead class="bg-primary text-center">
                        <tr>
                            <th>Job Code</th>
                            <th class="bg-primary">Name</th>
                            <th>Created Date</th>
                            <th>Phone Number</th>
                            <th>Email Id</th>
                            <th>Location</th>
                            <th>Referred By</th>
                            <th>Resume</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="col-sm-12 col-xl-12 xl-100">
                <div id="siva"></div>
                <div id="page-data"></div>
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

<!--Schdule Modal -->

<div class="modal fade" id="schedule_modal" tabindex="-1" aria-labelledby="exampleModalCenter" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" id="modal-content">
        </div>
    </div>
</div>

@endsection


@section('script')

<script>
    $("#close-details").on('click', function() {
        $(".customizer-contain").removeClass("open");
    });

    var job = "{{$job_id}}";

    $(document).ready(function() {
        $('#jobinterview_datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                'type': 'GET',
                'url': '{{ route("get-more-candidate") }}',
                'data': {
                    job_id: job
                },
            },
            order: [
                [2, 'desc']
            ],

            "columns": [{
                    "data": "job"
                },

                {
                    "data": "name",
                    "className": "bg-white"

                },
                {
                    "data": "created_at",
                    "render": function(data, type) {
                        return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                    }
                },
                {
                    "data": "phone_number"
                },
                {
                    "data": "email"
                },
                {
                    "data": "candidate_location"
                },
                {
                    "data": "referred_by",
                },
                {
                    "data": "resume"
                },
                {
                    "data": "status"
                },

                {
                    "data": "action"
                },

            ]
        });
    });
</script>

<script>
    function getcandetails(id, job) {
        var id = id;
        $.ajax({
            type: "GET",
            data: {
                'id': id,
                'job': job,

            },
            url: "{{ route('get-can-details') }}",
            success: function(data) {

                $('#candetails').html(data);

                $(".customizer-contain").addClass("open");
                $(".customizer-links").addClass("open");

            }
        });
    }
</script>


@endsection