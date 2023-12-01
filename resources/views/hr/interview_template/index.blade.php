@extends('layouts.report')
@section('page_title')
<title>Interview Template</title>
@endsection
@section('content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Interview Template</h3>
                </div>
                <div class="col-12 col-sm-6">
                    <span class="pull-right"><a href="{{url('interview-template/create')}}" class="btn btn-primary " style="float: right;">Add Interview Template</a></span>
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
                                        <th>Position Name</th>
                                        <th>Round 1</th>
                                        <th>Round 2</th>
                                        <th>Round 3</th>
                                        <th>Round 4</th>
                                        <th>Round 5</th>
                                        <th>Round 6</th>
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
            "ajax": "{{ route('api.interview.temp') }}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    "data": "position_name",                 

                },
                {
                    "data": "round_1",
                    "render": function(data, type, row) {
                        return data === null ? '' : data;

                    }

                },
                {
                    "data": "round_2",
                    "render": function(data, type, row) {
                        return data === null ? '' : data;

                    }
                },
                {
                    "data": "round_3",
                    "render": function(data, type, row) {
                        return data === null ? '' : data;

                    }
                },
                {
                    "data": "round_4",
                    "render": function(data, type, row) {
                        return data === null ? '' : data;

                    }
                },
                {
                    "data": "round_5",
                    "render": function(data, type, row) {
                        return data === null ? '' : data;

                    }
                },
                {
                    "data": "round_6",
                    "render": function(data, type, row) {
                        return data === null ? '' : data;

                    },

                },
                {

                    "data": "action"
                },


            ],

        });
    });
</script>

@endsection