@extends('layouts.app')

@section('page_title')
<title>Create Team Allocation</title>
@endsection
@section('content')

<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-sm-6">
          <h3>Create Team Allocation</h3>
        </div>
        <div class="col-12 col-sm-6">

        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid starts-->
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">

            @if(Session::has('message'))
            <div class="alert alert alert-success" role="alert">
              {{session::get('message')}}

            </div>
            @endif

            @if(Session::has('error2'))
            <div class="alert alert alert-danger" role="alert">
              {{session::get('error2')}}

            </div>
            @endif
            <div class="form theme-form projectcreate">
              <form action="{{url('teamallocation')}}" method="POST" id='team' autocomplete="off">
                @csrf
                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label class="col-form-label">Employee Name*</label>
                      <select class="js-example-basic-single col-sm-12 {{ $errors->has('userid') ? ' has-error' : ''}}" name="userid" id="employee">
                        <option value="">Select</option>
                        @foreach($employees as $emp)
                        <option value="{{$emp->id}}" {{ (collect(old('userid'))->contains($emp->id)) ? 'selected':'' }}>{{$emp->employee_code}} - {{$emp->name}} {{$emp->last_name}}</option>
                        @endforeach
                      </select>
                      @if ($errors->has('userid'))
                      <div class="text-danger">{{ $errors->first('userid') }}</div>
                      @endif
                    </div>
                    <!--<div class="mb-3">
                      <label>Employee Name*</label>
                      <div class="form-group">
                        <input type="text" name="dummy" value='' id='employee_search' class="typeahead form-control input-lg {{ $errors->has('userid') ? ' has-error' : ''}}" placeholder="Employee Name" />
                        <input type="hidden" name="userid" value='' id='emp_id' class="form-control input-lg" placeholder="Employee Name" />
                        @if ($errors->has('userid'))
                        <div class="text-danger">{{ $errors->first('userid') }}</div>
                        @endif
                      </div>
                    </div>-->
                  </div>
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Designation*</label>
                      <input class=" form-control" type="text" data-language="en" id="designation" disabled>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Full Time / Part Time*</label>
                      <select class="form-select {{ $errors->has('worktype') ? ' has-error' : ''}}" name="worktype">
                        <option value="">Select</option>
                        <option value="FullTime" {{ (collect(old('worktype'))->contains($emp->id)) ? 'selected':'' }}>Full Time</option>
                        <option value="Part Time" {{ (collect(old('worktype'))->contains($emp->id)) ? 'selected':'' }}>Part Time</option>
                      </select>
                      @if ($errors->has('worktype'))
                      <div class="text-danger">{{ $errors->first('worktype') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Project*</label>
                      <select class="js-example-basic-single col-sm-12 {{ $errors->has('projectid') ? ' has-error' : ''}}" name="projectid" id='project'>
                        <option value="">Select</option>
                        @foreach($projects as $pro)
                        <option value="{{$pro->id}}" {{ (collect(old('projectid'))->contains($pro->id)) ? 'selected':'' }}>{{$pro->project_name}}</option>
                        @endforeach
                      </select>
                      @if ($errors->has('projectid'))
                      <div class="text-danger">{{ $errors->first('projectid') }}</div>
                      @endif
                      <!--<div class="form-group">
                        <input type="text" name="dummy" value='' id='project_search' class="typeahead form-control input-lg {{ $errors->has('projectid') ? ' has-error' : ''}}" placeholder="Project Name" />
                        <input type="hidden" name="projectid" value='' id='proj_id' class="form-control input-lg" placeholder="Project Name" />
                        
                      </div>-->
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Project Start Date</label>
                      <input type="text" name="dummy" id='startDate' placeholder="DD-MM-YYYY" disabled class="form-control" />
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Project End Date</label>
                      <input type="text" name="dummy" placeholder="DD-MM-YYYY" id='endDate' disabled class="form-control" />
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Employee Start Date*</label>
                      <input class="datepicker-here form-control digits {{ $errors->has('startdate') ? ' has-error' : ''}}" data-position="bottom right" data-date-format="dd-mm-yyyy" placeholder="DD-MM-YYYY" type="text" data-language="en" name="startdate" value="{{ old ('startdate') }}">
                      @if ($errors->has('startdate'))
                      <div class="text-danger">{{ $errors->first('startdate') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Employee End Date*</label>
                      <input class=" datepicker-here form-control digits {{ $errors->has('enddate') ? ' has-error' : ''}}" data-position="bottom right" data-date-format="dd-mm-yyyy" placeholder="DD-MM-YYYY" type="text" data-language="en" value="{{old('enddate')}}" name="enddate">
                      @if ($errors->has('enddate'))
                      <div class="text-danger">{{ $errors->first('enddate') }}</div>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Billable*</label>
                      <select class="form-select {{ $errors->has('billable') ? ' has-error' : ''}}" name="billable">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                      </select>
                      @if ($errors->has('billable'))
                      <div class="text-danger">{{ $errors->first('billable') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Primary Project*</label>
                      <select class="form-select {{ $errors->has('is_primary_project') ? ' has-error' : ''}}" name="is_primary_project">
                        <option value="">Select</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                      </select>
                      @if ($errors->has('is_primary_project'))
                      <div class="text-danger">{{ $errors->first('is_primary_project') }}</div>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Shadow Eligible*</label>
                      <select class="form-select {{ $errors->has('shadow') ? ' has-error' : ''}}" name="shadow">
                        <option value="">Select</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                      </select>
                      @if ($errors->has('shadow'))
                      <div class="text-danger">{{ $errors->first('shadow') }}</div>
                      @endif
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="mb-3">
                      <label>Unit Rate*</label>
                      <input class=" form-control {{ $errors->has('unit_rate') ? ' has-error' : ''}}" type="number" value="{{old('unit_rate')}}" name="unit_rate">
                      @if ($errors->has('unit_rate'))
                      <div class="text-danger">{{ $errors->first('unit_rate') }}</div>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <div class="text-right"> <button class="btn btn-primary me-3" type="submit"> Add </button> <a onclick="resetForm()" class="btn btn-danger me-3">Reset</a> <a href="{{route('teamallocation.index')}}" class="btn btn-secondary me-3">Cancel</a></div>
                  </div>
                </div>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid Ends-->
</div>

@endsection

@section('script')
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

<!-- Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
  // CSRF Token
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
  $("#employee").change(function() {
    $.ajaxSetup({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
    });
    const empId = $(this).val();
    $.ajax({
      type: "get",
      url: "{{ route('getdesignation') }}",
      data: {
        employeeId: empId,
      },
      success: function(result) {
        $("#designation").empty();
        if (result && result?.status === "success") {
          $("#designation").val(result.data);
        }
      },
      error: function(result) {
        console.log("error", result);
      },
    });
  });

  $("#project").change(function() {
    $.ajaxSetup({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
    });
    const proId = $(this).val();
    $.ajax({
      type: "get",
      url: "{{ route('project.timeline') }}",
      data: {
        projectId: proId,
      },
      success: function(result) {
        $("#startDate").empty();
        $("#endDate").empty();
        // console.log(result.data["startDate"]);
        if (result && result?.status === "success") {
          $("#startDate").val(result.data["startDate"]);
          $("#endDate").val(result.data["endDate"]);
        }
      },
      error: function(result) {
        console.log("error", result);
      },
    });
  });



  /* $(document).ready(function() {

    $("#employee_search").autocomplete({
        source: function(request, response) {

          // Fetch data
          $.ajax({

            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('datafetch')}}",
            type: 'post',
            dataType: "json",
            data: {
              _token: CSRF_TOKEN,
              search: request.term
            },
            success: function(data) {
              response(data);
            }
          });
        },
        select: function(event, ui) {
          // Set selection       
          $('#employee_search').val(ui.item.label2 + '-' + ui.item.label); // display the selected text        
          $("#emp_id").attr("value", ui.item.value);
          $('#designation').val(ui.item.designation);
          // save selected id to input

          return false;
        }
      });

    $("#project_search").autocomplete({
      source: function(request, response) {

        // Fetch data
        $.ajax({

          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: "{{route('projectfetch')}}",
          type: 'post',
          dataType: "json",
          data: {
            _token: CSRF_TOKEN,
            search: request.term
          },
          success: function(data) {
            response(data);
          }
        });
      },
      select: function(event, ui) {
        // Set selection
        $('#project_search').val(ui.item.label); // display the selected text        
        $("#proj_id").attr("value", ui.item.value);
        $('#startDate').val(ui.item.startDate);
        $('#endDate').val(ui.item.endDate);
        // save selected id to input

        return false;
      }
    });

  });*/
</script>
<script>
  function resetForm() {
    document.getElementById("team").reset();
  }
</script>

<script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/select2/select2-custom.js')}}"></script>
@endsection