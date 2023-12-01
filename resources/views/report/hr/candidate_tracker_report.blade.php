@extends('layouts.report')
@section('page_title')
<title>Candidate Tracker Report</title>
@endsection
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Candidate Tracker Report</h3>
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
                                            <label>Client</label>
                                            <select class="form-select project" id='project' name='project'>
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
                                            <select class="form-select position" id='position' name='position'>
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
                                            <select class="form-select hr" id='hr' name='hr'>
                                                <option value=''>Select</option>
                                                @foreach ($hr as $hr)
                                                <option value="{{$hr->id}}">{{$hr->name}} - {{$hr->employee_code}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Interviewer</label>
                                            <select class="form-select interviewer" id='interviewer' name='interviewer'>
                                                <option value=''>Select</option>
                                                @foreach ($interviewer as $int)
                                                <option value="{{$int->id}}">{{$int->name}} - {{$int->employee_code}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Job</label>
                                            <select class="form-select job_code" id='job_code' name='job_code'>
                                                <option value=''>Select</option>
                                                @foreach ($job as $j)
                                                <option value="{{$j->id}}">{{$j->job_code}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Offer Letter</label>
                                            <select class="form-select ol" id='ol' name='ol'>
                                                <option value=''>Select</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Offer Ack</label>
                                            <select class="form-select offer_ack" id='offer_ack' name='offer-ack'>
                                                <option value=''>Select</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Appointed</label>
                                            <select class="form-select appointed" id='appointed' name='appointed'>
                                                <option value=''>Select</option>
                                                <option value="Yes">Yes</option>
                                                <option value="No">No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="text-left"><button type="button" name="filter" id="filter_join" class="btn btn-primary">Search</button></div>
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
                    <div class="table-responsive ">
                        <table class="display basic-1" id="job">
                            <thead>
                                <tr>
                                    <th>S.No.</th>
                                    <th>Date</th>
                                    <th style="width: 150px;">Name</th>
                                    <th>Job Code</th>
                                    <th>Project</th>
                                    <th>Position</th>
                                    <th>Handled By</th>
                                    <th>Tot. Exp.</th>
                                    <th>Rev. Exp.</th>
                                    <th>Current Company</th>
                                    <th>Current Location</th>
                                    <th>Current CTC</th>
                                    <th>Expected CTC</th>
                                    <th>Notice Period</th>
                                    <th>Round-1</th>
                                    <th>Round-1-Status</th>
                                    <th>Round-1-Int</th>
                                    <th>Round-2</th>
                                    <th>Round-2-Status</th>
                                    <th>Round-2-Interviewer</th>
                                    <th>Round-3</th>
                                    <th>Round-3-Status</th>
                                    <th>Round-3-Interviewer</th>
                                    <th>Round-4</th>
                                    <th>Round-4-Status</th>
                                    <th>Round-4-Interviewer</th>
                                    <th>Round-5</th>
                                    <th>Round-5-Status</th>
                                    <th>Round-5-Interviewer</th>
                                    <th>Round-6</th>
                                    <th>Round-6-Status</th>
                                    <th>Round-6-Interviewer</th>
                                    <th>Round-7</th>
                                    <th>Round-7-Status</th>
                                    <th>Round-7-Interviewer</th>
                                    <th>Offer Letter</th>
                                    <th>Offer Ack</th>
                                    <th>Ack Date</th>
                                    <th>Joining Date</th>
                                    <th>Appointment Received</th>
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
            "sEmptyTable": "Candidate Tracker Report",
        }
    });
    $(document).ready(function() {
        $('#filter_join').click(function() {

            var hr = $('#hr').val();
            var project = $('#project').val();
            var position = $('#position').val();
            var interviewer = $('#interviewer').val();
            var job_code = $('#job_code').val();
            var ol = $('#ol').val();
            var offer_ack = $('#offer_ack').val();
            var appointed = $('#appointed').val();

            $('#job').DataTable().destroy();
            fill_datatable(job_code, position, project, hr, interviewer, ol, offer_ack, appointed);

        });

        function fill_datatable(job_code, position, project, hr, interviewer, ol, offer_ack, appointed) {

            var dataTable = $('#job').DataTable({

                processing: true,
                serverSide: true,
                "bDestroy": true,
                scrollX: true,
                "ScrollXInner": "100%",
                scrollY: 500,
                scrollCollapse: true,

                ajax: {
                    url: "{{ route('candidate-tracker-report') }}",
                    type: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        position: position,
                        project: project,
                        hr: hr,
                        interviewer: interviewer,
                        job_code: job_code,
                        ol: ol,
                        offer_ack: offer_ack,
                        appointed: appointed,
                    },
                },
                scrollCollapse: true,
                paging: true,

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
                    },
                    {
                        width: "30%"
                    }
                ],
                order: [
                    [0, 'Asc']
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'candidate_created_date',
                        "render": function(data, type) {
                            if (data != null) {
                                return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                            } else {
                                return '';
                            }
                        }
                    },

                    {

                        data: 'name',
                    },
                    {

                        data: 'job_code',
                    },
                    {

                        data: 'project',
                    },
                    {

                        data: 'position',
                    },
                    {

                        data: 'recruiter_name',
                    },
                    {

                        data: 'tot_exp',
                    },
                    {

                        data: 'rev_exp',
                    },
                    {

                        data: 'current_company',
                    },
                    {

                        data: 'current_company_location',
                    },
                    {

                        data: 'cur_ctc',
                    },
                    {

                        data: 'exp_ctc',
                    },
                    {

                        data: 'notice_period',
                    },

                    {
                        data: 'round_1'
                    },
                    {
                        data: 'round_1_status'
                    },
                    {
                        data: 'round_1_int'
                    },
                    {
                        data: 'round_2'
                    },
                    {
                        data: 'round_2_status'
                    },
                    {
                        data: 'round_2_int'
                    },
                    {
                        data: 'round_3'
                    },
                    {
                        data: 'round_3_status'
                    },
                    {
                        data: 'round_3_int'
                    },
                    {
                        data: 'round_4'
                    },
                    {
                        data: 'round_4_status'
                    },
                    {
                        data: 'round_4_int'
                    },
                    {
                        data: 'round_5'
                    },
                    {
                        data: 'round_5_status'
                    },
                    {
                        data: 'round_5_int'
                    },
                    {
                        data: 'round_6'
                    },
                    {
                        data: 'round_6_status'
                    },
                    {
                        data: 'round_6_int'
                    },
                    {
                        data: 'round_7',
                    },
                    {
                        data: 'round_7_status'
                    },
                    {
                        data: 'round_7_int'
                    },
                    {
                        data: 'offer_letter'
                    },
                    {
                        data: 'offer_ack'
                    },
                    {
                        data: 'offer_ack_date',
                        "render": function(data, type) {
                            if (data != '') {
                                return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        data: 'joining_date',
                        "render": function(data, type) {
                            if (data != '') {
                                return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        data: 'aor'
                    },


                ],
                "createdRow": function(row, data, index) {
                    if (data.can_id != "") {
                        $('td:eq(1)', row).addClass('bg-primary');
                        $('td:eq(2)', row).addClass('bg-primary');
                    }
                },




            });


        }



    });
</script>

<script>
    $(document).ready(function() {
        $('.position').change(function() { // position 
            $('.project').val('');
            $('.hr').val('');
            $('.interviewer').val('');
            $('.job_code').val('');
            $('.ol').val('');
            $('.offer_ack').val('');
            $('.appointed').val('');
        });
        $('.project').change(function() { // project
            $('.position').val('');
            $('.hr').val('');
            $('.interviewer').val('');
            $('.job_code').val('');
            $('.ol').val('');
            $('.offer_ack').val('');
            $('.appointed').val('');
        });
        $('.hr').change(function() { // hr
            $('.project').val('');
            $('.position').val('');
            $('.interviewer').val('');
            $('.job_code').val('');
            $('.ol').val('');
            $('.offer_ack').val('');
            $('.appointed').val('');
        });
        $('.interviewer').change(function() { // interviewer
            $('.project').val('');
            $('.hr').val('');
            $('.position').val('');
            $('.job_code').val('');
            $('.ol').val('');
            $('.offer_ack').val('');
            $('.appointed').val('');
        });
        $('.ol').change(function() { // ol
            $('.project').val('');
            $('.hr').val('');
            $('.interviewer').val('');
            $('.job_code').val('');
            $('.position').val('');
            $('.offer_ack').val('');
            $('.appointed').val('');
        });
        $('.offer_ack').change(function() { // offer_ack
            $('.project').val('');
            $('.hr').val('');
            $('.interviewer').val('');
            $('.job_code').val('');
            $('.ol').val('');
            $('.position').val('');
            $('.appointed').val('');
        });
        $('.job_code').change(function() { // job_code
            $('.project').val('');
            $('.hr').val('');
            $('.interviewer').val('');
            $('.position').val('');
            $('.ol').val('');
            $('.offer_ack').val('');
            $('.appointed').val('');
        });
        $('.appointed').change(function() { // appointed
            $('.project').val('');
            $('.hr').val('');
            $('.interviewer').val('');
            $('.job_code').val('');
            $('.ol').val('');
            $('.offer_ack').val('');
            $('.position').val('');
        });
    });
</script>
@endsection