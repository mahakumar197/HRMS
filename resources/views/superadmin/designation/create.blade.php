@extends('layouts.app')

@section('page_title')
<title>Add Designation</title>
@endsection

@section('content')

<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-sm-6">
          <h3>{{ __(' Add Designation') }}</h3>
        </div>
        <div class="col-12 col-sm-6">

        </div>
      </div>
    </div>
  </div>
  <!-- Container-fluid starts-->
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-8">
        <div class="card">
          <div class="card-body">
       


            @if(Session::has('message'))
            <div class="alert alert-success dark alert-dismissible fade show" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up">
                <path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path>
              </svg>
              <p> {{session::get('message')}}</p>
              <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
            </div>
            @endif

            <div class="form theme-form projectcreate">
              <form action="{{url ('designation') }}" method="post" id='desig' autocomplete="off"> 
                @csrf
                <div class="row">
                  <div class="col-sm-12">
                    <div class="mb-3">
                      <label>{{ __('Designation*') }}</label>
                      <input type="text" name="designation" value="{{old('name')}}" placeholder="Designation" class="form-control {{ $errors->has('designation') ? ' has-error' : ''}}">
                      @if ($errors->has('designation'))
                      <div class="text-danger">{{ $errors->first('designation') }}</div>
                      @endif
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col">
                    <div class="text-left"> <button class="btn btn-primary me-3" type="submit"> Add </button><a onclick="resetForm()" class="btn btn-danger me-3">Reset</a> <a href="{{ route('designation.index') }}" class="btn btn-secondary" type="submit">Cancel</a></div>
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
<!-- footer start-->
@endsection

@section('script')
<script>
  function resetForm() {
    document.getElementById("desig").reset();
  }
</script>
@endsection