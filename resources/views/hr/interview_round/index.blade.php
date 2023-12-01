@extends('layouts.report')
@section('page_title')
<title>Interview Rounds</title>
@endsection

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-4">
                    <h3></h3>
                </div>
                <div class="col-12 col-sm-8 text-start">
                    <h3>Interview Round Summary</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-4 box-col-4 col-md-6 xl-30">
                <div class="card card-absolute">
                    <div class="card-header bg-primary">
                        <h5 class="text-white">Add Interview Round</h5>
                    </div>
                    <div class="card-body form theme-form">
                        <div class="return mb-2"></div>
                        <form action=" " method="POST" id="emp">
                            <input type="hidden" name="_token" value="gbq43ZAQlDS47upkaoBeoxjKmqnFfowxs3Uo7q3I">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label>Round Name*</label>
                                        <input type="text" id="round_name" value="" placeholder="Round Name" class="form-control ">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="mb-3">
                                        <label>Feedback Template*</label>
                                        <select class="form-select" name="feedback_template" id="feedback_template">
                                        <option value="">Select</option>
                                        <option value="0">Common Template</option>
                                        <option value="1">HR Template</option>
                                        <option value="2">Tech Template</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="text-end"> <button class="btn btn-primary me-3" type="submit" id="btn-save">Add</button><a onclick="resetForm()" class="btn btn-danger me-3">Reset</a> </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 box-col-8 col-md-12 xl-70">
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
                            <table class="display basic-1 " id="datatable">
                                <thead>
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Rounds</th>
                                        <th>Feedback Template</th>
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
@endsection


@section('script')
<script>
    jQuery(document).ready(function($) {

        var table = $('#datatable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('list.interview.round') }}",

            "columns": [{
                    "data": "srno",
                    "render": function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "data": "round_name"
                },
                {
                    "data": "feedback_template"
                },

                {
                    "data": "action",
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
                round_name: jQuery('#round_name').val(),
                feedback_template: jQuery('#feedback_template').val(),
            };
            var state = jQuery('#btn-save').val();
            var type = "POST";
            var ajaxurl = 'interview-round';
            $.ajax({
                type: type,
                url: ajaxurl,
                data: formData,
                dataType: 'json',
                success: function(data) {
                    //document.getElementById("cform").reset();
                    var details = '<div class="alert alert-success dark alert-dismissible fade show" role="alert">' + data.success + ' <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button></div>'
                    $('#empModal').modal('hide');
                    table.draw();
                    jQuery('#emp').trigger("reset");
                    $('.return').html(details);
                },
                error: function(data) {
                    let error = data["responseJSON"]["errors"];
                    var error_html = '';
                    console.log(data);
                    $.each(error, function(code, message) {

                        error_html += '<p>' + message + '</p>';
                    });
                    $('.return').html('<div class="alert alert-danger dark alert-dismissible fade show" role="alert">' + error_html + '<button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button></div>');

                    $('#empModal').modal('hide');
                    table.draw();

                }
            });
        });
    });

</script>
@endsection