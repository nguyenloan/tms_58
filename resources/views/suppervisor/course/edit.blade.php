@extends('layout.layout')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-11">
                <div class="page-header">
                    <h2>{{ trans('settings.edit_course') }}</h2><br/>
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
                                'class' => 'form-control'
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', trans('settings.description'), [
                                'class' => 'col-md-4 control-label'
                            ]) !!}
                            {!! Form::text('description', $course->description, [
                                'class' => 'form-control',
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit(trans('settings.save'), [
                                'class' => 'btn btn-info'
                            ]) !!}
                            {!! link_to_action('Suppervisor\CourseController@addSuppervisor',
                                    trans('settings.add_suppervisor'),
                                    [$course->id],
                                    ['class' => 'btn btn-info']
                            ) !!}
                            {!! link_to_action('Suppervisor\UserCourseController@create',
                                    trans('general/label.add_trainee'),[],
                                    ['class' => 'btn btn-info']
                            ) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

