@extends('layouts.report')
@section('page_title')
<title>Team Allocation Summary</title>
@endsection
@section('content')

<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-sm-6">
          <h3>Team Allocation Summary</h3>
        </div>
        <div class="col-12 col-sm-6">
          <span class="pull-right"><a href="{{url('teamallocation/create')}}" class="btn btn-primary " style="float: right;">Create Team Allocation</a></span>
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
                    <th>Employee Code</th>
                    <th>Employee Name</th>
                    <th>Designation</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Project</th>
                    <th>Project Manager</th>
                    <th>Billable</th>
                    <th>Primary Project</th>
                    <th>Shadow Eligible</th>
                    <th>Action</th>
                    <th>Joining Date</th>
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
      "autoWidth": false,
      columnDefs: [{
          width: '10%',
          targets: [5, 4]
        },
        {
          "visible": false,
          "targets": 12
        }
      ],
      "ajax": "{{ route('api.teamallocations.index') }}",
      order: [12, "ASC"],
      "columns": [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          "data": "employee_code"
        },
        {
          "data": "employee_name"
        },
        {
          "data": "designation"
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
          "data": "project"
        },
        {
          "data": "project_manager"
        },
        {
          "data": "billable"
        },
        {
          "data": "is_primary_project"
        },
        {
          "data": "shadow_eligible"
        },
        {
          "data": "action",
        },
        {
          "data": "employee_join",
          "render": function(data, type) {
            return type === 'sort' ? data : moment(data).format('DD-MM-Y');
          }
        },

      ]
    });
  });
</script>
@endsection