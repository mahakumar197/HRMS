@extends('layouts.report')
@section('page_title')
<title>Consultancy</title>
@endsection
@section('content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Consultancies</h3>
                </div>
                <div class="col-12 col-sm-6">
                    <span class="pull-right"><a href="{{url('agency/create')}}" class="btn btn-primary " style="float: right;">Add Consultancy</a></span>
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
                                        <th>Consultancy Name</th>
                                        <th>Contact Person</th>
                                        <th>Contact Number</th>
                                        <th>Email Id</th>
                                        <th>Alternate Email Id</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
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

@endsection

@section('script')

<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('api.agency.index') }}",
             order: [[10, 'desc']],
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    "data": "consultancy_name"
                },
                {
                    "data": "contact_person"
                },
                {
                    "data": "contact_number",
                },
                {
                    "data": "email",
                },
                {
                    "data": "alternate_email",
                },
                {
                    "data": "start_date",
                    "render": function(data, type) {
                        return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                    }
                },
                {
                    "data": "end_date",
                    "render": function(data, type) {
                        if (data != null) {
                            return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                        }

                    },
                    defaultContent: "-",
                },
                {
                    "data": "status",
                },
                {
                    "data": "action",
                },
                {
                    "data": "created_at",
                    visible:false
                },

            ]
        });
    });
</script>

@endsection