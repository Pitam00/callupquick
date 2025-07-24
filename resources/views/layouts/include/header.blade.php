<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.rawgit.com/t4t5/sweetalert/v0.2.0/lib/sweet-alert.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- remix icon link -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">

    <!-- select 2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- chosen js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" integrity="sha512-yVvxUQV0QESBt1SyZbNJMAwyKvFTLMyXSyBHDO4BG5t7k/Lw34tyqlSDlKIrIENIzCl+RVUNjmCPG+V/GMesRw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- style.css link -->
    <link rel="stylesheet" href="{{asset('admin_asset/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('admin_asset/css/responsive.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css" rel="stylesheet">




    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Event Booking</title>
  </head>
  <body>
    <div class="dashboard">
    @include('layouts.include.sidebar')

        <div class="page_wrapper" id="page_wrapper">
          <!-- header -->
            <div class="main_header">
              <div class="header_wrapper">
                <div class="serch-wrapper">
                    <form>
                        <input type="text" placeholder="Search Here..." class="form-control">
                    </form>
                    <a class="search-close" href="javascript:void(0);"><i class="ri-close-line"></i></a>
                </div>
                <div class="header_left">
                  <div class="header_links">
                    <div class="hamburger" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Shrink Sidebar">
                      <span class="line"></span>
                      <span class="line"></span>
                      <span class="line"></span>
                  </div>
                  </div>
                  <div class="header_links">
                    <div class="search_link" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Search"><i class="ri-search-2-line"></i></div>
                  </div>
                </div>
                <div class="header_controls">
                  <div class="header_links">
                    <div class="fullscreenbtn" onclick="toggleFullScreen(documentElement)" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Fullscreen"><i class="ri-fullscreen-exit-line"></i></div>
                  </div>
                  <div class="header_links">
                    <div class="setting_btn"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Settings"><i class="ri-settings-5-line"></i></div>
                  </div>
                  <div class="header_links">
                    <div class="notification_btn">
                      <i class="ri-notification-2-line"></i>
                      <span class="count-notification"></span>
                    </div>
                    <div class="recent-notification">
                      <div class="drop-down-header">
                          <h4>All Notification</h4>
                          <p>You have 6 new notifications</p>
                      </div>
                      <ul>
                          <li>
                              <a href="javascript:void(0);">
                                  <h5><i class="ri-error-warning-fill"></i>Storage Full</h5>
                                  <p>Lorem ipsum dolor sit amet, consectetuer.</p>
                              </a>
                          </li>
                          <li>
                              <a href="javascript:void(0);">
                                  <h5><i class="ri-add-circle-line"></i>New Membership</h5>
                                  <p>Lorem ipsum dolor sit amet, consectetuer.</p>
                              </a>
                          </li>
                      </ul>
                      <div class="drop-down-footer">
                          <a href="javascript:void(0);" class="btn sm-btn">
                              View All
                          </a>
                      </div>
                  </div>
                  </div>
                  <div class="header_links">
                    <a href="javascript:void(0);" class="user-info">
                      <img src="https://kamleshyadav.com/html/splashdash/html/b5/light/assets/images/user.jpg" alt="" class="user-img img-fluid">
                      <div class="blink-animation">
                          <span class="blink-circle"></span>
                          <span class="main-circle"></span>
                      </div>
                  </a>
                  <div class="user-info-box">
                    <div class="drop-down-header">
                        {{-- <h4>{{ Auth::user()->name }}</h4> --}}
                        <h4>Name</h4>
                        {{-- <!-- <p>{{ Auth::user()->email }}</p> --> --}}
                        <p>Email@gmail.com</p>
                        {{-- <p>{{ ucwords(Auth::user()->role) }}</p> --}}
                        <p>Role</p>

                    </div>
                    <ul>
                        <li>
                            <a href="#">
                              <i class="ri-edit-box-line"></i> Edit Profile
                            </a>
                        </li>
                        <li>
                            <a href="setting.html">
                              <i class="ri-list-settings-line"></i> Settings
                            </a>
                        </li>
                        <li>
                            {{-- <a href="#">
                              <i class="ri-logout-circle-r-line"></i> logout
                            </a> --}}

                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" style="border: none; background: none; padding: 0; margin: 0; color: inherit; cursor: pointer;">
                                    <i class="ri-logout-circle-r-line"></i> Logout
                                </button>
                            </form>

                        </li>
                    </ul>
                </div>
                  </div>
                </div>
              </div>
            </div>

          <!-- header -->
