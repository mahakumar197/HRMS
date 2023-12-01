@extends('layouts.auth1')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="login-card">
                <form class="theme-form login-form" method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <h4>{{ __('Reset Password') }}</h4>
                    <h6>Hi! Enter your registered email address to change your account password.</h6>
                    <form method="POST" action="/forgot-password">
                        <div class="form-group">
                            <label>{{ __('E-Mail Address') }}</label>
                            <div class="input-group"><span class="input-group-text"><i class="icon-email"></i></span>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block"
                                type="submit">{{ __('Email Password Reset Link') }}</button>
                        </div>

                        <p>Already have an password?<a class="ms-2" href="{{ route('login') }}">Sign in</a></p>
                    </form>


            </div>

        </div>
    </div>
@endsection
