@extends($layout)
@section("content")
    <div class="page-header">
        <h2>{{ trans('general/label.subject_information') }}</h2>
        <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">
            {{ trans('general/label.back') }}
        </button>
    </div>
    <div class="page-content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="{{ route('courses.show', ['id' => $subject['course']['id']]) }}">
                    <span>{{ $subject['course']['name'] }}</span>
                </a>
                <i class="glyphicon glyphicon-chevron-right"></i>
                <a href="{{ route('subjects.show', ['id' => $subject['id']]) }}">
                    <span>{{ $subject['name'] }}</span>
                </a>
            </div>
            <div class='panel-body'>
                <div class="subject-description">{{ $subject['description'] }}</div>
                <div class="subject-information">
                    <div class="start_date">{{ trans('general/label.start_date', ['date' => $subject['pivot']['start_date']]) }}</div>
                    @if (!empty($subject->pivot->end_date))
                        <div class="end_date">{{ trans('general/label.end_date', ['date' => $subject->pivot->end_date]) }}</div>
                    @endif
                    @if ($subject['pivot']['status'])
                        <div class="status">{{ trans('general/label.subject_status', ['status' => trans('general/label.completed')]) }}</div>
                    @else
                        <div class="status">{{ trans('general/label.subject_status', ['status' => trans('general/label.training')]) }}</div>
                    @endif
                </div>
                <div class="subject-task">
                    @foreach ($subject['tasks'] as $key => $task)
                        <a href="{{ route('tasks.show', ['id' => $task['id']]) }}">
                            <span class='badge'>{{ $key + 1 }}</span>
                            <span>{{ $task['name'] }}</span>
                            <span>{{ trans('general/label.task_status', ['status' => $task['status']]) }}</span>
                        </a>
                        {!! Form::checkbox($subject['id'], $task->pivot['id']) !!}
                        <br>
                    @endforeach

                    @if (count($subject['tasks']))
                        <button
                            class="btn btn-default"
                            data-check="{{ trans('general/message.alert_update') }}"
                            data-url="{{ route('tasks.ajax-update') }}"
                            id="btn-update-task">{{ trans('general/label.update') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
