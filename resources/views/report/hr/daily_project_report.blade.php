@extends('layouts.report')
@section('page_title')
<title>Daily Project Report</title>
@endsection
@section('content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Daily Project Report</h3>
                </div>

            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        @if(Session::has('message'))
                        <div class="alert alert alert-success" role="alert">
                            {{session::get('message')}}
                        </div>
                        @endif
                        <div class="table-responsive">
                            <table class="display basic-1 " id="datatable">
                                <thead>
                                    <tr>
                                        <th>Job Code</th>
                                        <th>Client</th>
                                        <th>Position</th>
                                        <th>Headcount</th>
                                        <th>Offered</th>
                                        <th>Joined</th>
                                        <th>Remaining</th>
                                        <th>Interviews Today</th>
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

@endsection

@section('script')

<script>
    var role = '{{Auth::user()->role}}';
    var sub_role = '{{Auth::user()->sub_role}}'
    $(document).ready(function() {
        var showAdminColumns = role == "super_admin" || sub_role == 'hr' ? true : false;
        $('#datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('daily-project-data') }}",
            columnDefs: [{
                targets: 0,
                type: 'natural'
            }, ],
            order: [
                [7, 'desc']
            ],
            dom: 'Bfrtip',
            buttons: [{
                    "extend": 'copy',
                    "text": 'COPY',
                    "titleAttr": 'Copy',
                    "action": newexportaction
                },
                {
                    "extend": 'excel',
                    "text": 'EXCEL',
                    "titleAttr": 'Excel',
                    "action": newexportaction
                },
                {
                    "extend": 'csv',
                    "text": 'CSV',
                    "titleAttr": 'CSV',
                    "action": newexportaction
                },
                {
                    "extend": 'pdf',
                    "text": 'PDF',
                    "titleAttr": 'PDF',
                    "action": newexportaction
                },
            ],
            "columns": [{
                    "data": "job_code",
                },
                {
                    "data": "project",
                },
                {
                    "data": "position",

                },
                {
                    "data": "headcount"
                },
                {
                    "data": "offered",
                },
                {
                    "data": "joined",
                },
                {
                    "data": "remaining"
                },
                {
                    "data": "interview_today",
                },

            ]
        });
    });
</script>

@endsection