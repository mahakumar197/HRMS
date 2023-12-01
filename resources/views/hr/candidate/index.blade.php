@extends('layouts.report')
@section('page_title')
<title>Candidates</title>
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
                                        <th>S.No.</th>
                                        <th>Job Code</th>
                                        <th>Created Date</th>
                                        <th>Name</th>
                                        <th>Phone Number</th>
                                        <th>Email Id</th>
                                        <th>Location</th>
                                        <th>Referred By</th>                                        
                                        <th>Resume</th>
                                        <th>Action</th>
                                        <th>Interview Round Edit</th>
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
            "ajax": "{{ route('api.candidate.index') }}",
            order:[[2,'desc']],
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
                    "data": "referred_by",
                },
                {
                    "data": "resume_upload",
                    "render": function(data, type, full, meta) {
                        return "<a href=\"resume/" + data + "\"  target = '_blank'>View/Download</a>";
                    }
                },
                {
                    "data": "action",
                },
                {
                    "data": "can_int_edit",
                    visible: showAdminColumns
                },

            ]
        });
    });
</script>

@endsection