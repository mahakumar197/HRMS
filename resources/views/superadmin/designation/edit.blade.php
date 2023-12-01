@extends('layouts.app')
@section('page_title')
<title>Edit Designation</title>
@endsection

@section('content')

<div class="page-body">
  <div class="container-fluid">
    <div class="page-title">
      <div class="row">
        <div class="col-12 col-sm-6">
          <h3>
            Edit Designation</h3>
        </div>
        <div class="col-12 col-sm-6">

        </div>
      </div>
    </div>
  </div>

  <div class="container-fluid">



    <div class="row">
      <div class="col-sm-8">
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



            <div class="form theme-form projectcreate">
              <form action="{{url ('designation/'.$designation->id) }}" method="post" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="row">
                  <div class="col-sm-12">
                    <div class="mb-3">

                      <lable>Desigination* </lable>
                      <input class="form-control {{ $errors->has('designation') ? ' has-error' : ''}}" type="text" data-language="en" name="designation" value="{{$designation->designation}}">
                      @if ($errors->has('designation'))
                      <div class="text-danger">{{ $errors->first('designation') }}</div>
                      @endif
                    </div>
                  </div>

                  <div class="row">
                    <div class="col">
                      <div class="text-right"><input type="submit" class="btn btn-primary me-3" value="Update"> <a href="{{ route('designation.index') }}" class="btn btn-secondary" type="submit">Cancel</a></div>
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

@endsection