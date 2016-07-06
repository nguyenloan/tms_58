@extends($layout)
@section("content")
    {!! Form::open(['route' => 'admin.trainees.store', 'class' => 'form-horizontal', 'method' => 'POST']) !!}
        <div class="page-header">
            <h2>{{ trans('general/label.create_object', ['object' => 'trainee']) }}</h2>
            <button type="submit" class="btn btn-default btn-lg btn-header">{{ trans('general/label.save') }}</button>
            <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">{{ trans('general/label.back') }}</button>
        </div>
        @include('common.error')
        <div class="col-sm-8">
            <div class="form-group">
                {!! Form::label('name', trans('general/label.name'), ['class' => 'control-label col-sm-2 required']) !!}
                <div class="col-sm-9">
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('name', trans('general/label.email'), ['class' => 'control-label col-sm-2 required']) !!}
                <div class="col-md-9">
                    {!! Form::email('email', old('email'), ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('password', trans('general/label.password'), ['class' => 'control-label col-sm-2 required']) !!}
                <div class="col-md-9">
                    {!! Form::password('password', ['class' => 'form-control', 'required' => true]) !!}
                </div>
            </div>
        </div>
    {!! Form::close() !!}
@endsection
