@extends($layout)
@section("content")
    {!! Form::model($trainee, ['route' => ['admin.trainees.update', $trainee['id']], 'class' => 'form-horizontal', 'enctype' =>"multipart/form-data", 'method' => 'PUT']) !!}
        <div class="page-header">
            <h2>{{ trans('general/label.edit_object', ['object' => 'trainee']) }}</h2>
            <button type="submit" class="btn btn-default btn-lg btn-header">
                {{ trans('general/label.save') }}
            </button>
            <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">
                {{ trans('general/label.back') }}
            </button>
            <button type="button" class="btn btn-default btn-lg btn-header" id="btn-destroy"
                    data-redirect="{{ route('admin.trainees.index') }}"
                    data-url="{{ route('admin.trainees.destroy', ['id' => $trainee['id']]) }}">
                {{ trans('general/label.delete') }}
            </button>
        </div>
        @include('common.error')
        <input type="hidden" name="id" value="{{ $trainee['id'] or '' }}">
        <div class="col-sm-8">
            <div class="form-group">
                {!! Form::label('name', trans('general/label.name'), ['class' => 'control-label col-sm-2 required']) !!}
                <div class="col-sm-9">
                    {!! Form::text('name', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('email', trans('general/label.email'), ['class' => 'control-label col-sm-2 required']) !!}
                <div class="col-sm-9">
                    {!! Form::email('email', null, ['class' => 'form-control', 'readonly' => true]) !!}
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group" id="image-preview">
                {!! Form::label('image', trans('general/label.image'), ['class' => 'control-label']) !!}
                {!! Form::hidden('image_hidden', $trainee['avatar'], ['class' => 'form-control', 'id' => 'image_hidden']) !!}
                {!! Form::file('image', ['class' => 'form-control']) !!}
                <img class="img img-responsive" id="image_url" src="{{ $trainee['avatar'] }}">
                @if ($errors->has('image'))
                    <p class="error-message">{!! $errors->first('image') !!}</p>
                @endif
            </div>
        </div>
    {!! Form::close() !!}
@endsection
