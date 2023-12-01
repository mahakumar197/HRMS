@extends('layouts.app')
@section('page_title')
<title>Team Attendance</title>
@endsection
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Team Attendance
                    </h3>
                </div>

            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-sm-6">
                @if (Session::has('message'))
                <div class="alert alert-success dark alert-dismissible fade show" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up">
                        <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3">
                        </path>
                    </svg>
                    {{ Session::get('message') }}
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                </div>
                @endif

                @if (Session::has('error'))
                <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
                    <p> {{ Session::get('error') }}</p>
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                </div>
                @endif
                <div class="card">
                    <div class="card-body">

                        @if ($errors->any())
                        @foreach ($errors->all() as $error)
                        <div class="alert alert-danger dark alert-dismissible fade show" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down">
                                <path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17">
                                </path>
                            </svg>
                            <p> {{ $error }}</p>
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                        </div>
                        @endforeach
                        @endif






                        <div class="form theme-form projectcreate">

                            <form action="{{ url('teamattendance') }}" method="POST" autocomplete="off" >
                                @csrf
                                <div class="row d-flex align-items-center">
                                    <div class="col-sm-8">
                                        <div class="mb-3">
                                            <label for="name">Select Project*</label>

                                            <select class="form-select" name="project" required>
                                                <option value="">Select</option>
                                                @foreach ($primary as $p)
                                                <option value="{{ $p->id }}">{{ $p->project_name }}</option>
                                                @endforeach

                                            </select>

                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="text-center"> <button type="submit" name="filter" id="filter_join" class="btn btn-primary">Search</button></div>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if(!empty($employees))

        <div class="row">

            <!-- Zero Configuration  Starts-->
            <div class="col-sm-12">

                <div class="card card-absolute">
                    <div class="card-header bg-primary">
                        <h5 class="text-white">@if(!empty($current_project_name)) {{'Attendance For Project Team : '}} {{$current_project_name->project_name}}@endif</h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ url('submitteam') }}" method="POST" class="theme-form" autocomplete="off">@csrf
                            @if(count($employees)!=0)
                            <div class="col-sm-12 col-xl-6">
                                <div class="mb-5">
                                    <label for="name">Date*</label>
                                    <input class="datepicker-here form-control digits" readonly value="{{  Carbon\Carbon::now()->format('d-m-Y') }}"   id="attendance_picker" data-language="en" type="text" data-position="bottom right" placeholder="DD-MM-YYYY" name="attend_date">
                                </div>
                            </div>@endif
                            @if(count($employees)==0)

                            <h4>No Employees Assigned for this Project. </h4>

                            @endif

                            <div class="row">

                                <div class="m-t-15 m-checkbox-inline mb-4 custom-control d-flex justify-content-end">
                                <div class="tag h4">Select All</div>
                                    <input type="checkbox" id='checkall' class="regular-checkbox big-checkbox" /><label for="checkall"></label>
                                    <!--<input type="checkbox" id='checkall' class="regular-checkbox" style="transform: scale(1);" />
                                    <label class="form-check-label" for="checkall">Select All</label>-->
                                </div>


                                @foreach ($employees as $e)
                                <div class="col-md-2 mt-3 mb-5">
                                    <div class="teamcol shadow">
                                        <div class="teamcolinner">
                                            <div class="avatarimg"><img src="image/{{ $e->image_path }}" alt="Member"></div>
                                            <div class="member-name">
                                                <h4 align="center">{{ $e->name }} {{ $e->last_name }}</h4>
                                            </div>
                                            <div class="member-info">
                                                <p align="center">{{ $e->designation->designation }}</p>
                                            </div>

                                            <div class="inputGroup">
                                                <input id="option2" name="user[]" value="{{ $e->id }}" type="checkbox" class="largerCheckbox checkbox" style="transform: scale(1);" />

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                                <input type="hidden" name="primary_project[0][name]" value="{{ $current_project_name->project_name }}">
                                <input type="hidden" name="primary_project[0][hours]" value="8">
                                <input type="hidden" name="current_project" value="{{ $current_project_name->project_name }}">
                                
                            </div>

                            @if(count($employees)!=0)
                            <button type="submit" class="btn btn-primary mt-4">submit</button>
                            @endif
                        </form>

                    </div>

                </div>
            </div>
            <!-- Zero Configuration  Ends-->
        </div>
        @endif


    </div>


</div>
<!-- Container-fluid Ends-->
</div>
@endsection
@section('script')
<script type='text/javascript'>
    $(document).ready(function() {
        // Check or Uncheck All checkboxes
        $("#checkall").change(function() {
            var checked = $(this).is(':checked');
            if (checked) {
                $(".checkbox").each(function() {
                    $(this).prop("checked", true);
                });
            } else {
                $(".checkbox").each(function() {
                    $(this).prop("checked", false);
                });
            }
        });

        // Changing state of CheckAll checkbox 
        $(".checkbox").click(function() {

            if ($(".checkbox").length == $(".checkbox:checked").length) {
                $("#checkall").prop("checked", true);
            } else {
                $("#checkall").prop("checked", false);
            }

        });
    });
</script>

@endsection