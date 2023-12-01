@extends('layouts.report')
@section('page_title')
<title>Interviews</title>
@endsection
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Interviews</h3>
                </div>

            </div>
        </div>
    </div>
    <div class="container-fluid return"> </div>
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

                        @if(Session::has('error'))
                        <div class="alert alert alert-danger" role="alert">
                            {{session::get('error')}}
                        </div>
                        @endif
                        <div class="table-responsive">
                            <table class="display basic-1 " id="interviewer_datatable">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Position Name</th>
                                        <th>Job Code</th>
                                        <th>Candidate Name</th>
                                        <th>Interview Round</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Type</th>
                                        <th>Link</th>
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
    $(document).ready(function() {

        var table = $('#interviewer_datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('interviewer-data') }}",
            columnDefs: [{
                className: 'text-center',
                targets: [9],
            }, ],
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    "data": "position_name"
                },
                {
                    "data": "jobdetails.job_code"
                },
                {
                    "data": "candetails.name"
                },
                {
                    "data": "round"
                },
                {
                    "data": "schedule_date",
                    "render": function(data, type) {
                        return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                    }
                },
                {
                    "data": "schedule_time",
                    "render": function(data, type) {
                        return type === 'sort' ? data : moment(data, ["HH:mm"]).format('hh:mm a');
                    }
                },
                {
                    "data": "interview_type"
                },
                {
                    "data": "meeting_link"
                },
                {
                    "data": "action"
                }

            ]
        });


    });
</script>

@endsection