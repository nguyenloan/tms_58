@extends('layout.layout')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h2>{{ trans('general/label.create_daily_report') }}</h2>
                <button class="btn btn-default" id="btn-back">
                    {{ trans('general/label.back') }}
                </button>
                @include('common.error')
                {!! Form::open(['action' => 'Trainee\ReportController@store'],
                    ['class' => 'form-group'])
                !!}
                    <div class="form-group">
                        {!! Form::label('date', trans('general/label.date'), [
                            'class' => 'col-sm-3 control-label'
                        ]) !!}
                        {!! Form::date('date') !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('achievement', trans('general/label.achivement'), [
                            'class' => 'col-sm-3 control-label'
                        ]) !!}
                        {!! Form::textarea('achievement', old('achievement'), [
                            'class' => 'form-control',
                            'rows' => 4
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('next_day_plan', trans('general/label.next_day_plan'), [
                            'class' => 'col-sm-3 control-label'
                        ]) !!}
                        {!! Form::textarea('nextDayPlan', old('nextDayPlan'), [
                            'class' => 'form-control',
                            'rows' => 4
                        ]) !!}
                    </div>
                    <div class="form-group">
                        {!! Form::label('prolem', trans('general/label.problem'), [
                            'class' => 'col-sm-3 control-label'
                        ]) !!}
                        {!! Form::textarea('problem', old('problem'), [
                            'class' => 'form-control',
                            'rows' => 4
                        ]) !!}
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            {!! Form::submit(trans('general/label.save'), [
                                'class' => 'btn btn-info'
                            ]) !!}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection
