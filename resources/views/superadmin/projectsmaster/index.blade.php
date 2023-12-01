@extends('layouts.report')
@section('page_title')
<title>Projects</title>
@endsection
@section('content')

<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-sm-6"><h3>{{'Project Summary'}}</h3></div>
        <div class="col-12 col-sm-6">
        <span class="pull-right"><a href="{{url('projects/create')}}" class="btn btn-primary " style="float: right;">Add Project</a></span>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3>{{ __('Active Projects') }}</h3>           
          </div>

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
                  <th>Project Title</th>
                  <th>Project Manager</th>
                  <th>Location</th>
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




      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3>

              {{ __('InActive Projects') }}

            </h3>


          </div>

          <div class="card-body">

            @if(Session::has('message3'))
            <div class="alert alert alert-success" role="alert">
              {{session::get('message3')}}
            </div>
            @endif

       

            <div class="table-responsive">
            <table class="display basic-1 " id="datatableinactive">
              <thead>
                <tr>
                  <th>S.No.</th>
                  <th>Project Title</th>
                  <th>Project Manager</th>
                  <th>Location</th>
                  <th>Start Date</th>
                  <th>End Date</th>
                  <th>Status</th>
                  <th>Status Action</th>
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
      "ajax": "{{ route('api.activeprojects.index') }}",

      "columns": [
        {
          data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false 
        },
        {
          "data": "project_name"
        },
        {
          "data": "name"
        },
        {
          "data": "location"
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
                                return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                                }
          
        },
        {
          "data": "status",
        },      
        {
          "data": "action",
        },

      ]
    });
  });
</script>

<script>
  $(document).ready(function() {
    $('#datatableinactive').DataTable({
      "processing": true,
      "serverSide": true,
      "ajax": "{{ route('api.inactiveprojects.index') }}",

      "columns": [
        {
          data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false 
        },
        {
          "data": "project_name"
        },
        {
          "data": "name"
        },
        {
          "data": "location"
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
                                return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                                }
        },
        {
          "data": "status",
        },
        {
          "data": "status_action",
        },
        {
          "data": "action",
        },

      ]
    });
  });
</script>
@endsection