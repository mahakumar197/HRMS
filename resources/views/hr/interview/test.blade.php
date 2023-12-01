@extends('layouts.report')
@section('page_title')
<title>Interview</title>
@endsection
@section('style')
<style>
    .statContainer {
        margin: 5px;
        width: 100%;
        font-size: 13px;
        border-radius: 3px;
        background-color: #fff;
        padding: 0;
        overflow: hidden;
    }

    .statContainer .title {
        padding: 5px 10px;
        color: #fff;
    }

    .statContainer.blue .title {
        background-color: #2d72c0;
    }

    .statContainer.blue .status {
        color: #2d72c0;
    }

    .statContainer.yellow .title {
        background-color: #f3a254;
    }

    .statContainer.yellow .status {
        color: #f3a254;
    }

    .statContainer.fountainBlue .title {
        background-color: #6abebf;
    }

    .statContainer.fountainBlue .status {
        color: #6abebf;
    }

    .statContainer.lightBlue .title {
        background-color: #52a1e5;
    }

    .statContainer.lightBlue .status {
        color: #52a1e5;
    }

    .statContainer.purple .title {
        background-color: #916df6;
    }

    .statContainer.purple .status {
        color: #916df6;
    }

    .statContainer.pink .title {
        background-color: #ef6e85;
    }

    .statContainer.pink .status {
        color: #ef6e85;
    }

    .statContainer.orange .title {
        background-color: #ff7043;
    }

    .statContainer.orange .status {
        color: #ff7043;
    }
</style>
@endsection
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <h3>HR Feedback</h3>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="row justify-content-end">
                        <div class="col-md-2">
                            <div class="statContainer blue shadow-sm">
                                <div class="title text-center">Recruited</div>
                                <div class="d-flex">
                                    <div class="p-2 flex-fill text-center">TOTAL </br>
                                        <h5 class="font-weight-bold">20</h5>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="statContainer yellow shadow-sm">
                                <div class="title text-center">Pipeline</div>
                                <div class="d-flex">
                                    <div class="p-2 flex-fill text-center">TOTAL </br>
                                        <h5 class="font-weight-bold">20</h5>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="statContainer fountainBlue shadow-sm">
                                <div class="title text-center">Dropped</div>
                                <div class="d-flex">
                                    <div class="p-2 flex-fill text-center">TOTAL </br>
                                        <h5 class="font-weight-bold">20</h5>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="statContainer lightBlue shadow-sm">
                                <div class="title text-center">Shortlisted</div>
                                <div class="d-flex">
                                    <div class="p-2 flex-fill text-center">TOTAL</br>
                                        <h5 class="font-weight-bold">20</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="container-fluid">
        <div class="col-sm-12 col-xl-12 xl-100">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs border-tab nav-secondary" id="info-tab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="info-home-tab" data-bs-toggle="tab" href="#info-home" role="tab" aria-controls="info-home" aria-selected="true" data-bs-original-title="" title=""><i class="icofont icofont-ui-home"></i>HR Round</a></li>
                        <li class="nav-item"><a class="nav-link" id="hr-not-attend-tab" data-bs-toggle="tab" href="#info-profile" role="tab" aria-controls="info-profile" aria-selected="false" data-bs-original-title="" title=""><i class="icofont icofont-man-in-glasses"></i>Tech Level</a></li>
                        <li class="nav-item"><a class="nav-link" id="contact-info-tab" data-bs-toggle="tab" href="#info-contact" role="tab" aria-controls="info-contact" aria-selected="false" data-bs-original-title="" title=""><i class="fa fa-chevron-circle-down"></i>PM Level</a></li>
                        <li class="nav-item"><a class="nav-link" id="contact-info-tab" data-bs-toggle="tab" href="#info-contact" role="tab" aria-controls="info-contact" aria-selected="false" data-bs-original-title="" title=""><i class="fa fa-chevron-circle-down"></i>Client</a></li>
                    </ul>
                    <div class="tab-content" id="info-tabContent">
                        <div class="tab-pane fade show active" id="info-home" role="tabpanel" aria-labelledby="info-home-tab">
                            <div class="table-responsive">
                                <table class="display basic-1 " id="datatable">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Job Code</th>
                                            <th>Candidate Created Date</th>
                                            <th>Name</th>
                                            <th>Phone Number</th>
                                            <th>Email Id</th>
                                            <th>Candidate Location</th>
                                            <th>Resume</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="info-profile" role="tabpanel" aria-labelledby="profile-info-tab">

                            <div class="table-responsive">
                                <table class="display basic-1 " id="hr-not-attend">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Job Code</th>
                                            <th>Candidate Created Date</th>
                                            <th>Name</th>
                                            <th>Phone Number</th>
                                            <th>Email Id</th>
                                            <th>Candidate Location</th>
                                            <th>Resume</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="info-contact" role="tabpanel" aria-labelledby="contact-info-tab">
                            <div class="table-responsive">
                                <table class="display basic-1 " id="hr-reject">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Job Code</th>
                                            <th>Candidate Created Date</th>
                                            <th>Name</th>
                                            <th>Phone Number</th>
                                            <th>Email Id</th>
                                            <th>Candidate Location</th>
                                            <th>Resume</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>

</div>

@endsection

@section('script')
<script>
    $(document).ready(function() {
        var table = $('#datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('list.hr-selected') }}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    "data": "job_code"
                },
                {
                    "data": "candidate_created_date",
                    "render": function(data, type) {
                        return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                    }
                },
                {
                    "data": "name"
                },
                {
                    "data": "phone_number"
                },
                {
                    "data": "email",
                },
                {
                    "data": "candidate_location",
                },

            ]
        });

        var table = $('#hr-reject').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('list.hr-rejected') }}",
            "columns": [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    "data": "job_code"
                },
                {
                    "data": "candidate_created_date",
                    "render": function(data, type) {
                        return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                    }
                },
                {
                    "data": "name"
                },
                {
                    "data": "phone_number"
                },
                {
                    "data": "email",
                },
                {
                    "data": "candidate_location",
                },

            ]
        });


        $("#hr-not-attend-tab").click(function(e) {

            var table_not_attened = $('#hr-not-attend').DataTable();
            table_not_attened.destroy();
            var table = $('#hr-not-attend').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('list.hr-not-interviewed') }}",
                "columns": [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        "data": "job_code"
                    },
                    {
                        "data": "candidate_created_date",
                        "render": function(data, type) {
                            return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                        }
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "phone_number"
                    },
                    {
                        "data": "email",
                    },
                    {
                        "data": "candidate_location",
                    },
                    {
                        "data": "resume",
                        "render": function(data, type, full, meta) {
                            return "<a href=\"/resume/" + data + "\"  target = '_blank'>View/Download</a>";
                        }
                    },

                    {
                        "data": "action",

                    },

                ]
            });

        });

    });
</script>
@endsection