@extends('layouts.app')
@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-12 col-sm-6">

                    </div>

                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="edit-profile">
                <div class="row justify-content-center">
                    <div class="col-xl-4">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h4 class="card-title mb-0">Change Password</h4>
                                <div class="card-options"><a class="card-options-collapse" href="#"
                                        data-bs-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a><a
                                        class="card-options-remove" href="#" data-bs-toggle="card-remove"><i
                                            class="fe fe-x"></i></a></div>
                            </div>
                            <div class="card-body">

                                <div class="row mb-2">
                                    <div class="profile-title">
                                        <div class="media"><img class="img-70 rounded-circle" alt=""
                                                src="image/{{Auth::user()->image_path}}">
                                            <div class="media-body">
                                                <h3 class="mb-1 f-20 txt-primary text-capitalize">{{ Auth::user()->name }}
                                                </h3>
                                                <p class="f-12 text-capitalize">
                                                    {{ Auth::user()->designation->designation }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Email-Address:
                                        <span>{{ Auth::user()->email }}</span></label>
                                </div>
                                <form method="POST" action="{{ route('change.password') }}">
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
                                        <input id="password" type="password" class="form-control" name="current_password"
                                            autocomplete="current-password">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">New Password</label>
                                        <input id="new_password" type="password" class="form-control" name="new_password"
                                            autocomplete="current-password">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Confirm New Password</label>
                                        <input id="new_confirm_password" type="password" class="form-control"
                                            name="new_confirm_password" autocomplete="current-password">
                                    </div>
                                    <div class="form-footer">
                                        <button class="btn btn-primary btn-block" type="submit"> Update Password </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
