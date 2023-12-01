@extends('layouts.app')

@section('page_title')
<title>Give Your Feedback</title>
@endsection

@section('content')

<div class="page-body">
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <h3>Give Your Feedback</h3>
                </div>
                <div class="col-12 col-sm-6">

                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-8">

                @if(Session::has('message'))
                <div class="alert alert alert-success" role="alert">
                    {{session::get('message')}}

                </div>
                @endif
                <div class="col-sm-12">
                    <div class="card">
                       
                      <div class="card-body">
                        <form class="theme-form" action="{{url ('feedback') }}" method="POST" id="feedback" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="inputEmail3">Email</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" id="email" type="email" value="{{Auth::user()->email}}" name="email">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" >Date</label>
                                    <div class="col-sm-9">
                                        <input class="datepicker-here form-control digits {{ $errors->has('holidaydate') ? ' has-error' : ''}}" data-date-format="dd-mm-yyyy" placeholder="DD-MM-YYYY" data-position="bottom right" type="text" data-language="en" name="feedbackdate">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="inputPassword3">Here is my</label>
                                    <div class="col-sm-9">
                                        <select class="form-select {{ $errors->has('hereismy') ? ' has-error' : ''}}" name="hereismy">
                                            <option value="">Select</option>
                                            <option value="Feedback">Feedback</option>
                                            <option value="Suggestion">Suggestion</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="inputPassword3">It is regarding</label>
                                    <div class="col-sm-9">
                                        <select class="form-select {{ $errors->has('regarding') ? ' has-error' : ''}}" name="regarding">
                                            <option value="">Select</option>
                                            <option value="General">General</option>
                                            <option value="Project">Project</option>
                                            <option value="Finance">Finance</option>
                                            <option value="HR">HR</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-3 col-form-label" for="inputPassword3">Description</label>
                                    <div class="col-sm-9">
                                    <textarea class="form-control  {{ $errors->has('description') ? ' has-error' : ''}}" id="exampleFormControlTextarea1" rows="3" name="description">{{old('skill_set')}}</textarea>
                                    </div>
                                </div>

                                
                                   <div class="mb-3 row">
                                       <label class="col-sm-3 col-form-label">Image</label>
                                       <div class="col-sm-9">
                                        <input class="form-control " type="file" name="image">
                                        </div>                
                              </div>
                   

                                <div class="row mb-0">
                                    <label class="col-sm-3 col-form-label pb-0">Post As </label>
                                    <div class="col-sm-9">
                                        <div class="mb-0">
                                            <div class="form-check form-check-inline checkbox checkbox-primary">
                                                <input class="form-check-input" id="anonymous" type="checkbox">
                                                <label class="form-check-label" for="anonymous">Anonymous</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                             
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-primary" type="submit">Submit</button>
                            <a href="{{route('feedback.index')}}" class="btn btn-secondary">Cancel</a>
                            <button onclick="resetForm()" class="btn btn-danger">Reset</button>                            
                        </div>
                                </form>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
</div>


@endsection

@section('script')
<script>
    function resetForm() {
      document.getElementById("feedback").reset();
    }
  </script>

<script>
  function setBillingAddress() {
    if ($("#anonymous").is(":checked")) {
      $('#email').val('anonymous@swordgroup.in');
      $('#email').attr('readonly', 'readonly');
      
      
    } else {
      $('#email').removeAttr('readonly');
      $('#email').val('{{Auth::user()->email}}');
      
    }  
  }

  $('#anonymous').click(function() {
    setBillingAddress();
  })
</script>
@endsection