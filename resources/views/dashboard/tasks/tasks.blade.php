@extends('dashboard.base')

@section('content')

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i>{{ __('Tasks') }}</div>
                        <div class="card-body">
                            <div class="row">
                                <a href="{{url('/tasks/create-task')}}" class="btn btn-primary m-2">{{ __('Add Task') }}</a>
                            </div>
                            <br>
                            <table class="table table-responsive-sm table-striped">
                                <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Priority</th>
                                    <th>Deadline</th>
                                    <th>Created at</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($tasks as $task)
                                    <tr>
                                        <td>{{$task['title']}}</td>
                                        <td>{{$task['text']}}</td>
                                        <td>
                                            @if($task['priority'] == 1)
                                                <span class="badge bg-success">Normal</span>
                                            @elseif($task['priority'] == 2)
                                                <span class="badge bg-warning">Medium</span>
                                            @elseif($task['priority'] == 3)
                                                <span class="badge bg-danger">High</span>
                                            @endif
                                        </td>
                                        <td>{{!empty($task['deadline']) ? date('d-m-Y', strtotime($task['deadline'])) : '-'}}</td>
                                        <td>{{date('d-m-Y', strtotime($task['created_at']))}}</td>
                                        <td>
                                            <a href="{{ url('/tasks/edit-task/' . $task['id']) }}" class="btn btn-block btn-primary">Edit</a>
                                        </td>
                                        <td>
                                            <form action="{{url('/tasks/delete-task/'. $task['id'])}}" method="POST">
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

