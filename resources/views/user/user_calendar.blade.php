@extends($layout)

@section("content")
    <div class="col-lg-11">
        <div class="panel panel-default">
            <div class="panel-heading">
                <b>
                    <i>
                        <h1>{{ trans('settings.current_user') }}</h1>
                    </i>
                </b>
            </div>
            <div class="panel-body">
                @foreach($calendarUser as $calendar)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <tr>
                                <th>
                                    <h3><strong>{{ $calendar->name }}</strong></h3>
                                </th>
                                <th>
                                    {{ trans('settings.start') }} {{ $calendar->start_date }}
                                </th>
                                <th>
                                    {{ trans('settings.end') }} {{ $calendar->end_date }}
                                </th>
                            </tr>
                        </div>
                        <div class="panel-body">
                            @foreach ($calendar['subjects'] as $subject)
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>{{ $subject->name }}</th>
                                            <th>{{ $subject->start_date }}</th>
                                            <th>{{ $subject->end_date}}</th>
                                            <th>
                                                @if ($subject->status == config('common.subject.status.start'))
                                                    <a href="{{ route('task', [$subject->id ]) }}"
                                                        class="btn btn-success">{{ trans('settings.training') }}
                                                    </a>
                                                @else
                                                    <a href="{{ route('calendar') }}" class="btn btn-danger">
                                                        {{ trans('settings.finish') }}
                                                    </a>
                                                @endif
                                            </th>
                                        </tr>
                                    </tbody>
                                </table>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
