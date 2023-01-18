<header class="app-header">
    <a class="app-header__logo" href="index.html">Double Cutz Spa</a>
    <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>


@if(Auth::user()->role_id==2)
  <a class="app-nav__item bg-info" href="#" data-toggle="" aria-label="">Commission: <strong class="text-warning">Ksh {{number_format(\App\SalesCommission::where('employee_id',auth()->user()->id)->sum('commission'))??'0'}}</strong></a>
@endif


    <!-- Navbar Right Menu-->
    <ul class="app-nav">

        <!--Notification Menu-->
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
            <ul class="dropdown-menu settings-menu dropdown-menu-right">
                <li><a class="dropdown-item" href="{{route('update_password')}}"><i class="fa fa-cog fa-lg"></i>Password</a></li>
                <li><a class="dropdown-item" href="{{route('edit_profile')}}"><i class="fa fa-user fa-lg"></i>Profile</a></li>
                <li><a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-sign-out fa-lg"></i> Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>
        </li>
    </ul>
</header>
