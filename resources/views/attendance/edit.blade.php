@extends('layouts.app')

@section('page_title')
<title>Edit Attendance</title>
@endsection

@section('content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>{{ __(' Edit Attendance') }}</h3>
                </div>

            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">

                        @if(Session::has('message'))
                        <div class="alert alert-danger dark alert-dismissible fade show" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up">
                                <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                            </svg>
                            <p> {{session::get('message')}}</p>
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                        </div>
                        @endif

                        @if(Session::has('error2'))
                        <div class="alert alert-danger dark alert-dismissible fade show" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down">
                                <path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path>
                            </svg>
                            <p> {{session::get('error2')}}</p>
                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                        </div>
                        @endif

                        <form action="{{url ('attendance/'.$emp_attend->id) }}" method="POST" autocomplete="off">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="name">Employee Code*</label>
                                    <input class="form-control" id="name" type="text" required="required" value="{{$emp->employee_code}}" disabled>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="name">Employee Name*</label>
                                    <input class="form-control" id="name" type="text" required="required" value="{{$emp->name}} {{$emp->last_name}}" disabled>
                                </div>
                            </div>


                            <div class="row">

                                @foreach($emp_attend['primary_project'] as $e)
                                <div class="mb-3 col-md-6">
                                    <label for="name">Primary Project*</label>
                                    <input class="form-control" name="primary_project[0][name]" type="text" value="{{$e['name']}}" required="required" readonly>
                                </div>


                                <div class="mb-3 col-md-6">
                                    <label for="name">Hours*</label>
                                    <select class="form-select  " name="primary_project[0][hours]" value="{{$e['hours']}}">
                                        <option value="0" {{($e['hours']) == '0'  ?'selected':'' }}>0</option>
                                        <option value="1" {{($e['hours']) == '1'  ?'selected':'' }}>1</option>
                                        <option value="2" {{($e['hours']) == '2'  ?'selected':'' }}>2</option>
                                        <option value="3" {{($e['hours']) == '3'  ?'selected':'' }}>3</option>
                                        <option value="4" {{($e['hours']) == '4'  ?'selected':'' }}>4</option>
                                        <option value="5" {{($e['hours']) == '5'  ?'selected':'' }}>5</option>
                                        <option value="6" {{($e['hours']) == '6'  ?'selected':'' }}>6</option>
                                        <option value="7" {{($e['hours']) == '7'  ?'selected':'' }}>7</option>
                                        <option value="8" {{($e['hours']) == '8'  ?'selected':'' }}>8</option>
                                    </select>
                                </div>

                                @endforeach

                                @if($secondary_projects == null)
                                <div class="mb-3 col-md-6">
                                    <label for="name"> </label>
                                    <input class="form-control" hidden name="secondary[{{  1 }}][project]" type="text" value="{{''}}" required="required" readonly>
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="name"> </label>
                                    <select class="form-select " hidden name="secondary[{{  1 }}][hours]">
                                        <option value="0" selected>0</option>

                                    </select>
                                </div>
                                @else

                                <div class=" col-md-6">
                                    @foreach($emp_attend['secondary_project'] as $e)
                                    @if($e['project'] != null)
                                    <label for="name">Secondary Project(s)</label>
                                    @endif
                                    @break

                                    @endforeach
                                </div>

                                <div class=" col-md-6"> </div>

                                @php
                                $i=-1;

                                @endphp

                                @foreach($emp_attend['secondary_project'] as $e)
                                @if($e['project'] != null)
                                @php
                                ++$i;

                                @endphp
                                <div class="mb-3 col-md-6">
                                    <label for="name"> </label>
                                    <input class="form-control" name="secondary[{{  $i }}][project]" type="text" value="{{$e['project']}}" required="required" readonly>
                                </div>


                                <div class="mb-3 col-md-6">
                                    <label for="name"> </label>
                                    <select class="form-select " name="secondary[{{  $i }}][hours]" value="{{$e['hours']}}">
                                        <option value="0" {{($e['hours']) == '0'  ?'selected':'' }}>0</option>
                                        <option value="1" {{($e['hours']) == '1'  ?'selected':'' }}>1</option>
                                        <option value="2" {{($e['hours']) == '2'  ?'selected':'' }}>2</option>
                                        <option value="3" {{($e['hours']) == '3'  ?'selected':'' }}>3</option>
                                        <option value="4" {{($e['hours']) == '4'  ?'selected':'' }}>4</option>
                                        <option value="5" {{($e['hours']) == '5'  ?'selected':'' }}>5</option>
                                        <option value="6" {{($e['hours']) == '6'  ?'selected':'' }}>6</option>
                                        <option value="7" {{($e['hours']) == '7'  ?'selected':'' }}>7</option>
                                        <option value="8" {{($e['hours']) == '8'  ?'selected':'' }}>8</option>
                                    </select>
                                </div>
                                @endif
                                @endforeach
                                @endif

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label for="name">Date*</label>
                                        <input class=" form-control " value="{{Carbon\Carbon::parse($emp_attend->attendance_date)->format('d-m-Y')}}" type="text" required="required" placeholder="DD-MM-YYYY" name="attendance_date" readonly>
                                    </div>

                                    <div class="my-3 col-md-6">

                                        <div class="col" id="radio-group">
                                            <div class="m-t-15 m-checkbox-inline custom-radio-ml">
                                                <div class="form-check form-check-inline radio radio-primary">
                                                    <input class="form-check-input" id="radioinline3" type="radio" name="work_from" value="OD" {{$emp_attend->work_from == 'OD' ?'checked':''}}>
                                                    <label class="form-check-label mb-0" for="radioinline3">Work from home</label>
                                                </div>
                                                <div class="form-check form-check-inline radio radio-primary">
                                                    <input class="form-check-input" id="radioinline1" type="radio" name="work_from" value="P" {{$emp_attend->work_from == 'P' ?'checked':''}}>
                                                    <label class="form-check-label mb-0" for="radioinline1">Working from office</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="text-right"> <button class="btn btn-primary me-3" type="submit"> Update </button>
                                            @if(Auth::user()->role=='super_admin'&& $user_id==Auth::user()->id || Auth::user()->role=='project_manager' && $user_id==Auth::user()->id)
                                            <a href="{{route('myattendance')}}" class="btn btn-secondary me-3">Cancel</a>
                                            @else
                                            <a href="{{route('attendance.index')}}" class="btn btn-secondary me-3">Cancel</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div> <!-- Container-fluid Ends-->
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection