@extends('layouts.report')
@section('page_title')
<title>Daily HR Report</title>
@endsection
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Daily HR Report</h3>
                </div>

            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form theme-form">
                            <form action=" " method="POST" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="name">From Date*</label>
                                            <input class="datepicker-here form-control digits" id="from_date" value="{{ Carbon\Carbon::now()->firstOfMonth()->format('d-m-Y') }}" type="text" data-position="bottom right" placeholder="DD-MM-YYYY" name="from_date">
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="name">To Date*</label>
                                            <input class="datepicker-here form-control digits" id="to_date" value="{{ Carbon\Carbon::now()->endOfMonth()->format('d-m-Y') }}" type="text" data-position="bottom right" placeholder="DD-MM-YYYY" name="to_date">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Client</label>
                                            <select class="form-select" id='project' name='project'>
                                                <option value=''>Select</option>
                                                @foreach ($project as $pro)
                                                <option value="{{$pro->id}}">{{$pro->project_name}}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Position</label>
                                            <select class="form-select" id='position' name='position'>
                                                <option value=''>Select</option>
                                                @foreach ($position as $pos)
                                                <option value="{{$pos->id}}">{{$pos->position_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>HR</label>
                                            <select class="form-select" id='hr' name='hr'>
                                                <option value=''>Select</option>
                                                @foreach ($hr as $hr)
                                                <option value="{{$hr->id}}">{{$hr->name}} - {{$hr->employee_code}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label for="name">Received Date</label>
                                            <input class="datepicker-here form-control" id="received_date"  type="text" data-position="bottom right" placeholder="DD-MM-YYYY" name="received_date">
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
                        <table class="display basic-1 " id="job">
                            <thead>
                                <tr>
                                    <th>Job Code</th>
                                    <th>Client</th>
                                    <th>Position</th>
                                    <th>No Of Position(s)</th>
                                    <th>HR</th>
                                    <th>Received Date</th>
                                    <th>Status</th>
                                    <th>Joined</th>
                                    <th>Job Posted Date</th>
                                    <th>Closed Date</th>
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
    $('#job').dataTable({
        "oLanguage": {
            "sEmptyTable": "Daily HR Report",
        }
    });
    $(document).ready(function() {

        $('#filter_join').click(function() {

            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            var hr = $('#hr').val();
            var project = $('#project').val();
            var position = $('#position').val();
            var received_date = $('#received_date').val();



            var rxDatePattern = /^(\d{1,2})(\/|-)(\d{1,2})(\/|-)(\d{4})$/; //Declare Regex
            var fromDate = from_date.match(rxDatePattern);
            var toDate = to_date.match(rxDatePattern);

            if (from_date == '') {
                alert('From Date field is required.');

            } else if (fromDate == null) {
                alert('Invalid From Date');

            } else if (to_date == '') {
                alert('To Date field is required.');

            } else if (toDate == null) {
                alert('Invalid To Date.');

            } else {
                if (from_date != '' && to_date != '') {

                    if (Date.parse(from_date) > Date.parse(to_date)) {
                        alert('To Date must be greater than From Date.');

                    } else {
                        $('#job').DataTable().destroy();

                        fill_datatable(from_date, to_date, position, project, hr, received_date);


                    }


                }
            }

        });


        function fill_datatable(from_date, to_date, position, project, hr, received_date) {
            
            var dataTable = $('#job').DataTable({

                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('daily-hr-report') }}",
                    data: {
                        from_date: from_date,
                        to_date: to_date,
                        position: position,
                        project: project,
                        hr: hr,
                        received_date: received_date,
                    },

                },

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
                columnDefs: [{
                    targets: 0,
                    type: 'natural'
                }],
                order: [
                    [0, 'Asc']
                ],

                columns: [{

                        data: 'job_code',
                    },
                    {
                        data: 'project',
                    },
                    {
                        data: 'position',
                    },
                    {
                        data: 'headcount',
                    },
                    {
                        data: 'job_owner'
                    },
                    {
                        data: 'received_date',
                        "render": function(data, type) {
                            if (data != null) {
                                return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'joined',
                    },
                    {
                        data: 'job_posted_date',
                        "render": function(data, type) {
                            if (data != null) {
                                return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        data: 'closed_date',
                        "render": function(data, type) {
                            if (data != null) {
                                return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                            } else {
                                return '';
                            }
                        }
                    },




                ],


            });
        }




    });
</script>
@endsection