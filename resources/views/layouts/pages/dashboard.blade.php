@include("layouts.include.header")

<!-- main content -->

<!-- dashboard content -->
<div class="main-content dashboard active_content">
    <!-- page header start -->
    <div class="page-header">
        <div>
            <h2 class="main-content-title">Welcome To DashboardAAAAAAA</h2>
            @if (Auth::guard("admin")->check())
                <p>Logged in as {{ Auth::guard("admin")->user()->name }}</p>
            @else
                <p>Not logged in as admin.</p>
            @endif
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sales</li>
            </ol>
        </div>
        <div>
            <a href="javascript:void(0);" class="btn ripple btn_secondary" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <i
                    class="ri-filter-2-line"></i> Filter </a>
        </div>
    </div>
    <!-- page header close -->

    <!-- dash board page start -->
    <section class="dashboard">
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <div class="stat_card theme_green">
                    <div class="stat_info">
                        <span class="statname">Sales Statistics</span>
                        <span class="statNo">
                            <b>153</b>
                            <small>this month</small>
                        </span>
                        <a href="" class="viewbtn">view all <i class="ri-arrow-right-line"></i></a>
                    </div>
                    <div class="stat_icon"><i class="ri-bar-chart-2-line"></i></div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="stat_card theme_red">
                    <div class="stat_info">
                        <span class="statname">Total Revenue</span>
                        <span class="statNo">
                            <b>$4,32,474</b>
                            <small>this month</small>
                        </span>
                        <a href="" class="viewbtn">view all <i class="ri-arrow-right-line"></i></a>
                    </div>
                    <div class="stat_icon"><i class="ri-money-dollar-circle-line"></i></div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="stat_card theme_blue">
                    <div class="stat_info">
                        <span class="statname">Page Views</span>
                        <span class="statNo">
                            <b>27,146</b>
                            <small>this month</small>
                        </span>
                        <a href="" class="viewbtn">view all <i class="ri-arrow-right-line"></i></a>
                    </div>
                    <div class="stat_icon"><i class="ri-file-text-line"></i></div>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3">
                <div class="stat_card theme_orange">
                    <div class="stat_info">
                        <span class="statname">Profit By Sale</span>
                        <span class="statNo">
                            <b>$563</b>
                            <small>this month</small>
                        </span>
                        <a href="" class="viewbtn">view all <i class="ri-arrow-right-line"></i></a>
                    </div>
                    <div class="stat_icon"><i class="ri-wallet-3-line"></i></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-7 col-lg-8">
                <div class="chart_area">
                    <div id="chart"></div>
                </div>
            </div>
            <div class="col-sm-12 col-md-5 col-lg-4">
                <div class="revenue-wrapper">
                    <div class="tab_header">
                        <b class="tab_title">Revenue Get</b>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link ripple btn_secondary active" id="home-tab" data-bs-toggle="tab"
                                    data-bs-target="#home" type="button" role="tab" aria-controls="home"
                                    aria-selected="true">Home</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link ripple btn_secondary" id="profile-tab" data-bs-toggle="tab"
                                    data-bs-target="#profile" type="button" role="tab" aria-controls="profile"
                                    aria-selected="false">Profile</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link ripple btn_secondary" id="contact-tab" data-bs-toggle="tab"
                                    data-bs-target="#contact" type="button" role="tab" aria-controls="contact"
                                    aria-selected="false">Contact</button>
                            </li>
                        </ul>
                    </div>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel"
                            aria-labelledby="home-tab">
                            <table class="table revenue_table">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="revenue_name">
                                                <i class="ri-line-chart-line"></i>
                                                total sale
                                            </div>
                                        </td>
                                        <td>
                                            5995
                                            <sup class="text-success">+15%</sup>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="revenue_name">
                                                <i class="ri-user-follow-line"></i>
                                                Total Customers
                                            </div>
                                        </td>
                                        <td>
                                            5855
                                            <sup class="text-success">+15%</sup>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="revenue_name">
                                                <i class="ri-money-dollar-circle-line"></i>
                                                Total Income
                                            </div>
                                        </td>
                                        <td>
                                            5995
                                            <sup class="text-danger">+15%</sup>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="revenue_name">
                                                <i class="ri-bar-chart-grouped-fill"></i>
                                                Total Expense
                                            </div>
                                        </td>
                                        <td>
                                            7454
                                            <sup class="text-success">+22%</sup>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="revenue_name">
                                                <i class="ri-heart-line"></i>
                                                Total Likes
                                            </div>
                                        </td>
                                        <td>
                                            14454
                                            <sup class="text-success">+15%</sup>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="revenue_name">
                                                <i class="ri-user-follow-line"></i>
                                                Total Customers
                                            </div>
                                        </td>
                                        <td>
                                            5855
                                            <sup class="text-success">+15%</sup>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <table class="table revenue_table">
                                <tbody>

                                    <tr>
                                        <td>
                                            <div class="revenue_name">
                                                <i class="ri-user-follow-line"></i>
                                                Total Customers
                                            </div>
                                        </td>
                                        <td>
                                            5855
                                            <sup class="text-success">+15%</sup>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="revenue_name">
                                                <i class="ri-line-chart-line"></i>
                                                total sale
                                            </div>
                                        </td>
                                        <td>
                                            5995
                                            <sup class="text-success">+15%</sup>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="revenue_name">
                                                <i class="ri-money-dollar-circle-line"></i>
                                                Total Income
                                            </div>
                                        </td>
                                        <td>
                                            5995
                                            <sup class="text-danger">+15%</sup>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="revenue_name">
                                                <i class="ri-bar-chart-grouped-fill"></i>
                                                Total Expense
                                            </div>
                                        </td>
                                        <td>
                                            7454
                                            <sup class="text-success">+22%</sup>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="revenue_name">
                                                <i class="ri-heart-line"></i>
                                                Total Likes
                                            </div>
                                        </td>
                                        <td>
                                            14454
                                            <sup class="text-success">+15%</sup>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="revenue_name">
                                                <i class="ri-user-follow-line"></i>
                                                Total Customers
                                            </div>
                                        </td>
                                        <td>
                                            5855
                                            <sup class="text-success">+15%</sup>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <table class="table revenue_table">
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="revenue_name">
                                                <i class="ri-line-chart-line"></i>
                                                total sale
                                            </div>
                                        </td>
                                        <td>
                                            5995
                                            <sup class="text-success">+15%</sup>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="revenue_name">
                                                <i class="ri-user-follow-line"></i>
                                                Total Customers
                                            </div>
                                        </td>
                                        <td>
                                            5855
                                            <sup class="text-success">+15%</sup>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="revenue_name">
                                                <i class="ri-money-dollar-circle-line"></i>
                                                Total Income
                                            </div>
                                        </td>
                                        <td>
                                            5995
                                            <sup class="text-danger">+15%</sup>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="revenue_name">
                                                <i class="ri-bar-chart-grouped-fill"></i>
                                                Total Expense
                                            </div>
                                        </td>
                                        <td>
                                            7454
                                            <sup class="text-success">+22%</sup>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="revenue_name">
                                                <i class="ri-heart-line"></i>
                                                Total Likes
                                            </div>
                                        </td>
                                        <td>
                                            14454
                                            <sup class="text-success">+15%</sup>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="revenue_name">
                                                <i class="ri-user-follow-line"></i>
                                                Total Customers
                                            </div>
                                        </td>
                                        <td>
                                            5855
                                            <sup class="text-success">+15%</sup>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- dash board page close -->

    <!-- page footer start -->
    @include("layouts.include.footer")
    <!-- page footer start -->
</div>
<!-- dashboard content -->








</div>
</div>

<!-- ===setting bar==== -->


<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
@include("layouts.include.script")

</body>

</html>

<script>
    // total revenue========================


    var chart = new ApexCharts(document.querySelector("#chart"), options);
    chart.render();
</script>
