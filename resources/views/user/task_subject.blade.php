@extends($layout)

@section('content')
    <div class="col-lg-9">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 class="text-primary">
                    {{ trans('settings.current_user') }}
                </h1>
            </div>
            <div class="panel-body">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong>{{ $subjectTask->name }}</strong>
                    </div>
                    <div class="panel-body">
                        @foreach ($subjectTask->tasks as $value)
                            <table class="table">
                                <tr>
                                    <td>{{ $value->name }}</td>
                                    <td>
                                        @if ($value->status == config('common.task.status.finish'))
                                            <a href="{{ route('calendar') }}" class="btn btn-success">
                                                {{ trans('settings.finish') }}
                                            </a>
                                        @else
                                            <a href="{{ route('users.show', [$userCurrent->id ]) }}" class="btn btn-warning">
                                                {{ trans('settings.training') }}
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

