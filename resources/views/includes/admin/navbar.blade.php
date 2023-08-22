<style>
    .nav-link[data-toggle].collapsed:after {
        content: '\f107';
        font-family: "FontAwesome" !important;
        font-size: 20px;
    }

    .nav-link[data-toggle]:not(.collapsed):after {
        content: '\f106';
        font-family: "FontAwesome" !important;
        font-size: 20px;
    }
</style>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-header">
    <a class="navbar-brand logo-header" href="#">
        <img src="{{asset('public/assets/images/side-logo.png')}}" alt="Admin logo">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa fa-bars" aria-hidden="true"></i>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <form class="form-inline  mt-2 mt-md-0 ml-auto navbar-header-right-section pt-2 pt-lg-0">

            <div class="form-group has-search profile mr-2">

                <span class="mr-2">{{auth()->user()->name}}</span>
                <a href="{{ auth()->user()->profile_img == null ? asset('public/assets/images/profile.png') : auth()->user()->profile_img }}" target="_blank"><img src="{{ auth()->user()->profile_img == null ? asset('public/assets/images/profile.png') : auth()->user()->profile_img }}"></a>
            </div>
            <div class="form-group has-search">
                <div class="dropdown dropdown-logout">
                    <img src="{{asset('public/assets/images/Vector.png')}}" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown">
                    <div class="dropdown-menu text-center logout-dropdown" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item logout" href="{{(url('logout'))}}"><i class="fa fa-sign-out pr-2" aria-hidden="true"></i>Logout</a>
                    </div>
                </div>
            </div>
        </form>
        <ul class="navbar-nav mr-auto sidenav" id="navAccordion">
            <li class="nav-item my-1 active">
                <a class="nav-link sidenav-item dasboard-link" href="{{url('admin/dashboard')}}">
                    <img src="{{asset('public/assets/images/d-white.png')}}" class="icon-white pr-2">
                    <img src="{{asset('public/assets/images/d-blue.png')}}" class="icon-blue pr-2">
                    Dashboard
                </a>
            </li>

            <li class="nav-item my-1 ">
                <a class="nav-link sidenav-item" href="{{url('profile')}}"><img src="{{asset('public/assets/images/pro-white.png')}}" class="pr-2 icon-white">
                    <img src="{{asset('public/assets/images/pro-blue.png')}}" class="pr-2 icon-blue">
                    Profile</a>
            </li>
            <li class="nav-item my-1 ">
                <a class="nav-link sidenav-item" href="{{url('support')}}"><img src="{{asset('public/assets/images/sup-white.png')}}" class="pr-2 icon-white">
                    <img src="{{asset('public/assets/images/sup-blue.png')}}" class="pr-2 icon-blue">
                    Support</a>
            </li>
        </ul>

    </div>
</nav>
