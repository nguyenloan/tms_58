@extends('layout.layout')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-11">
                <div class="page-header">
                    <h2>{{ trans('settings.create_course') }}</h2><br/>
                </div>
                <div class="page-content">
                    @include('common.error')
                    {!! Form::open([
                        'method' => 'POST',
                        'url' => 'admin/courses/'
                    ]) !!}
                        <div class="form-group">
                            {!! Form::label('name', trans('settings.name_course'), [
                                'class' => 'col-md-4 control-label'
                            ]) !!}
                            {!! Form::text('name', null, [
                                'class' => 'form-control'
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', trans('settings.description'), [
                                'class' => 'col-md-4 control-label'
                            ]) !!}
                            {!! Form::text('description', null, [
                                'class' => 'form-control'
                            ]) !!}
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
