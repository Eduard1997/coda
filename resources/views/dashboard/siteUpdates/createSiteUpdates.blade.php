@extends('dashboard.base')

@section('content')

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> {{ __('Create Site Update') }}</div>
                        <div class="card-body">
                            <form method="POST" action="/site-updates/post-create-site-message">
                                @csrf
                                @method('POST')
                                <div class="form-group row">
                                    <div class="col">
                                        <label>Site Message</label>
                                        <input class="form-control" type="text" placeholder="{{ __('Site Message') }}" name="message" required autofocus>
                                    </div>
                                </div>
                                <button class="btn btn-success" type="submit">{{ __('Save') }}</button>
                                <a href="{{ url('/site-updates') }}" class="btn btn-primary">{{ __('Return') }}</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('javascript')

@endsection
