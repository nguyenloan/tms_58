@extends('layout.layout')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-11">
                <div class="page-header">
                    <h2>{{ trans('general/label.detail_subject') }}</h2>
                    <h4>{{ trans('general/label.subject_name') }} {{ $subject['name'] }}</h4>
                    <h4>{{ trans('general/label.subject_description') }} {{ $subject['description'] }}</h4>
                    <p class="flash alert-info"> {{ $message }}</p>
                    <button type="button" class="btn btn-info" id="btn-back">
                        {{ trans('general/label.back') }}
                    </button>
                </div>
                <div class="page-content">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>{{ trans('general/label.no') }}</th>
                                <th>{{ trans('general/label.id') }}</th>
                                <th>{{ trans('general/label.name') }}</th>
                                <th>{{ trans('general/label.description') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($subject['tasks'] as $index => $task)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $task['id'] }}</td>
                                    <td>{{ $task['name'] }}</td>
                                    <td>{{ $task['description'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
