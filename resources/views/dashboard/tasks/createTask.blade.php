@extends('dashboard.base')

@section('content')

    <div class="container-fluid">
        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-align-justify"></i> {{ __('Create Task') }}</div>
                        <div class="card-body">
                            <form method="POST" action="/tasks/post-create-task">
                                @csrf
                                @method('POST')
                                <div class="form-group row">
                                    <div class="col">
                                        <label>Title</label>
                                        <input class="form-control" type="text" placeholder="{{ __('Title') }}" name="task-title" required autofocus>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col">
                                        <label>Description</label>
                                        <textarea class="form-control" id="textarea-input" name="task-text" rows="9"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label>Priority</label>
                                        <select class="form-control" name="task-priority">
                                            <option value="1">Normal</option>
                                            <option value="2">Medium</option>
                                            <option value="3">High</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label>Deadline</label>
                                        <input class="form-control" id="date" name="task-deadline" placeholder="DD/MM/YYYY" type="text" />
                                    </div>
                                </div>
                                <button class="btn btn-success" type="submit">{{ __('Save') }}</button>
                                <a href="{{ url('/tasks') }}" class="btn btn-primary">{{ __('Return') }}</a>
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
