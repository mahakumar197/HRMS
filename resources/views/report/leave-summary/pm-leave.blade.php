@extends('layouts.report')
@section('page_title')
<title>Employees Leave Summary Report</title>
@endsection
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Employees Leave Summary Report

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
                                            <input class="datepicker-here form-control digits" id="leave_from_date" 
                                            value="{{ Carbon\Carbon::now()->firstOfMonth()->format('d-m-Y') }}" 
                                            type="text" required="required" data-position="bottom right" placeholder="DD-MM-YYYY" name="leave_from_date">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="name">To Date*</label>
                                            <input class="datepicker-here form-control digits" id="leave_to_date" 
                                            value="{{ Carbon\Carbon::now()->endOfMonth()->format('d-m-Y') }}" 
                                            type="text" required="required" data-position="bottom right" placeholder="DD-MM-YYYY" name="leave_to_date">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="text-left"> <button type="button" name="filter" id="filter_join" class="btn btn-primary">Search</button></div>
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
                        <table class="display basic-1 " id="leave_all">
                            <thead>
                                <tr>
                                    <th>Employee Code</th>
                                    <th>Employee Name</th>
                                    <th>Designation</th>

                                    <th>Leave From Date</th>
                                    <th>Leave To Date</th>
                                    <th>Leave Type</th>
                                    <th>No of Day(s)</th>
                                    <th>Leave Status</th>

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
    $('#leave_all').dataTable({
        "oLanguage": {
            "sEmptyTable": "Employee Leave Summary Report"
        }
    });
    $(document).ready(function() {

        $('#filter_join').click(function() {

            var leave_from_date = $('#leave_from_date').val();
            var leave_to_date = $('#leave_to_date').val();

            var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; //Declare Regex
            var fromDate = leave_from_date.match(rxDatePattern);
            var toDate = leave_to_date.match(rxDatePattern);



            //let isValidDate = Date.parse(leave_from_date);
            //let isValidToDate = Date.parse(leave_to_date);

            if (leave_from_date == '') {
                alert('From Date field is required');

            } else if (fromDate == null) {
                alert('Invalid From Date');

            } else if (leave_to_date == '') {
                alert('To Date field is required');

            } else if (toDate == null) {
                alert('Invalid To Date');

            } else {
                if (leave_from_date != '' && leave_to_date != '') {

                    if (Date.parse(leave_from_date) > Date.parse(leave_to_date)) {
                        alert('To Date must be greater than From Date.');

                    } else {
                        $('#leave_all').DataTable().destroy();
                        fill_datatable(leave_from_date, leave_to_date);
                    }
                }
            }

        });

        function fill_datatable(leave_from_date, leave_to_date) {

            var dataTable = $('#leave_all').DataTable({

                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('leave-report-pm') }}",
                    data: {
                        leave_from_date: leave_from_date,
                        leave_to_date: leave_to_date
                    },
                },
               
                dom: 'Bfrtip',
                order:[3,'DESC'],
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
                        data: 'startDate',
                        "render": function(data, type) {
                                return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                                }

                    },
                    {
                        data: 'endDate',
                        "render": function(data, type) {
                                return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                                }
                    },
                    {
                        data: 'leave_type'
                    },
                    {
                        data: 'noOfDayDeduct'
                    },
                    {
                        data: 'leaveStatus',
                    },

                ],


            });
        }




    });
</script>
@endsection