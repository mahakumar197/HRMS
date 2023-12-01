@extends('layouts.report')
@section('page_title')
<title>Emp Referral</title>
@endsection
@section('content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Referral Job Summary</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid return"> </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body siva">
                        @if(Session::has('message2'))
                        <div class="alert alert alert-success" role="alert">
                            {{session::get('message2')}}
                        </div>
                        @endif
                        @if(Session::has('error2'))
                        <div class="alert alert alert-danger" role="alert">
                            {{session::get('error2')}}
                        </div>
                        @endif
                        <div class="table-responsive">
                            <table class="display basic-1 " id="datatable">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Position Name</th>
                                        <th>Posted Date</th>
                                        <th>Job Code</th>
                                        <th>Headcount</th>
                                        <th>Remaining Count</th>
                                        <th>Exp. Req.</th>
                                        <th>Job Owner</th>
                                        <th>Importance</th>
                                        <th>Job Status</th>
                                        <th>Add Candidate</th>
                                        <th>Job Profile</th>
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
    $(document).ready(function() {
        var table = $('#datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('api.getJob.empref') }}",

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
                    "data": "remaining_count",
                },
                {
                    "data": "experience_required",
                },
                {
                    "data": "job_owner",
                },
                {
                    "data": "importance",
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
            ]
        });

    });
</script>

@endsection