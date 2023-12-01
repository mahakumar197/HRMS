@extends('layouts.app')

@section('page_title')
<title>Edit Job</title>
@endsection
@section('content')
<div id="mail_send"></div>
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
                    <div class="card-body  b-l-primary">
                        <div class="media"><i data-feather="edit-2"></i>
                            <div class="media-body px-2">
                                <h3 class="f-w-600 fs-4">Edit Job - {{$job->job_code}}</h3>                                
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
                        <div class="form theme-form projectcreate">
                            <form action="{{url('job/'.$job->id)}}" method="POST" id='job' autocomplete="off" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="col-form-label">Position Name*</label>
                                            <select class="form-select {{ $errors->has('position_id') ? ' has-error' : ''}}" name="position_id">
                                                <option value="">Select</option>
                                                @foreach ($job_position as $jp)
                                                <option value="{{$jp->id}}" {{ $job->position_id  == $jp->id ? 'selected':'' }}>{{ $jp->position_name}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('position_id'))
                                            <div class="text-danger">{{ $errors->first('position_id') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Project*</label>
                                            <div class="form-group">
                                                <input type="text" name="dummy" value='{{$job->project->project_name}}' id='project_search' class="typeahead form-control input-lg {{ $errors->has('project_id') ? ' has-error' : ''}}" placeholder="Project Name" />
                                                <input type="hidden" name="project_id" value='{{$job->project->id}}' id='proj_id' class="form-control input-lg" placeholder="Project Name" />
                                                @if ($errors->has('project_id'))
                                                <div class="text-danger">{{ $errors->first('project_id') }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Received Date</label>
                                            <input class=" datepicker-here form-control  {{ $errors->has('received_date') ? ' has-error' : ''}}" readonly type="text" data-position="top right" placeholder="DD-MM-YYYY" value="{{$job->received_date != null ? Carbon\Carbon::parse($job->received_date)->format('d-m-Y') : '' }}" name="received_date">
                                            @if ($errors->has('received_date'))
                                            <div class="text-danger">{{ $errors->first('received_date') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Closed Date</label>
                                            <input class=" datepicker-here form-control  {{ $errors->has('closed_date') ? ' has-error' : ''}}" readonly type="text" data-position="top right" placeholder="DD-MM-YYYY" value="{{$job->closed_date != null ? Carbon\Carbon::parse($job->closed_date)->format('d-m-Y') :'' }}" name="closed_date">
                                            @if ($errors->has('closed_date'))
                                            <div class="text-danger">{{ $errors->first('closed_date') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Submit Date</label>
                                            <input class=" datepicker-here form-control  {{ $errors->has('submit_date') ? ' has-error' : ''}}" readonly type="text" data-position="top right" placeholder="DD-MM-YYYY" value="{{$job->submit_date != null ? Carbon\Carbon::parse($job->submit_date)->format('d-m-Y') : '' }}" name="submit_date">
                                            @if ($errors->has('submit_date'))
                                            <div class="text-danger">{{ $errors->first('submit_date') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>WO ID</label>
                                            <input class=" form-control {{ $errors->has('wo_id') ? ' has-error' : ''}}" placeholder="WO ID" type="text" name="wo_id" value="{{$job->wo_id}}">
                                            @if ($errors->has('wo_id'))
                                            <div class="text-danger">{{ $errors->first('wo_id') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Candidate Type*</label>
                                            <select class="form-select {{ $errors->has('candidate_type') ? ' has-error' : ''}}" name="candidate_type">
                                                <option value="">Select</option>
                                                <option value="Fresher" {{$job->candidate_type == 'Fresher' ?'selected':''}}>Fresher</option>
                                                <option value="Experience" {{$job->candidate_type == 'Experience' ?'selected':''}}>Experience</option>
                                            </select>
                                            @if ($errors->has('candidate_type'))
                                            <div class="text-danger">{{ $errors->first('candidate_type') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Location</label>
                                            <select class="form-select {{ $errors->has('location') ? ' has-error' : ''}}" name="location">
                                                <option value="">Select</option>
                                                <option value="Remote" {{ $job->location == 'Remote' ? 'selected' : '' }}>Remote</option>
                                                <option value="WFO" {{ $job->location == 'WFO' ? 'selected' : '' }}>WFO</option>
                                                <option value="Hybrid" {{ $job->location == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                            </select>
                                            @if ($errors->has('location'))
                                            <div class="text-danger">{{ $errors->first('location') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Job Type*</label>
                                            <select class="form-select {{ $errors->has('job_type_id') ? ' has-error' : ''}}" name="job_type_id">
                                                <option value=''>Select</option>
                                                @foreach ($job_type as $jt)
                                                <option value="{{$jt->id}}" {{$jt->id == $job->job_type_id ?'selected':''}}>{{ $jt->job_type}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('job_type_id'))
                                            <div class="text-danger">{{ $errors->first('job_type_id') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3 bootstrap-touchspin">
                                            <label>Headcount*</label>
                                            <fieldset>
                                                <div class="input-group mt-1">
                                                    <input class="touchspin" type="text" value="{{$job->headcount}}" name="headcount">
                                                </div>
                                            </fieldset>
                                            @if ($errors->has('headcount'))
                                            <div class="text-danger">{{ $errors->first('headcount') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Minimum Salary*</label>
                                            <input class=" form-control {{ $errors->has('minimum_salary') ? ' has-error' : ''}}" type="text" value="{{$job->minimum_salary}}" name="minimum_salary">
                                            @if ($errors->has('minimum_salary'))
                                            <div class="text-danger">{{ $errors->first('minimum_salary') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Maximum Salary*</label>
                                            <input class=" form-control {{ $errors->has('maximum_salary') ? ' has-error' : ''}}" type="text" value="{{$job->maximum_salary}}" name="maximum_salary">
                                            @if ($errors->has('maximum_salary'))
                                            <div class="text-danger">{{ $errors->first('maximum_salary') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Currency*</label>
                                            <input class="form-control {{ $errors->has('currency') ? ' has-error' : ''}}" type="text" placeholder="Currency" name="currency" value="{{$job->currency}}" id="currency">
                                            @if ($errors->has('currency'))
                                            <div class="text-danger">{{ $errors->first('currency') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Priority*</label>
                                            <select class="form-select {{ $errors->has('importance') ? ' has-error' : ''}}" name="importance">
                                                <option value="">Select</option>
                                                <option value="High" {{$job->importance == "High" ?'selected':''}}>High</option>
                                                <option value="Medium" {{$job->importance == "Medium" ?'selected':''}}>Medium</option>
                                                <option value="Low" {{$job->importance == "Low" ?'selected':''}}>Low</option>
                                            </select>
                                            @if ($errors->has('importance'))
                                            <div class="text-danger">{{ $errors->first('importance') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <!--  <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Billing Mode*</label>
                                            <select class="form-select {{ $errors->has('billing_mode') ? ' has-error' : ''}}" name="billing_mode">
                                                <option value="">Select</option>
                                                <option value="Daily" {{$job->billing_mode == "Daily" ?'selected':''}}>Daily</option>
                                                <option value="Hourly" {{$job->billing_mode == "Hourly" ?'selected':''}}>Hourly</option>
                                                <option value="Weekly" {{$job->billing_mode == "Weekly" ?'selected':''}}>Weekly</option>
                                                <option value="Monthly" {{$job->billing_mode == "Monthly" ?'selected':''}}>Monthly</option>
                                                <option value="Annually" {{$job->billing_mode == "Annually" ?'selected':''}}>Annually</option>
                                            </select>
                                            @if ($errors->has('billing_mode'))
                                            <div class="text-danger">{{ $errors->first('billing_mode') }}</div>
                                            @endif
                                        </div>
                                    </div>-->
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3 ">
                                            <label>Experience Required*</label>
                                            <fieldset>
                                                <div class="input-group mt-1">
                                                    <input class="form-control" type="text" value="{{$job->experience_required}}" name="experience_required">
                                                </div>
                                            </fieldset>
                                            @if ($errors->has('experience_required'))
                                            <div class="text-danger">{{ $errors->first('experience_required') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Job Posted Date*</label>
                                            <input class=" datepicker-here form-control {{ $errors->has('job_posted_date') ? ' has-error' : ''}}" readonly type="text" data-position="top right" placeholder="DD-MM-YYYY" value="{{Carbon\Carbon::parse($job->job_posted_date)->format('d-m-Y') }}" name="job_posted_date">
                                            @if ($errors->has('job_posted_date'))
                                            <div class="text-danger">{{ $errors->first('job_posted_date') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Job Owner*</label>
                                            <select class="form-select {{ $errors->has('job_owner') ? ' has-error' : ''}}" name="job_owner">
                                                <option value="">Select</option>
                                                @foreach ($hr as $hr)
                                                <option value="{{$hr->id}}" {{ $job->job_owner == $hr->id ? 'selected':'' }}>{{ $hr->name}} {{ $hr->last_name}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('job_owner'))
                                            <div class="text-danger">{{ $errors->first('job_owner') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>JD Upload</label>
                                            <input class="form-control  {{ $errors->has('jd_upload') ? ' has-error' : ''}}" type="file" name="jd_upload">
                                            @if ($errors->has('jd_upload'))
                                            <div class="text-danger">{{ $errors->first('jd_upload') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label>Job Description*</label>
                                            <textarea id="editor" type="text" class="form-control  {{ $errors->has('job_description') ? ' has-error' : ''}}" id="exampleFormControlTextarea1" rows="3" name="job_description" value="">{{html_entity_decode ($job->job_description)}}</textarea>
                                            @if ($errors->has('job_description'))
                                            <div class="text-danger">{{ $errors->first('job_description') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="col-form-label">Essential Skills*</label>
                                            <select class="js-example-basic-multiple col-sm-12 form-control {{ $errors->has('essential_skills') ? ' has-error' : ''}}" multiple="multiple" name="essential_skills[]">
                                                @foreach($skill as $skills)
                                                <option value="{{$skills->id}}" @foreach($job->essential_skills as $job_skill){{ ($job_skill == $skills->id) ? 'selected':'' }}@endforeach>{{$skills->skillset}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('essential_skills'))
                                            <div class="text-danger">{{ $errors->first('essential_skills') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="col-form-label">Desirable Skills</label>
                                            <select class="js-example-basic-multiple col-sm-12 form-control" multiple="multiple" name="desirable_skills[]">
                                                @foreach($skill as $skills)
                                                <option value="{{$skills->id}}" @if($job->desirable_skills != null) @foreach($job->desirable_skills as $job_skill){{ ($job_skill == $skills->id) ? 'selected':'' }}@endforeach @endif>{{$skills->skillset}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="text-end"> <button class="btn btn-primary me-3" type="submit" id="btn_submit"> Update </button> <a href="{{route('job.index')}}" class="btn btn-secondary me-3">Cancel</a></div>
                                    </div>
                                </div>
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

<script src="{{asset('assets/js/touchspin/vendors.min.js')}}"></script>
<script src="{{asset('assets/js/touchspin/touchspin.js')}}"></script>
<script src="{{asset('assets/js/touchspin/input-groups.min.js')}}"></script>


<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">


<!-- Script -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

<script>
    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function() {
        $("#project_search").autocomplete({
            source: function(request, response) {

                // Fetch data
                $.ajax({

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('projectfetch')}}",
                    type: 'post',
                    dataType: "json",
                    data: {
                        _token: CSRF_TOKEN,
                        search: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                // Set selection
                $('#project_search').val(ui.item.label); // display the selected text        
                $("#proj_id").attr("value", ui.item.value);
                $('#startDate').val(ui.item.startDate);
                $('#endDate').val(ui.item.endDate);
                // save selected id to input

                return false;
            }
        });

    });
</script>
<script>
    tinymce.init({
        selector: 'textarea#editor',

        plugins: [
            'autolink', 'link', 'image', 'lists', 'charmap', 'preview', 'anchor', 'pagebreak',
            'searchreplace', 'wordcount', 'visualblocks', 'visualchars', 'code', 'fullscreen', 'insertdatetime',
            'media', 'table',
        ],
        toolbar: 'undo redo | styles | bold italic | alignleft aligncenter alignright alignjustify | ' +
            'bullist numlist outdent indent | print preview media fullscreen | ' +
            'forecolor backcolor emoticons | help',
        menubar: 'favs file edit view insert format tools table help',
        content_css: 'css/content.css'
    });
</script>
<script>

$("#btn_submit").click(function(){

  $('#mail_send').append('<div class="loader-wrapper" style="opacity: 0.980147;"><div class="loader"><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-bar"></div><div class="loader-ball"></div></div></div>');
  //alert("The paragraph was clicked.");
});
</script>

<script src="{{asset('assets/js/select2/select2.full.min.js')}}"></script>
<script src="{{asset('assets/js/select2/select2-custom.js')}}"></script>

@endsection