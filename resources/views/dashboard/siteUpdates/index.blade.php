@extends('dashboard.base')

@section('content')

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>{{ __('Site updates') }}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @if(strpos(\Auth::user()->menuroles, 'admin'))
                                    <a href="{{url('/site-updates/create-site-message')}}" class="btn btn-primary m-2">{{ __('Create site message') }}</a>
                                @endif
                            </div>
                            <br>
                            <table class="table table-responsive-sm table-striped">
                                <thead>
                                <tr>
                                    <th>Message</th>
                                    <th>Created at</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($adminUpdates as $adminUpdate)
                                    <tr>
                                        <td>{{$adminUpdate['message']}}</td>
                                        <td>{{date('d-m-Y', strtotime($adminUpdate['created_at']))}}</td>
                                        <td>
                                            @if(strpos(\Auth::user()->menuroles, 'admin'))
                                                <form action="{{url('/site-updates/delete-site-update/'. $adminUpdate['id'])}}" method="POST">
                                                    @method('POST')
                                                    @csrf
                                                    <button class="btn btn-block btn-danger">Delete</button>
                                                </form>
                                            @endif
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

