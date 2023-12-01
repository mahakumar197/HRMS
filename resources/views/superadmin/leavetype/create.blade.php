@extends('layouts.app')

@section('page_title')
<title>Add Leave Type</title>
@endsection

@section('content')

<div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-12 col-sm-6">
                  <h3>{{ __(' Leave Type') }}</h3>
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
                  @if($errors->any())
 
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger dark alert-dismissible fade show" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-down"><path d="M10 15v4a3 3 0 0 0 3 3l4-9V2H5.72a2 2 0 0 0-2 1.7l-1.38 9a2 2 0 0 0 2 2.3zm7-13h2.67A2.31 2.31 0 0 1 22 4v7a2.31 2.31 0 0 1-2.33 2H17"></path></svg>
                      <p> {{$error}}</p>
                      <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                    </div>
                @endforeach

                @endif

    
                @if(Session::has('message'))
                  <div class="alert alert-success dark alert-dismissible fade show" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-thumbs-up"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.7l1.38-9a2 2 0 0 0-2-2.3zM7 22H4a2 2 0 0 1-2-2v-7a2 2 0 0 1 2-2h3"></path></svg>
                      <p> {{session::get('message')}}</p>
                      <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close" data-bs-original-title="" title=""></button>
                  </div>
                @endif

                    <div class="form theme-form projectcreate">
                    <form action="{{url ('leavetype') }}" method="post" autocomplete="off">
                    @csrf 
					          <div class="row">
					            <div class="col-sm-12">
                          <div class="mb-3">
                            <label>{{ __(' Leave Type') }}</label>
                            <input type="text" name="name" value="{{old('name')}}" placeholder="Leave Type*" class="form-control"> 
                             
                          </div>
                        </div>
                      </div>			  		  
				
                      <div class="row">
                        <div class="col">
                          <div class="text-left"> <button  class="btn btn-primary me-3" type="submit"> Add </button></div>
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


