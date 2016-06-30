@extends($layout)
@section("content")
    <div class="page-header">
        <h2>{{ trans('general/label.task_information') }}</h2>
        <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">
            {{ trans('general/label.back') }}
        </button>
    </div>
    <div class="page-content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="{{ route('tasks.show', ['id' => $task['id']]) }}">
                    <span>{{ $task['name'] }}</span>
                </a>
            </div>
            <div class='panel-body'>
                <div class="task-description">{{ $task['description'] }}</div>
                <a class="btn btn-default" href="{{ route('tasks.update', ['id' => $task['id']]) }}">
                    {{ trans('general/label.finish') }}
                </a>
            </div>
        </div>
    </div>
@endsection
