@extends('layouts.app')
@section('page_title')
<title>Employee Attendance Report</title>
@endsection

@section('content')

<div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-12 col-sm-6">
                  <h3>

                </div>

              </div>
            </div>
          </div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Attendance Monthly Report


                <span class="pull-right"><button  id="btnexport" class="btn btn-primary " style="float: right;">Download Excel</button></span>

                </div>

                <div class="card-body">

                @if(Session::has('message'))
                <div class="alert alert alert-success" role="alert">
                   {{session::get('message')}} </div>
                 @endif
                 <div class="text-center m-3">
                    @foreach($paginationLinks as $link)



                        @if($link['year'] == $selectedYear && $link['month'] == $selectedMonth)
                            <span class="mr-2 font-weight-bold today">
                                {{ $link['fullName'] }}
                            </span>
                        @else
                            <a class="mr-2 font-weight-bold siva" href="{{ route('report.attendancereport.index', ['year' => $link['year'], 'month' => $link['month']]) }}">
                                {{ $link['fullName'] }}
                            </a>
                        @endif
                    @endforeach
                        </div>

                    <div class="table-responsive" style="overflow: scroll;">
                        <table class=" table-sm table-bordered table-striped table-hover datatable" id="tbldemo">
                            <thead>
                                <tr>
                                    <th style="width: 85px">Employee/Days</th>
                                    @for($i = 1; $i <= $daysInMonth; $i++)
                                        <th style="width: 5px">{{ $i }}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                
                                @foreach($students as $student)
                                    <tr>
                                        <td>{{ $student->name }} </td>

                                        @for($i = 1; $i <= $daysInMonth; $i++)
                                           
                                            <td style="width: 5px">

                                                <input
                                                type="hidden"
                                                name="student_{{ $student->id }}[]"
                                                value="{{ $day = now()->setYear($selectedYear)->setMonth($selectedMonth)->setDay($i)->format('Y-m-d') }}"
                                            >
                                                {{ isset($attendances[$student->id][$day]) ? 'OD' : '' }}
                                                {{ isset($getLeave[$student->id][$day]) ?  'leave' : '' }}
                                            </td>
                                             
                                        @endfor
                                    </tr>
                                @endforeach

                                 

                                @foreach($getLeavetype as $leave)
                                        
                                {{$leave->leaveType->name}}            

                                @endforeach
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

<script src="{{ asset('js/jquery.table2excel.js') }}"></script>
<script>
    $(function () {
        $("#btnexport").click(function () {
            $("#tbldemo").table2excel();
        });
    });
</script>
@endsection

