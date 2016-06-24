@extends($layout)
@section("content")
    <div class="page-header">
        <h2>{{ trans('user/label.user_profile') }}</h2>
        <button type="button" class="btn btn-default btn-lg btn-header" id="btn-back">{{ trans('user/label.back') }}</button>
    </div>
    <div class="col-sm-2 user-info">
        <img class="img img-responsive user-image" id="image_url" src="{{ $user['avatar'] }}">
        <div class="user-name">{{ $user['name'] }}</div>
    </div>
    <div class="col-sm-8">
        <div class="information">
            <div class="information-label"><strong>{{ trans('user/label.name') }}</strong></div>
            <span>{{ $user['name'] }}</span>
        </div>
        <div class="information">
            <span class="information-label"><strong>{{ trans('user/label.email') }}</strong></span>
            <span>{{ $user['email'] }}</span>
        </div>
    </div>
@endsection
