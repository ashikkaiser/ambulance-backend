<!-- Dashboard for Admin -->
@if(Auth::guard('admin_user')->user()->can('haveAdminAccess', App\Models\AdminUser::class))
    <div class="app-content main-content">
        <div class="side-app">

            <!-- Row 1-->
            <div class="row">
                <!--Invoice-->
                <div class="col-sm-12 col-md-6 col-xl-3">
                    <div class="card bg-primary">
                        <div class="card-body">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h6 class="text-white">Total Partners</h6>
                                    <h2 class="text-white m-0 font-weight-bold">{{ count($partners) }}</h2>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-white display-6"><i class="fa fa-handshake-o"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-xl-3">
                    <div class="card bg-secondary">
                        <div class="card-body">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h6 class="text-white">Total Vehicles</h6>
                                    <h2 class="text-white m-0 font-weight-bold">{{ count($vehicles) }}</h2>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-white display-6"><i class="fa fa-car"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-xl-3">
                    <div class="card bg-warning">
                        <div class="card-body">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h6 class="text-white">Total Users</h6>
                                    <h2 class="text-white m-0 font-weight-bold">{{ count($users) }}</h2>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-white display-6"><i class="fa fa-user"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-xl-3">
                    <div class="card bg-info">
                        <div class="card-body">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h6 class="text-white">Todays Trips</h6>
                                    <h2 class="text-white m-0 font-weight-bold">{{ count($tripsToday) }}</h2>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-white display-6"><i class="fa fa-outdent"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Row 1 -->

            <!-- Row 2-->
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <div class="card text-center overflow-hidden">
                        <div class="widget-line mt-5 ">
                            <p class="mb-2">Vehicle Status</p>
                            <h1 class="font-weight-bold">{{ count($vehicles) }}</h1>
                        </div>
                        <div class="mx-auto chart-circle chart-circle-md chart-circle-primary" data-value="0.67"
                            data-thickness="15" data-color="#60499a">
                            <div class="chart-circle-value fs">
                                <!--
                                <i class="fa fa-random text-primary"></i>
                                -->
                            </div>
                        </div>
                        <ul class="widget-line-list mt-5 mb-5">
                            <li class="border-right">{{ count($onlineVehicles) }} <br><span class="text-success"><i class="fa fa-hand-o-up"></i>
                                    Online</span></li>
                            <li>{{ count($vehicles) - count($onlineVehicles) }} <br><span class="text-danger"><i class="fa fa-hand-o-down"></i> Offline</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 p-l-0 p-r-0">
                    <div class="card text-center overflow-hidden">
                        <div class="widget-line mt-5">
                            <p class="mb-2">Search Status</p>
                            <h1 class="font-weight-bold">350</h1>
                        </div>
                        <div class="mx-auto chart-circle chart-circle-md chart-circle-secondary" data-value="0.55"
                            data-thickness="15" data-color="#f7346b">
                            <div class="chart-circle-value fs">
                                <!--
                                <i class="fa fa-life-ring text-secondary"></i>
                                -->
                            </div>
                        </div>
                        <ul class="widget-line-list mt-5 mb-5">
                            <li class="border-right">80% <br><span class="text-success"><i class="fa fa-hand-o-up"></i>
                                    Booked</span></li>
                            <li>20% <br><span class="text-danger"><i class="fa fa-hand-o-down"></i> Cancelled</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 p-l-0">
                    <div class="card text-center overflow-hidden">
                        <div class="widget-line  mt-5">
                            <p class="mb-2">Users</p>
                            <h1 class="font-weight-bold">500</h1>
                        </div>
                        <div class="mx-auto chart-circle chart-circle-md chart-circle-success" data-value="0.67"
                            data-thickness="15" data-color="#2dce89">
                            <div class="chart-circle-value fs">
                                <!--
                                <i class="fa fa-tags text-success"></i>
                                -->
                            </div>
                        </div>
                        <ul class="widget-line-list mt-5 mb-5">
                            <li class="border-right">75% <br><span class="text-success"><i class="fa fa-hand-o-up"></i>
                                    Positive</span></li>
                            <li>6% <br><span class="text-danger"><i class="fa fa-hand-o-down"></i> Negative</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- End Row 2 -->

            <!-- Row-3 -->
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Revenue Report</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-xl-3 col-6">
                                    <p class="mb-1">Today</p>
                                    <h3 class="mb-0 fs-20 number-font1">&#2547; {{ $revTripsToday }}</h3>
                                </div>
                                <div class="col-xl-3 col-6 ">
                                    <p class=" mb-1">Yesterday</p>
                                    <h3 class="mb-0 fs-20 number-font1">&#2547; {{ $revTripsYesterday }}</h3>
                                </div>
                                <div class="col-xl-3 col-6">
                                    <p class=" mb-1">This Week</p>
                                    <h3 class="mb-0 fs-20 number-font1">&#2547; {{ $revTripsWeek }}</h3>

                                </div>
                                <div class="col-xl-3 col-6">
                                    <p class=" mb-1">This Month</p>
                                    <h3 class="mb-0 fs-20 number-font1">&#2547; {{ $revTripsMonth }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Trip Report</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-xl-3 col-6">
                                    <p class="mb-1">Today</p>
                                    <h3 class="mb-0 fs-20 number-font1">{{ count($tripsToday) }} Trips</h3>
                                </div>
                                <div class="col-xl-3 col-6 ">
                                    <p class=" mb-1">Yesterday</p>
                                    <h3 class="mb-0 fs-20 number-font1">{{ count($tripsYesterday) }} Trips</h3>
                                </div>
                                <div class="col-xl-3 col-6">
                                    <p class=" mb-1">This Week</p>
                                    <h3 class="mb-0 fs-20 number-font1">{{ count($tripsWeek) }} Trips</h3>

                                </div>
                                <div class="col-xl-3 col-6">
                                    <p class=" mb-1">This Month</p>
                                    <h3 class="mb-0 fs-20 number-font1">{{ count($tripsMonth) }} Trips</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Row-3 -->
        </div>
    </div>
@endif
<!-- Dashboard for Admin -->

<!-- Dashboard for Moderator -->
@if(Auth::guard('admin_user')->user()->can('haveModeratorAccess', App\Models\AdminUser::class))
    <div class="app-content main-content">
        <div class="side-app">

            <!-- Row 1-->
            <div class="row">
                <!--Invoice-->
                <div class="col-sm-12 col-md-6 col-xl-3">
                    <div class="card bg-primary">
                        <div class="card-body">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h6 class="text-white">Total Partners</h6>
                                    <h2 class="text-white m-0 font-weight-bold">{{ count($partners) }}</h2>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-white display-6"><i class="fa fa-handshake-o"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-xl-3">
                    <div class="card bg-secondary">
                        <div class="card-body">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h6 class="text-white">Total Vehicles</h6>
                                    <h2 class="text-white m-0 font-weight-bold">{{ count($vehicles) }}</h2>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-white display-6"><i class="fa fa-car"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-xl-3">
                    <div class="card bg-warning">
                        <div class="card-body">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h6 class="text-white">Total Users</h6>
                                    <h2 class="text-white m-0 font-weight-bold">{{ count($users) }}</h2>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-white display-6"><i class="fa fa-user"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-xl-3">
                    <div class="card bg-info">
                        <div class="card-body">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h6 class="text-white">Todays Trips</h6>
                                    <h2 class="text-white m-0 font-weight-bold">{{ count($tripsToday) }}</h2>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-white display-6"><i class="fa fa-outdent"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Row 1 -->

            <!-- Row 2-->
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <div class="card text-center overflow-hidden">
                        <div class="widget-line mt-5 ">
                            <p class="mb-2">Vehicle Status</p>
                            <h1 class="font-weight-bold">{{ count($vehicles) }}</h1>
                        </div>
                        <div class="mx-auto chart-circle chart-circle-md chart-circle-primary" data-value="0.67"
                            data-thickness="15" data-color="#60499a">
                            <div class="chart-circle-value fs">
                                <!--
                                <i class="fa fa-random text-primary"></i>
                                -->
                            </div>
                        </div>
                        <ul class="widget-line-list mt-5 mb-5">
                            <li class="border-right">{{ count($onlineVehicles) }} <br><span class="text-success"><i class="fa fa-hand-o-up"></i>
                                    Online</span></li>
                            <li>{{ count($vehicles) - count($onlineVehicles) }} <br><span class="text-danger"><i class="fa fa-hand-o-down"></i> Offline</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 p-l-0 p-r-0">
                    <div class="card text-center overflow-hidden">
                        <div class="widget-line mt-5">
                            <p class="mb-2">Search Status</p>
                            <h1 class="font-weight-bold">350</h1>
                        </div>
                        <div class="mx-auto chart-circle chart-circle-md chart-circle-secondary" data-value="0.55"
                            data-thickness="15" data-color="#f7346b">
                            <div class="chart-circle-value fs">
                                <!--
                                <i class="fa fa-life-ring text-secondary"></i>
                                -->
                            </div>
                        </div>
                        <ul class="widget-line-list mt-5 mb-5">
                            <li class="border-right">80% <br><span class="text-success"><i class="fa fa-hand-o-up"></i>
                                    Booked</span></li>
                            <li>20% <br><span class="text-danger"><i class="fa fa-hand-o-down"></i> Cancelled</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 p-l-0">
                    <div class="card text-center overflow-hidden">
                        <div class="widget-line  mt-5">
                            <p class="mb-2">Users</p>
                            <h1 class="font-weight-bold">500</h1>
                        </div>
                        <div class="mx-auto chart-circle chart-circle-md chart-circle-success" data-value="0.67"
                            data-thickness="15" data-color="#2dce89">
                            <div class="chart-circle-value fs">
                                <!--
                                <i class="fa fa-tags text-success"></i>
                                -->
                            </div>
                        </div>
                        <ul class="widget-line-list mt-5 mb-5">
                            <li class="border-right">75% <br><span class="text-success"><i class="fa fa-hand-o-up"></i>
                                    Positive</span></li>
                            <li>6% <br><span class="text-danger"><i class="fa fa-hand-o-down"></i> Negative</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- End Row 2 -->

            <!-- Row-3 -->
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Revenue Report</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-xl-3 col-6">
                                    <p class="mb-1">Today</p>
                                    <h3 class="mb-0 fs-20 number-font1">&#2547; {{ $revTripsToday }}</h3>
                                </div>
                                <div class="col-xl-3 col-6 ">
                                    <p class=" mb-1">Yesterday</p>
                                    <h3 class="mb-0 fs-20 number-font1">&#2547; {{ $revTripsYesterday }}</h3>
                                </div>
                                <div class="col-xl-3 col-6">
                                    <p class=" mb-1">This Week</p>
                                    <h3 class="mb-0 fs-20 number-font1">&#2547; {{ $revTripsWeek }}</h3>

                                </div>
                                <div class="col-xl-3 col-6">
                                    <p class=" mb-1">This Month</p>
                                    <h3 class="mb-0 fs-20 number-font1">&#2547; {{ $revTripsMonth }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Trip Report</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-xl-3 col-6">
                                    <p class="mb-1">Today</p>
                                    <h3 class="mb-0 fs-20 number-font1">{{ count($tripsToday) }} Trips</h3>
                                </div>
                                <div class="col-xl-3 col-6 ">
                                    <p class=" mb-1">Yesterday</p>
                                    <h3 class="mb-0 fs-20 number-font1">{{ count($tripsYesterday) }} Trips</h3>
                                </div>
                                <div class="col-xl-3 col-6">
                                    <p class=" mb-1">This Week</p>
                                    <h3 class="mb-0 fs-20 number-font1">{{ count($tripsWeek) }} Trips</h3>

                                </div>
                                <div class="col-xl-3 col-6">
                                    <p class=" mb-1">This Month</p>
                                    <h3 class="mb-0 fs-20 number-font1">{{ count($tripsMonth) }} Trips</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Row-3 -->
        </div>
    </div>
@endif
<!-- Dashboard for Moderator -->

<!-- Dashboard for Partner -->
@if(Auth::guard('admin_user')->user()->can('havePartnerAccess', App\Models\AdminUser::class))
    <div class="app-content main-content">
        <div class="side-app">

            <!-- Row 1-->
            <div class="row">
                <!--Invoice-->
                <div class="col-sm-12 col-md-6 col-xl-3">
                    <div class="card bg-primary">
                        <div class="card-body">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h6 class="text-white">Total Vehicles</h6>
                                    <h2 class="text-white m-0 font-weight-bold">{{ count($vehicles) }}</h2>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-white display-6"><i class="fa fa-handshake-o"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-xl-3">
                    <div class="card bg-secondary">
                        <div class="card-body">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h6 class="text-white">Total Drivers</h6>
                                    <h2 class="text-white m-0 font-weight-bold">{{ count($drivers) }}</h2>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-white display-6"><i class="fa fa-car"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-xl-3">
                    <div class="card bg-warning">
                        <div class="card-body">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h6 class="text-white">Total Assistants</h6>
                                    <h2 class="text-white m-0 font-weight-bold">{{ count($assistants) }}</h2>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-white display-6"><i class="fa fa-user"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-xl-3">
                    <div class="card bg-info">
                        <div class="card-body">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h6 class="text-white">Todays Trip</h6>
                                    <h2 class="text-white m-0 font-weight-bold">{{ count($tripsToday) }}</h2>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-white display-6"><i class="fa fa-outdent"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Row 1 -->

            <!-- Row 2-->
            <div class="row">
                <div class="col-lg-4 col-sm-12">
                    <div class="card text-center overflow-hidden">
                        <div class="widget-line mt-5 ">
                            <p class="mb-2">Vehicle Status</p>
                            <h1 class="font-weight-bold">{{ count($vehicles) }}</h1>
                        </div>
                        <div class="mx-auto chart-circle chart-circle-md chart-circle-primary" data-value="0.67"
                            data-thickness="15" data-color="#60499a">
                            <div class="chart-circle-value fs">
                                <!--
                                <i class="fa fa-random text-primary"></i>
                                -->
                            </div>
                        </div>
                        <ul class="widget-line-list mt-5 mb-5">
                            <li class="border-right">{{ count($onlineVehicles) }} <br><span class="text-success"><i class="fa fa-hand-o-up"></i>
                                    Online</span></li>
                            <li>{{ count($vehicles) - count($onlineVehicles) }} <br><span class="text-danger"><i class="fa fa-hand-o-down"></i> Offline</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 p-l-0 p-r-0">
                    <div class="card text-center overflow-hidden">
                        <div class="widget-line mt-5">
                            <p class="mb-2">Driver Status</p>
                            <h1 class="font-weight-bold">{{ count($drivers) }}</h1>
                        </div>
                        <div class="mx-auto chart-circle chart-circle-md chart-circle-secondary" data-value="0.55"
                            data-thickness="15" data-color="#f7346b">
                            <div class="chart-circle-value fs">
                                <!--
                                <i class="fa fa-life-ring text-secondary"></i>
                                -->
                            </div>
                        </div>
                        <ul class="widget-line-list mt-5 mb-5">
                            <li class="border-right">{{ count($drivers->where('status', 'Active')) }} <br><span class="text-success"><i class="fa fa-hand-o-up"></i>
                                    Approved</span></li>
                            <li>{{ count($drivers->where('status', '!=', 'Active')) }}<br><span class="text-danger"><i class="fa fa-hand-o-down"></i> Pending</span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-12 p-l-0">
                    <div class="card text-center overflow-hidden">
                        <div class="widget-line  mt-5">
                            <p class="mb-2">Assistant Status</p>
                            <h1 class="font-weight-bold">{{ count($assistants) }}</h1>
                        </div>
                        <div class="mx-auto chart-circle chart-circle-md chart-circle-success" data-value="0.67"
                            data-thickness="15" data-color="#2dce89">
                            <div class="chart-circle-value fs">
                                <!--
                                <i class="fa fa-tags text-success"></i>
                                -->
                            </div>
                        </div>
                        <ul class="widget-line-list mt-5 mb-5">
                            <li class="border-right">{{ count($assistants->where('status', 'Active')) }}  <br><span class="text-success"><i class="fa fa-hand-o-up"></i>
                                    Approved</span></li>
                            <li>{{ count($assistants->where('status', '!=', 'Active')) }}<br><span class="text-danger"><i class="fa fa-hand-o-down"></i> Pending</span></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- End Row 2 -->

            <!-- Row-3 -->
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Revenue Report</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-xl-3 col-6">
                                    <p class="mb-1">Today</p>
                                    <h3 class="mb-0 fs-20 number-font1">&#2547; {{ $revTripsToday }}</h3>
                                </div>
                                <div class="col-xl-3 col-6 ">
                                    <p class=" mb-1">Yesterday</p>
                                    <h3 class="mb-0 fs-20 number-font1">&#2547; {{ $revTripsYesterday }}</h3>
                                </div>
                                <div class="col-xl-3 col-6">
                                    <p class=" mb-1">This Week</p>
                                    <h3 class="mb-0 fs-20 number-font1">&#2547; {{ $revTripsWeek }}</h3>

                                </div>
                                <div class="col-xl-3 col-6">
                                    <p class=" mb-1">This Month</p>
                                    <h3 class="mb-0 fs-20 number-font1">&#2547; {{ $revTripsMonth }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Trip Report</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-xl-3 col-6">
                                    <p class="mb-1">Today</p>
                                    <h3 class="mb-0 fs-20 number-font1">{{ count($tripsToday) }} Trips</h3>
                                </div>
                                <div class="col-xl-3 col-6 ">
                                    <p class=" mb-1">Yesterday</p>
                                    <h3 class="mb-0 fs-20 number-font1">{{ count($tripsYesterday) }} Trips</h3>
                                </div>
                                <div class="col-xl-3 col-6">
                                    <p class=" mb-1">This Week</p>
                                    <h3 class="mb-0 fs-20 number-font1">{{ count($tripsWeek) }} Trips</h3>

                                </div>
                                <div class="col-xl-3 col-6">
                                    <p class=" mb-1">This Month</p>
                                    <h3 class="mb-0 fs-20 number-font1">{{ count($tripsMonth) }} Trips</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Row-3 -->
        </div>
    </div>
@endif
<!-- Dashboard for Partner -->

<!-- Dashboard for Agent -->
@if(Auth::guard('admin_user')->user()->can('haveAgentAccess', App\Models\AdminUser::class))
    <div class="app-content main-content">
        <div class="side-app">

            <!-- Row 1-->
            <div class="row">
                <!--Invoice-->
                <div class="col-sm-12 col-md-6 col-xl-4">
                    <div class="card bg-primary">
                        <div class="card-body">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h6 class="text-white">Total Bookings</h6>
                                    <h2 class="text-white m-0 font-weight-bold">6</h2>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-white display-6"><i class="fa fa-handshake-o"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-xl-4">
                    <div class="card bg-secondary">
                        <div class="card-body">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h6 class="text-white">Pending Bookings</h6>
                                    <h2 class="text-white m-0 font-weight-bold">{{ count($vehicles) }}</h2>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-white display-6"><i class="fa fa-car"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-xl-4">
                    <div class="card bg-warning">
                        <div class="card-body">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h6 class="text-white">Booking Processing</h6>
                                    <h2 class="text-white m-0 font-weight-bold">{{ count($users) }}</h2>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-white display-6"><i class="fa fa-user"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6 col-xl-4">
                    <div class="card bg-info">
                        <div class="card-body">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h6 class="text-white">Booking Processed</h6>
                                    <h2 class="text-white m-0 font-weight-bold">{{ count($tripsToday) }}</h2>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-white display-6"><i class="fa fa-outdent"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-xl-4">
                    <div class="card bg-success">
                        <div class="card-body">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h6 class="text-white">Running Trips</h6>
                                    <h2 class="text-white m-0 font-weight-bold">{{ count($tripsToday) }}</h2>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-white display-6"><i class="fa fa-outdent"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-xl-4">
                    <div class="card bg-danger">
                        <div class="card-body">
                            <div class="d-flex no-block align-items-center">
                                <div>
                                    <h6 class="text-white">Cancelled Trips</h6>
                                    <h2 class="text-white m-0 font-weight-bold">{{ count($tripsToday) }}</h2>
                                </div>
                                <div class="ml-auto">
                                    <span class="text-white display-6"><i class="fa fa-outdent"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Row 1 -->

            <!-- Row 2-->
            <!-- End Row 2-->

            <!-- Row-3 -->
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Revenue Report</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-xl-3 col-6">
                                    <p class="mb-1">Today</p>
                                    <h3 class="mb-0 fs-20 number-font1">&#2547; {{ $revTripsToday }}</h3>
                                </div>
                                <div class="col-xl-3 col-6 ">
                                    <p class=" mb-1">Yesterday</p>
                                    <h3 class="mb-0 fs-20 number-font1">&#2547; {{ $revTripsYesterday }}</h3>
                                </div>
                                <div class="col-xl-3 col-6">
                                    <p class=" mb-1">This Week</p>
                                    <h3 class="mb-0 fs-20 number-font1">&#2547; {{ $revTripsWeek }}</h3>

                                </div>
                                <div class="col-xl-3 col-6">
                                    <p class=" mb-1">This Month</p>
                                    <h3 class="mb-0 fs-20 number-font1">&#2547; {{ $revTripsMonth }}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Trip Report</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-xl-3 col-6">
                                    <p class="mb-1">Today</p>
                                    <h3 class="mb-0 fs-20 number-font1">{{ count($tripsToday) }} Trips</h3>
                                </div>
                                <div class="col-xl-3 col-6 ">
                                    <p class=" mb-1">Yesterday</p>
                                    <h3 class="mb-0 fs-20 number-font1">{{ count($tripsYesterday) }} Trips</h3>
                                </div>
                                <div class="col-xl-3 col-6">
                                    <p class=" mb-1">This Week</p>
                                    <h3 class="mb-0 fs-20 number-font1">{{ count($tripsWeek) }} Trips</h3>

                                </div>
                                <div class="col-xl-3 col-6">
                                    <p class=" mb-1">This Month</p>
                                    <h3 class="mb-0 fs-20 number-font1">{{ count($tripsMonth) }} Trips</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Row-3 -->
        </div>
    </div>
@endif
<!-- Dashboard for Agent -->
