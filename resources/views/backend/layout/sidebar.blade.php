<div class="col-md-3 left_col menu_fixed">
    <div class="left_col scroll-view">
        <div class="navbar nav_title" style="border: 0;">
            <a class="site_title" href="">
                <span>
                    Dashboard
                </span>
            </a>
        </div>
        <div class="clearfix">
        </div>
        <div class="profile">
            <div class="profile_pic">
                <img alt="..." class="img-circle profile_img" src="{{ asset('backend/images/').'/'.Auth::user()->avatar }}">
                </img>
            </div>
            <div class="profile_info">
                <span>
                    Hai,
                </span>
                <h2>
                    {{ Auth::user()->name }}
                </h2>
            </div>
        </div>
        <br/>
        <div class="main_menu_side hidden-print main_menu" id="sidebar-menu">
            <div class="menu_section">
                <h3>
                    General
                </h3>
                <ul class="nav side-menu">
                    <li class="{{ Route::is('backend.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('backend.dashboard') }}">
                            <i class="fa fa-home">
                            </i>
                            Dashbor
                        </a>
                    </li>
                    <li class="{{ Route::is('backend.user.*') ? 'active' : '' }}">
                        <a href="{{ route('backend.user') }}">
                            <i class="fa fa-envelope">
                            </i>
                            Manage Account
                        </a>
                    </li>

                    @if(Auth::user()->can('list-inbox'))
                    <li class="{{ Route::is('backend.inbox') ? 'active' : '' }}">
                        <a href="{{ route('backend.inbox') }}">
                            <i class="fa fa-envelope">
                            </i>
                            Inbox
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->can('list-jobApply'))
                    <li class="{{ Route::is('backend.job-apply') ? 'active' : '' }}">
                        <a href="{{ route('backend.job-apply') }}">
                            <i class="fa fa-envelope">
                            </i>
                            Job Applied
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->can('list-news'))
                    <li class="{{ Route::is('backend.news*') ? 'active' : '' }}">
                        <a href="{{ route('backend.news') }}">
                            <i class="fa fa-envelope">
                            </i>
                            News
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->can('list-page'))
                    <li class="{{ Route::is('backend.banner*') ? 'active' : '' }}">
                        <a href="{{ route('backend.banner') }}">
                            <i class="fa fa-envelope">
                            </i>
                            Banner
                        </a>
                    </li>
                    <li class="{{ Route::is('backend.certification*') ? 'active' : '' }}">
                        <a href="{{ route('backend.certification') }}">
                            <i class="fa fa-envelope">
                            </i>
                            Certification
                        </a>
                    </li>
                    <li class="{{ Route::is('backend.careers*') ? 'active' : '' }}">
                        <a href="{{ route('backend.careers') }}">
                            <i class="fa fa-envelope">
                            </i>
                            Careers
                        </a>
                    </li>
                    <li class="{{ Route::is('backend.category-product*') ? 'active' : '' }}">
                        <a href="{{ route('backend.category-product') }}">
                            <i class="fa fa-envelope">
                            </i>
                            Product Category
                        </a>
                    </li>
                    <li class="{{ Route::is('backend.product*') ? 'active' : '' }}">
                        <a href="{{ route('backend.product') }}">
                            <i class="fa fa-envelope">
                            </i>
                            Product
                        </a>
                    </li>
                    <li class="{{ Route::is('backend.partner*') ? 'active' : '' }}">
                        <a href="{{ route('backend.partner') }}">
                            <i class="fa fa-envelope">
                            </i>
                            Partner
                        </a>
                    </li>
                    <li class="{{ Route::is('backend.overseas*') ? 'active' : '' }}">
                        <a href="{{ route('backend.overseas') }}">
                            <i class="fa fa-envelope">
                            </i>
                            Overseas
                        </a>
                    </li>
                    <li class="{{ Route::is('backend.solutions-category*') ? 'active' : '' }}">
                        <a href="{{ route('backend.solutions-category') }}">
                            <i class="fa fa-envelope">
                            </i>
                            Solutions Category
                        </a>
                    </li>
                    <li class="{{ Route::is('backend.solutions*') ? 'active' : '' }}">
                        <a href="{{ route('backend.solutions') }}">
                            <i class="fa fa-envelope">
                            </i>
                            Solutions
                        </a>
                    </li>
                    <li class="{{ Route::is('backend.general-config*') ? 'active' : '' }}">
                        <a href="{{ route('backend.general-config') }}">
                            <i class="fa fa-envelope">
                            </i>
                            General Config
                        </a>
                    </li>
                    @endif

                    {{--
                    <li class="{{ Route::is('account*') ? 'active' : '' }}">
                        <a>
                            <i class="fa fa-gear">
                            </i>
                            General
                            <span class="fa fa-chevron-down">
                            </span>
                        </a>
                        <ul class="nav child_menu" style="{{ Route::is('general.*') ? 'display: block;' : '' }}">
                            <li class="{{ Route::is('general.menu') ? 'current-page' : '' }}">
                                <a href="{{ route('general.menu') }}">
                                    Menu
                                </a>
                            </li>
                            <li class="{{ Route::is('general.email') ? 'current-page' : '' }}">
                                <a href="{{ route('general.email') }}">
                                    Email
                                </a>
                            </li>
                        </ul>
                    </li>
                    --}}
                </ul>
            </div>
        </div>
        {{--
        <div class="sidebar-footer hidden-small">
            <a data-placement="top" data-toggle="tooltip" href="" title="Users">
                <span aria-hidden="true" class="glyphicon glyphicon-user">
                </span>
            </a>
            <a data-placement="top" data-toggle="tooltip" href="" title="Inbox">
                <span aria-hidden="true" class="glyphicon glyphicon-envelope">
                </span>
            </a>
            <a data-placement="top" data-toggle="tooltip" href="" title="Profile">
                <span aria-hidden="true" class="glyphicon glyphicon-cog">
                </span>
            </a>
            <a data-placement="top" data-toggle="tooltip" href="" title="Logout">
                <span aria-hidden="true" class="glyphicon glyphicon-off">
                </span>
            </a>
        </div>
        --}}
    </div>
</div>
