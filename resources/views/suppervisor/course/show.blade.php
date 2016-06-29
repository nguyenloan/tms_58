@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ trans('settings.details_course') }}</h1>
    <h3><strong>{{ trans('settings.name') }} : {{ $course->name }}
    </strong></h3>
    <h3><strong>{{ trans('settings.description') }} : {{ $course->description }}
    </strong></h3>
    <h3><strong>{{ trans('settings.supervisor') }} :
        @foreach($course->users as $user)
            <div class="user" align="left">
                <ul>
                    <li>{{ $user->name }}</li>
                </ul>
            </div>
        @endforeach
    </strong></h3>
    <h3><strong>{{ trans('settings.subject_of_course') }}</strong></h3>
    <table class="table">
        <thead>
            <tr>
                <td>{{ trans('settings.id') }}</td>
                <td>{{ trans('settings.name_subject') }}</td>
                <td>{{ trans('settings.description_subject') }}</td>
            </tr>
        </thead>
        <tbody>
            @foreach($course->subjects as $value)
                <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
