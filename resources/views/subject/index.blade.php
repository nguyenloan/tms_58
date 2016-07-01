@extends($layout)
@section("content")
    <div class="page-header">
        <h2>{{ trans('label.courses') }}</h2>
    </div>
    <div class="page-content">
        @foreach ($rows as $key => $row)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="{{ route('courses.show', ['id' => $ids[$key]]) }}">
                        <span class='badge'>{{ $key + 1 }}</span>
                        <span>{{ $row['name'] }}</span>
                    </a>
                </div>
                <div class='panel-body'>
                    {{ $row['description'] }}
                </div>
            </div>
        @endforeach
        {!! $rows->render() !!}
    </div>
@endsection
