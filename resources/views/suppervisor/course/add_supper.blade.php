@extends('layout.layout')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-11">
                <div class="page-header">
                    <h2>{{ trans('settings.add_suppervisor') }}</h2><br/>
                </div>
                <div class="page-content">
                    @include('common.error')
                    {!! Form::open([
                        'method' => 'POST',
                        'url' => 'admin/courses/addSuppervisor'
                    ]) !!}
                        <div class="form-group">
                            {!! Form::label('user_id', trans('settings.name'), [
                                'class' => 'col-md-4 control-label'
                            ]) !!}
                            {!! Form::select('user_id', $suppervisor, null, ['class' => 'form-control']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::hidden('course_id', $course->id) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit(trans('settings.save'), [
                                'class' => 'btn btn-success'
                            ]) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

