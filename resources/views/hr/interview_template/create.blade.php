@extends('layouts.app')

@section('page_title')
<title>Interview Round Create</title>
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
                                <h3 class="f-w-600 fs-4">Interview Template Create</h3>
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

                                            <select class="form-select {{ $errors->has('status') ? ' has-error' : ''}}" name="position_id">
                                                <option value="">Select</option>

                                                @foreach($position as $pos)
                                                <option value="{{$pos->id}}">{{$pos->position_name}}</option>
                                                @endforeach

                                            </select>
                                            @if ($errors->has('status'))
                                            <div class="text-danger">{{ $errors->first('status') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <table class="table table-bordered table-striped" id="user_table">
                                    <thead>
                                        <tr>
                                            <th width="70%">Round</th>
                                            <th width="30%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td align="right">&nbsp;</td>
                                            <td>
                                                @csrf
                                                <input type="submit" name="save" id="save" class="btn btn-primary" value="Save" />
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

@endsection

@section('script')
<script>
    $(document).ready(function() {

        var count = 1;

        dynamic_field(count);

        function dynamic_field(number) {
            html = '<tr>';
            html += '<td><input type="text" name="round_' + count + '" class="form-control" /></td>';

            if (number > 10) {

                $('#result1').html('<div class="alert alert-danger dark alert-dismissible fade show" role="alert">Maximum Reached</div>');

            } else if (number > 1) {
                html += '<td><button type="button" name="add" id="add" class="btn btn-success">Add</button>  <button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></td></tr>';
                $('tbody').append(html);
            } else {
                html += '<td><button type="button" name="add" id="add" class="btn btn-success">Add</button></td></tr>';
                $('tbody').html(html);
            }
        }

        $(document).on('click', '#add', function() {
            count++;
            dynamic_field(count);
        });

        $(document).on('click', '.remove', function() {
            count--;
            $(this).closest("tr").remove();
        });

        $('#dynamic_form').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: '{{ route("interview-template.store") }}',
                method: 'post',
                data: $(this).serialize(),


                dataType: 'json',
                beforeSend: function() {
                     $('#save').attr('disabled','disabled');
                },

                success: function(data) {

                    if (data.error) {
                        var error_html = '';
                        for (var count = 0; count < data.error.length; count++) {
                            error_html += '<p>' + data.error[count] + '</p>';
                        }
                        $('#result').html('<div class="alert alert-danger">' + error_html + '</div>');
                    } else {
                        dynamic_field(1);
                        $('#result').html('<div class="alert alert-success">' + data.success + '</div>');
                    }
                    $('#save').attr('disabled', false);
                }
            })

        });

    })
</script>script>
@endsection