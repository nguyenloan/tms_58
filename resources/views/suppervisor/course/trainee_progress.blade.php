@extends($layout)
@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-11">
                <div class="page-header">
                    <h2>{{ trans('general/label.trainee_progress') }}</h2>
                    <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">
                        {{ trans('general/label.back') }}
                    </button>
                </div>
                <div class="page-content">
                    <div class="trainee-information">
                        <div>
                            <span><b>{{ trans('general/label.total_trainees') }}</b></span>
                            <span class="statistic">{{ $totalTrainee }}</span>
                        </div>
                        <div>
                            <span><b>{{ trans('general/label.completed_trainees') }}</b></span>
                            <span class="statistic">{{ $completed }}</span>
                        </div>
                        <div>
                            <span><b>{{ trans('general/label.training_trainees') }}</b></span>
                            <span class="statistic">{{ $training }}</span>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-responsive table-grid">
                        <thead>
                            <tr>
                                <th>{{ trans('general/label.no') }}</th>
                                <th>{{ trans('general/label.user') }}</th>
                                <th>{{ trans('general/label.progress') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <a href="{{ route('users.show', ['id' => $user['id']]) }}">
                                            {{ $user['name'] }}
                                        </a>
                                    </td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success progress-bar-striped" role="progressbar"
                                                 aria-valuenow="{{ $user['completed'] }}" aria-valuemin="0" aria-valuemax="100" style="{{ 'width:' . $user['completed'] . '%' }}">
                                                {{ trans('general/message.process_bar_percentage', ['percent' => $user['completed']]) }}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $users->render() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

