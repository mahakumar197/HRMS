@extends('layouts.report')
@section('page_title')
<title>Job Summary</title>
@endsection
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Jobs</h3>
                </div>
                <div class="col-12 col-sm-6">
                    <span class="pull-right"><a href="{{url('job/create')}}" class="btn btn-primary " style="float: right;">Add Job</a></span>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid return"> </div>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        @if(Session::has('message'))
                        <div class="alert alert alert-success" role="alert">
                            {{session::get('message')}}
                        </div>
                        @endif

                        @if(Session::has('error'))
                        <div class="alert alert alert-danger" role="alert">
                            {{session::get('error')}}
                        </div>
                        @endif
                        <div class="table-responsive">
                            <table class="display basic-1" id="datatable">
                                <thead>
                                    <tr role="row">
                                        <th colspan="9" rowspan="1" class="text-center b-r-secondary border-2">Job Information</th>
                                        <th colspan="5" rowspan="1" class="text-center b-r-secondary border-2">Actions</th>
                                        <th colspan="3" rowspan="1" class="text-center">Interview</th>
                                    </tr>
                                    <tr>
                                        <th>Job Code</th>
                                        <th>HR Screening</th>
                                        <th>Position</th>
                                        <th>Project</th>
                                        <th>Posted Date</th>
                                        <th>Headcount/ Remaining</th>
                                        <th>Exp. Req.</th>
                                        <th>Job Owner</th>
                                        <th>Priority</th>
                                        <th>Job Status</th>
                                        <th>Edit Job/JD</th>
                                        <th>Interview Rounds</th>
                                        <th>Share</th>
                                        <th>Add Candidate</th>                                        
                                        <th>Offer Process</th>
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

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Job Status</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" data-bs-original-title="" title=""></button>
            </div>
            <div class="modal-body">
                <form action="{{url('/api/v2/job_status')}}" method='POST' id="edit_form123" autocomplete="off">
                    @csrf
                    <div class="form-group">
                        <label for="message-text" class="col-form-label" id="title">Status</label>
                        <select class="form-select {{ $errors->has('job_status') ? ' has-error' : ''}}" name="job_status" id="job_status">
                            <option value="">Select</option>
                            <option value="1">Active</option>
                            <option value="2">On Hold</option>
                            <option value="3">Completed</option>
                            <option value="0">Cancelled</option>
                        </select>
                        @if ($errors->has('job_status'))
                        <div class="text-danger">{{ $errors->first('job_status') }}</div>
                        @endif
                        <input type="hidden" class="l_id" name="id">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" data-bs-original-title="" title="">Cancel</button>
            </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="sharemodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title text-capitalize" id="name"> </h4>
                <button class="btn-close btn-light" type="button" data-bs-dismiss="modal" aria-label="Close" data-bs-original-title="" title=""></button>
            </div>
            <form action="{{url('/sharemail')}}" method='POST' id="edit_form" autocomplete="off">
                @csrf
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="form-group">
                            <div class="row justify-content-between" id="round-warning"> </div>
                            <div class="row justify-content-between" id="share-data-emp">

                            </div>
                            <hr id="hr1">
                            <div class="m-t-15 m-checkbox-inline mb-4 custom-control d-flex justify-content-end sec d-none">
                                <div class="tag h4">Select All</div>
                                <input type="checkbox" id='checkall' class="regular-checkbox big-checkbox" /><label for="checkall"></label>
                            </div>
                            <div class="row justify-content-between" id="notshare-data">

                            </div>
                            <hr id="hr2">
                            <div class="row justify-content-between" id="share-data"> </div>
                            <input type="hidden" class="l_id" name="id">
                        </div>
                    </div>
                </div>

                <div class="modal-footer text-end">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal" data-bs-original-title="" title="">Close</button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- medium modal -->
<div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content no-border">
            <div class="modal-header bg-grad" id="mediumHeader">
            </div>
            <div class="modal-body" id="mediumBody">
                <ul class="sortable-list"></ul>
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
            "ajax": "{{ route('api.job.index') }}",
            columnDefs: [{
                targets: 0,
                type: 'natural'
            }, {
                className: 'text-center',
                targets: [1,10, 11, 12, 13, 14, 4],
            }, ],
            order: [
                [0, 'desc']
            ],

            scrollCollapse: true,
            paging: true,
            fixedColumns: {
                leftColumns: 1
            },
            fixedHeader: true,

            "columns": [{
                    "data": "job_code",
                    "render": function(data, type, row, meta) {
                        if (type === 'display') {
                            data = '<a href="job-candidate/' + row.id + '">' + data + '</a>';
                        }
                        return data;
                    }
                },
                {
                    "data": "hr_int",
                    "render": function(data, type, row, meta) {
                        if (type === 'display') {
                            data = '<a href="hr-screening/' + row.id + '" data-toggle="tooltip" data-placement="top" title="Hr Screening">' + data + '</a>';
                        }
                        return data;
                    }
                },
                {
                    "data": "position"
                },
                {
                    "data": "project"
                },
                {
                    "data": "job_posted_date",
                    "render": function(data, type) {
                        return type === 'sort' ? data : moment(data).format('DD-MM-Y');
                    }
                },
                {
                    "data": "count",
                },

                {
                    "data": "experience_required",
                },
                {
                    "data": "job_owner",
                },
                {
                    "data": "importance",
                },
                {
                    "data": "job_status",
                },
                {
                    "data": "edit_job",
                },
                {
                    "data": "job_int",
                },
                {
                    "data": "share",
                },
                {
                    "data": "add_candidate",
                },
                {
                    "data": "offer_process",

                },


            ]
        });


        // CREATE
        $("#btn-save").click(function(e) {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            e.preventDefault();
            var formData = {
                id: jQuery('.l_id').val(),
                status: jQuery('#job_status').val(),
            };
            var state = jQuery('#btn-save').val();
            var type = "POST";
            var ajaxurl = 'jobstatus';
            $.ajax({
                type: type,
                url: ajaxurl,
                data: formData,
                dataType: 'json',
                success: function(data) {

                    var details = '<div class="alert alert-success dark alert-dismissible fade show" role="alert">' + data.success + ' <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button></div>'
                    $('#exampleModal').modal('hide');
                    table.draw();
                    jQuery('#edit_form').trigger("reset");
                    $('.return').html(details);
                    // Display Modal
                },
                error: function(data) {
                    jsonValue = jQuery.parseJSON(data.responseText);
                    var details = '<div class="alert alert-danger dark alert-dismissible show" role="alert">' + jsonValue.message + ' <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button></div>'
                    $('#exampleModal').modal('hide');
                    table.draw();
                    jQuery('#edit_form').trigger("reset");
                    $('.return').html(details);
                    // Display Modal
                }
            });
        });
    });
</script>
<script>
    let $modal = $('#exampleModal');
    let $sharemodal = $('#sharemodal');

    function testFunction(id, status, name) {
        event.preventDefault();

        $('#title').html(name);
        $('#userid').attr(id);
        $modal.modal('show');
        $('.l_id').val(id);
        $('#status').val(status);

    }

    function share(emp_refer, id) {

        let name = $('#name-' + id + '').val()
        // CREATE

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

        var formData = {
            id: id
        };

        var type = "POST";
        //   var ajaxurl = '/api/v2/share/' + id;
        var ajaxurl = '{{url("/api/v2/share","id")}}';
        ajaxurl = ajaxurl.replace('id', id);
        $.ajax({
            type: type,
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function(data) {
                $("#share-data").html("");
                $("#notshare-data").html("");
                $("#share-data-emp").html("");
                $('#round-warning').html("");
                $('#round-warning').html(data.rounds);
                if (data.rounds != null || data.rounds != undefined) {
                    $('.modal-footer').css('display', 'none');
                    $('#hr1').addClass("d-none");
                    $('#hr2').css('display', 'none');
                    $('.modal-body').addClass("bg-danger");
                } else {
                    $('.modal-footer').css('display', 'block');
                    $('#hr1').removeClass("d-none");
                    $('#hr2').css('display', 'block');
                    $('.modal-body').removeClass("bg-danger");
                }
                (data.shared == '') ? $('#hr2').addClass("d-none"): $('#hr2').removeClass("d-none");

                var shared = data.shared;
                var job = data.job;
                var notshared = data.notshared;
                $sharemodal.modal('show');
                $('#name').html(name);
                $('.l_id').val(id);

                var x = [];
                var y = [];

                $.each(job, function(key, value) {

                    if (value.emp_refer == 1) {
                        $('#share-data-emp').append('<div class="col-md-12"><div class="form-check form-check-inline checkbox checkbox-dark mb-0"><input class = "form-check-input" id = "emp_refer  " type = "checkbox" value="' + value.emp_refer + '" name="emp_refer" disabled><label class = "form-check-label" for = "emp_refer" > Mail Employee</label ></div></div>');
                    } else {
                        $('#share-data-emp').append('<div class="col-md-12"><div class="form-check form-check-inline checkbox checkbox-dark mb-0"><input class = "form-check-input" id = "emp_refer" type = "checkbox" value="1" name="emp_refer" ><label class = "form-check-label" for = "emp_refer" > Mail Employee </label ></div></div>');
                    }
                    if (value.emp_show == 1) {
                        $('#share-data-emp').append('<div class="col-md-12"><div class="form-check form-check-inline checkbox checkbox-dark mb-0"><input class = "form-check-input" id = "emp_show" type = "checkbox" value="' + value.emp_show + '" name="emp_show" disabled><label class = "form-check-label" for = "emp_show" >Show Employee</label ></div></div>');
                    } else {
                        $('#share-data-emp').append('<div class="col-md-12"><div class="form-check form-check-inline checkbox checkbox-dark mb-0"><input class = "form-check-input" id = "emp_show" type = "checkbox" value="1" name="emp_show" ><label class = "form-check-label" for = "emp_show" >Show Employee</label ></div></div>');
                    }

                })

                $.each(notshared, function(key, value) {
                    $('#notshare-data').append('<div class="col-md-4"><div class="form-check form-check-inline checkbox checkbox-dark mb-0"><input class = "form-check-input checkBoxClass" id = "con_' + value.id + '" type = "checkbox"  value="' + value.id + '" name="consultancy_id[]"><label class = "form-check-label" for = "con_' + value.id + '" >' + value.consultancy_name + '</label ></div></div>');
                })


                $.each(shared, function(key, value) {
                    $('#share-data').append('<div class="col-md-4"><div class="form-check form-check-inline checkbox checkbox-dark mb-0"><input class = "form-check-input" id = "' + value.id + '" type = "checkbox" disabled value="' + value.id + '" name="consultancy_id[]"><label class = "form-check-label" for = "' + value.id + '" >' + value.consultancy_name + '</label ></div></div>');
                })

                if (notshared.length != '') {
                    $(".sec").addClass("d-block");
                    $(".sec").removeClass("d-none");
                }
            },
            error: function(data) {
                let error = data["responseJSON"]["errors"];
                var error_html = '';
                $.each(error, function(code, message) {

                    error_html += '<p>' + message + '</p>';
                });
                $('.return').html('<div class="alert alert-danger dark alert-dismissible fade show" role="alert">' + error_html + '<button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button></div>');
            }


        });

    }
</script>
<script>
    function round(id) {

        event.preventDefault();
        var ajaxurl = '{{url("int-round")}}';
        $.ajax({
            url: ajaxurl,
            data: {
                id: id
            },
            success: function(round) {
                console.log(round);
                $('#mediumBody ul').html("");
                $('#mediumHeader').html("");
                $('#mediumHeader').append('<h4 class="m-0 text-light"> Interview Rounds - ' + round[1] + '</h4> <button class="btn-close btn-light" type="button" data-bs-dismiss="modal" aria-label="Close" data-bs-original-title="" title=""></button>');
                $.each(round[0], function(key, value) {
                    $('#mediumBody ul').append('<li class="item flex-row"><h4 class="m-0">' + value.round_name + '</h4></li>');
                })
                $('#mediumModal').modal("show");
            },
            complete: function() {
                $('#loader').hide();
            },

            timeout: 8000
        })
    };
</script>
<script>
    $("#checkall").click(function() {
        $('.checkBoxClass').not(this).prop('checked', this.checked);
    });
</script>
@endsection