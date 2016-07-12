@extends('layout.layout')

@section('content')
<div class="grid">
    <div class="page-header">
        <h2>{{ trans('general/label.daily_report') }}</h2><br/>
        <button type="button" class="btn btn-info" id="btn-back">
            {{ trans('general/label.back') }}
        </button>
        <p class="flash alert-info"> {{ $message }}</p>
    </div>
    <div class="page-content">
        <table class="table table-bordered table-striped table-responsive table-grid">
            <thead>
                <tr>
                    <th>{{ trans('general/label.no') }}</th>
                    <th>{{ trans('general/label.id')}}</th>
                    <th>{{ trans('general/label.date') }}</th>
                    <th>{{ trans('general/label.achivement') }}</th>
                    <th>{{ trans('general/label.next_day_plan') }}</th>
                    <th>{{ trans('general/label.problem') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $index => $report)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $report->user_id }}</td>
                        <td>{{ $report->date }}</td>
                        <td>{{ $report->achievement }}</td>
                        <td>{{ $report->next_day_plan }}</td>
                        <td>{{ $report->problem }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {!! $reports->render() !!}
    </div>
</div>
@endsection
