@extends('layouts.report')
@section('page_title')
<title>Employee Joining Report</title>
@endsection
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Employee Joining Report
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



                        <div class="form theme-form projectcreate" autocomplete="off">


                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="name">From Date*</label>
                                        <input class="datepicker-here form-control digits" id="emp_from_date" readonly  type="text" 
                                        value="{{ Carbon\Carbon::now()->firstOfMonth()->format('d-m-Y') }}"  required="required" data-position="bottom right" placeholder="DD-MM-YYYY" name="emp_date">
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <div class="mb-3">
                                        <label for="name">To Date*</label>
                                        <input class="datepicker-here form-control digits" id="emp_to_date" readonly type="text"  
                                        value="{{ Carbon\Carbon::now()->endOfMonth()->format('d-m-Y') }}"  required="required" data-position="bottom right" placeholder="DD-MM-YYYY" name="emp_date">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="text-left"> <button type="button" name="filter" id="filter_join" class="btn btn-primary">Search</button></div>
                                </div>
                            </div>

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
                        <table class="display basic-1 " id="emp_join">
                            <thead>
                                <tr>
                                    <th>Employee Code</th>
                                    <th>Employee Name</th>
                                    <th>Designation</th>
                                    <th>Joining Date</th>
                                    <th>Status</th>
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
    $('#emp_join').dataTable({
        "oLanguage": {
            "sEmptyTable": "Employee Joining Report"
        }
    });
    $(document).ready(function() {


        $('#filter_join').click(function() {
            var emp_from_date = $('#emp_from_date').val();
            var emp_to_date = $('#emp_to_date').val();

            var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; //Declare Regex
            var fromDate = emp_from_date.match(rxDatePattern);
            var toDate = emp_to_date.match(rxDatePattern);


            if (emp_from_date == '') {
                alert('From Date field is required');

            } else if (fromDate == null) {
                alert('Invalid From Date');

            } else if (emp_to_date == '') {
                alert('To Date field is required');

            } else if (toDate == null) {
                alert('Invalid To Date');

            } else {
                if (emp_from_date != '' && emp_to_date != '') {
                    if (Date.parse(emp_from_date) > Date.parse(emp_to_date)) {
                        alert('To Date must be greater than From Date.');

                    } else {
                        $('#emp_join').DataTable().destroy();
                        fill_datatable(emp_from_date, emp_to_date);
                    }
                }
            }




        });




        function fill_datatable(emp_from_date, emp_to_date) {

            var dataTable = $('#emp_join').DataTable({

                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('employee-join-report') }}",
                    data: {
                        emp_from_date: emp_from_date,
                        emp_to_date: emp_to_date
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



                columns: [
                    
                    {
                        data: 'employee_code',
                    },
                    {
                        data: 'name',
                    },
                    {
                        data: 'designation.designation',

                    },
                    {
                        data: 'joining_date',
                        "render": function(data, type) {
                                return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                                }
                    },
                    {
                        data: 'employee_status',
                    },

                ],


            });
        }




    });
</script>
@endsection