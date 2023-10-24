@extends('backend.app')
@section('title','Change Password')
@push('css')
@endpush
@section('main_menu','HOME')
@section('active_menu','Change Password')
@section('link',route('admin.dynamic_route'))
@section('content')

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="card">

                    <div class="card-header">Change Your Password</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.password/save_change_password') }}">
                            @csrf
                            <div class="form-group row">
                                <label for="current_password" class="col-md-4 col-form-label text-md-right">Current Password</label>
                                <div class="col-md-6">
                                    <input id="current_password" type="password" class="form-control" name="current_password"
                                           autocomplete="current-password">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password"
                                           autocomplete="current-password">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">New Confirm
                                    Password</label>
                                <div class="col-md-6">
                                    <input id="password_confirmation" type="password" class="form-control"
                                           name="password_confirmation" autocomplete="password_confirmation">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update Password
                                    </button>
                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
@push('js')
@endpush
