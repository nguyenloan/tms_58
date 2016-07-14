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
                <a href="{{ route('courses.show', ['id' => $task['course']['id']]) }}">
                    <span>{{ $task['course']['name'] }}</span>
                </a>
                <i class="glyphicon glyphicon-chevron-right"></i>
                <a href="{{ route('subjects.show', ['id' => $task['subject']['id']]) }}">
                    <span>{{ $task['subject']['name'] }}</span>
                </a>
                <i class="glyphicon glyphicon-chevron-right"></i>
                <a href="{{ route('tasks.show', ['id' => $task['id']]) }}">
                    <span>{{ $task['name'] }}</span>
                </a>
            </div>
            <div class='panel-body'>
                <div class="task-description">{{ $task['description'] }}</div>
                {!! Form::open(['route' => ['tasks.update', $task['id']], 'class' => 'form-horizontal', 'method' => 'PUT']) !!}
                    {!! Form::hidden('id', $task['id']) !!}
                    {!! Form::submit(trans('general/label.finish'), ['class' => 'btn btn-default']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
