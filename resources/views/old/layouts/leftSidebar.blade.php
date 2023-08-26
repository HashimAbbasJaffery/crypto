<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>
                <li>
                    <a href="{{route('home')}}" class="waves-effect">
                        <i class="ri-dashboard-line"></i>
                        <span>@lang('messages.Dashboard')</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('dashboard.profile')}}" class="waves-effect">
                        <i class="fas fa-user"></i>
                        <span>@lang('messages.Profile')</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('dashboard.referral')}}" class="waves-effect">
                        <i class="fas fa-sync-alt"></i>
                        <span>@lang('messages.Referral')</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('dashboard.help')}}" class="waves-effect">
                        <i class="fas fa-info-circle"></i>
                        <span>@lang('messages.Help Desk')</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('dashboard.pool')}}" class="waves-effect">
                        <i class="fas fa-project-diagram"></i>
                        <span>@lang('messages.Pool')</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('dashboard.wallet')}}" class="waves-effect">
                        <i class="fas fa-wallet"></i>
                        <span>@lang('messages.wallet')</span>
                    </a>
                </li>
                @php
                    $message = "Tokens Dashboard";
                @endphp
                <li>
                    <a href="{{route('dashboard.tokens_dashboard')}}" class="waves-effect">
                        <i class="fas fa-wallet"></i>
                        <span>{{$message}}</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
