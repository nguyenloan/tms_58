@extends('layout.layout')

@section('content')
<div class="container">
    <h1 class="text-primary">{{ trans('settings.details_course') }}</h1>
    <h3>
        <i>{{ trans('settings.name') }} : {{ $course->name }}</i>
    </h3>
    <h3>
        <i>{{ trans('settings.description') }} : {{ $course->description }}</i>
    </h3>
    <h3>
        <i>{{ trans('settings.supervisor') }}</i>
        @foreach($supervisors as $index => $supervisor)
            <div class="user" align="left">
                <span class='badge'>{{ $index + 1 }}</span>
                <span>{{ $supervisor->name }}</span>
            </div>
        @endforeach
    </h3>
    <h3>
        <i>{{ trans('general/label.trainee') }}</i>
        @foreach($trainees as $index => $trainee)
            <div class="user" align="left">
                <span class='badge'>{{ $index + 1 }}</span>
                <span>{{ $trainee->name }}</span>
            </div>
        @endforeach
    </h3>
    <h3>
        <i>{{ trans('settings.subject_of_course') }}</i>
    </h3>
    <table class="table table-striped table-bordered">
        <thead>
            <tr class="bg-danger">
                <td class="title">{{ trans('settings.id') }}</td>
                <td class="title">{{ trans('settings.name_subject') }}</td>
                <td class="title">{{ trans('settings.description_subject') }}</td>
            </tr>
        </thead>
        <tbody>
            @foreach($course->subjects as $value)
                <tr class="bg-warning">
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
