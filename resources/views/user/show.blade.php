@extends($layout)
@section("content")
    <div class="page-header">
        <h2>{{ trans('general/label.user_profile') }}</h2>
        <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">
            {{ trans('general/label.back') }}
        </button>
    </div>
    <div class="col-sm-2 user-info">
        <img class="img img-responsive user-image" id="image_url" src="{{ $user['avatar'] }}">
        <div class="user-name">{{ $user['name'] }}</div>
    </div>
    <div class="col-sm-8">
        <div class="user-information">
            <div>
                <span class="information-label"><strong>{{ trans('general/label.name') }}</strong></span>
                <span>{{ $user['name'] }}</span>
            </div>
            <div>
                <span class="information-label"><strong>{{ trans('general/label.email') }}</strong></span>
                <span>{{ $user['email'] }}</span>
            </div>
            <div>
                <span class="information-label"><strong>{{ trans('settings.current_user') }}</strong></span>
                <a href="{{ route('calendar') }}">{{ trans('settings.link') }}</a>
            </div>
        </div>
        <div class="user-course">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('general/label.courses') }}</div>
                <div class='panel-body'>
                    @if (count($courses))
                        @foreach ($courses as $key => $course)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <a href="{{ route('courses.show', ['id' => $course['course_id']]) }}">
                                        <span class='badge'>{{ $key + 1 }}</span>
                                        <span>{{ $course['name'] }}</span>
                                    </a>
                                    <span>{{ trans('general/label.course_start_date', ['date' => $course['start_date']]) }}</span>
                                </div>
                                <div class='panel-body'>
                                    @if (count($course['subjects']))
                                        @foreach ($course['subjects'] as $subject)
                                            <div class="subject">
                                                <span class="subject-name">{{ $subject['name'] }}</span>
                                                @if ($subject['status'])
                                                    <button class="btn btn-success btn-subject-status">{{ trans('finish') }}</button>
                                                @else
                                                    <a href="{{ route('subjects.show', ['id' => $subject['subject_id']]) }}" class="btn btn-warning btn-subject-status">{{ trans('training') }}</a>
                                                @endif
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @endif
                    {!! $courses->render() !!}
                </div>
            </div>
        </div>
        <div class="user-activity">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('general/label.activities') }}</div>
                <div class='panel-body'>
                    @if (count($activities))
                        @foreach ($activities as $activity)
                            <div class="activity">{{ $activity['description'] }}</div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
