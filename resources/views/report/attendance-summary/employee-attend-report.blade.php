@extends('layouts.report')
@section('page_title')
<title>Employees Attendance Summary Report</title>
@endsection
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Employees Attendance Summary Report

                    </h3>
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
                        <div class="form theme-form projectcreate">
                            <form action=" " method="POST" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="name">From Date*</label>
                                            <input class="datepicker-here form-control digits" id="attend_from_date" 
                                            type="text" required="required" data-position="bottom right" value="{{ Carbon\Carbon::now()->firstOfMonth()->format('d-m-Y') }}" placeholder="DD-MM-YYYY" name="attend_from_date">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="name">To Date*</label>
                                            <input class="datepicker-here form-control digits" id="attend_to_date" 
                                            type="text" required="required" data-position="bottom right" value="{{ Carbon\Carbon::now()->endOfMonth()->format('d-m-Y') }}" placeholder="DD-MM-YYYY" name="attend_to_date">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="text-left"> <button type="button" name="filter" id="filter_attend" class="btn btn-primary">Search</button></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <!-- Zero Configuration  Starts-->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display basic-1 " id="attend_emp">
                            <thead>
                                <tr>
                                    <th>Employee Code</th>
                                    <th>Employee Name</th>
                                    <th>Designation</th>
                                    <th>Attendance Date</th>
                                    <th>Primary Project</th>
                                    <th>Working Hours</th>
                                    <th>Secondary Project</th>
                                    <th>Working Hours</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Zero Configuration  Ends-->


    </div>
</div>
<!-- Container-fluid Ends-->
</div>
@endsection

@section('script')
<script>
    $('#attend_emp').dataTable({
        "oLanguage": {
            "sEmptyTable": "Employee Attendance Summary Report"
        }
    });
    $(document).ready(function() {


        $('#filter_attend').click(function() {

            var attend_from_date = $('#attend_from_date').val();
            var attend_to_date = $('#attend_to_date').val();

            var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; //Declare Regex
            var fromDate = attend_from_date.match(rxDatePattern);
            var toDate = attend_to_date.match(rxDatePattern);

            if (attend_from_date == '') {
                alert('From Date field is required');

            } else if (fromDate == null) {
                alert('Invalid From Date');

            } else if (attend_to_date == '') {
                alert('To Date field is required');

            } else if (toDate == null) {
                alert('Invalid To Date');

            } else {
                if (attend_from_date != '' && attend_to_date != '') {
                    if (Date.parse(attend_from_date) > Date.parse(attend_to_date)) {
                        alert('To Date must be greater than From Date.');

                    } else {
                        $('#attend_emp').DataTable().destroy();
                        fill_datatable(attend_from_date, attend_to_date);
                    }
                }
            }

        });


        function fill_datatable(attend_from_date, attend_to_date) {

            var dataTable = $('#attend_emp').DataTable({

                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('atten-report-emp') }}",
                    data: {
                        attend_from_date: attend_from_date,
                        attend_to_date: attend_to_date
                    },
                },
                order:[3,'DESC'],
                "bDestroy": true,
                dom: 'Bfrtip',               
                buttons: [{
                        "extend": 'copy',
                        "text": 'COPY',
                        "titleAttr": 'Copy',
                        "action": newexportaction
                    },
                    {
                        "extend": 'excel',
                        "text": 'EXCEL',
                        "titleAttr": 'Excel',
                        "action": newexportaction
                    },
                    {
                        "extend": 'csv',
                        "text": 'CSV',
                        "titleAttr": 'CSV',
                        "action": newexportaction
                    },
                    {
                        "extend": 'pdf',
                        "text": 'PDF',
                        "titleAttr": 'PDF',
                        "action": newexportaction
                    },
                ],


                columns: [{

                        data: 'emp_code',
                    },
                    {
                        data: 'emp_name',
                    },
                    {
                        data: 'designation',
                    },
                    {
                        data: 'attendance_date',
                        "render": function(data, type) {
                                return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                                }
                    },
                    {

                        data: 'primary_project.0',
                    },
                    {

                        data: 'primary_project_hours',orderable: false, searchable: false 
                    },
                    {
                        data: 'secondary_project',orderable: false, searchable: false ,
                        defaultContent: "-",
                    },
                    {
                        data: 'secondary_project_hours',orderable: false, searchable: false ,
                        defaultContent: "-",
                    },



                ],


            });
        }




    });
</script>
@endsection