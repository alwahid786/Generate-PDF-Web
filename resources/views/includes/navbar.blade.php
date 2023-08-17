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
            <!-- <div class="form-group has-search mr-4">
                <div class="dropdown">
                    <img src="{{asset('public/assets/images/bn-bell-icon.svg')}}" class="dropdown-toggle icon-button" id="dropdownMenuButton" data-toggle="dropdown">
                    <span class="icon-button__badge"></span>
                    <div class="dropdown-menu notification-dropdown" aria-labelledby="dropdownMenuButton">
                        <a class="notification-area " href="#">
                            <div class="notification-profile d-flex py-3">
                                <img src="{{asset('public/assets/images/profile.svg')}}">
                                <p class="pl-3"><span>Dayut Carlotte</span>wants to update his access level from
                                    view to edit</p>
                            </div>
                        </a>
                        <a class=" notification-area" href="#">
                            <div class="notification-profile d-flex py-3">
                                <img src="{{asset('public/assets/images/profile.svg')}}">
                                <p class="pl-3"><span>Dayut Carlotte</span>wants to update his <br>access level from
                                    view to edit</p>
                            </div>
                        </a>
                        <a class=" notification-area" href="#">
                            <div class="notification-profile d-flex py-3">
                                <img src="{{asset('public/assets/images/profile.svg')}}">
                                <p class="pl-3"><span>Dayut Carlotte</span>wants to update his <br>access level from
                                    view to edit</p>
                            </div>
                        </a>
                        <a class=" notification-area" href="#">
                            <div class="notification-profile d-flex py-3">
                                <img src="{{asset('public/assets/images/profile.svg')}}">
                                <p class="pl-3"><span>Dayut Carlotte</span>wants to update his <br>access level from
                                    view to edit</p>

                            </div>
                        </a>
                        <a class=" notification-area" href="#">
                            <div class="notification-profile d-flex py-3">
                                <img src="{{asset('public/assets/images/profile.svg')}}">
                                <p class="pl-3"><span>Dayut Carlotte</span>wants to update his <br>access level from
                                    view to edit</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div> -->
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
                <a class="nav-link sidenav-item dasboard-link" href="{{url('dashboard')}}">
                    <img src="{{asset('public/assets/images/d-white.png')}}" class="icon-white pr-2">
                    <img src="{{asset('public/assets/images/d-blue.png')}}" class="icon-blue pr-2">
                    Dashboard
                </a>
            </li>
            <li class="nav-item my-1 ">
                <a class="nav-link sidenav-item" href="{{url('coming-soon')}}">
                    <img src="{{asset('public/assets/images/spec-blue.png')}}" class="icon-blue pr-2">
                    <img src="{{asset('public/assets/images/spec-white.png')}}" class="icon-white pr-2">
                    Specification Package</a>
            </li>

            <li class="nav-item my-1 ">
                <a class="nav-link sidenav-item" href="{{url('coming-soon')}}"><img src="{{asset('public/assets/images/light-white.png')}}" class="pr-2 icon-white">
                    <img src="{{asset('public/assets/images/light-blue.png')}}" class="pr-2 icon-blue">
                    Lighting Legend</a>
            </li>
            <li class="nav-item my-1 ">
                <a class="nav-link sidenav-item" href="{{url('coming-soon')}}"><img src="{{asset('public/assets/images/sub-white.png')}}" class="pr-2 icon-white">
                    <img src="{{asset('public/assets/images/sub-blue.png')}}" class="pr-2 icon-blue">
                    Submittal Package</a>
            </li>
            <li class="nav-item my-1 ">
                <a class="nav-link sidenav-item" href="{{url('coming-soon')}}"><img src="{{asset('public/assets/images/rec-white.png')}}" class="pr-2 icon-white">
                    <img src="{{asset('public/assets/images/rec-blue.png')}}" class="pr-2 icon-blue">
                    Record Drawing</a>
            </li>
            <li class="nav-item my-1 ">
                <a class="nav-link sidenav-item" href="{{url('coming-soon')}}"><img src="{{asset('public/assets/images/exis-white.png')}}" class="pr-2 icon-white">
                    <img src="{{asset('public/assets/images/exis-blue.png')}}" class="pr-2 icon-blue">
                    Existing Record Search</a>
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
