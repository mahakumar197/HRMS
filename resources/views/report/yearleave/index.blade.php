@extends('layouts.app')
@section('page_title')
<title>Year Leave Detail Report</title>
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
                        Year Leave Detail Report</h3>

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
                                <form action="{{ url('year-leave-report') }}" method="POST" autocomplete="off">
                                    @csrf

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="name">From Date</label>
                                                <input class="datepicker-here form-control digits {{ $errors->has('from_date') ? ' has-error' : '' }}" type="text" 
                                                value="{{ Carbon\Carbon::now()->firstOfYear()->format('d-m-Y') }}" 
                                                data-position="bottom right" placeholder="DD-MM-YYYY" name="from_date" required>

                                                @if ($errors->has('from_date'))
                                                <div class="text-danger">{{ $errors->first('from_date') }}
                                                </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="mb-3">
                                                <label for="name">To Date</label>
                                                <input class="datepicker-here form-control digits {{ $errors->has('to_date') ? ' has-error' : '' }}" type="text"
                                                value="{{ Carbon\Carbon::now()->endOfYear()->format('d-m-Y') }}" 
                                                data-position="bottom right" placeholder="DD-MM-YYYY" name="to_date" required>


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


                                @foreach ($exit_employee as $el => $ee)
                                <tr>

                                    <td> {{ $ee['name'] }}</td>
                                    <td> {{ $ee['code'] }}</td>



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

                        <h2>YEAR LEAVE DETAIL REPORT</h2>

                        <span class="pull-right"><button id="export" class="btn btn-primary  exportToExcel" style="float: right;">Download Excel</button>

                    </div>

                    <div class="card-body">
                        <div class="table-responsive" style="overflow:auto">

                            <table class=" table-sm table-bordered table-striped table-hover datatable table2excel table2excel_with_colors" id="leave-details" data-cols-width="9,15,40,20">

                                <!-- <table class="table2excel table2excel_with_colors" data-tablename="Test Table 3" id="leave=details">-->
                                <col style="text-align: left;">
                                <thead>

                                    <tr>
                                        <td class="header" colspan="30" data-f-sz="25" data-f-color="000000" data-a-h="center" data-a-v="middle" data-f-bold="true">
                                            <h1> LEAVE DETAILS - <span id="from_month">{{ Str::upper(Carbon\Carbon::parse($from)->format(' F Y ')) }}
                                                </span> -<span id="to_month">{{ Str::upper(Carbon\Carbon::parse($to)->format(' F Y ')) }}</span>
                                            </h1>
                                        </td>
                                    </tr>





                                    <tr>
                                        <th></th>
                                        <th></th>


                                    </tr>

                                </thead>
                                <tbody>



                                    <tr>
                                        <th rowspan="2" scope="col" data-f-bold="true" data-fill-color="00ccff" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-v="middle">
                                            S.NO.
                                        </th>
                                        <th rowspan="2" scope="col" data-fill-color="00ccff" data-f-bold="true" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-v="middle">
                                            <h5> {{ 'EMP.ID' }}</h5>
                                        </th>
                                        <th rowspan="2" scope="col" data-f-bold="true" data-fill-color="00ccff" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-v="middle">
                                            <h5> {{ 'LIST OF EMPLOYEES AT  SWORD INDIA.' }}</h5>
                                        </th>

                                        <th rowspan="2" scope="col" data-f-bold="true" data-fill-color="00ccff" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-v="middle">
                                            <h5> {{ 'DOJ' }}</h5>
                                        </th>

                                        @foreach ($data['cl'] as $employee => $empid)
                                        @if (!empty($empid))
                                        @foreach ($empid as $month => $monthinfo)
                                        <th colspan="4" scope="col" id="month" data-f-bold="true" data-a-wrap="true" data-fill-color="e36c09" data-a-h="center" data-b-a-s="double" data-b-a-c="000000">
                                            {{ date('F', mktime(0, 0, 0, $month, 10)) }}{{ ' - ' . $year }}


                                        </th>
                                        @endforeach
                                        @break
                                        @endif
                                        @endforeach

                                        <th colspan="4" scope="col" data-f-bold="true" data-a-v="middle" data-fill-color="e36c09" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true">
                                            <h5>TOTAL LEAVE AVAILED {{ $year }}</h5>
                                        </th>

                                    </tr>



                                    @foreach ($data['cl'] as $employee => $empid)
                                    <!-- first -->

                                    @php
                                    $cl = 0;
                                    $sl = 0;
                                    $pl = 0;
                                    $lop = 0;

                                    @endphp

                                    @if ($loop->first)
                                    <tr>


                                        @foreach ($empid as $month => $monthinfo)
                                        <th data-fill-color="00ccff" data-b-a-s="thin" data-b-a-c="000000" data-f-bold="true" data-a-h="center" data-a-v="middle">{{ 'CL' }}</th>
                                        <th data-fill-color="00ccff" data-b-a-s="thin" data-b-a-c="000000" data-f-bold="true" data-a-h="center" data-a-v="middle">{{ 'SL' }}</th>
                                         <th data-fill-color="00ccff" data-b-a-s="thin" data-b-a-c="000000" data-f-bold="true" data-a-h="center" data-a-v="middle">{{ 'PL' }}</th>
                                         <th data-fill-color="00ccff" data-b-a-s="thin" data-b-a-c="000000" data-f-bold="true" data-a-h="center" data-a-v="middle">{{ 'LOP' }}</th>
                                        @endforeach

                                        <th data-fill-color="00ccff" data-b-a-s="thin" data-b-a-c="000000" data-f-bold="true" data-a-h="center" data-a-v="middle">{{ 'CL' }}</th>
                                        <th data-fill-color="00ccff" data-b-a-s="thin" data-b-a-c="000000" data-f-bold="true" data-a-h="center" data-a-v="middle">{{ 'SL' }}</th>
                                        <th data-fill-color="00ccff" data-b-a-s="thin" data-b-a-c="000000" data-f-bold="true" data-a-h="center" data-a-v="middle">{{ 'PL' }}</th>
                                        <th data-fill-color="00ccff" data-b-a-s="thin" data-b-a-c="000000" data-f-bold="true" data-a-h="center" data-a-v="middle">{{ 'LOP' }}</th>

                                    </tr>
                                    @endif

                                    <tr>

                                        @foreach ($employee_info as $v_employee)
                                        @if ($employee == $v_employee->id)
                                        @if (Carbon\Carbon::parse($to)->lessThan(Carbon\Carbon::parse($v_employee->exit_date)))
                                        <th class="black">{{ $loop->iteration }}</th>
                                        <th data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true" data-a-v="middle">
                                            {{ $v_employee->employee_code }}
                                        </th>
                                        <th data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-a-v="middle" data-f-bold="true">
                                            {{ $v_employee->name }}&nbsp; {{ $v_employee->last_name }}
                                        </th>
                                        <th data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true" data-a-v="middle">
                                            {{ Carbon\Carbon::parse($v_employee->joining_date)->format('d-m-Y ') }}
                                        </th>

                                        @else
                                        <th data-f-color="FF0000" class="red">
                                            {{ $loop->iteration }}
                                        </th>
                                        <th data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true" data-a-v="middle" data-f-color="FF0000">
                                            {{ $v_employee->employee_code }}
                                        </th>
                                        <th data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true" data-a-v="middle" data-f-color="FF0000">
                                            {{ $v_employee->name }} &nbsp; {{ $v_employee->last_name }}
                                        </th>
                                        <th data-b-a-s="thin" data-b-a-c="000000" data-a-wrap="true" data-f-bold="true" data-a-v="middle" data-f-color="FF0000">
                                            {{ Carbon\Carbon::parse($v_employee->joining_date)->format('d-m-Y ') }}
                                        </th>

                                        @endif
                                        @break
                                        @endif
                                        @endforeach
                                        <!-- Emp Name foreach -->


                                        <!--week display -->

                                        @foreach ($empid as $month => $monthinfo)
                                        @if ($monthinfo['CL'] == 0)
                                        <th data-b-a-s="thin" data-b-a-c="000000"></th>
                                        @else
                                        <th data-b-a-s="thin" data-b-a-c="000000" data-a-h="center" data-a-v="middle">{{ $monthinfo['CL'] }}</th>
                                        @endif

                                        @if ($monthinfo['SL'] == 0)
                                        <th data-b-a-s="thin" data-b-a-c="000000"></th>
                                        @else
                                        <th data-b-a-s="thin" data-b-a-c="000000" data-a-h="center" data-a-v="middle">{{ $monthinfo['SL'] }}</th>
                                        @endif

                                        @if ($monthinfo['PL'] == 0)
                                        <th data-b-a-s="thin" data-b-a-c="000000" data-a-h="center" data-a-v="middle"></th>
                                        @else
                                        <th data-b-a-s="thin" data-b-a-c="000000" data-a-h="center" data-a-v="middle" data-b-l-s="double">
                                            {{ $monthinfo['PL'] }}
                                        </th>
                                        @endif

                                        @if ($monthinfo['LOP'] == 0)
                                        <th data-b-a-s="thin" data-b-a-c="000000" data-a-h="center" data-a-v="middle"></th>
                                        @else
                                        <th data-b-a-s="thin" data-b-a-c="000000" data-a-h="center" data-a-v="middle" data-b-l-s="double">
                                            {{ $monthinfo['LOP'] }}
                                        </th>
                                        @endif


                                        @php
                                        $cl += $monthinfo['CL'];
                                        $sl += $monthinfo['SL'];
                                        $pl += $monthinfo['PL'];
                                        $lop += $monthinfo['LOP'];
                                        @endphp
                                        @endforeach

                                        <td class="extra" data-t="n" data-b-a-s="thin" data-b-a-c="000000" data-fill-color="FFFFCC" data-a-h="center" data-a-v="middle"> {{ $cl }} </td>
                                        <td class="extra" data-t="n" data-b-a-s="thin" data-b-a-c="000000" data-fill-color="FFFFCC" data-a-h="center" data-a-v="middle"> {{ $sl }} </td>
                                        <td class="extra" data-t="n" data-b-a-s="thin" data-b-a-c="000000" data-fill-color="FFFFCC" data-a-h="center" data-a-v="middle"> {{ $pl }} </td>
                                        <td class="extra" data-t="n" data-b-a-s="thin" data-b-a-c="000000" data-fill-color="FFFFCC" data-a-h="center" data-a-v="middle"> {{ $lop }} </td>


                                        @foreach ($relieved_employee as $v_employee_r)
                                        @if ($employee == $v_employee_r->id)
                                        <td data-a-h="center" data-a-v="middle" data-f-color="FF0000" data-a-h="center" data-a-v="middle" data-b-a-s="thin" data-b-a-c="000000" data-f-bold="true">
                                            {{ 'Resigned On ' . Carbon\Carbon::parse($v_employee_r->exit_date)->format('d-m-Y ') }}
                                        </td>
                                        @endif
                                        @endforeach


                                        @foreach ($ml_employee as $v_employee_ml)

                                        @if ($employee == $v_employee_ml->id)


                                        <td data-f-color="FF0000" data-a-h="center" data-a-v="middle" data-b-a-s="thin" data-f-bold="true">
                                            {{ 'Maternity Leave From : '. Carbon\Carbon::parse($v_employee_ml->ml_from_date )->format('d-m-Y ') }}<br />{{ 'To : '. Carbon\Carbon::parse($v_employee_ml->ml_to_date )->format('d-m-Y ') }}
                                        </td>

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
<script src="{{ asset('js/jquery.tableTotal.js') }}"></script>

<script src="{{ asset('js/tableToExcel.js') }}"></script>






<script>
    var project_name = $('#project_name').text();
    var from_month = $('#from_month').text();
    var to_month = $('#to_month').text();







    $("#export").click(function() {

        TableToExcel.convert(document.getElementById("leave-details"), {
            name: "Year Leave Details " + from_month + "-" + to_month + ".xlsx",
            sheet: {
                name: "Sheet 1"
            }
        });


    });
</script>
@endsection