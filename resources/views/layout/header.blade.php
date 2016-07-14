<header id="header">
    <div class="container">
        <div class="row">
            <div class="col-sm-2 logo">
                @if (Auth::check())
                    <a href="{{ route('courses.index') }}"><img src="{{ asset('/images/logo.png') }}"/></a>
                @else
                    <a><img src="{{ asset('/images/logo.png') }}"/></a>
                @endif
            </div>
            <div class="col-sm-10 menu">
                <ul class="nav navbar-nav">
                    @if (Auth::check())
                        <li>
                            <a href="{{ route('courses.index') }}">
                                <i class="glyphicon glyphicon-education"></i>
                                {{ trans('general/label.courses') }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('users.show', ['id' => Auth::user()->id]) }}">
                                <span class="hello_user">{{ Auth::user()->email }}</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('reports.create') }}">
                                <i class="glyphicon glyphicon-list-alt"></i>
                                {{ trans('general/label.report') }}
                            </a>
                        </li>
                        @if (Auth::user()->role)
                            <li>
                                <a href="{{ route('admin.courses.index') }}">
                                    {{ trans('general/label.manage') }}
                                </a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ url('/logout') }}">
                                <i class="fa fa-btn fa-sign-out"></i>
                                {{ trans('settings.logout') }}
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="#" id="login" data-toggle="modal">
                                {{ trans('settings.login') }}
                            </a>
                        </li>
                        <li>
                            <a href="#" id="register" data-toggle="modal">
                                {{ trans('settings.register') }}
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</header>
