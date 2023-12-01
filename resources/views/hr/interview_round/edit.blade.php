@extends('layouts.app')

@section('page_title')
<title>Interview Round</title>
@endsection

@section('content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Edit Interview Round</h3>
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
                                            <form action="{{url('interview-round/'.$interview_round->id)}}" method="post" id='skill' autocomplete="off">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="mb-3">
                                                            <label>Job Position*</label>
                                                            <input type="text" name="round_name" value="{{$interview_round->round_name}}" placeholder="Job Position" class="form-control {{ $errors->has('round_name') ? ' has-error' : ''}}">
                                                            @if ($errors->has('round_name'))
                                                            <div class="text-danger">{{ $errors->first('round_name') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>


                                                    <div class="col-sm-12">
                                                        <div class="mb-3">
                                                            <label>Feedback Template*</label>
                                                            <select class="form-select" name="feedback_template" id="feedback_template">
                                                                <option value="">Select</option>
                                                                <option value="0" {{$interview_round->feedback_template == '0'  ?'selected ':'' }}>Common Template</option>
                                                                <option value="1" {{$interview_round->feedback_template == '1'  ?'selected ':'' }}>HR Template</option>
                                                                <option value="2" {{$interview_round->feedback_template == '2'  ?'selected ':'' }}>Tech Template</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="text-end"> <button class="btn btn-primary me-3" type="submit" id="btn-save">Update</button>
                                                            <a href="{{url('/interview-round')}}" class="btn btn-secondary me-3">Cancel</a>

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