@if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>
            {{ trans('general/general.whoops') }}
        </strong>
        {{ trans('general/general.input_errors') }}
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
