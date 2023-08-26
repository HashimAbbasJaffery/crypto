<!-- Top Bar Start -->
<div class="topbar">
    <!-- Navbar -->
    <nav class="navbar-custom">
        <ul class="list-unstyled topbar-nav float-right mb-0">
            <li class="hidden-sm">
                @if(Session::has('locale'))
                    @if(Session::get('locale') === 'en')
                        <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown"
                           href="javascript: void(0);" role="button"
                           aria-haspopup="false" aria-expanded="false">
                            English <img src="{{asset('images/flags/us.jpg')}}" class="ml-2" height="16" alt=""/> <i
                                class="mdi mdi-chevron-down"></i>
                        </a>
                    @else
                        <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown"
                           href="javascript: void(0);" role="button"
                           aria-haspopup="false" aria-expanded="false">
                            French <img src="{{asset('images/flags/french.jpg')}}" class="ml-2" height="16" alt=""/> <i
                                class="mdi mdi-chevron-down"></i>
                        </a>
                    @endif
                @else
                    <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown"
                       href="javascript: void(0);" role="button"
                       aria-haspopup="false" aria-expanded="false">
                        English <img src="{{asset('images/flags/us.jpg')}}" class="ml-2" height="16" alt=""/> <i
                            class="mdi mdi-chevron-down"></i>
                    </a>
                @endif
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{route('locale', ['locale' => 'en'])}}"><span> English </span><img
                            src="{{asset('images/flags/us.jpg')}}" alt="" class="ml-2 float-right" height="14"/></a>
                    <a class="dropdown-item" href="{{route('locale', ['locale' => 'fr'])}}"><span> French </span><img
                            src="{{asset('images/flags/french.jpg')}}" alt="" class="ml-2 float-right"
                            height="14"/></a>
                </div>
            </li>

            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#"
                   role="button"
                   aria-haspopup="false" aria-expanded="false">
                    <i class="ti-bell noti-icon"></i>
                    <span class="badge badge-danger badge-pill noti-icon-badge">2</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-lg pt-0">

                    <h6 class="dropdown-item-text font-15 m-0 py-3 bg-primary text-white d-flex justify-content-between align-items-center">
                        Notifications <span class="badge badge-light badge-pill">2</span>
                    </h6>
                    <div class="slimscroll notification-list">
                        <!-- item-->
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-right text-muted pl-2">2 min ago</small>
                            <div class="media">
                                <div class="avatar-md bg-primary">
                                    <i class="la la-cart-arrow-down text-white"></i>
                                </div>
                                <div class="media-body align-self-center ml-2 text-truncate">
                                    <h6 class="my-0 font-weight-normal text-dark">Your order is placed</h6>
                                    <small class="text-muted mb-0">Dummy text of the printing and industry.</small>
                                </div><!--end media-body-->
                            </div><!--end media-->
                        </a><!--end-item-->
                        <!-- item-->
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-right text-muted pl-2">10 min ago</small>
                            <div class="media">
                                <div class="avatar-md bg-success">
                                    <i class="la la-group text-white"></i>
                                </div>
                                <div class="media-body align-self-center ml-2 text-truncate">
                                    <h6 class="my-0 font-weight-normal text-dark">Meeting with designers</h6>
                                    <small class="text-muted mb-0">It is a long established fact that a reader.</small>
                                </div><!--end media-body-->
                            </div><!--end media-->
                        </a><!--end-item-->
                        <!-- item-->
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-right text-muted pl-2">40 min ago</small>
                            <div class="media">
                                <div class="avatar-md bg-pink">
                                    <i class="la la-list-alt text-white"></i>
                                </div>
                                <div class="media-body align-self-center ml-2 text-truncate">
                                    <h6 class="my-0 font-weight-normal text-dark">UX 3 Task complete.</h6>
                                    <small class="text-muted mb-0">Dummy text of the printing.</small>
                                </div><!--end media-body-->
                            </div><!--end media-->
                        </a><!--end-item-->
                        <!-- item-->
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-right text-muted pl-2">1 hr ago</small>
                            <div class="media">
                                <div class="avatar-md bg-warning">
                                    <i class="la la-truck text-white"></i>
                                </div>
                                <div class="media-body align-self-center ml-2 text-truncate">
                                    <h6 class="my-0 font-weight-normal text-dark">Your order is placed</h6>
                                    <small class="text-muted mb-0">It is a long established fact that a reader.</small>
                                </div><!--end media-body-->
                            </div><!--end media-->
                        </a><!--end-item-->
                        <!-- item-->
                        <a href="#" class="dropdown-item py-3">
                            <small class="float-right text-muted pl-2">2 hrs ago</small>
                            <div class="media">
                                <div class="avatar-md bg-info">
                                    <i class="la la-check-circle text-white"></i>
                                </div>
                                <div class="media-body align-self-center ml-2 text-truncate">
                                    <h6 class="my-0 font-weight-normal text-dark">Payment Successfull</h6>
                                    <small class="text-muted mb-0">Dummy text of the printing.</small>
                                </div><!--end media-body-->
                            </div><!--end media-->
                        </a><!--end-item-->
                    </div>
                    <!-- All-->
                    <a href="javascript:void(0);" class="dropdown-item text-center text-primary">
                        View all <i class="fi-arrow-right"></i>
                    </a>
                </div>
            </li>
            @auth
            <li class="dropdown">
                <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#"
                   role="button"
                   aria-haspopup="false" aria-expanded="false">
                    @if(!empty(Auth::user()->photo))
                        <img src="{{asset('media/profileImages/'.Auth::user()->photo)}}" alt="profile-user"
                             class="rounded-circle"/>
                    @else
                        <img src="{{asset('images/user.png') }}" alt="profile-user" class="rounded-circle"/>
                    @endif
                    <span class="ml-1 nav-user-name hidden-sm">{{Auth::user()->first_name}} {{Auth::user()->last_name}} <i
                            class="mdi mdi-chevron-down"></i> </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{route('dashboard.profile')}}"><i
                            class="dripicons-user text-muted mr-2"></i> @lang('messages.Profile')</a>
                    <div class="dropdown-divider"></div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="dropdown-item" type="submit"><i
                                class="dripicons-exit text-muted mr-2"></i> @lang('messages.Logout')</button>
                    </form>
                </div>
            </li>
            @endauth
        </ul><!--end topbar-nav-->
        <ul class="list-unstyled topbar-nav mb-0">
            <li>
                <a href="../crypto/crypto-index.html">
                    <span class="responsive-logo">
                        <img src="{{asset('images/logo.png')}}" alt="logo-small" class="logo-sm align-self-center"
                             height="34">
                    </span>
                </a>
            </li>
            <li>
                <button class="button-menu-mobile nav-link waves-effect waves-light">
                    <i data-feather="menu" class="align-self-center"></i>
                </button>
            </li>
        </ul>
    </nav>
    <!-- end navbar-->
</div>
<!-- Top Bar End -->
