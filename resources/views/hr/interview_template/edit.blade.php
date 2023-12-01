@extends('layouts.app')

@section('page_title')
<title>Interview Round Edit</title>
@endsection
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-sm-8 box-col-12">
                <div class="card">
                    <div class="card-body b-l-primary">
                        <div class="media"><i data-feather="file-plus"></i>
                            <div class="media-body px-3">
                                <h3 class="f-w-600 fs-4">Interview Template Edit</h3>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">

                        @if(Session::has('message'))
                        <div class="alert alert alert-success" role="alert">
                            {{session::get('message')}}

                        </div>
                        @endif

                        @if(Session::has('error2'))
                        <div class="alert alert alert-danger" role="alert">
                            {{session::get('error2')}}

                        </div>
                        @endif
                        <span id="result1"></span>

                        <div class="form theme-form projectcreate">
                            <form method="post" id="dynamic_form">
                                <span id="result"></span>
                                <div class="row">

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Positon*</label>

                                            <input type="hidden" value="{{$int_round->id}}" id="data-id" name="id">
                                            <input type="text" name="position" value="{{$int_round->position->position_name}}" class=" form-control input-lg {{ $errors->has('position') ? ' has-error' : ''}}" />
                                            @if ($errors->has('position'))
                                            <div class="text-danger">{{ $errors->first('position') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-bordered table-striped" id="int-table">
                                    <thead>
                                        <tr>
                                            <th width="70%">Round</th>
                                            <th width="30%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><input type="text" name="round_1" class="form-control" value="{{$int_round->round_1}}" /></td>
                                        </tr>

                                        <tr>
                                            <td><input type="text" name="round_2" class="form-control" value="{{$int_round->round_2}}" /></td>
                                            <td><button type="button" name="add" id="add" class="btn btn-success">Add</button> <button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></td>
                                        </tr>
                                        @isset($int_round->round_3)
                                        <tr>
                                            <td><input type="text" name="round_3" class="form-control" value="{{$int_round->round_3}} " /></td>
                                            <td><button type="button" name="add" id="add" class="btn btn-success">Add</button> <button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></td>
                                        </tr>
                                        @endisset

                                        @isset($int_round->round_4)
                                        <tr>
                                            <td><input type="text" name="round_4" class="form-control" value="{{$int_round->round_4}} " /></td>
                                            <td><button type="button" name="add" id="add" class="btn btn-success">Add</button> <button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></td>
                                        </tr>
                                        @endisset

                                        @isset($int_round->round_5)
                                        <tr>
                                            <td><input type="text" name="round_5" class="form-control" value="{{$int_round->round_5}} " /></td>
                                            <td><button type="button" name="add" id="add" class="btn btn-success">Add</button> <button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></td>
                                        </tr>
                                        @endisset

                                        @isset($int_round->round_6)
                                        <tr>
                                            <td><input type="text" name="round_6" class="form-control" value="{{$int_round->round_6}} " /></td>
                                            <td><button type="button" name="add" id="add" class="btn btn-success">Add</button> <button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></td>
                                        </tr>
                                        @endisset

                                        @isset($int_round->round_7)
                                        <tr>
                                            <td><input type="text" name="round_7" class="form-control" value="{{$int_round->round_7}} " /></td>
                                            <td><button type="button" name="add" id="add" class="btn btn-success">Add</button> <button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></td>
                                        </tr>
                                        @endisset

                                        @isset($int_round->round_8)
                                        <tr>
                                            <td><input type="text" name="round_8" class="form-control" value="{{$int_round->round_8}} " /></td>
                                            <td><button type="button" name="add" id="add" class="btn btn-success">Add</button> <button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></td>
                                        </tr>
                                        @endisset

                                        @isset($int_round->round_9)
                                        <tr>
                                            <td><input type="text" name="round_9" class="form-control" value="{{$int_round->round_9}} " /></td>
                                            <td><button type="button" name="add" id="add" class="btn btn-success">Add</button> <button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></td>
                                        </tr>
                                        @endisset

                                        @isset($int_round->round_10)
                                        <tr>
                                            <td><input type="text" name="round_10" class="form-control" value="{{$int_round->round_10}} " /></td>
                                            <td><button type="button" name="add" id="add" class="btn btn-success">Add</button> <button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></td>
                                        </tr>
                                        @endisset
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td align="right">&nbsp;</td>
                                            <td>
                                                @csrf
                                                <input type="submit" name="save" id="save" class="btn btn-primary" value="Update" />
                                                <a href="{{route('interview-template.index')}}" class="btn btn-secondary me-3">Cancel</a>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
</div>

<div class="modal fade" id="template-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-white bg-primary">
                <div class="my-2 align-items-center d-flex justify-content-between">
                    <h6 id="share-data"></h6>
                    <a href="{{route('interview-template.index')}}" class="btn btn-secondary">OK</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function() {

        var count = $('#int-table>tbody >tr').length;

        $(document).on('click', '#add', function() {
            count++;
            html = '<tr>';
            html += '<td><input type="text" name="round_' + count + '" class="form-control" /></td>';

            if (count > 10) {

                $('#result1').html('<div class="alert alert-danger dark alert-dismissible fade show" role="alert">Maximum Reached</div>');

            } else {

                html += '<td><button type="button" name="add" id="add" class="btn btn-success">Add</button>  <button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></td></tr>';
                $('tbody').append(html);

            }

        });

        $(document).on('click', '.remove', function() {
            count--;
            $(this).closest("tr").remove();
        });

        $('#dynamic_form').on('submit', function(event) {
            event.preventDefault();
            var t_id = jQuery('#data-id').val();


            var ajaxurl = '{{url("interview-template","id")}}';
            ajaxurl = ajaxurl.replace('id', t_id);
            $.ajax({
                url: ajaxurl,
                method: 'PUT',
                data: $(this).serialize(),


                dataType: 'json',
                beforeSend: function() {
                    $('#save').attr('disabled', 'disabled');
                },

                success: function(data) {

                    if (data.error) {
                        var error_html = '';
                        for (var count = 0; count < data.error.length; count++) {
                            error_html += '<p>' + data.error[count] + '</p>';
                        }
                        $('#result').html('<div class="alert alert-danger">' + error_html + '</div>');
                    } else {

                        let $template = $('#template-edit');
                        $template.modal('show');

                        $('#share-data').html(data.success);

                        //$('#result').html('<div class="alert alert-success">' + data.success + '</div>');
                    }
                    $('#save').attr('disabled', false);
                }
            })

        });

    })
</script>
@endsection