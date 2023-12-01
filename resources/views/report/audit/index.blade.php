@extends('layouts.app')
@section('page_title')
    <title>Audit Report</title>
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
                           Audit Report</h3>

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
                                    <form action="{{ url('audit-report') }}" method="POST" autocomplete="off">
                                        @csrf

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label for="name">From Date</label>
                                                    <input class="datepicker-here form-control digits {{ $errors->has('from_date') ? ' has-error' : ''}}"
                                                        type="text"
                                                        value="{{ Carbon\Carbon::now()->firstOfYear()->format('d-m-Y') }}" 
                                                        data-position="bottom right"
                                                        placeholder="DD-MM-YYYY"
                                                        name="from_date" required>

                                                    @if ($errors->has('from_date'))
                                                        <div class="text-danger">{{ $errors->first('from_date') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <div class="mb-3">
                                                    <label for="name">To Date</label>
                                                    <input class="datepicker-here form-control digits {{ $errors->has('to_date') ? ' has-error' : ''}}"
                                                        type="text"
                                                        value="{{ Carbon\Carbon::now()->endOfMonth()->format('d-m-Y') }}" 
                                                        data-position="bottom right"
                                                        placeholder="DD-MM-YYYY"
                                                        name="to_date" required>


                                                    @if ($errors->has('to_date'))
                                                        <div class="text-danger">{{ $errors->first('to_date') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>




                                        <div class="row">
                                            <div class="col">
                                                <div class="text-left"> <button type="submit" id="filter_join"
                                                        class="btn btn-primary">Search</button></div>
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


                                  <table
                                        class=" table-sm table-bordered table-striped table-hover datatable table2excel table2excel_with_colors">


                                        <thead>

                                        <tr> <th>
                                            Name </th>
                                          <th> Employee Code  </th></tr>
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
                        </div> </div>


              @endif


                @if (!empty($employee_info))

                    <div class="col-sm-12">
                        <!-- Report Div  Start -->

                        <div class="card">
                            <div class="card-header">

                                <h2>AUDIT REPORT</h2>

                                <span class="pull-right"><button id="export" class="btn btn-primary  exportToExcel"
                                        style="float: right;">Download Excel</button>

                            </div>

                            <div class="card-body">
                                <div class="table-responsive" style="overflow:auto">

                                    <table
                                        class=" table-sm table-bordered table-striped table-hover datatable table2excel table2excel_with_colors"
                                        id="leave-details" data-cols-width="9,15,40,20 ,20,20,20,20,20,20,20,20,20,20" >

                                        <!-- <table class="table2excel table2excel_with_colors" data-tablename="Test Table 3" id="leave=details">-->
                                        <col style="text-align: left;">
                                        <thead>

                                            <tr>
                                            <td class="header" colspan="30" data-f-sz="25" data-f-color="993300" data-fill-color="c4bd97" data-a-h="center" data-a-v="middle" data-f-bold="true">
                                                <h1> AUDIT REPORT - <span id="from_month">{{ Str::upper(Carbon\Carbon::parse($from)->format(' F Y '))}} </span> -<span id="to_month">{{ Str::upper(Carbon\Carbon::parse($to)->format(' F Y '))}}</span> </h1>
                                            </td>
                                        </tr>







                                    </thead>
                                    <tbody>
 

                                        <tr>
                                            <th  data-f-color="FFFFFF" scope="col"  data-f-bold="true"  data-fill-color="548dd4" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-v="middle">
                                                S.NO.
                                            </th>
                                            <th data-f-color="FFFFFF"  scope="col"   data-fill-color="548dd4" data-f-bold="true" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-v="middle">
                                                <h5> {{ 'EMP.ID' }}</h5>
                                            </th>
                                            <th data-f-color="FFFFFF"  scope="col" data-f-bold="true" data-fill-color="548dd4" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-v="middle">
                                                <h5> {{ 'LIST OF EMPLOYEES AT  SWORD INDIA.' }}</h5>
                                            </th>

                                            <th data-f-color="FFFFFF"  scope="col" data-f-bold="true"  data-fill-color="548dd4" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-v="middle">
                                                <h5> {{ 'DOJ' }}</h5>
                                            </th>

                                            <th data-f-color="FFFFFF"  scope="col" data-f-bold="true"  data-fill-color="548dd4" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-v="middle">
                                                <h5> {{ 'PL as on ' }}  {{ Str::upper(Carbon\Carbon::parse($from)->format(' d-m-Y '))}}  </h5>
                                            </th>

                                            <th data-f-color="FFFFFF"  scope="col" data-f-bold="true"  data-fill-color="548dd4" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-v="middle">
                                                <h5> {{ 'Leave Availed ' }}  </h5>
                                            </th>

                                            <th data-f-color="FFFFFF"  scope="col" data-f-bold="true"  data-fill-color="548dd4" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-v="middle">
                                                <h5> {{ 'Balance Leave ' }}  </h5>
                                            </th>


                                            <th data-f-color="FFFFFF"  scope="col" data-f-bold="true"  data-fill-color="548dd4" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-v="middle">
                                                <h5> {{ 'CL as on ' }}  {{ Str::upper(Carbon\Carbon::parse($from)->format(' d-m-Y '))}}  </h5>
                                            </th>

                                            <th data-f-color="FFFFFF"  scope="col" data-f-bold="true"  data-fill-color="548dd4" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-v="middle">
                                                <h5> {{ 'Leave Availed ' }}  </h5>
                                            </th>

                                            <th data-f-color="FFFFFF"  scope="col" data-f-bold="true"  data-fill-color="548dd4" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-v="middle">
                                                <h5> {{ 'Balance Leave ' }}  </h5>
                                            </th>

                                            <th data-f-color="FFFFFF"  scope="col" data-f-bold="true"  data-fill-color="548dd4" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-v="middle">
                                                <h5> {{ 'SL as on ' }}  {{ Str::upper(Carbon\Carbon::parse($from)->format(' d-m-Y '))}}  </h5>
                                            </th>

                                            <th  data-f-color="FFFFFF" scope="col" data-f-bold="true"  data-fill-color="548dd4" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-v="middle">
                                                <h5> {{ 'Leave Availed ' }}  </h5>
                                            </th>

                                            <th data-f-color="FFFFFF"  scope="col" data-f-bold="true"  data-fill-color="548dd4" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-v="middle">
                                                <h5> {{ 'Balance Leave ' }}  </h5>
                                            </th>


                                             <th data-f-color="FFFFFF"  scope="col" data-f-bold="true"  data-fill-color="548dd4" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-v="middle">
                                                <h5> {{ 'Opening Privillage leave ' }}{{ Str::upper(Carbon\Carbon::parse($from)->format('Y '))}}  </h5>
                                            </th>


                                            <th data-f-color="FFFFFF"  scope="col" data-f-bold="true"  data-fill-color="548dd4" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-v="middle">
                                                <h5> {{ 'PL as on ' }}{{ Str::upper(Carbon\Carbon::parse($to)->format('d-m-Y '))}}  </h5>
                                            </th>


                                            


                                            <th data-f-color="FFFFFF"  scope="col" data-f-bold="true"  data-fill-color="548dd4" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-v="middle">
                                                <h5> {{ 'CL as on ' }}{{ Str::upper(Carbon\Carbon::parse($to)->format('d-m-Y '))}}  </h5>
                                            </th>


                                            <th data-f-color="FFFFFF"  scope="col" data-f-bold="true"  data-fill-color="548dd4" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-v="middle">
                                                <h5> {{ 'SL as on ' }}{{ Str::upper(Carbon\Carbon::parse($to)->format('d-m-Y '))}}  </h5>
                                            </th>


                                             <th data-f-color="FFFFFF"  scope="col" data-f-bold="true"  data-fill-color="548dd4" data-a-h="center" data-b-a-s="thin" data-b-a-c="000000" data-a-v="middle">
                                                <h5> {{ 'Total PL/CL/SL as on ' }}{{ Str::upper(Carbon\Carbon::parse($to)->format('d-m-Y '))}}  </h5>
                                            </th>






                                </tr>



                                @foreach ($data['details'] as $employee)


                                    <!-- first -->
                                   <tr>

                                    @if ($employee['relieved'] == 'yes')


                                    <td data-a-h="center" data-a-v="middle" data-f-color="FF0000" data-b-a-s="thin" data-f-bold="true">{{$loop->iteration}}</td>
                                    <td data-a-h="center" data-a-v="middle" data-f-color="FF0000" data-f-bold="true" data-b-a-s="thin"> {{ $employee['code']}}</td>
                                    <td  data-a-h="center" data-a-v="middle" data-f-color="FF0000" data-b-a-s="thin" data-f-bold="true"> {{ $employee['name']}}</td>
                                    <td data-a-h="center" data-a-v="middle" data-f-color="FF0000" data-f-bold="true" data-b-a-s="thin"> {{ Carbon\Carbon::parse($employee['joining_date'])->format('d-m-Y ')}}</td>

                                    <td data-a-h="center" data-a-v="middle" data-f-color="FF0000" data-b-a-s="thin" data-f-bold="true"> {{ $employee['pl_ent']}}</td>
                                    <td data-a-h="center" data-a-v="middle" data-f-color="FF0000" data-b-a-s="thin" data-f-bold="true"> {{ $employee['PL']}}</td>
                                    <td data-a-h="center" data-a-v="middle" data-f-color="FF0000" data-b-r-s="double"data-fill-color="c9daf8" data-b-b-s="thin" data-f-bold="true"> {{ $employee['pl_ent'] - $employee['PL']}}</td>

                                    <td data-a-h="center" data-a-v="middle" data-f-color="FF0000" data-b-a-s="thin" data-f-bold="true"> {{ $employee['cl_ent']}}</td>
                                    <td data-a-h="center" data-a-v="middle" data-f-color="FF0000" data-b-a-s="thin" data-f-bold="true"> {{ $employee['CL']}}</td>
                                    <td data-a-h="center" data-a-v="middle" data-f-color="FF0000" data-b-r-s="double" data-fill-color="c9daf8" data-b-b-s="thin" data-f-bold="true"> {{ $employee['cl_ent'] - $employee['CL']}}</td>


                                    <td data-a-h="center" data-a-v="middle" data-f-color="FF0000" data-b-a-s="thin" data-f-bold="true"> {{ $employee['sl_ent']}}</td>
                                    <td data-a-h="center" data-a-v="middle" data-f-color="FF0000" data-b-a-s="thin" data-f-bold="true"> {{ $employee['SL']}}</td>
                                    <td data-a-h="center" data-a-v="middle" data-f-color="FF0000" data-b-r-s="double" data-fill-color="c9daf8" data-b-b-s="thin" data-f-bold="true"> {{ $employee['sl_ent'] - $employee['SL']}}</td>

                                     <td data-a-h="center" data-a-v="middle" data-f-color="FF0000" data-fill-color="FFFFCC" data-b-a-s="thin" data-f-bold="true"> {{ $employee['pl_ent']}}</td>
                                    <td data-a-h="center" data-a-v="middle" data-f-color="FF0000"  data-fill-color="FFFFCC" data-b-a-s="thin" data-f-bold="true"> 

                                             {{ ($employee['pl_ent'] /12)*(Carbon\Carbon::parse($to)->format('m'))-  $employee['PL']   }}  
                                    </td>


                                
                                    <td data-a-h="center" data-a-v="middle" data-f-color="FF0000" data-fill-color="FFFFCC" data-b-a-s="thin" data-f-bold="true"> 

                                             {{ ($employee['cl_ent'] /12)*(Carbon\Carbon::parse($to)->format('m'))-  $employee['CL']}}

                                    </td>


                                     <td data-a-h="center" data-a-v="middle" data-f-color="FF0000"  data-fill-color="FFFFCC" data-b-a-s="thin" data-f-bold="true"> 

                                             {{ ($employee['sl_ent'] /12)*(Carbon\Carbon::parse($to)->format('m'))-  $employee['SL']}}

                                    </td>



                                    <td data-a-h="center" data-a-v="middle" data-f-color="FF0000" data-fill-color="FFFFCC" data-b-a-s="thin" data-f-bold="true"> 

                                             {{ (($employee['cl_ent'] /12)*(Carbon\Carbon::parse($to)->format('m'))-  $employee['CL'])+(($employee['sl_ent'] /12)*(Carbon\Carbon::parse($to)->format('m'))-  $employee['SL'])+(($employee['pl_ent'] /12)*(Carbon\Carbon::parse($to)->format('m'))-  $employee['PL'])}}

                                    </td>

                                    <td data-a-h="center" data-a-v="middle" data-a-h="center" data-a-v="middle" data-f-color="FF0000" data-a-h="center" data-a-v="middle" data-b-a-s="thin" data-b-a-s="000000" data-f-bold="true">{{ 'Resigned On '. Carbon\Carbon::parse($employee['exit_date'] )->format('d-m-Y ') }}</td>

                                    @else

                                    <td data-a-h="center" data-a-v="middle" data-f-color="000000" data-b-a-s="thin" data-f-bold="true">{{$loop->iteration}}</td>
                                    <td data-a-h="center" data-a-v="middle" data-f-color="000000" data-f-bold="true" data-b-a-s="thin"> {{ $employee['code']}}</td>
                                    <td data-a-h="center" data-a-v="middle" data-f-color="000000" data-b-a-s="thin"> {{ $employee['name']}}</td>
                                    <td data-a-h="center" data-a-v="middle" data-f-color="000000" data-f-bold="true" data-b-a-s="thin"> {{ Carbon\Carbon::parse($employee['joining_date'])->format('d-m-Y ')}}</td>

                                    <td data-a-h="center" data-a-v="middle" data-f-color="aa3300" data-b-a-s="thin" data-f-bold="true"> {{ $employee['pl_ent']}}</td>
                                    <td data-a-h="center" data-a-v="middle" data-f-color="aa3300" data-b-a-s="thin" data-f-bold="true"> {{ $employee['PL']}}</td>
                                    <td data-a-h="center" data-a-v="middle" data-f-color="aa3300" data-b-r-s="double" data-fill-color="c9daf8" data-b-b-s="thin" data-f-bold="true"> {{ $employee['pl_ent'] - $employee['PL']}}</td>

                                    <td data-a-h="center" data-a-v="middle"  data-f-color="008000" data-b-a-s="thin" data-f-bold="true"> {{ $employee['cl_ent']}}</td>
                                    <td data-a-h="center" data-a-v="middle" data-f-color="008000" data-b-a-s="thin" data-f-bold="true"> {{ $employee['CL']}}</td>
                                    <td data-a-h="center" data-a-v="middle" data-f-color="008000" data-b-r-s="double" data-fill-color="c9daf8" data-b-b-s="thin" data-f-bold="true"> {{ $employee['cl_ent'] - $employee['CL']}}</td>


                                    <td data-a-h="center" data-a-v="middle" data-f-color="244061" data-b-a-s="thin" data-f-bold="true"> {{ $employee['sl_ent']}}</td>
                                    <td data-a-h="center" data-a-v="middle" data-f-color="244061" data-b-a-s="thin" data-f-bold="true"> {{ $employee['SL']}}</td>
                                    <td data-a-h="center" data-a-v="middle" data-f-color="244061" data-b-r-s="double" data-fill-color="c9daf8" data-b-b-s="thin" data-f-bold="true"> {{ $employee['sl_ent'] - $employee['SL']}}</td>


                                    <td data-a-h="center" data-a-v="middle" data-f-color="244061" data-fill-color="FFFFCC" data-b-a-s="thin" data-f-bold="true"> {{ $employee['pl_ent']}}</td>
                                    <td data-a-h="center" data-a-v="middle" data-f-color="244061"  data-fill-color="FFFFCC" data-b-a-s="thin" data-f-bold="true"> 

                                             {{ ($employee['pl_ent'] /12)*(Carbon\Carbon::parse($to)->format('m'))-  $employee['PL']   }}  
                                    </td>


                                
                                    <td data-a-h="center" data-a-v="middle" data-f-color="244061" data-fill-color="FFFFCC" data-b-a-s="thin" data-f-bold="true"> 

                                             {{ ($employee['cl_ent'] /12)*(Carbon\Carbon::parse($to)->format('m'))-  $employee['CL']}}

                                    </td>


                                     <td data-a-h="center" data-a-v="middle" data-f-color="244061"  data-fill-color="FFFFCC" data-b-a-s="thin" data-f-bold="true"> 

                                             {{ ($employee['sl_ent'] /12)*(Carbon\Carbon::parse($to)->format('m'))-  $employee['SL']}}

                                    </td>



                                    <td data-a-h="center" data-a-v="middle" data-f-color="244061" data-fill-color="FFFFCC" data-b-a-s="thin" data-f-bold="true"> 

                                             {{ (($employee['cl_ent'] /12)*(Carbon\Carbon::parse($to)->format('m'))-  $employee['CL'])+(($employee['sl_ent'] /12)*(Carbon\Carbon::parse($to)->format('m'))-  $employee['SL'])+(($employee['pl_ent'] /12)*(Carbon\Carbon::parse($to)->format('m'))-  $employee['PL'])}}

                                    </td>

                                    @endif
                                    
                                    @foreach ($ml_employee as $v_employee_ml)
                                  
                                        @if ($employee['id'] == $v_employee_ml->id)
                                     

                                        <td data-f-color="FF0000" data-a-h="center" data-a-v="middle" data-b-a-s="thin" data-f-bold="true">
                                            {{ 'Maternity Leave From : '. Carbon\Carbon::parse($v_employee_ml->ml_from_date )->format('d-m-Y ') }}<br/>{{ 'To : '. Carbon\Carbon::parse($v_employee_ml->ml_to_date )->format('d-m-Y ') }}</td>

                                        @endif

                                        @endforeach

                                        </tr>
                            @endforeach <!-- first -->










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
<script src="{{ asset('js/sumtable.js') }}"></script>

<script src="{{ asset('js/tableToExcel.js') }}"></script>


<script>


    $("#leave-details").sumTable({

  "skipFirstColumn" :true

});

</script>



<script>

var project_name = $('#project_name').text();
        var from_month = $('#from_month').text();
        var to_month = $('#to_month').text();







    $("#export").click(function() {

        TableToExcel.convert(document.getElementById("leave-details"), {
            name: "Audit Report "+from_month+"-"+to_month +".xlsx",
            sheet: {
                name: "Sheet 1"
            }
        });


    });
</script>
@endsection
