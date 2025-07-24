<aside id="sidebar">
    <div class="logo_wrapper">
        <a href="{{ route("dashboard") }}"><img src="images/logo_img.png" alt=""> <span><b>Admin</b>Dash</span></a>
    </div>
    <div class="side_menuwrap">
        <ul class="sidenav">
            <li class="sidenav_li {{ request()->routeIs("dashboard") ? "active_menu" : "" }}">
                <a href="{{ route("dashboard") }}" class="sidenav_navlink">
                    <span><i class="ri-apps-line"></i></span> <b>Dashboard</b>
                </a>
            </li>

            <li class="sidenav_li {{ request()->routeIs("categories.*") ? "active_menu" : "" }}">
                <div class="dropdown_area">
                    <div class="dropdowntitle">
                        <span><i class="ri-table-line"></i></span>
                        <b>Categories</b>
                        <span class="dropicon"><i class="ri-arrow-right-s-line"></i></span>
                    </div>
                    <ul class="dropdown_list">
                        <li>
                            <a href="{{ route("admin.categories.index") }}"
                                class="dropdownnav sidenav_navlink {{ request()->routeIs("admin.categories.index") ? "active" : "" }}">
                                <span><i class="ri-list-check"></i></span> All Categories
                            </a>
                        </li>
                        <li>
                            <a href="{{ route("admin.categories.create") }}"
                                class="dropdownnav sidenav_navlink {{ request()->routeIs("admin.categories.create") ? "active" : "" }}">
                                <span><i class="ri-add-circle-line"></i></span> Add New Category
                            </a>
                        </li>
                        {{-- <li>
                <a href="{{ route('admin.categories.test') }}"
                   class="dropdownnav sidenav_navlink {{ request()->routeIs('admin.categories.create') ? 'active' : '' }}">
                  <span><i class="ri-add-circle-line"></i></span> test
                </a>
              </li> --}}
                    </ul>
                </div>
            </li>

            <li class="sidenav_li {{ request()->routeIs("bunsiness.add") ? "active_menu" : "" }}">
                <a href="{{ route("bunsiness.add") }}" class="sidenav_navlink">
                    <span><i class="ri-apps-line"></i></span> <b>Business Add</b>
                </a>
            </li>

            <!-- Other menu items -->
        </ul>
    </div>
</aside>
