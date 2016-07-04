@extends($layout)
@section("content")
    <div class="page-header">
        <h2>{{ trans('general/label.course_trainee', ['course' => $course['name']]) }}</h2>
        <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">
            {{ trans('general/label.back') }}
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
                <div class="trainees">
                    @foreach($course['trainees'] as $trainee)
                        <div class="trainees">{{ $trainee['name'] }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
