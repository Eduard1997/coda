@extends('dashboard.base')

@section('content')

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> {{ __('Create Message') }}</div>
                        <div class="card-body">
                            <form method="POST" action="/messages/post-create-message">
                                @csrf
                                @method('POST')
                                <div class="form-group row">
                                    <div class="col">
                                        <label>Text</label>
                                        <input class="form-control" type="text" placeholder="{{ __('Message') }}" name="message-text" required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col">
                                        <label>Receiver</label>
                                        <select name="to_user" class="form-control">
                                            @foreach($users as $user)
                                                <option value="{{$user['id']}}">{{$user['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button class="btn btn-success" type="submit">{{ __('Send') }}</button>
                                <a href="{{ url('/messages') }}" class="btn btn-primary">{{ __('Return') }}</a>
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
