@extends('layouts.app')

@section('page_title')
<title>Job Interview Rounds - {{$job->job_code}}</title>
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
        <div class="row align-items-center">
            <div class="col-sm-4 box-col-12">
                <div class="card">
                    <div class="card-header b-r-0 b-l-primary">
                        <div class="media"><i data-feather="file-plus"></i>
                            <div class="media-body px-3">
                                <h3 class="f-w-600 fs-4">Create Interview Rounds</h3>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="project-box">
                            <span class="badge {{$job->job_status == 1 ? 'badge-success' : 'badge-danger'}}">
                                @switch($job->job_status)
                                @case(1)
                                {{'Active'}}
                                @break
                                @case(0)
                                {{'InActive'}}
                                @break
                                @default
                                {{''}}
                                @endswitch
                            </span>
                            <h6>{{$job->job_code}}</h6>
                            <h5 class="pb-2">{{$job->position->position_name}}</h5>
                            <p>{{strip_tags(trim($job->job_description),150)}}</p>
                            <div class="row details">
                                <div class="col-6"> <span>Job Owner</span></div>
                                <div class="col-6 font-primary">{{$job->user->name}}</div>
                                <div class="col-6"><span>Head Count</span></div>
                                <div class="col-6 font-primary">{{$job->headcount}}</div>
                                <div class="col-6"> <span>Experience Required</span></div>
                                <div class="col-6 font-primary">{{$job->experience_required}}</div>
                                <div class="col-6"> <span>Priority</span></div>
                                <div class="col-6 font-primary">{{$job->importance}}</div>
                            </div>
                            <div class="project-status mt-4">
                                <div class="progress" style="height: 5px">
                                    <div class="progress-bar-animated bg-primary progress-bar-striped" role="progressbar" style="width: 70%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-8">
                <form method="POST" action="{{route('can-int-save')}}" id="int">
                    @csrf
                    
                    <div class="form theme-form">
                        <div class="">
                            <div style="padding:30px">
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
                                <span id="result"></span>
                                <input type="hidden" name="job_id" value="{{$job->id}}" id="data-id">
                                <input type="hidden" name="can_id" value="{{$candit->id}}" id="data-id">
                                <input type="hidden" value="{{$id}}" name="job_int_id">
                                <ul id="status" class="sortable-list">
                                    @foreach($round_completed as $rc)
                                    <li class="item flex-row b-success">
                                        <div class="p-2"><svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" style="width: 2em;height: 2em;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1">
                                                <path d="M430 266m-50 0a50 50 0 1 0 100 0 50 50 0 1 0-100 0Z" fill="#444444" />
                                                <path d="M430 430m-50 0a50 50 0 1 0 100 0 50 50 0 1 0-100 0Z" fill="#444444" />
                                                <path d="M430 594m-50 0a50 50 0 1 0 100 0 50 50 0 1 0-100 0Z" fill="#444444" />
                                                <path d="M430 758m-50 0a50 50 0 1 0 100 0 50 50 0 1 0-100 0Z" fill="#444444" />
                                                <path d="M594 266m-50 0a50 50 0 1 0 100 0 50 50 0 1 0-100 0Z" fill="#444444" />
                                                <path d="M594 430m-50 0a50 50 0 1 0 100 0 50 50 0 1 0-100 0Z" fill="#444444" />
                                                <path d="M594 594m-50 0a50 50 0 1 0 100 0 50 50 0 1 0-100 0Z" fill="#444444" />
                                                <path d="M594 758m-50 0a50 50 0 1 0 100 0 50 50 0 1 0-100 0Z" fill="#444444" />
                                            </svg></div>
                                        <div class="p-2" style="min-width:200px">
                                            <label class="col-form-label pt-0 d-flex justify-content-between aligh-items-center" for="exampleInputEmail1">
                                                <span>{{$rc->round_name}}</span>
                                                <span class=" badge badge-info">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up">
                                                        <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                                                    </svg>
                                                </span>

                                            </label>
                                            <input class="form-control" name="job_round[]" type="hidden" aria-describedby="emailHelp" value="{{$rc->id}}" placeholder="{{$rc->name}} ">
                                        </div>
                                        <div class="p-2"><button type="button" class="btn btn-success btn-sm">Completed</button></div>
                                    </li>
                                    @endforeach
                                </ul>
                                <ul id="sort-1" class="sortable-list">
                                    @foreach($job_in as $ji)
                                    <li class="item flex-row">
                                        <div class="p-2"><svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" style="width: 2em;height: 2em;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1">
                                                <path d="M430 266m-50 0a50 50 0 1 0 100 0 50 50 0 1 0-100 0Z" fill="#444444" />
                                                <path d="M430 430m-50 0a50 50 0 1 0 100 0 50 50 0 1 0-100 0Z" fill="#444444" />
                                                <path d="M430 594m-50 0a50 50 0 1 0 100 0 50 50 0 1 0-100 0Z" fill="#444444" />
                                                <path d="M430 758m-50 0a50 50 0 1 0 100 0 50 50 0 1 0-100 0Z" fill="#444444" />
                                                <path d="M594 266m-50 0a50 50 0 1 0 100 0 50 50 0 1 0-100 0Z" fill="#444444" />
                                                <path d="M594 430m-50 0a50 50 0 1 0 100 0 50 50 0 1 0-100 0Z" fill="#444444" />
                                                <path d="M594 594m-50 0a50 50 0 1 0 100 0 50 50 0 1 0-100 0Z" fill="#444444" />
                                                <path d="M594 758m-50 0a50 50 0 1 0 100 0 50 50 0 1 0-100 0Z" fill="#444444" />
                                            </svg></div>
                                        <div class="p-2" style="min-width:200px">
                                            <label class="col-form-label pt-0 d-flex justify-content-between aligh-items-center" for="exampleInputEmail1">
                                                <span>{{$ji->round_name}}</span>
                                                <span class=" badge badge-info">saved</span>
                                            </label>
                                            <input class="form-control" name="job_round[]" type="hidden" aria-describedby="emailHelp" value="{{$ji->id}}" placeholder="{{$ji->name}} ">
                                        </div>
                                        <div class="p-2"><button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></div>
                                    </li>
                                    @endforeach

                                    @foreach($job_notin as $ji)
                                    <li class="item flex-row">

                                        <div class="p-2"><svg xmlns="http://www.w3.org/2000/svg" class="svg-icon" style="width: 2em;height: 2em;vertical-align: middle;fill: currentColor;overflow: hidden;" viewBox="0 0 1024 1024" version="1.1">
                                                <path d="M430 266m-50 0a50 50 0 1 0 100 0 50 50 0 1 0-100 0Z" fill="#444444" />
                                                <path d="M430 430m-50 0a50 50 0 1 0 100 0 50 50 0 1 0-100 0Z" fill="#444444" />
                                                <path d="M430 594m-50 0a50 50 0 1 0 100 0 50 50 0 1 0-100 0Z" fill="#444444" />
                                                <path d="M430 758m-50 0a50 50 0 1 0 100 0 50 50 0 1 0-100 0Z" fill="#444444" />
                                                <path d="M594 266m-50 0a50 50 0 1 0 100 0 50 50 0 1 0-100 0Z" fill="#444444" />
                                                <path d="M594 430m-50 0a50 50 0 1 0 100 0 50 50 0 1 0-100 0Z" fill="#444444" />
                                                <path d="M594 594m-50 0a50 50 0 1 0 100 0 50 50 0 1 0-100 0Z" fill="#444444" />
                                                <path d="M594 758m-50 0a50 50 0 1 0 100 0 50 50 0 1 0-100 0Z" fill="#444444" />
                                            </svg></div>


                                        <div class="p-2">
                                            <label class="col-form-label pt-0" for="exampleInputEmail1">{{$ji->round_name}}</label>
                                            <input class="form-control" name="job_round[]" type="hidden" aria-describedby="emailHelp" value="{{$ji->id}}" placeholder="{{$ji->name}} ">
                                        </div>
                                        <div class="p-2"><button type="button" name="remove" id="" class="btn btn-danger remove">Remove</button></div>

                                    </li>
                                    @endforeach

                                </ul>
                                <ul class="sortable-list">
                                    <li class="item flex-row justify-content-end fixed">
                                        <div class="p-2">
                                            <button type="submit" class="btn btn-primary me-3">Update</button>
                                        </div>
                                        <div class="p-2">
                                            <a href="{{route('job.index')}}" class="btn btn-secondary">Cancel</a>
                                        </div>
                                        <div class="p-2">
                                            <a onclick="reload()" class="btn btn-danger">Reset</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </form>
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

        $(document).on('click', '#add1', function() {
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
            $(this).closest("li").remove();
        });

        $('#dynamic_form').on('submit', function(event) {
            event.preventDefault();
            var t_id = jQuery('#data-id').val();


            var ajaxurl = '';
            //  ajaxurl = ajaxurl.replace('id', t_id);
            $.ajax({
                url: ajaxurl,
                method: 'POST',
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


                    }
                    $('#result1').html('<div class="alert alert-success mb-3" >' + data.success + '</div>');
                    $('#save').attr('disabled', false);
                }
            })

        });

    })
</script>

<script>
    $(function() {
        $("#sort-1").sortable();
    });
</script>

<script>
    function reload() {
        location.reload(true);
    }
</script>
@endsection