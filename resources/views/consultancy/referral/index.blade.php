@extends('layouts.consultancy.con-report')
@section('page_title')
<title>Consultancy Referral</title>
@endsection
@section('style')

<style>
    .display1 tbody tr {
        box-shadow: 0px 4px 30px rgb(94 94 231 / 7%) !important;
    }

    .display1 tbody tr td {
        vertical-align: middle;
        padding: 25px 40px !important;
        padding-right: 10px !important;
        border: none;
        /*border-bottom: 10px solid #f9f9f9;*/
    }

    .gfg {
        border-spacing: 0 15px !important;
        border: none !important;
    }
</style>
@endsection
@section('content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Consultancy Job Summary</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid return"> </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @if(Session::has('message2'))
                <div class="alert alert alert-success" role="alert">
                    {{session::get('message2')}}
                </div>
                @endif

                @if(Session::has('error'))
                <div class="alert alert alert-danger" role="alert">
                    {{session::get('error')}}
                </div>
                @endif
                <div class="table-responsive">
                    <table class="basic-1 display1 gfg" id="datatable" style="border-collapse: separate!important;">
                        <thead class="bg-primary text-center">
                            <tr>
                                <th>S.No.</th>
                                <th>Position Name</th>
                                <th>Posted Date</th>
                                <th>Job Code</th>
                                <th>Headcount</th>
                                <th>Exp. Req.</th>
                                <th>Job Owner</th>
                                <th>Job Status</th>
                                <th>Add Candidate</th>
                                <th>View Job Profile</th>
                                <th>Candidate List</th>
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
@endsection
@section('script')
<script>
    $(document).ready(function() {
        var table = $('#datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('consultancy.api.getJob.conref') }}",
            'columnDefs': [{
                "targets": [8, 9], // your case first column
                "className": "text-center",
            }],
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    "data": "position"
                },
                {
                    "data": "job_posted_date",
                    "render": function(data, type) {
                        return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                    }
                },
                {
                    "data": "job_code"
                },
                {
                    "data": "headcount",
                },
                {
                    "data": "experience_required",
                },
                {
                    "data": "job_owner",
                },
                {
                    "data": "job_status",
                },
                {
                    "data": "action",
                },
                {
                    "data": "view",
                },
                {
                    "data": "candidate_list",
                },
            ]
        });

    });
</script>
@endsection