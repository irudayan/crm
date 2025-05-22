<nav id="sidebar">
    <div class="sidebar_blog_1">
        <div class="sidebar-header">
            <div class="logo_section">
                <a href="{{ route('admin.home') }}"><img class="logo_icon img-responsive"
                        src="{{ asset('backend/images/logo/logo_icon.png') }}" alt="#" /></a>
            </div>
        </div>
        <div class="sidebar_user_info">
            <div class="icon_setting"></div>
            <div class="user_profle_side">
                <div class="user_img">
                    {{-- <img class="img-responsive" style="width: 70px; height: 70px;"
                        src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : asset('backend/images/layout_img/user_img.jpg') }}"
                        alt="User Image" /> --}}
                        {{-- <img class="img-responsive" style="width: 70px; height: 70px;"
                        src="{{ auth()->user()->profile_image ? asset(auth()->user()->profile_image) : asset('backend/images/layout_img/user_img.jpg') }}"
                        alt="User Image" /> --}}
                        <img class="img-responsive" style="width: 70px; height: 70px;"
     src="{{ auth()->check() && auth()->user()->profile_image ? asset(auth()->user()->profile_image) : asset('backend/images/layout_img/user_img.jpg') }}"
     alt="User Image" />

                </div>
                <div class="user_info">
                    <h6>Name</h6>
                    {{-- <p><span class="online_animation"></span>{{ Auth::user()->name }}</p> --}}
                    <p>
                        <span class="online_animation"></span>
                        {{ Auth::check() ? Auth::user()->name : 'Guest' }}
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="sidebar_blog_2">
        {{-- <h4>General</h4> --}}
        <ul class="list-unstyled components">
            @can('dashboard_access')
                <li class="active">
                    <a href="{{ route('admin.home') }}" class="dropdown-item"><i class="fa fa-dashboard yellow_color"></i>
                        <span>Dashboard</span></a>
                </li>
            @endcan

            @can('lead_management_access')
                <li><a href="{{ route('admin.leads.index') }}" class="dropdown-item"><i
                            class="fa fa-briefcase _color"></i>
                        <span> {{ trans('cruds.leads.title') }}</span></a>
                </li>
            @endcan

            @can('lead_management_access')
            <li><a href="{{ route('admin.our-leads.index') }}" class="dropdown-item"><i
                        class="fa fa-bullhorn blue1_color"></i>
                    <span> {{ trans('cruds.ourLeads.title') }}</span></a>
            </li>
        @endcan

            @can('qualified_management_access')
                <li><a href="{{ route('admin.qualified.index') }}" class="dropdown-item"><i
                            class="fa fa-diamond purple_color"></i>
                        <span>Qualified </span></a>
                </li>
            @endcan

            @can('flowup_management_access')
                <li><a href="{{ route('admin.followUp.index') }}" class="dropdown-item"><i
                            class="fa fa-share-square-o brown_color"></i>
                        <span>Follow Up </span></a>
                </li>
            @endcan


            @can('appointment_management_access')
            <li><a href="{{ route('admin.appointments.index') }}" class="dropdown-item"><i
                        class="fa fa-calendar green_color"></i>
                    <span>Apponitments </span></a>
            </li>
           @endcan


            @can('quotation_management_access')
                <li><a href="{{ route('admin.quotations.index') }}" class="dropdown-item"><i
                            class="fa fa-clone yellow_color"></i>
                        <span>{{ trans('cruds.quotation.title') }} </span></a>
                </li>
            @endcan




            @can('closedorwon_management_access')
                <li><a href="{{ route('admin.closedOrWon.index') }}" class="dropdown-item"><i
                            class="fa fa-thumbs-up blue_color"></i>
                        <span>Closed or Won </span></a>
                </li>
            @endcan

            @can('droppedorcancel_management_access')
                <li><a href="{{ route('admin.droppedOrCancel.index') }}" class="dropdown-item"><i
                            class="fa fa-home red_color"></i>
                        <span>Dropped or Cancel </span></a>
                </li>
            @endcan


            @can('catalogue_management_access')
                <li>
                    <a href="#element" data-toggle="collapse" aria-expanded="false" class="dropdown-item"><i
                            class="fa fa-folder-open purple_color"></i> <span>catalogue</span></a>
                    <ul class="collapse list-unstyled" id="element">
                        @can('product_management_access')
                            <li class="c-sidebar-nav-item"><a href="{{ route('admin.products.index') }}"
                                    class="dropdown-item"><i class="fa fa-cube green_color"></i> <span>
                                        {{ trans('cruds.products.title') }}</span></a>
                            </li>
                        @endcan
                        @can('product_category_access')
                            <li><a href="{{ route('admin.productCategory.index') }}" class="dropdown-item"><i
                                        class="fa fa-list-alt green_color"></i> <span>
                                        {{ trans('cruds.productCategory.title') }}</span></a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcan
            @can('reports_management_access')
            <li><a href="{{ route('admin.reports.index') }}" class="dropdown-item"><i
                        class="fa fa-clock-o orange_color"></i>
                    <span> {{ trans('cruds.reports.title') }}</span></a>
            </li>
        @endcan
            @can('contact_management_access')
                <li><a href="{{ route('admin.contacts.index') }}" class="dropdown-item"><i
                            class="fa fa-clock-o orange_color"></i>
                        <span> {{ trans('cruds.contact.title') }}</span></a>
                </li>
            @endcan
            @can('user_management_access')
                <li
                    class="c-sidebar-nav-dropdown {{ request()->is('admin/permissions*') ? 'c-show' : '' }} {{ request()->is('admin/roles*') ? 'c-show' : '' }} {{ request()->is('admin/users*') ? 'c-show' : '' }}">
                    <a class="c-sidebar-nav-dropdown-toggle" href="#">
                        <i class="fa fa-users c-sidebar-nav-icon">

                        </i>
                        {{ trans('cruds.userManagement.title') }}
                    </a>
                    <ul class="c-sidebar-nav-dropdown-items">
                        @can('permission_access')
                            <li class="c-sidebar-nav-item">
                                <a href="{{ route('admin.permissions.index') }}"
                                    class="c-sidebar-nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'c-active' : '' }}">
                                    <i class="fa fa-unlock-alt c-sidebar-nav-icon">

                                    </i>
                                    {{ trans('cruds.permission.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('role_access')
                            <li class="c-sidebar-nav-item">
                                <a href="{{ route('admin.roles.index') }}"
                                    class="c-sidebar-nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'c-active' : '' }}">
                                    <i class="fa fa-briefcase c-sidebar-nav-icon">

                                    </i>
                                    {{ trans('cruds.role.title') }}
                                </a>
                            </li>
                        @endcan
                        @can('user_access')
                            <li class="c-sidebar-nav-item">
                                <a href="{{ route('admin.users.index') }}"
                                    class="c-sidebar-nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'c-active' : '' }}">
                                    <i class="fa fa-user c-sidebar-nav-icon">

                                    </i>
                                    {{ trans('cruds.user.title') }}
                                </a>
                            </li>
                        @endcan

                    </ul>
                </li>
            @endcan

            <li> <a href="#" class="dropdown-item"
                    onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="fa fa-sign-out red_color">
                    </i><span> {{ trans('global.logout') }}</span>
                </a></li>
            </li>


        </ul>
    </div>
</nav>
