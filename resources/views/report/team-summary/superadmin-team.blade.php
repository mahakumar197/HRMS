@extends('layouts.report')
@section('page_title')
<title>Employees Team Allocation Report</title>
@endsection
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Employees Team Allocation Report

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
                                            <input class="datepicker-here form-control digits" id="team_from_date"  
                                            value="{{ Carbon\Carbon::now()->firstOfMonth()->format('d-m-Y') }}" 
                                            type="text"  required="required" data-position="bottom right" placeholder="DD-MM-YYYY" name="attend_from_date">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="name">To Date*</label>
                                            <input class="datepicker-here form-control digits" id="team_to_date"  
                                            value="{{ Carbon\Carbon::now()->endOfMonth()->format('d-m-Y') }}" 
                                            type="text"  required="required" data-position="bottom right" placeholder="DD-MM-YYYY" name="attend_from_date">
                                        </div>
                                    </div>


                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="text-left"> <button type="button" name="filter" id="filter_team" class="btn btn-primary">Search</button></div>
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
                        <table class="display basic-1 " id="team_allocate">
                            <thead>
                                <tr>                                    
                                    <th>Employee Code</th>
                                    <th>Employee Name</th>
                                    <th>Designation</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Project</th>
                                    <th>Billable</th>
                                    <th>Primary Project</th>
                                    <th>Shadow Eligible</th>                                    
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
    $('#team_allocate').dataTable({
        "oLanguage": {
            "sEmptyTable": "Team Allocation Report"
        }
    });
    $(document).ready(function() {


        $('#filter_team').click(function() {

            var team_from_date = $('#team_from_date').val();
            var team_to_date = $('#team_to_date').val();

            var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; //Declare Regex
            var fromDate = team_from_date.match(rxDatePattern);
            var toDate = team_to_date.match(rxDatePattern);



            //let isValidDate = Date.parse(team_from_date);
            //let isValidToDate = Date.parse(team_to_date);

            if (team_from_date == '') {
                alert('From Date field is required');

            } else if (fromDate == null) {
                alert('Invalid From Date');

            } else if (team_to_date == '') {
                alert('To Date field is required');

            } else if (toDate == null) {
                alert('Invalid To Date');

            } else {
                if (team_from_date != '' && team_to_date != '') {
                    if (Date.parse(team_from_date) > Date.parse(team_to_date)) {
                        alert('To Date must be greater than From Date.');

                    } else {
                        $('#team_allocate').DataTable().destroy();
                        fill_datatable(team_from_date, team_to_date);
                    }
                }
            }
           

        });




        function fill_datatable(team_from_date, team_to_date) {

            var dataTable = $('#team_allocate').DataTable({

                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('team-report-all') }}",
                    data: {
                        team_from_date: team_from_date,
                        team_to_date: team_to_date
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
                        data: "user.employee_code"
                    },
                    {
                        data: "name"
                    },
                    {
                        data: "user.designation.designation"
                    },
                    {
                        data: "start_date",
                        "render": function(data, type) {
                                return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                                }
                    },
                    {
                        data: "end_date",
                        "render": function(data, type) {
                                return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                                }
                    },
                    {
                        data: "project.project_name"
                    },
                    {
                        data: "billable"
                    },
                    {
                        data: "is_primary_project"
                    },
                    {
                        data: "shadow_eligible"
                    },

                ],


            });
        }




    });
</script>
@endsection