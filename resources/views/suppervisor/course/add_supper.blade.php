@extends('layout.layout')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-11">
                <div class="page-header">
                    <h2>{{ trans('settings.add_suppervisor') }}</h2><br/>
                </div>
                <div class="page-content">
                    @include('common.error')
                    {!! Form::open([
                        'method' => 'POST',
                        'url' => 'admin/courses/addSuppervisor'
                    ]) !!}
                        <div class="form-group">
                            <table class="table table-bordered table-striped ">
                                <thead>
                                    <tr>
                                        <th><span class="select-all">{{ trans('general/label.all') }}</span></th>
                                        <th>{{ trans('settings.id') }}</th>
                                        <th>{{ trans('settings.name') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($suppervisor as $key => $super)
                                        <tr>
                                            <td>
                                                {!! Form::checkbox('user_id', $key, null, ['class' => 'select']) !!}
                                            </td>
                                            <td>{{ $key }}</td>
                                            <td>{{ $super }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            {!! Form::hidden('course_id', $course->id) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::submit(trans('settings.save'), [
                                'class' => 'btn btn-success'
                            ]) !!}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

