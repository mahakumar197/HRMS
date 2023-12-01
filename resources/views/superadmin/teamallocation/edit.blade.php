@extends('layouts.app')
@section('page_title')
<title>Edit Team Allocation</title>
@endsection

@section('content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>
                        Edit Team Allocation</h3>
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
                            <form action="{{url('teamallocation/'.$team->id)}}" method="POST" autocomplete="off">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Employee Name*</label>
                                            
                                            <div class="form-group">
                                                <input type="text" value='{{$team->user->employee_code}} - {{$team->user->name}} {{$team->user->last_name}}'  class="typeahead form-control input-lg" placeholder="Employee Name" required  readonly/>
                                                <input type="hidden" value='{{$team->user_id}}' name="userid" id='proj_id' class="form-control input-lg" placeholder="Project Name" />
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Designation*</label>
                                            <input class=" form-control" type="text" value="{{$team->user->designation->designation}}" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Full Time / Part Time*</label>
                                            <select class="form-select {{ $errors->has('worktype') ? ' has-error' : ''}}" name="worktype">
                                                <option value="">Select</option>
                                                <option value="FullTime" {{$team->work_type == 'FullTime' ? 'selected':'' }}>Full Time</option>
                                                <option value="Part Time" {{$team->work_type == 'Part Time' ? 'selected':'' }}>Part Time</option>
                                            </select>
                                            @if ($errors->has('worktype'))
                                            <div class="text-danger">{{ $errors->first('worktype') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Project*</label>
                                            <div class="form-group">
                                                <input type="text" value='{{$team->project->project_name}}' id='project_search' class="typeahead form-control input-lg" placeholder="Project Name" disabled/>
                                                <input type="hidden" value=' {{$team->project->id}}' name="projectid" id='proj_id' class="form-control input-lg" placeholder="Project Name" />
                                                @if ($errors->has('projectid'))
                                                <div class="text-danger">{{ $errors->first('projectid') }}</div>
                                                @endif
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Project Start Date</label>
                                            <input type="text" name="dummy" value="{{Carbon\Carbon::parse($team->project->start_date)->format('d-m-Y')}}" id='startDate' disabled class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Project End Date</label>
                                            <input type="text" name="dummy" value="{{Carbon\Carbon::parse($team->project->end_date)->format('d-m-Y')}}" id='endDate' disabled class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Employee Start Date*</label>
                                            <input class="datepicker-here form-control digits {{ $errors->has('startdate') ? ' has-error' : ''}}" data-position="bottom right" placeholder="DD-MM-YYYY" type="text" name="startdate"value="{{Carbon\Carbon::parse($team->start_date)->format('d-m-Y')}}">
                                            @if ($errors->has('startdate'))
                                            <div class="text-danger">{{ $errors->first('startdate') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Employee End Date*</label>
                                            <input class="datepicker-here form-control digits  {{ $errors->has('enddate') ? ' has-error' : ''}} "  data-position="bottom right" placeholder="DD-MM-YYYY"  type="text" value="{{Carbon\Carbon::parse($team->end_date)->format('d-m-Y')}}" name="enddate">
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
                                            <select class="form-select" name="billable">
                                                <option value="">Select</option>
                                                <option value="Yes" {{$team->billable == 'Yes' ? 'selected':'' }}>Yes</option>
                                                <option value="No" {{$team->billable == 'No' ? 'selected':'' }}>No</option>
                                            </select>
                                            @if ($errors->has('billable'))
                                            <div class="text-danger">{{ $errors->first('billable') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Primary Project*</label>
                                            <select class="form-select" name="is_primary_project">
                                                <option value="">Select</option>
                                                <option value="yes" {{$team->is_primary_project == 'yes' ? 'selected':'' }}>Yes</option>
                                                <option value="no" {{$team->is_primary_project == 'no' ? 'selected':'' }}>No</option>
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
                                            <select class="form-select" name="shadow">
                                                <option value="">Select</option>
                                                <option value="yes" {{$team->shadow_eligible == 'yes' ? 'selected':'' }}>Yes</option>
                                                <option value="no" {{$team->shadow_eligible == 'no' ? 'selected':'' }}>No</option>
                                            </select>
                                            @if ($errors->has('shadow'))
                                            <div class="text-danger">{{ $errors->first('shadow') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Unit Rate*</label>
                                            <input class=" form-control" type="number" value="{{$team->unit_rate}}" name="unit_rate">
                                            @if ($errors->has('unit_rate'))
                                            <div class="text-danger">{{ $errors->first('unit_rate') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="text-right"> <button class="btn btn-primary me-3" type="submit"> Update </button> <a href="{{route('teamallocation.index')}}" class="btn btn-secondary me-3">Cancel</a></div>
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
    $(document).ready(function() {


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
                $('#employee_search').val(ui.item.label + ' ' + ui.item.label2); // display the selected text        
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

    });
</script>
@endsection