@extends('layouts.report')
@section('page_title')
<title>Active Employees List Report</title>
@endsection
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Active Employees List Report</h3>
                </div>

            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row project-cards">
            <div class="col-md-8 project-list">

                @if($errors->any())

                @foreach ($errors->all() as $error)
                <div class="alert alert-danger dark alert-dismissible fade show" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down">
                        <path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path>
                    </svg>
                    <p> {{$error}}</p>
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                </div>
                @endforeach

                @endif


                @if(Session::has('message'))
                <div class="alert alert-success dark alert-dismissible fade show" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up">
                        <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                    </svg>
                    <p> {{session::get('message')}}</p>
                    <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                </div>
                @endif
                <div class="card">
                    <form method="POST" id="search" autocomplete="off">
                        <div class="row align-items-center">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label for="name">Date*</label>
                                    <input class="datepicker-here form-control digits disableFuturedate" readonly value="{{ Carbon\Carbon::now()->format('d-m-Y') }}" 
                                    id="emp_date"  type="text"  required="required" data-position="bottom right" placeholder="DD-MM-YYYY" name="emp_date">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="text-left mt-2"> <button type="button" name="filter" id="filter" class="btn btn-primary" style="float:none;">Search</button></div>
                            </div>
                        </div>
                    </form>

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
                        <table class="display basic-1 " id="test">
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
    $('#test').dataTable({
        "oLanguage": {
            "sEmptyTable": "Employee Active Report"
        }
    });
    $(document).ready(function() {


        $('#filter').click(function() {
            var emp_date = $('#emp_date').val();

            var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; //Declare Regex
            var date = emp_date.match(rxDatePattern);

            if (emp_date == '') {
                alert('Date field is required');

            } else if (date == null) {
                alert('Invalid Date');

            } else {
                if (emp_date != '') {
                $('#test').DataTable().destroy();
                fill_datatable(emp_date);
            }
            }
        

        });




        function fill_datatable(emp_date) {

            var dataTable = $('#test').DataTable({

                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('active-employee.index') }}",
                    data: {
                        emp_date: emp_date
                    },


                },
                order: [3,'ASC'],
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