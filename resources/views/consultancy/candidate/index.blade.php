@extends('layouts.consultancy.con-report')
@section('page_title')
<title>Candidates</title>
@endsection
@section('style')

<style>
    .display1 tbody tr {
        box-shadow: 0px 4px 30px rgb(94 94 231 / 7%) !important;
    }

    .display1 tbody tr td {
        vertical-align: middle;
        padding: 25px 10px !important;
        border: none;
        /*border-bottom: 10px solid #f9f9f9;*/
    }

    .gfg {
        border-spacing: 0 15px !important;
        border: none !important;
        font-size: 15px !important;
    }
</style>
@endsection
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Candidates</h3>
                </div>

            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @if(Session::has('message'))
                <div class="alert alert alert-success" role="alert">
                    {{session::get('message')}}
                </div>
                @endif
                <div class="table-responsive">
                    <table class="basic-1 display1 gfg" id="datatable" style="border-collapse: separate!important;">
                        <thead class="bg-primary">
                            <tr>
                                <th>S.No.</th>
                                <th>Job Code</th>
                                <th>Candidate Created Date</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Email Id</th>
                                <th>Candidate Location</th>
                                <th>Resume</th>
                                <th>Action</th>
                                <th>Interview Status</th>
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
<div class="customizer-contain">
    <div class="tab-content" id="c-pills-tabContent">
        <div class="customizer-header"> <i class="icofont-close icon-close" id="close-details"></i>
            <h3 class="f-w-500">Candidate Interview Status</h3>
        </div>
        <div class="customizer-body custom-scrollbar b-t-secondary">
            <div class="candidate-int-status"></div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script>
    $(document).ready(function() {
        var job_id = '{{$id}}';

        $('#datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                url: "{{route('consultancy.get.candidate')}}",
                data: {
                    job_id: job_id
                },
            },
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
                    "data": "candidate_created_date",
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
                    "data": "resume_upload",
                    "render": function(data, type, full, meta) {
                        return "<a href=\"/resume/" + data + "\"  target = '_blank'>View/Download</a>";
                    }
                },
                {
                    "data": "action",
                },

                {
                    "data": "int_status",
                },

            ]
        });
    });
</script>

<script>
    function testfunction(id, job_id) {

        $.ajax({
            type: "GET",
            data: {
                'id': id,
                'job_id': job_id
            },
            url: "{{ route('consultancy.candidate-int-status') }}",
            success: function(data) {
                $('.candidate-int-status').html(data);
                $(".customizer-contain").addClass("open");
                $(".customizer-links").addClass("open");

            }
        });


    }

    $("#close-details").on('click', function() {
        $(".customizer-contain").removeClass("open");

    });
</script>

@endsection