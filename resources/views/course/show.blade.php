@extends($layout)
@section("content")
    <div class="page-header">
        <h2>{{ trans('label.course_information') }}</h2>
        <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">
            {{ trans('label.back') }}
        </button>
    </div>
    <div class="page-content">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a href="{{ route('courses.show', ['id' => $course['id']]) }}">
                    <span>{{ $course['name'] }}</span>
                </a>
            </div>
            <div class='panel-body'>
                <div class="course-description">{{ $course['description'] }}</div>
                <div class="course-subject">
                    @foreach($course['subjects'] as $key => $subject)
                        <a href="{{ route('subjects.show', ['id' => $subject['id']]) }}">
                            <span class='badge'>{{ $key + 1 }}</span>
                            <span>{{ $subject['name'] }}</span>
                        </a><br>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
