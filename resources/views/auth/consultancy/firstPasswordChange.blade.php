@extends('layouts.auth1')

@section('content')

    <!-- Container-fluid starts-->
    <div class="row">
        <div class="col-12">
            <div class="login-card">
                <form class="theme-form login-form" method="POST" action="{{ route('consultancy.First-Password-Change') }}">
                    @csrf

                    <h4>{{ _('Change Password') }}</h4>
                    <h6>Welcome back! Log in to your account.</h6>

                    @csrf

                    @foreach ($errors->all() as $error)
                    <p class="text-danger">{{ $error }}</p>
                    @endforeach

                    @if (Session::has('message2'))
                    <div class="alert alert alert-success" role="alert">
                        {{ session::get('message2') }}

                    </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">
                    </div>
                    <div class="form-footer">
                        <button class="btn btn-primary btn-block" type="submit"> Change Password </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    @endsection