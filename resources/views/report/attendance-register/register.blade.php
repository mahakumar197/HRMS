@extends('layouts.app')
@section('page_title')
<title> Attendance Register</title>
@endsection
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>
                        Attendance Register</h3>
                </div>

            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">

        <div class="row">
            <!-- Zero Configuration  Starts-->



            <div class="row">
                <div class="col-sm-8">
                    <div class="card">
                        <div class="card-body">
                            @if (Session::has('message'))
                            <div class="alert alert alert-danger" role="alert">
                                {{ Session::get('message') }}

                            </div>
                            @endif

                            <div class="form theme-form projectcreate">
                                <form action="{{ url('attendance-register') }}" method="POST" autocomplete="off">
                                    @csrf

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="name">From Date*</label>
                                                <input class="datepicker-here form-control digits {{ $errors->has('from_date') ? ' has-error' : ''}}" type="text" data-position="bottom right" placeholder="DD-MM-YYYY"  name="from_date" value="{{ Carbon\Carbon::now()->firstOfMonth()->format('d-m-Y') }}">

                                                @if ($errors->has('from_date'))
                                                <div class="text-danger">{{ $errors->first('from_date') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="name">To Date*</label>
                                                <input class="datepicker-here form-control digits {{ $errors->has('to_date') ? ' has-error' : ''}}" type="text" data-position="bottom right" placeholder="DD-MM-YYYY" name="to_date" value="{{ Carbon\Carbon::now()->endOfMonth()->format('d-m-Y') }}">


                                                @if ($errors->has('to_date'))
                                                <div class="text-danger">{{ $errors->first('to_date') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>




                                    <div class="row">
                                        <div class="col">
                                            <div class="text-left"> <button type="submit" id="filter_join" class="btn btn-primary">Search</button></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (!empty($employee_info))

            <div class="col-sm-12">
                <!-- Report Div  Start -->

                <div class="card">
                    <div class="card-header">

                        <h2>Attendance Register</h2>


                        <span class="pull-right"><button id="btnexport" class="btn btn-primary " style="float: right;">Download Excel</button></span>

                    </div>

                    <div class="card-body">
                        <div class="table-responsive" style="overflow:auto">



                            <table class=" table-sm table-bordered table-striped table-hover datatable" id="attendance-register" data-cols-width="9,15,32,29">

                                <thead>

                                    <tr>
                                        <td class="header" colspan="30" data-f-sz="25" data-f-color="4e6197" data-a-h="center" data-a-v="middle" data-f-bold="true">
                                            <h1> STAFF ATTENDANCE FOR THE MONTH OF <span id="month_name">{{ Str::upper(Carbon\Carbon::parse($from)->format(' F Y '))}} </span> </h1>
                                        </td>
                                    </tr>




                                </thead>
                                <tbody>



                                    <tr>
                                        <th scope="col" data-f-bold="true" data-a-h="center" data-a-v="middle" data-b-a-s="thin">
                                            S.NO.
                                        </th>
                                        <th scope="col" data-f-bold="true" data-a-h="center" data-a-v="middle" data-b-a-s="thin">
                                            {{ 'Employee Code' }}
                                        </th>
                                        <th scope="col" data-f-bold="true" data-a-h="center" data-a-v="middle" data-b-a-s="thin">
                                            {{ 'Employee Name' }}
                                        </th>
                                        <th scope="col" data-f-bold="true" data-a-h="center" data-a-v="middle" data-b-a-s="thin">
                                            {{ 'Working Hours' }}
                                        </th>


                                        @foreach ($data['attendance_info'] as $employee => $empid)
                                        @if (!empty($empid))
                                        @foreach ($empid as $week => $weekinfo)
                                        @foreach ($weekinfo as $date => $dateinfo)
                                        <!--date display -->
                                        @if(Carbon\Carbon::parse($date)->isWeekend())
                                        <th scope="col" id="month" data-f-color="FF0000" data-f-bold="true" data-a-h="center" data-a-v="middle" data-b-a-s="thin">

                                            {{ Carbon\Carbon::parse($date)->format('d') }}

                                        </th>

                                        @else

                                        <th scope="col" id="month" data-f-bold="true" data-a-h="center" data-a-v="middle" data-b-a-s="thin">

                                            {{ Carbon\Carbon::parse($date)->format('d') }}

                                        </th>

                                        @endif

                                        @endforeach
                                        @endforeach
                                        @break
                                        @endif
                                        @endforeach



                                    </tr>



                                    @foreach ($data['attendance_info'] as $employee => $empid)
                                    <!-- first -->
                                    <tr>

                                        @foreach ($employee_info as $v_employee)
                                        @if ($employee == $v_employee->id)

                                        <th data-num-fmt="0" data-a-h="center" data-a-v="middle" data-b-a-s="thin">{{$loop->iteration}}</th>

                                        @if($from->format('m-Y') === Carbon\Carbon::parse($v_employee->exit_date)->format('m-Y'))


                                        <th data-f-bold="true" data-a-h="center" data-a-v="middle" data-f-color="FF0000" data-b-a-s="thin">{{ $v_employee->employee_code }}</th>
                                        <th data-f-bold="true" data-a-h="center" data-a-v="middle" data-f-color="FF0000" data-b-a-s="thin">{{ $v_employee->name }} {{ $v_employee->middle_name }} {{ $v_employee->last_name }}</th>


                                        @else


                                        <th data-f-bold="true" data-a-h="center" data-a-v="middle" data-b-a-s="thin">{{ $v_employee->employee_code }}</th>
                                        <th data-f-bold="true" data-a-h="center" data-a-v="middle" data-b-a-s="thin">{{ $v_employee->name }} {{ $v_employee->middle_name }} {{ $v_employee->last_name }}</th>
                                        @endif









                                        @if ($loop->first)

                                        <th data-f-color="993300" data-a-h="center" data-a-v="middle" data-b-a-s="thin">{{ '09.00 A.M TO 05.30 PM'}}</th>
                                        @elseif(($loop->index+1) == 2)

                                        <th data-f-color="993300" data-f-bold="true" data-a-h="center" data-a-v="middle" data-b-a-s="thin">{{ 'LUNCH BREAK :'}}</th>
                                        @elseif(($loop->index+ 1) == 3)
                                        <th data-f-color="993300" data-a-h="center" data-a-v="middle" data-b-a-s="thin">{{ '01.00 TO 01.30 PM'}}</th>
                                        @else

                                        <th data-b-a-s="thin"></th>
                                        @endif

                                        @break
                                        @endif
                                        @endforeach
                                        <!-- Emp Name foreach -->
                                        @php

                                        $total_billed_day = 0;
                                        $total_potential_days = 0;

                                        @endphp

                                        @foreach ($empid as $week => $weekinfo)
                                        <!--week display -->
                                        @php
                                        $present = 0;
                                        $leave = 0;
                                        $holiday = 0;
                                        $cost = 0;

                                        @endphp

                                        @foreach ($weekinfo as $date => $dateinfo)
                                        <!--date display -->


                                        @switch($dateinfo['attendance_status'])
                                        @case('empty')

                                        <td> </td>

                                        @break

                                        @case('HOL')
                                        <td data-a-h="center" data-f-bold="true" data-f-color="FF0000" data-a-v="middle" data-b-a-s="thin">{{ 'HOL' }}</td>
                                        @break

                                        @case('p')
                                        @if($dateinfo['day_count'] >= 1.0)
                                        @if($dateinfo['work_from'] !='' )
                                        <td data-a-h="center" data-a-v="middle" data-b-a-s="thin">{{$dateinfo['work_from']}}</td>
                                        @else
                                        <td data-a-h="center" data-a-v="middle" data-b-a-s="thin">{{'OD'}}</td>
                                        @endif
                                        @else                                        
                                        <td data-a-h="center" data-a-v="middle" data-b-a-s="thin">{{ 'OD' }}</td>
                                        
                                        @endif
                                        @break

                                        @case('WKND')
                                        <td data-f-color="FF0000" data-f-bold="true" data-a-h="center" data-a-v="middle" data-b-a-s="thin">{{ 'WKND' }}</td>
                                        @break
                                        @case('ML')
                                        <td data-f-color="FF0000" data-f-bold="true" data-a-h="center" data-a-v="middle" data-b-a-s="thin">{{ 'ML' }}</td>
                                        @break

                                        @case('CL')


                                        @if($dateinfo['noOfDayDeduct'] >= 1.0)

                                        <td data-f-color="FF0000" data-f-bold="true" data-a-h="center" data-a-v="middle" data-b-a-s="thin">{{ 'CL' }}</td>
                                        @else

                                        <td data-f-color="FF0000" data-f-bold="true" data-a-h="center" data-a-v="middle" data-b-a-s="thin">{{ 'CL/H' }}</td>
                                        @endif
                                        @break

                                        @case('PL')

                                        @if($dateinfo['noOfDayDeduct'] >= 1.0)
                                        <td data-f-color="FF0000" data-f-bold="true" data-a-h="center" data-a-v="middle" data-b-a-s="thin">{{ 'PL' }}</td>

                                        @else

                                        <td data-f-color="FF0000" data-f-bold="true" data-a-h="center" data-a-v="middle" data-b-a-s="thin">{{ 'PL/H' }}</td>

                                        @endif
                                        @break

                                        @case('SL')

                                        @if($dateinfo['noOfDayDeduct'] >= 1.0)
                                        <td data-f-color="FF0000" data-f-bold="true" data-a-h="center" data-a-v="middle" data-b-a-s="thin">{{ 'SL' }}</td>

                                        @else

                                        <td data-f-color="FF0000" data-f-bold="true" data-a-h="center" data-a-v="middle" data-b-a-s="thin">{{ 'SL/H' }}</td>
                                        @endif
                                        @break

                                        @case('LOP')

                                        @if($dateinfo['noOfDayDeduct'] >= 1.0)
                                        <td data-f-color="FF0000" data-f-bold="true" data-a-h="center" data-a-v="middle" data-b-a-s="thin">{{ 'LOP' }}</td>

                                        @else

                                        <td data-f-color="FF0000" data-f-bold="true" data-a-h="center" data-a-v="middle" data-b-a-s="thin">{{ 'LOP/H' }}</td>
                                        @endif
                                        @break

                                        @case('')
                                        <td data-f-bold="true" data-a-h="center" data-a-v="middle" data-b-a-s="thin">{{ 'AD' }}</td>
                                        @break

                                        @default
                                        <td>{{ 'no' }}</td>
                                        @endswitch



                                        @endforeach
                                        <!--date display -->
                                        @endforeach
                                        <!--week display -->


                                        @foreach ($relieved_employee as $v_employee_r)
                                        @if ($employee == $v_employee_r->id)

                                        <td data-f-color="FF0000" data-a-h="center" data-a-v="middle" data-b-a-s="thin" data-f-bold="true">{{ 'RESIGNED ON '. Carbon\Carbon::parse($v_employee_r->exit_date )->format('d-m-Y ') }}</td>

                                        @endif

                                        @endforeach
                                       
                                        @foreach ($ml_employee as $v_employee_ml)
                                        
                                        @if ($employee == $v_employee_ml->id)
                                        
                                        <td data-f-color="FF0000" data-a-h="center" data-a-v="middle" data-b-a-s="thin"  data-f-bold="true">{{ 'Maternity Leave From: '. Carbon\Carbon::parse($v_employee_ml->ml_from_date )->format('d-m-Y ') }} {{ 'To: '. Carbon\Carbon::parse($v_employee_ml->ml_to_date )->format('d-m-Y ') }}</td>

                                        @endif

                                        @endforeach



                                    </tr>
                                    @endforeach
                                    <!-- first -->










                                </tbody>
                            </table>



                        </div>

                    </div>

                </div>
            </div> <!-- Report Div Finished -->

            @endif
        </div>
    </div>








</div>
@endsection



@section('script')

<!--<script src="{{ asset('js/jquery.table2excel.js') }}"></script> -->

<script src="{{ asset('js/tableToExcel.js') }}"></script>

<!--<script>
    $(function () {       
        var month = $('#month_name').text();
        $("#btnexport1").click(function () {
            $("#attendance-register").table2excel({
            filename:  "Attendance Register For" +month,
            });
        });
    });
</script> -->


<script>
    var month = $('#month_name').text();


    $("#btnexport").click(function() {

        TableToExcel.convert(document.getElementById("attendance-register"), {
            name: "Staff Attendance Register For" + month + ".xlsx",
            sheet: {
                name: "Sheet 1"
            }
        });


    });
</script>

@endsection