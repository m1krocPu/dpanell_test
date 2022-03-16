<div class="page-main-header">
    <div class="main-header-right m-0">
        <div class="main-header-left">
            <div class="logo-wrapper"><a href="{{url('/')}}"><img class="img-fluid" src="{{ asset('assets/images/logo.png') }}" style="height: 34px" alt=""></a></div>
            <div class="dark-logo-wrapper"><a href="{{url('/')}}"><img class="img-fluid" src="{{ asset('assets/images/logo.png') }}"  style="height: 34px" alt=""></a></div>
            <div class="toggle-sidebar" id="sidebar-toggle"><i class="status_toggle middle" data-feather="align-center"></i></div>
        </div>
        <div class="left-menu-header">
            <h5>TODO APP - DPANELL</h5>
        </div>

        <div class="nav-right col pull-right right-menu p-0">
            <ul class="nav-menus">
                <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i
                            data-feather="maximize"></i></a></li>

                <li>
                    <div class="mode"><i class="fa fa-moon-o"></i></div>
                </li>

                <li class="onhover-dropdown p-0">
                    <button class="btn btn-primary-light" type="button"><a href="{{url('logout')}}"><i
                                data-feather="log-out"></i>Log out</a></button>
                </li>
            </ul>
        </div>
        <div class="d-lg-none mobile-toggle pull-right w-auto"><i data-feather="more-horizontal"></i></div>
    </div>
</div>