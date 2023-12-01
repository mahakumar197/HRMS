@extends('layouts.app')
@section('page_title')
<title>RR Report</title>
@endsection
@section('style')
<style>
    .al {
        text-align: left !important;
    }
</style>
@endsection
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>
                        Revenue Recognition Report</h3>

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
                                <form action="{{ url('pm-rr-report') }}" method="POST" autocomplete="off">
                                    @csrf

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="name">From Date</label>
                                                <input class="datepicker-here form-control digits {{ $errors->has('from_date') ? ' has-error' : ''}}" 
                                                type="text" data-position="bottom right" id="currentmonth"placeholder="DD-MM-YYYY" name="from_date" required>

                                                @if ($errors->has('from_date'))
                                                <div class="text-danger">{{ $errors->first('from_date') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="name">To Date</label>
                                                <input class="datepicker-here form-control digits {{ $errors->has('to_date') ? ' has-error' : ''}}" type="text" id="currentmonth2" data-position="bottom right" placeholder="DD-MM-YYYY" name="to_date" required>


                                                @if ($errors->has('to_date'))
                                                <div class="text-danger">{{ $errors->first('to_date') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="name">Project</label>
                                                <select class="form-select" name="projectid" required>
                                                    <option value="">Select</option>

                                                    @foreach ($project_list as $t)
                                                    <option value="{{ $t->id }}">{{ $t->project_name }}
                                                    </option>
                                                    @endforeach
                                                </select>

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


            @if (!empty($exit_employee))

            <div class="col-sm-12">
                <!-- Report Div  Start -->

                <div class="card">
                    <div class="card-header">

                        <h2>Employees Relieved </h2>

                        <p>The following employees relieved and team allocation date not closed.</p>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive" style="overflow:auto">


                            <table class=" table-sm table-bordered table-striped table-hover datatable table2excel table2excel_with_colors">


                                <thead>

                                    <tr>
                                        <th>
                                            Name </th>
                                        <th> Employee Code </th>
                                    </tr>
                                </thead>


                                @foreach($exit_employee as $el => $ee)


                                <tr>

                                    <td> {{$ee['name']}}</td>
                                    <td> {{$ee['code']}}</td>



                                </tr>



                                @endforeach




                            </table>


                        </div>

                    </div>
                </div>
            </div>


            @endif


            @if (!empty($employee_info))

            <div class="col-sm-12">
                <!-- Report Div  Start -->

                <div class="card">
                    <div class="card-header">

                        <h2>Timesheet for Revenue Recognition Report</h2>

                        <span class="pull-right"><button id="export" class="btn btn-primary  exportToExcel" style="float: right;">Download Excel</button>

                    </div>

                    <div class="card-body">
                        <div class="table-responsive" style="overflow:auto">

                            <table class=" table-sm table-bordered table-striped table-hover datatable table2excel table2excel_with_colors" id="RR-Report" data-cols-width="20,20,10,10,10,10,10,10,10,10,10,10,10,10,10">

                                <!-- <table class="table2excel table2excel_with_colors" data-tablename="Test Table 3" id="RR-Report">-->
                                <col style="text-align: left;">
                                <thead>

                                    <tr>
                                        <td id="monthdisplay" class="al" data-b-a-s="thin" data-b-a-c="000000"> Month </td>
                                        <td id="month_name" class="al" data-n="d" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000">{{ Carbon\Carbon::parse($from)->format(' F Y ') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="al" data-b-a-s="thin" data-b-a-c="000000">Potential days</td>
                                        <td id="workingdays" class="al" data-a-h="center" data-t="n" data-b-a-s="thin" data-b-a-c="000000"> </td>
                                    </tr>


                                    @foreach ($project_manager as $pm)
                                    <tr>
                                        <td class="al" data-b-a-s="thin" data-b-a-c="000000">Project</td>
                                        <td id="project_name" class="al" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000">{{ $pm->project_name }}</td>
                                    </tr>
                                    <tr>
                                        <td id="workingdays" style="text-align: center" data-b-a-s="thin" data-b-a-c="000000"> Project Manager </td>
                                        <td class="al" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000"> {{ $pm->userteam->name }} {{ $pm->userteam->last_name }} </td>
                                    </tr>
                                    @endforeach



                                    <tr>
                                        <th></th>
                                        <th></th>
                                        @foreach ($data['attendance_info'] as $employee => $empid)
                                        @foreach ($empid as $week => $weekinfo)
                                        @php
                                        $count = count($weekinfo);

                                        @endphp



                                        <th scope="col" class="combat" data-t="n" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000">

                                            {{ $count }}

                                        </th>
                                        @endforeach
                                        @break
                                        @endforeach

                                    </tr>

                                </thead>
                                <tbody>



                                    <tr>
                                        <th scope="col" style="background-color: #FF9900;" data-fill-color="FF9900" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000">
                                            <h5> {{ 'Profile' }}</h5>
                                        </th>
                                        <th scope="col" style="background-color: #FF9900;" data-fill-color="FF9900" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000">
                                            <h5> {{ 'Name' }}</h5>
                                        </th>

                                        @foreach ($data['attendance_info'] as $employee => $empid)
                                        @if (!empty($empid))
                                        @foreach ($empid as $week => $weekinfo)
                                        <th scope="col" id="month" style="background-color: #FF9900;" data-a-wrap="true" data-fill-color="FF9900" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000">

                                            @foreach ($weekinfo as $date => $dateinfo)
                                            <!--date display -->

                                            {{ Carbon\Carbon::parse($date)->startOfWeek()->format(' jS F Y ') }}
                                            @break
                                            @endforeach
                                        </th>
                                        @endforeach
                                        @break

                                        @endif
                                        @endforeach

                                        <th scope="col" style="background-color: #FF9900;" data-fill-color="FF9900" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true">
                                            <h5>Total Billed Days</h5>
                                        </th>
                                        <th scope="col" style="background-color: #FF9900;" data-fill-color="FF9900" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000">
                                            <h5>Day Rate</h5>
                                        </th>

                                        <th scope="col" style="background-color: #FF9900;" data-fill-color="FF9900" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000">
                                            <h5>LOP</h5>
                                        </th>
                                        <th scope="col" style="background-color: #FF9900;" data-fill-color="FF9900" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000">
                                            <h5>CL</h5>
                                        </th>
                                        <th scope="col" style="background-color: #FF9900;" data-fill-color="FF9900" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000">
                                            <h5>PL</h5>
                                        </th>
                                        <th scope="col" style="background-color: #FF9900;" data-fill-color="FF9900" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000">
                                            <h5>SL</h5>
                                        </th>
                                        <th scope="col" style="background-color: #FF9900;" data-fill-color="FF9900" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true">
                                            <h5>Total Potential Days</h5>
                                        </th>
                                        <th scope="col" style="background-color: #FF9900;" data-fill-color="FF9900" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000">
                                            <h5>Cost</h5>
                                        </th>

                                    </tr>



                                    @foreach ($data['attendance_info'] as $employee => $empid)
                                    <!-- first -->
                                    <tr>

 



                                        @foreach ($employee_info as $v_employee)
                                        @if ($employee == $v_employee->user_id)
                                        <th style="background-color: #FFFFCC;" data-fill-color="FFFFCC" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true">
                                            {{ $v_employee->user->designation->designation }}
                                        </th>
                                        <th style="background-color: #FFFFCC;" data-fill-color="FFFFCC" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true">
                                            {{ $v_employee->user->name }}&nbsp; {{ $v_employee->user->last_name }}
                                        </th>
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


                                           


                                        @if (!empty($dateinfo['hours']))
                                        @php

                                        // $present = $present + $dateinfo['day_count'];

                                        $present = $present + $dateinfo['hours'] / 8;



                                        @endphp

                                        @endif
                                        @endforeach
                                        <!--date display -->

                                       
                                       

                                        <td data-t="n" data-b-a-s="thin" data-b-a-c="000000" data-fill-color="FFFFCC" class="siva">

                                        @if (array_key_exists('ML', $dateinfo) && $present <= 0)

                                            {{ 'ML' }}

                                        @else    

                                        {{ $present }}

                                        @endif
                                            
                                        
                                           </td>
                                        @php

                                        $total_billed_day += $present;

                                        @endphp
                                        @endforeach
                                        <!--week display -->

                                        @php

                                        $total_potential_days += $total_billed_day + $cl[$v_employee->user_id] + $pl[$v_employee->user_id] + $sl_count[$v_employee->user_id] ;

                                        @endphp

                                        <td class="extra" style="background-color: #FFFFCC;" data-fill-color="FFFFCC" data-t="n" data-b-a-s="thin" data-b-a-c="000000">
                                            {{ $total_billed_day }}
                                        </td>
                                        <td class="extra" style="background-color: #FFFFCC;" data-fill-color="FFFFCC" data-t="n" data-b-a-s="thin" data-b-a-c="000000">
                                            {{ $unit_rate[$employee] == null ? '0' : $unit_rate[$employee] }}
                                        </td>


                                        <td class="extra" style="background-color: #FFFFCC;" data-fill-color="FFFFCC" data-t="n" data-b-a-s="thin" data-b-a-c="000000"> {{ $lop_count[$v_employee->user_id] }}</td>
                                        <td class="extra" style="background-color: #FFFFCC;" data-fill-color="FFFFCC" data-t="n" data-b-a-s="thin" data-b-a-c="000000">
                                            {{ $cl[$v_employee->user_id] }}
                                        </td>
                                        <td class="extra" style="background-color: #FFFFCC;" data-fill-color="FFFFCC" data-t="n" data-b-a-s="thin" data-b-a-c="000000">
                                            {{ $pl[$v_employee->user_id] }}
                                        </td>
                                        <td class="extra" style="background-color: #FFFFCC;" data-fill-color="FFFFCC" data-t="n" data-b-a-s="thin" data-b-a-c="000000">
                                            {{ $sl_count[$v_employee->user_id] }}
                                        </td>
                                        <td class="extra" style="background-color: #FFFFCC; color:red" data-fill-color="FFFFCC" data-t="n" data-b-a-s="thin" data-b-a-c="000000">
                                            {{ $total_potential_days }}
                                        </td>

                                        @php

                                        $cost = $unit_rate[$employee] * $total_billed_day;

                                        @endphp

                                        <td class="extra" data-t="n" data-b-a-s="thin" data-b-a-c="000000" data-fill-color="FFFFCC"> {{ $cost }} </td>

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
<script src="{{ asset('js/jquery.tableTotal.js') }}"></script>

<script src="{{ asset('js/tableToExcel.js') }}"></script>


<script>
    $('#RR-Report').tableTotal({

        totalRow: true,


        totalCol: false,


    });
</script>

<script>
    var summ = 0;
    $('.combat').each(function() {
        summ += Number($(this).text());
    });;

    document.getElementById("workingdays").innerHTML = summ;
</script>



<script>
    var project_name = $('#project_name').text();
    var month = $('#month_name').text();

    var name = project_name + "test";





    $("#export").click(function() {

        TableToExcel.convert(document.getElementById("RR-Report"), {
            name: project_name + "Monthly Time Sheet" + month + ".xlsx",
            sheet: {
                name: "Sheet 1"
            }
        });


    });
</script>
@endsection