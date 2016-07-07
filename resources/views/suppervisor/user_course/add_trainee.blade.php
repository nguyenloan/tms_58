@extends('layout.layout')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        {{ trans('general/label.add_trainee') }}
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="page-header">
                        @include('common.error')
                        <p class="flash alert-info"> {{ $message }}</p>
                        <h4>{{ trans('general/label.name') }}
                        {{ $course->name }}</h4>
                        <h4>{{ trans('general/label.description') }}
                        {{ $course->description }}</h4>
                    </div>
                    <div class="page-content">
                        <table class="table table-bordered table-striped ">
                            <thead>
                                <tr>
                                    <th><span class="select-all">{{ trans('general/label.all') }}</span></th>
                                    <th>{{ trans('general/label.id') }}</th>
                                    <th>{{ trans('general/label.name') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listTrainees as $trainee)
                                <tr>
                                    <td>
                                        {!! Form::checkbox('selectTrainee', $trainee->id, null, ['class' => 'select']) !!}
                                    </td>
                                    <td>{{ $trainee->id }}</td>
                                    <td>{{ $trainee->name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $listTrainees->render() !!}
                        <button
                            class="btn btn-info"
                            data-check="{{ trans('general/message.alert_add_trainee') }}"
                            data-url="{{ route('admin.userCourses.store') }}"
                            data-redirect="{{ route('admin.courses.index') }}"
                            id="btn-addTrainee">
                                {{ trans('general/label.add_trainee') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
