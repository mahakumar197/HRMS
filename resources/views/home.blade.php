@extends('layouts.app')

@section('content')
<div class="page-body">
          <div class="container-fluid">
            <div class="page-title">
              <div class="row">
                <div class="col-12 col-sm-6">
                  <h3>{{ __(' Dashboard') }}</h3>
                </div>
             
              </div>
            </div>
          </div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                   
                    @if(Auth::user()->role == 'supar_admin')
                     
                     <h1> Welcome Super admin </h1>
                     @elseif(Auth::user()->role == 'project_manager')

                     <h1> Welcome Admin </h1>
                     @else

                     <h1> Welcome Employee </h1>

                     @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>

</div>
@endsection
