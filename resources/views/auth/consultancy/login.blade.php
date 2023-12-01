@extends ('layouts.auth1')

@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            
            <div class="login-card flex-column">
            <div class="logo-wrapper"><a href="#"><img class="img-fluid mb-4 text-center" src="{{ asset('assets/css/images/logo/sword-logo.png') }}" style="height: 50px;" alt=""></a></div>
                <form class="theme-form login-form" method="POST" action="{{ route('consultancy.login') }}">
                    @csrf
                    
                    <h4>{{ _('Consultancy Log in') }}</h4>
                    <h6>Welcome back! Log in to your account.</h6>

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
                        <label>{{ __('Password') }}</label>
                        <div class="input-group"><span class="input-group-text"><i class="icon-lock"></i></span>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <span class="input-group-text"><i class="bi bi-eye-slash" id="togglePassword"></i> </span>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" value="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember">{{ __('Remember Me') }}</label>

                        </div>

                        @if (Route::has('password.request'))
                            <a class="link"
                                href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                        @endif

                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" type="submit">{{ __('Login') }}</button>


                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script>
        const togglePassword = document.querySelector("#togglePassword");
        const password = document.querySelector("#password");
        togglePassword.addEventListener("click", function() {
            // toggle the type attribute
            const type = password.getAttribute("type") === "password" ? "text" : "password";
            password.setAttribute("type", type);

            // toggle the icon
            this.classList.toggle("bi-eye");
        });
        /*-------------------------------------------------*/
    </script>
@endsection
