<aside id="sidebar">
    <div class="logo_wrapper">
        <a href=""><img src="images/logo_img.png" alt=""> <span><b>Admin</b>Dash</span></a>
    </div>
    <div class="side_menuwrap">
      <ul class="sidenav">


        <li class="sidenav_li">
          <a href="{{ route('dashboard') }}" class="sidenav_navlink {{ request()->routeIs('dashboard') ? 'activeItem' : '' }}" id="dashboard">
            <span><i class="ri-apps-line"></i></span> <b>Dashboard</b>
          </a>
        </li>
        <li class="sidenav_li">
          <div class="dropdown_area">
            <div class="dropdowntitle">
              <span><i class="ri-table-line"></i></span>
              <b>Categories</b>
              <span class="dropicon"><i class="ri-arrow-right-s-line"></i></span>
            </div>
            <ul class="dropdown_list">
              <li>
                <a href="{{ route('categories.index') }}"
                   class="dropdownnav sidenav_navlink {{ request()->routeIs('categories.index') ? 'active' : '' }}"
                   id="categories-list">
                  <span><i class="ri-list-check"></i></span> All Categories
                </a>
              </li>
              <li>
                <a href="{{ route('categories.create') }}"
                   class="dropdownnav sidenav_navlink {{ request()->routeIs('categories.create') ? 'active' : '' }}"
                   id="categories-create">
                  <span><i class="ri-add-circle-line"></i></span> Add New Category
                </a>
              </li>
            </ul>
          </div>
        </li>



        <li class="sidenav_li active_menu">
          <a href="javascript:void(0);" class="sidenav_navlink activeItem" id="dashboard"><span><i class="ri-apps-line"></i></span> <b>dashboard</b></a>
        </li>
        <li class="sidenav_li">
          <div class="dropdown_area">
            <div class="dropdowntitle"><span><i class="ri-table-line"></i></span> <b>table</b> <span class="dropicon"><i class="ri-arrow-right-s-line"></i></span></div>
            <ul class="dropdown_list">
              <li><a href="{{ route('categories.create') }}" class="dropdownnav sidenav_navlink" id="basictable"><span><i class="ri-arrow-right-double-line"></i></span> Categori Add</a></li>
              <li><a href="#" class="dropdownnav sidenav_navlink" id="advancetable"><span><i class="ri-arrow-right-double-line"></i></span> advance table</a></li>
              <li><a href="#" class="dropdownnav sidenav_navlink" id="datatable"><span><i class="ri-arrow-right-double-line"></i></span> data table</a></li>
          </ul>
          </div>
        </li>
        <li class="sidenav_li">
          <div class="dropdown_area">
            <div class="dropdowntitle"><span><i class="ri-user-settings-line"></i></span> <b>Forms</b> <span class="dropicon"><i class="ri-arrow-right-s-line"></i></span></div>
            <ul class="dropdown_list">
              <li><a href="#" class="dropdownnav sidenav_navlink" id="basic_form"><span><i class="ri-arrow-right-double-line"></i></span> Basic Forms</a></li>
              <li><a href="#" class="dropdownnav sidenav_navlink" id="tags"><span><i class="ri-arrow-right-double-line"></i></span> Tags / Inputs</a></li>
            </ul>
          </div>
        </li>
        <li class="sidenav_li">
          <a href="javascript:void(0);" class="sidenav_navlink" id="alerts"><span><i class="ri-alert-line"></i></span> <b>Alerts</b></a>
        </li>
        <li class="sidenav_li">
          <a href="javascript:void(0);" class="sidenav_navlink" id="cards"><span><i class="ri-dashboard-line"></i></span> <b>Cards</b></a>
        </li>
        <li class="sidenav_li">
          <a href="javascript:void(0);" class="sidenav_navlink" id="tabs"><span><i class="ri-archive-drawer-line"></i></span> <b>Tabs</b></a>
        </li>
        <li class="sidenav_li">
          <a href="javascript:void(0);" class="sidenav_navlink" id="loaders"><span><i class="ri-loader-2-line"></i></span> <b>Loaders</b></a>
        </li>
      </ul>
    </div>
</aside>
