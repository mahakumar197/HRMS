@extends('layouts.report')
@section('page_title')
<title>Employee Attendance Projectwise Summary</title>
@endsection
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Employee Attendance Projectwise Summary</h3>
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
                                            <label>Project*</label>
                                            <select class="form-select" id='project' name='project'>
                                                <option value=''>Select</option>
                                                @foreach ($project as $pro)
                                                <option value="{{$pro->id}}">{{$pro->project_name}}</option>
                                                @endforeach
                                            </select>
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
                                    <th>Primary Project</th>
                                    <th>Jan</th>
                                    <th>Feb</th>                                    
                                    <th>Mar</th>
                                    <th>Apr</th>
                                    <th>May</th>
                                    <th>Jun</th>
                                    <th>July</th>
                                    <th>Aug</th>
                                    <th>Sep</th>
                                    <th>Oct</th>
                                    <th>Nov</th>
                                    <th>Dec</th>
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
            var project = $('#project').val();
            fill_datatable(project);
        });

        function fill_datatable(project) {
            
            var dataTable = $('#attend_emp').DataTable({

                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('project-wise-attendance') }}",
                    data: {                       
                        project:project
                    },
                },                
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

                        data: 'employee_code',
                    },
                    {
                        data: 'name',
                    },                   
                    {
                        data: 'primary_project',
                    },
                    {
                        data: 'jan',
                    },
                    {
                        data: 'feb',
                    },
                    {
                        data: 'mar',
                    },
                    {
                        data: 'apr',
                    },
                    {
                        data: 'may',
                    },
                    {
                        data: 'jun',
                    },
                    {
                        data: 'jly',
                    },
                    {
                        data: 'aug',
                    },
                    {
                        data: 'sep',
                    },
                    {
                        data: 'oct',
                    },
                    {
                        data: 'nov',
                    },
                    {
                        data: 'dec',
                    },
                   



                ],


            });
        }




    });
</script>
@endsection