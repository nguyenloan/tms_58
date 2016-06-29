@extends('layout.grid')

@section('head_content')
    <h2>
        {{ trans('general/label.manage_object', ['object' => $subject]) }}
    </h2>
@endsection
