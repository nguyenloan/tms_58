@extends('layout.layout')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h2>{{ trans('general/label.create_subject') }}</h2>
                <button class="btn btn-default" id="btn-back">
                    {{ trans('general/label.back') }}
                </button>
                @include('common.error')
                    {!! Form::open([
                        'method' => 'POST',
                        'url' => 'admin/subjects/',
                        'id' => 'create-subject',
                    ]) !!}
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{ trans('general/label.create_subject') }}</h3>
                        </div>
                        <div class="panel-body">
                        <div class="form-group">
                            {!! Form::text('name', old('name'), [
                                'class' => 'form-control',
                                'placeholder' => trans('general/label.name_placeholder')
                            ]) !!}
                        </div>
                            <div class="form-group">
                                {!! Form::textarea ('description', old('description'), [
                                    'class' => 'form-control',
                                    'placeholder' => trans('general/label.description_placeholder'),
                                    'rows' => 4
                                ]) !!}
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">{{ trans('general/label.create_task') }}</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                {!! Form::hidden('optionCount', 1, ['id' => 'option-count']) !!}
                                <div class="col-md-10" id="option-wrap">
                                    {!! Form::text('name-0', null, [
                                        'class' => 'form-control task-name',
                                        'placeholder' => trans('general/label.name_placeholder'),
                                        'id' => 'name-0',
                                    ]) !!}
                                    {!! Form::text('description-0', null, [
                                        'class' => 'form-control task-description',
                                        'placeholder' => trans('general/label.description_placeholder'),
                                        'id' => 'description-0',
                                    ]) !!}
                                    <button type="button" class="btn btn-info task-remove" id="remove-0">
                                        {{ trans('general/label.remove_option') }}
                                    </button>
                                </div>
                            </div>
                            <div class="form-group hidden">
                                <div class="col-md-10">
                                    <input class="form-control task-name" placeholder="{{ trans('general/label.name_placeholder') }}" type="text">
                                    <input class="form-control task-description" placeholder="{{ trans('general/label.description_placeholder') }}" type="text">
                                    <button type="button" class = "btn btn-info task-remove">
                                        {{ trans('general/label.remove_option') }}
                                    </button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-info new-option" id="new-option">
                                {{ trans('general/label.new_option') }}
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::submit(trans('general/label.save'), [
                            'class' => 'btn btn-info btn-save'
                        ]) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
