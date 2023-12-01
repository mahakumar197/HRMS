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
                  <h3>
                  Add Desigination</h3>
                </div>
                <div class="col-12 col-sm-6">
                  
                </div>
              </div>
            </div>
          </div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __(' Add Desigination') }}

                <div class="pull-right"><a href="{{url('designation')}}" class="herf">Back</a></div>
                </div>
                
                <div class="card-body">

                @if($errors->any())
 
                  @foreach ($errors->all() as $error)

                  <div class="alert alert-danger" role="alert">

                  {{$error}}
                    
                    </div>

                  @endforeach

                @endif

                     
                @if(Session::has('message'))
                <div class="alert alert alert-success" role="alert">
                   {{session::get('message')}}

</div>
                 @endif


                 
       <form action="{{url ('designation') }}" method="post" autocomplete="off">
           @csrf 
       <lable>Desigination </lable>
       <input type="text" name="designation" value="{{old('name')}}" >      
             

        <button type="submit"> Save </button>
       </form>
     


                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
