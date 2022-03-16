<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
</head>

<body>
    <div class="loader-wrapper">
        <div class="theme-loader">
            <div class="loader-p"></div>
        </div>
    </div>
    <div class="page-wrapper" id="pageWrapper">
        @include('layouts.header')
        <div class="page-body-wrapper horizontal-menu">
            <div class="page-body-wrapper">
                @include('layouts.sidebar')
                <div class="page-body">
                    @yield('content')
                </div>
                @include('layouts.footer')
            </div>
        </div>
    </div>
    @include('layouts.script')
</body>

</html>