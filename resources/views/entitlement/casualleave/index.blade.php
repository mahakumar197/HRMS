@extends('layouts.report')
@section('page_title')
<title>Casual Leave Entitlement</title>
@endsection
@section('content')


<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-sm-6">
          <h3>Casual Leave Entitlement</h3>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-12">
        @if(Session::has('message'))
        <div class="alert alert-success dark alert-dismissible fade show" role="alert">
          <p> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up">
              <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
            </svg>
            {{session::get('message')}}
          </p>
          <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
        </div>
        @endif
        <div class="card">
          <div class="card-body">
            <div class="table-responsive">
              <table class="display basic-1 " id="datatable">
                <thead>
                  <tr>
                    <th>S.No.</th>
                    <th>Employee Code</th>
                    <th>Name</th>
                    <th>Joining Date</th>
                    <th>Leave Type</th>
                    <th>Entitlement</th>
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
      "ajax": "{{ route('casualleave.index') }}",
      order: [3, 'ASC'],
      columns: [
        {
          data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false 
         }, 
        {
          "data": "user.employee_code"
        },
        {
          "data": "name"
        },
        {
          "data": "user.joining_date",
          "render": function(data, type) {
                                return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                                }
        },
        {

          "data": "leave_type.name"
        },
        {

          "data": "entitlement"
        },
        {
          "data": "action",
        },

      ],

    });

  });
</script>
@endsection