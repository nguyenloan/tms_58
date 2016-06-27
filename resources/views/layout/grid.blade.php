@extends('layout.layout')
@section("content")
    <div class="grid">
        <div class="page-header">
            @yield('head_content')
            @include('common.message')
            @foreach ($buttons as $key => $button)
                <button type="button"
                @if (!empty($button['manage']))
                    data-manage="{{ route($button['manage']) }}"
                @else
                    data-manage="{{ route('admin.' . $subject . '.index') }}"
                @endif
                @if (isset($button['param']))
                    data-url="{{ route('admin.' . $subject . '.' . $button['url'], ['param' => $button['param']]) }}"
                @else
                    data-url="{{ route('admin.' . $subject . '.' . $button['url']) }}"
                @endif
                data-alert="{{ $button['alert'] }}"
                data-check="{{ $button['check'] }}"
                class="btn btn-default btn-lg btn-header"
                id="btn-{{ $button['name'] }}">
                    {{ trans('general/label.button_name', ['button' => $button['name']]) }}
                </button>
            @endforeach
        </div>
        <div class="page-content">
            <table class="table table-bordered table-striped table-responsive table-grid" id="{{ $subject }}">
                <thead>
                <tr>
                    <th><span class="select-all">{{ trans('general/label.all') }}</span></th>
                    @foreach ($columns as $column)
                        <th>{{ trans("general/label.$column") }}</th>
                    @endforeach
                    <th title="edit">{{ trans('general/label.edit') }}</th>
                    <th title="detail">{{ trans('general/label.detail') }}</th>
                </tr>
                </thead>
                <tbody>
                @if (isset($rows))
                    @foreach ($rows as $key => $row)
                        <tr>
                            <td>
                                {!! Form::checkbox('select', $ids[$key], false, ['class' => 'select']) !!}
                            </td>
                            @foreach ($columns as $column)
                                <td>{{ $row[$column] }}</td>
                            @endforeach
                            <td>
                                <a href="{{ route('admin.' . $subject . '.edit', ['id' => $ids[$key]]) }}" title="edit">
                                    <i class="glyphicon glyphicon-edit"></i>
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.' . $subject . '.show', ['id' => $ids[$key]]) }}" title="edit">
                                    <i class="glyphicon glyphicon-arrow-right"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
            {!! $rows->render() !!}
        </div>
    </div>
@endsection
