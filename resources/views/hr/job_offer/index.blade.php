@extends('layouts.candidate-interview')
@section('page_title')
<title>Job Offer Process</title>
@endsection

@section('content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row align-items-center">
                <div class="col-12 col-sm-6">
                    <h3>Job Offer Process</h3>
                </div>
                <div class="col-12 col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{route('job.index')}}" data-bs-original-title="" title=""> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg> Job Summary
                            </a>
                        </li>
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
                                <div class="blog-wrraper"><a href="blog-single.html"><img class="img-fluid sm-100-wp p-0" src="{{asset('assets/css/images/ui/job-offer.jpg')}}" alt=""></a></div>
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
                                    Document Verified
                                </div>
                                <div class="card-body p-2 text-center blog-box">
                                    <h6 class="blog-date">TOTAL</h6>
                                    <h6 class="font-weight-bold blog-date text-pink" style="cursor: pointer;" data-bs-trigger="hover" data-container="body" @if(! $doc_verified->isEmpty()) data-bs-toggle="popover" @endif data-bs-placement="bottom" title="" data-offset="-20px -20px" 
                                    data-bs-content="@foreach($doc_verified as $dv)                                    
                                    {{$dv->candetails->name}}
                                    @if( !$loop->last)
                                    ,
                                    @endif
                                    @endforeach" data-bs-original-title="Document Verified"><span>{{count($doc_verified)}}</span></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header card-bg-green p-2 text-center text-light">
                                    Offer letter Relesed
                                </div>
                                <div class="card-body p-2 text-center blog-box">
                                    <h6 class="blog-date">TOTAL</h6>
                                    <h6 class="font-weight-bold blog-date text-green" style="cursor: pointer;" data-bs-trigger="hover" data-container="body" @if(! $offer_relesed->isEmpty()) data-bs-toggle="popover" @endif data-bs-placement="bottom" title="" data-offset="-20px -20px" 
                                    data-bs-content="@foreach($offer_relesed as $or)                                    
                                    {{$or->candetails->name}}
                                    @if( !$loop->last)
                                    ,
                                    @endif
                                    @endforeach" data-bs-original-title="Offer letter Relesed"><span>{{count($offer_relesed)}}</span></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header card-bg-yellow p-2 text-center text-light">
                                    Offer Acknowledged
                                </div>
                                <div class="card-body p-2 text-center blog-box">
                                    <h6 class="blog-date">TOTAL</h6>
                                    <h6 class="font-weight-bold blog-date text-yellow" style="cursor: pointer;" data-bs-trigger="hover" data-container="body" @if(! $offer_ack->isEmpty()) data-bs-toggle="popover" @endif data-bs-placement="bottom" title="" data-offset="-20px -20px" 
                                    data-bs-content="@foreach($offer_ack as $oa)                                    
                                    {{$oa->candetails->name}}
                                    @if( !$loop->last)
                                    ,
                                    @endif
                                    @endforeach" data-bs-original-title="Offer Acknowledged"><span>{{count($offer_ack)}}</span></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header card-bg-purple p-2 text-center text-light">
                                    Appointed
                                </div>
                                <div class="card-body p-2 text-center blog-box">
                                    <h6 class="blog-date">TOTAL</h6>
                                    <h6 class="font-weight-bold blog-date" style="cursor: pointer;" data-bs-trigger="hover" data-container="body" @if(! $aor->isEmpty()) data-bs-toggle="popover" @endif data-bs-placement="bottom" title="" data-offset="-20px -20px" 
                                    data-bs-content="@foreach($aor as $ar)                                    
                                    {{$ar->candetails->name}}
                                    @if( !$loop->last)
                                    ,
                                    @endif
                                    @endforeach" data-bs-original-title="Appointed"><span>{{count($aor)}}</span></h6>
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
                                    <th>S.No.</th>
                                    <th>Position</th>
                                    <th>Job Code</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-12 col-xl-12 xl-100">
                        <div id="siva"></div>
                        <div id="page-data">
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
            <div id="shortlist-candetails">

            </div>

        </div>
    </div>
</div>



@endsection


@section('script')


<script>
    $("#close-details").on('click', function() {
        $(".customizer-contain").removeClass("open");

    });

    var job = "{{$id}}";

    $(document).ready(function() {
        $('#jobinterview_datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                'type': 'GET',
                'url': '{{ route("shortlisted-candidate") }}',
                'data': {
                    job_id: job
                },
            },
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    "data": "jobdetails.position.position_name"
                },
                {
                    "data": "jobdetails.job_code"
                },

                {
                    "data": "candetails.name"
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
            url: "{{ route('can-offer-details') }}",
            success: function(data) {

                $('#shortlist-candetails').html(data);

                $(".customizer-contain").addClass("open");
                $(".customizer-links").addClass("open");

            }
        });

    }
</script>


@endsection