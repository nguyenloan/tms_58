@extends('layout.layout')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-11">
                <div class="page-header">
                    <h2>{{ trans('general/label.create_subject') }}</h2><br/>
                </div>
                <div class="page-content">
                    @include('common.error')
                    {!! Form::open([
                        'method' => 'POST',
                        'url' => 'admin/subjects/'
                    ]) !!}
                        <div class="form-group">
                            {!! Form::label('name', trans('general/label.name'), [
                                'class' => 'col-md-4 control-label'
                            ]) !!}
                            {!! Form::text('name', null, [
                                'class' => 'form-control',
                                'placeholder' => trans('general/label.name_placeholder')
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', trans('general/label.description'), [
                                'class' => 'col-md-4 control-label'
                            ]) !!}
                            {!! Form::text('description', null, [
                                'class' => 'form-control',
                                'placeholder' => trans('general/label.description_placeholder')
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit(trans('general/label.save'), [
                                'class' => 'btn btn-info'
                            ]) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
