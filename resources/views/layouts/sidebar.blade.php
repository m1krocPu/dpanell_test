<header class="main-nav">
    <div class="sidebar-user text-center"><a class="setting-primary" href="{{url('change_pass')}}"><i
                data-feather="settings"></i></a><img class="img-90 rounded-circle"
            src="{{ asset('assets/images/default.png') }}" alt="">
        <a href="#">
            <h6 class="mt-3 f-14 f-w-600">{{auth()->user()->users_email}}</h6>
        </a>
        <p class="mb-0 font-roboto">{{auth()->user()->users_name}}</p>
    </div>
    <nav>
        <div class="main-navbar">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="mainnav">
                <ul class="nav-menu custom-scrollbar">
                    <li class="back-btn">
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>
                    @if(auth()->user()->users_level=='admin')
                    <li class="dropdown"><a class="nav-link menu-title link-nav" href="{{ url('/') }}"><i
                                data-feather="home"></i><span>Dashboard</span></a>
                    </li>
                    <!-- <li class="dropdown"><a class="nav-link menu-title "
                            href="#"><i data-feather="settings"></i><span>Settings</span></a>
                        <ul class="nav-submenu menu-content">
                            <li><a href="{{ url('users') }}">Users</a></li>
                        </ul>
                    </li> -->
                    
                    @endif
                    <li class="dropdown"><a class="nav-link menu-title link-nav" href="{{ url('/todo') }}"><i
                                data-feather="clock"></i><span>TODO</span></a>
                    </li>
                    
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </div>
    </nav>
</header>