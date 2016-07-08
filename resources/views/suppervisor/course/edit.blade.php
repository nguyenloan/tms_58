@extends('layout.layout')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h2>{{ trans('settings.edit_course') }}</h2>
                    <a href="{{ route('admin.courses.trainee-progress', ['id' => $course->id]) }}" class="btn btn-default btn-lg btn-header" id="trainee-progress">
                        {{ trans('general/label.trainee_progress') }}
                    </a>
                    <button type="submit" class="btn btn-default btn-lg btn-header">
                        {{ trans('general/label.save') }}
                    </button>
                    <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">
                        {{ trans('general/label.back') }}
                    </button>
                </div>
                <div class="page-content">
                    @include('common.error')
                    {!! Form::open([
                        'method' => 'PUT',
                        'route' => ['admin.courses.update', $course->id]
                    ]) !!}
                        <div class="form-group">
                            {!! Form::label('name', trans('settings.name_course'), [
                                'class' => 'col-md-4 control-label'
                            ]) !!}
                            {!! Form::text('name', $course->name, [
                                'class' => 'form-control',
                                'id' => 'name',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', trans('settings.description'), [
                                'class' => 'col-md-4 control-label'
                            ]) !!}
                            {!! Form::text('description', $course->description, [
                                'class' => 'form-control',
                                'id' => 'description'
                            ]) !!}
                            {!! Form::hidden('subjectIds', $subjectIds, ['id' => 'subjectIds']) !!}
                        </div>
                        <div class="form-group">
                            {!! link_to_action('Suppervisor\CourseController@addSuppervisor',
                                    trans('settings.add_suppervisor'),
                                    [$course->id]
                            ) !!}<br/>
                            {!! link_to_action('Suppervisor\UserCourseController@create',
                                    trans('general/label.add_trainee'),[]
                            ) !!}
                        </div>
                        <div class="form-group">
                            <h4>{{ trans('general/message.edit_subject') }}</h4>
                        </div>
                    </div>
                    <div class="page-content">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><span class="select-all">{{ trans('general/label.all') }}</span></th>
                                    <th>{{ trans('general/label.id') }}</th>
                                    <th>{{ trans('general/label.name') }}</th>
                                    <th>{{ trans('general/label.description') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($subjects as $subject)
                                <tr>
                                    <td>
                                    @if (in_array($subject->id, $subjectIds->toArray()))
                                        {!! Form::checkbox('selectSubject', $subject->id, true, ['class' => 'select']) !!}
                                    @else
                                        {!! Form::checkbox('selectSubject', $subject->id, false, ['class' => 'select']) !!}
                                    @endif
                                    </td>
                                    <td>{{ $subject->id }}</td>
                                    <td>{{ $subject->name }}</td>
                                    <td>{{ $subject->description }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $subjects->render() !!}
                    </div>
                    <div class="row">
                        <button
                            class="btn btn-info"
                            data-check="{{ trans('general/message.alert_add_subject') }}"
                            data-url="{{ route('admin.courses.update', ['id' => $course->id]) }}"
                            data-redirect="{{ route('admin.courses.index') }}"
                            id="btn-editCourse">
                                {{ trans('general/label.save') }}
                        </button>
                        <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">
                            {{ trans('general/label.back') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

