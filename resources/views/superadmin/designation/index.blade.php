@extends('layouts.report')
@section('page_title')
<title>Designation</title>
@endsection
@section('content')

<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-sm-6">
          <h3> Designation</h3>
        </div>
        <div class="col-12 col-sm-6">
          <span class="pull-right"><a href="{{url('designation/create')}}" class="btn btn-primary " style="float: right;">Add Designation</a></span>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
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
                    <th>Name</th>
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
      "ajax": "{{ route('api.designations.index') }}",

      "columns": [
        {
          data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false 
         }, 
        {
          "data": "designation"
        },

        {
          "data": "action",
        },

      ]
    });
  });
</script>
@endsection