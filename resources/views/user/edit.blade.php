@extends($layout)
@section("content")
    {!! Form::model($user, ['route' => ['users.update', $user['id']], 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'method' => 'PUT']) !!}
    <div class="page-header">
        <h2>{{ trans('general/label.user_profile') }}</h2>
        <button type="submit" class="btn btn-default btn-lg btn-header">{{ trans('general/label.save') }}</button>
        <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">{{ trans('general/label.back') }}</button>
    </div>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>{{ trans('general/general.whoops') }}</strong> {{ trans('user/auth.access_error') }}<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
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
            {!! Form::hidden('image_hidden', $user['avatar'], ['class' => 'form-control', 'id' => 'image_hidden']) !!}
            {!! Form::file('image', ['class' => 'form-control']) !!}
            <img class="img img-responsive" id="image_url" src="{{ $user['avatar'] }}">
            @if ($errors->has('image'))
                <p class="error-message">{!! $errors->first('image') !!}</p>
            @endif
        </div>
    </div>
    {!! Form::close() !!}
@endsection
