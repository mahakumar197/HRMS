@extends('layouts.report')
@section('page_title')
<title>HR Screening</title>
@endsection
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row align-items-center">
                <div class="col-12 col-sm-6">
                    <h3>HR Screening</h3>
                </div>
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('job.index')}}" data-bs-original-title="" title=""> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg> Job Summary</a></li>
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
                                <div class="blog-wrraper" style="background:#faebd7;"><a href="blog-single.html"><img class="img-fluid sm-100-wp p-0" src="{{asset('assets/css/images/ui/hr-screening.webp')}}" alt=""></a></div>
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
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header card-bg-yellow p-2 text-center text-light">
                                    Pipeline
                                </div>
                                <div class="card-body p-2 text-center blog-box">
                                    <h6 class="blog-date">TOTAL</h6>
                                    <h6 class="font-weight-bold blog-date text-yellow" style="cursor: pointer;" data-bs-trigger="hover" data-container="body" @if(!empty($hr_pipeline)) data-bs-toggle="popover" @endif data-bs-placement="bottom" title="" data-offset="-20px -20px" 
                                    data-bs-content="@foreach($hr_pipeline as $hp)                                    
                                    {{$hp}}
                                    @if( !$loop->last)
                                    ,
                                    @endif
                                    @endforeach" data-bs-original-title="Pipeline"><span>{{$pipeline}}</span></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header card-bg-green p-2 text-center text-light">
                                    HR Selected
                                </div>
                                <div class="card-body p-2 text-center blog-box">
                                    <h6 class="blog-date">TOTAL</h6>
                                    <h6 class="font-weight-bold blog-date text-green" style="cursor: pointer;" data-bs-trigger="hover" data-container="body" @if(!empty($hr_selected)) data-bs-toggle="popover" @endif data-bs-placement="bottom" title="" data-offset="-20px -20px" 
                                    data-bs-content="@foreach($hr_selected as $hs)                                    
                                    {{$hs}}
                                    @if( !$loop->last)
                                    ,
                                    @endif
                                    @endforeach" data-bs-original-title="HR Selected"><span>{{count($hr_selected)}}</span></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header card-bg-pink p-2 text-center text-light">
                                    HR Rejected
                                </div>
                                <div class="card-body p-2 text-center blog-box">
                                    <h6 class="blog-date">TOTAL</h6>
                                    <h6 class="font-weight-bold blog-date text-pink" style="cursor: pointer;" data-bs-trigger="hover" data-container="body" @if(!empty($hr_rejected)) data-bs-toggle="popover" @endif data-bs-placement="bottom" title="" data-offset="-20px -20px" 
                                    data-bs-content="@foreach($hr_rejected as $hr)                                    
                                    {{$hr}}
                                    @if( !$loop->last)
                                    ,
                                    @endif
                                    @endforeach" data-bs-original-title="HR Rejected"><span>{{count($hr_rejected)}}</span></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="col-sm-12 col-xl-12 xl-100">
            <div class="card">
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
                    <ul class="nav nav-tabs border-tab nav-info" id="info-tab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="info-home-tab" data-bs-toggle="tab" href="#info-home" role="tab" aria-controls="info-home" aria-selected="true" data-bs-original-title="" title=""><i class="fa fa-chevron-circle-down"></i>Current Candidate</a></li>
                        <li class="nav-item"><a class="nav-link" id="hr-selected-tab" data-bs-toggle="tab" href="#info-profile" role="tab" aria-controls="info-profile" aria-selected="false" data-bs-original-title="" title=""><i class="fa fa-thumbs-o-up"></i>HR Selected Candidate</a></li>
                        <li class="nav-item"><a class="nav-link" id="hr-rejected-tab" data-bs-toggle="tab" href="#info-contact" role="tab" aria-controls="info-contact" aria-selected="false" data-bs-original-title="" title=""><i class="fa fa-thumbs-o-down"></i>HR Rejected Candidate</a></li>
                    </ul>
                    <div class="tab-content" id="info-tabContent">
                        <div class="tab-pane fade show active" id="info-home" role="tabpanel" aria-labelledby="info-home-tab">
                            <div class="table-responsive">
                                <table class="display basic-1 " id="hr_datatable">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Job Code</th>
                                            <th>Candidate Created Date</th>
                                            <th>Name</th>
                                            <th>Phone Number</th>
                                            <th>Email Id</th>
                                            <th>Candidate Location</th>
                                            <th>Referred By</th>
                                            <th>Resume</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="info-profile" role="tabpanel" aria-labelledby="profile-info-tab">
                            <div class="table-responsive">
                                <table class="display basic-1 " id="hr-selected">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Job Code</th>
                                            <th>Candidate Created Date</th>
                                            <th>Name</th>
                                            <th>Phone Number</th>
                                            <th>Email Id</th>
                                            <th>Candidate Location</th>
                                            <th>Referred By</th>
                                            <th>Resume</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="info-contact" role="tabpanel" aria-labelledby="contact-info-tab">
                            <div class="table-responsive">
                                <table class="display basic-1 " id="hr-reject">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Job Code</th>
                                            <th>Candidate Created Date</th>
                                            <th>Name</th>
                                            <th>Phone Number</th>
                                            <th>Email Id</th>
                                            <th>Candidate Location</th>
                                            <th>Referred By</th>
                                            <th>Resume</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    var job_id = "{{$job_id}}";
    $(document).ready(function() {
        var table = $('#hr_datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                'type': 'GET',
                'url': '{{route("list.hr-interview")}}',
                'data': {
                    job_id: job_id,
                },
            },
            order: [
                [2, 'desc']
            ],
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    "data": "job_code"
                },
                {
                    "data": "created_at",
                    "render": function(data, type) {
                        return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                    }
                },
                {
                    "data": "name"
                },
                {
                    "data": "phone_number"
                },
                {
                    "data": "email",
                },
                {
                    "data": "candidate_location",
                },
                {
                    "data": "referred_by",
                },
                {
                    "data": "resume",
                    "render": function(data, type, full, meta) {
                        return "<a href=\"/resume/" + data + "\"  target = '_blank'>View/Download</a>";
                    }
                },
                {
                    "data": "action",
                },

            ]
        });


        $("#hr-selected-tab").click(function(e) {

            var table_not_attened = $('#hr-selected').DataTable();
            table_not_attened.destroy();
            var table = $('#hr-selected').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    'type': 'GET',
                    'url': '{{route("list.hr-selected")}}',
                    'data': {
                        job_id: job_id,
                    },
                },
                order: [
                    [2, 'desc']
                ],
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        "data": "job_code"
                    },
                    {
                        "data": "created_at",
                        "render": function(data, type) {
                            return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                        }
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "phone_number"
                    },
                    {
                        "data": "email",
                    },
                    {
                        "data": "candidate_location",
                    },
                    {
                        "data": "referred_by",
                    },
                    {
                        "data": "resume",
                        "render": function(data, type, full, meta) {
                            return "<a href=\"/resume/" + data + "\"  target = '_blank'>View/Download</a>";
                        }
                    },
                    {
                        "data": "action",
                    },

                ]
            });

        });
        $("#hr-rejected-tab").click(function(e) {

            var table_not_attened = $('#hr-reject').DataTable();
            table_not_attened.destroy();
            var table = $('#hr-reject').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    'type': 'GET',
                    'url': '{{route("list.hr-rejected")}}',
                    'data': {
                        job_id: job_id,
                    },
                },
                order: [
                    [2, 'desc']
                ],
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        "data": "job_code"
                    },
                    {
                        "data": "created_at",
                        "render": function(data, type) {
                            return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                        }
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "phone_number"
                    },
                    {
                        "data": "email",
                    },
                    {
                        "data": "candidate_location",
                    },
                    {
                        "data": "referred_by",
                    },
                    {
                        "data": "resume",
                        "render": function(data, type, full, meta) {
                            return "<a href=\"/resume/" + data + "\"  target = '_blank'>View/Download</a>";
                        }
                    },
                    {
                        "data": "action",
                    },


                ]
            });

        });

    });
</script>
@endsection