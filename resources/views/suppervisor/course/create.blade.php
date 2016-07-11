@extends('layout.layout')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{ trans('settings.create_course') }}
                    </h3>
                </button>
                </div>
                <div class="panel-body">
                    <div class="page-header">
                        @include('common.error')
                        <p class="flash alert-info"> {{ $message }}</p>
                        <div class="form-group">
                            {!! Form::label('name', trans('settings.name_course'), [
                                'class' => 'col-md-4 control-label'
                            ]) !!}
                            {!! Form::text('name', null, [
                                'class' => 'form-control',
                                'id' => 'name',
                                'placeholder' => trans('settings.name_of_course')
                            ]) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('description', trans('settings.description'), [
                                'class' => 'col-md-4 control-label'
                            ]) !!}
                            {!! Form::text('description', null, [
                                'class' => 'form-control',
                                'id'  => 'description',
                                'placeholder' => trans('settings.description_of_course')
                            ]) !!}
                        </div>
                        <div class="form-group">
                            <h4>{{ trans('general/message.choose_subject') }}</h4>
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
                                            {!! Form::checkbox('selectSubject', $subject->id, null, ['class' => 'select']) !!}
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
                            data-url="{{ route('admin.courses.store') }}"
                            data-redirect="{{ route('admin.courses.index') }}"
                            id="btn-addCourse">
                                {{ trans('general/label.save') }}
                        </button>
                        <button class="btn btn-default" id="btn-back">
                            {{ trans('general/label.back') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
