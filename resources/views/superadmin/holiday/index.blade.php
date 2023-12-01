@extends('layouts.report')
@section('page_title')
<title>Holidays</title>
@endsection

@section('content')

<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-sm-6">
          <h3>Holiday Summary</h3>
        </div>

        <div class="col-12 col-sm-6">
          <div class="col-md-12 col-sm-6">
            @if(Auth::user()->role =='super_admin')
            <span class="pull-right"><a href="{{url('holiday/create')}}" class="btn btn-primary " style="float: right;">Add Holiday</a></span>
            @endif
          </div>
          <div class="col-md-5 col-sm-7 pull-right mx-2">
            @if(Auth::user()->role != 'super_admin' && $next_year->isNotEmpty())
            <select class="form-select" name="year" id="selectbox1">
              <option value=''>Select</option>
              @if($next_year->isNotEmpty())
              <option value="{{Carbon\Carbon::now()->addYear(1)->year}} "> {{Carbon\Carbon::now()->addYear(1)->year}}</option>
              @endif
              <option value="{{Carbon\Carbon::now()->year}} "> {{Carbon\Carbon::now()->year}}</option>
            </select>
            @elseif(Auth::user()->role == 'super_admin')
            <select class="form-select  " name="year" id="selectbox1">
              <option value=''>Select</option>
              @if($next_year->isNotEmpty())
              <option value="{{Carbon\Carbon::now()->addYear(1)->year}} "> {{Carbon\Carbon::now()->addYear(1)->year}}</option>
              @endif
              <option value="{{Carbon\Carbon::now()->year}} "> {{Carbon\Carbon::now()->year}}</option>              
              <option value="{{Carbon\Carbon::now()->subYears(1)->year}} "> {{Carbon\Carbon::now()->subYears(1)->year}}</option>              
            </select>
            @endif
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
                      <th>Name</th>
                      <th>Date</th>
                      <th>Type</th>
                      <th>Scope</th>
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

</div>
@endsection


@section('script')


<script>
  var role = '{{Auth::user()->role}}';
  $(document).ready(function() {

    var showAdminColumns = role == "super_admin" ? true : false;

    $('#datatable').DataTable({
      "processing": true,
      "serverSide": true,
      order: [2, 'DESC'],
      "ajax": "{{ route('api.holidays.index') }}",
      "columns": [{
          data: 'DT_RowIndex',
          name: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          "data": "holidayname"
        },
        {
          "data": "holidaydate",
          "render": function(data, type) {
            return type === 'sort' ? data : moment(data).format('DD-MM-Y');
          }
        },
        {
          "data": "holidaytype"
        },
        {
          "data": "holidayscope"
        },
        {
          "data": "holidaystatus"
        },
        {
          "data": "action",
          visible: showAdminColumns

        },

      ]
    });


  });

  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

  $('#selectbox1').change(function() {


    var year = $("#selectbox1").val();

    var showAdminColumns = role == "super_admin" ? true : false;

    var dataTable = $('#datatable').DataTable({
      "bDestroy": true,
      processing: true,
      serverSide: true,

      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },

      ajax: {
        url: "{{ route('api.holidays.index') }}",
        type: "POST",
        data: {
          "_token": "{{ csrf_token() }}",
          year: year,

        },
      },

      columns: [{

          data: 'DT_RowIndex',
          name: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          "data": "holidayname"
        },
        {
          "data": "holidaydate",
          "render": function(data, type) {
            return type === 'sort' ? data : moment(data).format('DD-MM-Y');
          }
        },
        {
          "data": "holidaytype"
        },
        {
          "data": "holidayscope"
        },
        {
          "data": "holidaystatus"
        },
        {
          "data": "action",
          visible: showAdminColumns
        },

      ],


    });





  });
</script>
@endsection