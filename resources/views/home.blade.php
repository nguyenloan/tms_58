@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('settings.title') }}
                </div>
                <div class="panel-body">
                    {{ trans('settings.you_are_login') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
