<header id="header">
    <div class="container">
        <div class="row">
            <div class="col-sm-2 logo">
                <a href="{{ route('courses.index') }}"><img src="{{ asset('/images/logo.png') }}"/></a>
            </div>
            <div class="col-sm-10 menu">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="{{ route('courses.index') }}">
                            <i class="glyphicon glyphicon-education"></i>
                            {{ trans('general/label.courses') }}
                        </a>
                    </li>
                    @if (Auth::check())
                        <li>
                            <a href="{{ route('users.show', ['id' => Auth::user()->id]) }}">
                                <span class="hello_user">{{ Auth::user()->email }}</span>
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
                            <a href="#">
                                <i class="fa fa-unlock"></i>
                                {{ trans('general/label.logout') }}
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="#">
                                <i class="fa fa-lock"></i>
                                {{ trans('general/label.login') }}
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-user"></i>
                                {{ trans('general/label.register') }}
                            </a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</header>