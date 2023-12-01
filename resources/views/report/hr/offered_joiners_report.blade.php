@extends('layouts.report')
@section('page_title')
<title>Offered and Joiners Report</title>
@endsection
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Offered and Joiners Report</h3>
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
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Offer</label>
                                            <select class="form-select" id='offer' name='offer'>
                                                <option value=''>Select</option>
                                                <option value='Yes'>Accepted</option>
                                                <option value='No'>Declined</option>
                                            </select>
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
                                    <th>Offered Name</th>
                                    <th>Project</th>
                                    <th>Position</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Candidate Type</th>
                                    <th>Source</th>
                                    <th>Offer Date</th>
                                    <th>Offer Accepted / Declined</th>
                                    <th>EDOJ</th>
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
    $('#job').dataTable({
        "oLanguage": {
            "sEmptyTable": "Daily HR Report",
        }
    });
    $(document).ready(function() {

        $('#filter_join').click(function() {

            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            var project = $('#project').val();
            var position = $('#position').val();
            var offer = $('#offer').val();

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

                        fill_datatable(from_date, to_date, position, project, offer);


                    }


                }
            }

        });


        function fill_datatable(from_date, to_date, position, project, offer) {
           
            var dataTable = $('#job').DataTable({

                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('offered-joiners-report') }}",
                    data: {
                        from_date: from_date,
                        to_date: to_date,
                        position: position,
                        project: project,
                        offer: offer,
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
                        data: 'name',
                    },
                    {
                        data: 'project',
                    },
                    {
                        data: 'position',
                    },
                    {
                        data: 'phone_number'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'job_type'
                    },
                    {
                        data: 'source'
                    },
                    {
                        data: 'ol_date',
                        "render": function(data, type) {
                            if (data != null) {
                                return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        data: 'accepted_declined'
                    },
                    {
                        data: 'edjo',
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

                ],

            });
        }




    });
</script>
@endsection