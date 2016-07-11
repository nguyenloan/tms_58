<div id="registerModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;
                </button>
                <h4 class="modal-title">{{ trans('settings.register') }}</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['route' => 'register', 'name' => 'formRegister', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
                    <div class="form-group">
                        <div class="alert alert-warning" id="register-message" role="alert"></div>
                        {!! Form::label('name', trans('settings.name'), ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::text('name', '', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('email', trans('settings.email'), ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::email('email', '', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('password', trans('settings.password'), ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::password('password', ['class' => 'form-control'])!!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('password', trans('settings.confirm_password'), ['class' => 'col-md-4 control-label']) !!}
                        <div class="col-md-6">
                            {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            {{ Form::button("<i class=\"fa fa-btn fa-user\"></i> " . trans('settings.register'), [
                                'class' => 'btn btn-default btn-register',
                                'type' => 'submit'
                            ]) }}
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
            <div class="modal-footer">
                {!! Form::button(trans('settings.close'), [
                    'class' => 'close',
                    'data-dismiss' => 'modal'
                ]) !!}
            </div>
        </div>
    </div>
</div>
