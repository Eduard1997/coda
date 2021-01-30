@extends('dashboard.base')

@section('content')

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>{{ __('Received Messages') }}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <a href="{{url('/messages/create-message')}}" class="btn btn-primary m-2">{{ __('Create message') }}</a>
                                <a href="{{url('/messages/view-sent-messages')}}" class="btn btn-primary m-2">{{ __('View sent messages') }}</a>
                            </div>
                            <br>
                            <table class="table table-responsive-sm table-striped">
                                <thead>
                                <tr>
                                    <th>From</th>
                                    <th>Text</th>
                                    <th>Received</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($messages as $message)
                                    <tr>
                                        <td>{{$message['from_user']['name']}}</td>
                                        <td>{{$message['text']}}</td>
                                        <td>{{date('d-m-Y', strtotime($message['created_at']))}}</td>
                                        <td>
                                            <form action="{{url('/messages/delete-message/'. $message['id'])}}" method="POST">
                                                @method('POST')
                                                @csrf
                                                <button class="btn btn-block btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('javascript')

@endsection

