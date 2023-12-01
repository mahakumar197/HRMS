@extends('layouts.report')

@section('page_title')
<title>Job Position</title>
@endsection

@section('content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Edit Job Position</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="email-wrap">
            <div class="row">
                <div class="col-xl-4 box-col-4 col-md-6 xl-30">
                    <div class="email-sidebar"><a class="btn btn-primary email-aside-toggle" href="javascript:void(0)">email filter</a>
                        <div class="email-left-aside">
                            <div class="card">
                                <div class="card-body">
                                    <div class="email-app-sidebar">
                                        @if(Session::has('message'))
                                        <div class="alert alert-success dark alert-dismissible fade show" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up">
                                                <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
                                            </svg>
                                            <p> {{session::get('message')}}</p>
                                            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                                        </div>
                                        @endif

                                        <div class="form theme-form projectcreate">
                                            <form action="{{url('job-position/'.$job_position->id)}}" method="post" id='job_pos' autocomplete="off">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="mb-3">
                                                            <label>Job Position*</label>
                                                            <input type="text" id="position" name="position_name" value="{{$job_position->position_name}}" placeholder="Job Position" class="form-control {{ $errors->has('position_name') ? ' has-error' : ''}}">
                                                            @if ($errors->has('position_name'))
                                                            <div class="text-danger">{{ $errors->first('position_name') }}</div>
                                                            @endif
                                                        </div>
                                                        <div class="mb-3">
                                                            <label>Status*</label>
                                                            <select id="status" class="form-select {{ $errors->has('status') ? ' has-error' : ''}}" name="status">
                                                                <option value="">Select</option>
                                                                <option value="1" {{$job_position->status == '1' ?'selected':''}}>Active</option>
                                                                <option value="0" {{$job_position->status == '0' ?'selected':''}}>InActive</option>
                                                            </select>
                                                            @if ($errors->has('status'))
                                                            <div class="text-danger">{{ $errors->first('status') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="text-end"> <button class="btn btn-primary me-3" type="submit" id="btn-save">Update</button>                                                        
                                                        <a href="{{url('/job-position')}}" class="btn btn-secondary me-3">Cancel</a>
                                                        <a onclick="resetForm()" class="btn btn-danger me-3">Reset</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
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
<script>
    function resetForm() {
        document.getElementById("job_pos").reset();
    }
</script>

@endsection