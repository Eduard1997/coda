@extends('dashboard.base')

@section('content')

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> {{ __('Profile Settings') }}</div>
                        <div class="card-body">
                            <form method="POST" action="/profile/update/{{ $user->id }}">
                                @csrf
                                @method('POST')
                                <div class="form-group row">
                                    <div class="col">
                                        <label>Name</label>
                                        <input class="form-control" type="text" placeholder="{{ __('Name') }}" name="user-name" value="{{ $user->name }}" required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col">
                                        <label>Email</label>
                                        <input class="form-control" type="text" placeholder="{{ __('Email') }}" name="user-email" value="{{ $user->email }}" required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col">
                                        <label>Change password</label>
                                        <input class="form-control" type="text" placeholder="{{ __('Password') }}" name="user-password" autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col">
                                        <label>Picture</label>
                                        <input class="form-control" type="file" name="user-picture" required autofocus>
                                    </div>
                                </div>
                                <button class="btn btn-success" type="submit">{{ __('Save') }}</button>
                                <a href="{{ url('/') }}" class="btn btn-primary">{{ __('Return') }}</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')
    <script>
        $(document).ready(function() {
            var options = {
                format: 'dd/mm/yyyy'
            };
            $('#date').datepicker(options);
        });

    </script>
@endsection
