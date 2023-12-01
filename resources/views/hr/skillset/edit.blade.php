@extends('layouts.app')

@section('page_title')
<title>Skillset</title>
@endsection

@section('content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Edit Skillset</h3>
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
                                            <form action="{{url('skillset/'.$skillset->id)}}" method="post" id='skill' autocomplete="off">
                                                @csrf
                                                @method('PUT')
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="mb-3">
                                                            <label>Job Position*</label>
                                                            <input type="text" name="skillset" value="{{$skillset->skillset}}" placeholder="Job Position" class="form-control {{ $errors->has('skillset') ? ' has-error' : ''}}">
                                                            @if ($errors->has('skillset'))
                                                            <div class="text-danger">{{ $errors->first('skillset') }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="text-end"> <button class="btn btn-primary me-3" type="submit" id="btn-save">Update</button>
                                                            <a href="{{url('/skillset')}}" class="btn btn-secondary me-3">Cancel</a>
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