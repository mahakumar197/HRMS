@extends('layouts.app')

@section('page_title')
<title>New Job Referral</title>
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
                    <div class="card-body  b-l-primary">                 
                                
                        <div class="media"> 
                            <div class="media-body px-2">
                                <h3 class="f-w-600 fs-4">Do You Have Any Referral?</h3>
                            </div>
                            <div class="text-end"> 
                                <a href="{{url('/cancreate/'.$job->id)}}" class="btn btn-primary me-3" type="submit" name="ack" value="1"> Create Candidate </a>                                
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
                            
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label class="col-form-label">Position Name*</label>
                                             
                                            <input class="form-control " type="text"  value="{{$job->position->position_name}}"  disabled>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Project*</label>
                                            <div class="form-group">
                                                <input type="text" name="dummy" value='{{$job->project->project_name}}'  class="  form-control input-lg" disabled />
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Canditate Type*</label>
                                            <input type="text" name="dummy" value='{{$job->canditate_type}}'  class="  form-control input-lg" disabled />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Location*</label>
                                            <input class="form-control  " type="text"    value="{{$job->location}}" disabled  >
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Job Type*</label>
                                            
                                             <input class="form-control  " type="text"    value="{{$job->job_type->job_type}}" disabled  >
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3 bootstrap-touchspin">
                                            <label>Headcount*</label>
                                            <input class="form-control  " type="text"    value="{{$job->headcount}}" disabled  >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Minimum Salary*</label>
                                          
                                            <input class="form-control  " type="text"    value="{{$job->minimum_salary}}" disabled  >
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Maximum Salary*</label>
                                            <input class=" form-control " type="number" value="{{$job->maximum_salary}}"disabled >
                                           
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Currency*</label>
                                            <input class=" form-control " type="number" value="{{$job->currency}}" disabled >
                                           
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Billing Mode*</label>
                                            <input class=" form-control " type="number" value="{{$job->billing_mode}}" disabled >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3 bootstrap-touchspin">
                                            <label>Experience Required*</label>
                                            <input class=" form-control " type="number" value="{{$job->experience_required}}" disabled > 
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Importance*</label>
                                            <input class=" form-control " type="number" value="{{$job->importance}}" disabled >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <label>Job Posted Date*</label>
                                            <input class=" form-control " type="number" value="{{$job->job_posted_date}}" disabled >
                                            
                                        </div>
                                    </div>
                                     
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="mb-3">
                                            <label>Job Description*</label>
                                            <textarea class="form-control " rows="3" name="job_description" disabled >{{$job->job_description}}</textarea>
                                           
                                        </div>
                                    </div>
                                </div>
                               
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
@endsection