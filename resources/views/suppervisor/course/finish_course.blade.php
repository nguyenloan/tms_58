@extends('layout.layout')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-11">
                <div class="page-header">
                    <button type="button" class="btn btn-info btn-header" id="btn-back">
                        {{ trans('general/label.back') }}
                    </button>
                    <button
                        class="btn btn-info btn-header"
                        data-check="{{ trans('general/message.alert_add_trainee') }}"
                        data-url="{{ route('admin.courses.putFinishCourse', ['id' => $course->id]) }}"
                        id="btn-finish">
                            {{ trans('general/label.finish_course') }}
                    </button>
                    <h2>{{ trans('general/label.finish_course') }}</h2>
                    <h4>{{ trans('general/label.course_name') }} {{ $course->name }}</h4>
                    <h4>{{ trans('general/label.course_description') }} {{ $course->description }}</h4>
                    <p class="flash alert-info"> {{ $message }}</p>
                </div>
                <div class="page-content">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><span class="select-all">{{ trans('general/label.all') }}</span></th>
                                <th>{{ trans('general/label.name') }}</th>
                                <th>{{ trans('general/label.role') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{!! Form::checkbox('selectUser', $user->id, null, ['class' => 'select']) !!}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->role }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
