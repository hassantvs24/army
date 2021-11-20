<!-- Main navbar -->
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-header">
        <a class="navbar-brand" href=""><img src="{{asset('public/global_assets/images/logo_light.png')}}" alt="Logo"></a>

        <ul class="nav navbar-nav pull-right visible-xs-block">
            <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
            <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">
        <ul class="nav navbar-nav">
            <li><a class="sidebar-control sidebar-main-toggle hidden-xs" id="sidebarToggle" data-url="{{ route('sidebar') }}"><i class="icon-paragraph-justify3"></i></a></li>
        </ul>

        <ul class="nav navbar-nav navbar-right">

            <li class="dropdown dropdown-user">
                <a class="dropdown-toggle" data-toggle="dropdown">
                    <img src="{{asset('public/global_assets/images/image.png')}}" alt="User">
                    <span>{{ isset(Auth::user()->name) ? Auth::user()->name : 'Admin' }}</span>
                    <i class="caret"></i>
                </a>

                <ul class="dropdown-menu dropdown-menu-right">
                    <li><a href="#"><i class="icon-user-plus"></i> {{ isset(Auth::user()->name) ? Auth::user()->name : 'User name' }}</a></li>
                    <li><a href="#"><i class="icon-paperplane"></i> {{ isset(Auth::user()->email) ? Auth::user()->email : 'User email' }}</a></li>
                    <li><a href="{{route('backup')}}"><i class="icon-database-export"></i> Database Backup</a></li>
                    <li><a href="{{route('key')}}"><i class="icon-key"></i> Software Activation</a></li>
                    <li class="divider"></li>
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="icon-switch2"></i> Logout</a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->