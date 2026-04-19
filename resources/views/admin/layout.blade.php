<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - SIRI</title>

    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- HexaDash CSS -->
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor_assets/css/bootstrap/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor_assets/css/daterangepicker.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('admin-assets/style.css') }}">
    {{-- Unicons v3 — v4 font files corrupt --}}
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.0/css/line.css">
    @livewireStyles

    <style>
        /* Order badge di sidebar */
        .order-badge-count {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 18px;
            height: 18px;
            padding: 0 4px;
            background: #e85347;
            color: white;
            border-radius: 9px;
            font-size: 10px;
            font-weight: 700;
            margin-left: 6px;
            line-height: 1;
        }
        .sidebar-order-link {
            display: flex;
            align-items: center;
        }
        /* Alert styles */
        .alert-custom { padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; }
        .alert-success-custom { background: rgba(16,185,129,.1); color: #10B981; border: 1px solid rgba(16,185,129,.2); }
        .alert-danger-custom  { background: rgba(239,68,68,.1);  color: #EF4444;  border: 1px solid rgba(239,68,68,.2); }
    </style>
    @stack('styles')
</head>
<body class="layout-light side-menu">
    <div class="mobile-search">
        <form action="/" class="search-form">
            <img src="{{ asset('admin-assets/img/svg/search.svg') }}" alt="search" class="svg">
            <input class="form-control me-sm-2 box-shadow-none" type="search" placeholder="Search..." aria-label="Search">
        </form>
    </div>
    <div class="mobile-author-actions"></div>

    <!-- Header -->
    <header class="header-top">
        <nav class="navbar navbar-light">
            <div class="navbar-left">
                <div class="logo-area">
                    <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                        <img class="dark" src="{{ asset('admin-assets/img/logo-dark.png') }}" alt="logo">
                        <img class="light" src="{{ asset('admin-assets/img/logo-white.png') }}" alt="logo">
                    </a>
                    <a href="#" class="sidebar-toggle">
                        <img class="svg" src="{{ asset('admin-assets/img/svg/align-center-alt.svg') }}" alt="img">
                    </a>
                </div>
            </div>
            <div class="navbar-right">
                <ul class="navbar-right__menu">
                    <li class="nav-author">
                        <div class="dropdown-custom">
                            <a href="javascript:;" class="nav-item-toggle">
                                <span class="nav-item__title">{{ auth()->user()->name }}<i class="las la-angle-down nav-item__arrow"></i></span>
                            </a>
                            <div class="dropdown-parent-wrapper">
                                <div class="dropdown-wrapper">
                                    <div class="nav-author__info">
                                        <div class="author-img">
                                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #EC4899, #A855F7); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
                                                {{ substr(auth()->user()->name, 0, 1) }}
                                            </div>
                                        </div>
                                        <div>
                                            <h6>{{ auth()->user()->name }}</h6>
                                            <span>{{ auth()->user()->email }}</span>
                                        </div>
                                    </div>
                                    <div class="nav-author__options">
                                        <ul>
                                            <li>
                                                <form action="{{ route('admin.logout') }}" method="POST">
                                                    @csrf
                                                    <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer; width: 100%; text-align: left;">
                                                        <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                                            <i class="uil uil-sign-out-alt"></i> Sign Out
                                                        </a>
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <!-- Sidebar -->
        <div class="sidebar-wrapper">
            <div class="sidebar sidebar-collapse" id="sidebar">
                <div class="sidebar__menu-group">
                    <ul class="sidebar_nav">
                        <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <span class="nav-icon uil uil-create-dashboard"></span>
                                <span class="menu-text">Dashboard</span>
                            </a>
                        </li>

                        <li class="menu-title mt-30">
                            <span>Management</span>
                        </li>

                        <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                <span class="nav-icon uil uil-users-alt"></span>
                                <span class="menu-text">Users</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }} sidebar-order-link">
                                <span class="nav-icon uil uil-shopping-cart-alt"></span>
                                <span class="menu-text">Orders</span>
                                @livewire('order-badge', [], key('order-badge'))
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('admin.stores.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.stores.index') }}" class="{{ request()->routeIs('admin.stores.*') ? 'active' : '' }}">
                                <span class="nav-icon uil uil-store"></span>
                                <span class="menu-text">Stores</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.services.index') }}" class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                                <span class="nav-icon uil uil-car"></span>
                                <span class="menu-text">Services</span>
                            </a>
                        </li>

                        <li class="menu-title mt-30">
                            <span>Content</span>
                        </li>

                        <li class="{{ request()->routeIs('admin.home-sections.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.home-sections.index') }}" class="{{ request()->routeIs('admin.home-sections.*') ? 'active' : '' }}">
                                <span class="nav-icon uil uil-apps"></span>
                                <span class="menu-text">Home Sections</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('admin.push-notifications.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.push-notifications.index') }}" class="{{ request()->routeIs('admin.push-notifications.*') ? 'active' : '' }}">
                                <span class="nav-icon uil uil-bell"></span>
                                <span class="menu-text">Push Notifications</span>
                            </a>
                        </li>

                        <li class="menu-title mt-30">
                            <span>Finance</span>
                        </li>

                        <li class="{{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.transactions.index') }}" class="{{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
                                <span class="nav-icon uil uil-usd-circle"></span>
                                <span class="menu-text">Transactions</span>
                            </a>
                        </li>

                        <li class="menu-title mt-30">
                            <span>Settings</span>
                        </li>

                        <li class="{{ request()->routeIs('admin.account-deletions.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.account-deletions.index') }}" class="{{ request()->routeIs('admin.account-deletions.*') ? 'active' : '' }}">
                                <span class="nav-icon uil uil-trash-alt"></span>
                                <span class="menu-text">Account Deletions</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('admin.drivers.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.drivers.index') }}" class="{{ request()->routeIs('admin.drivers.*') ? 'active' : '' }}">
                                <span class="nav-icon uil uil-car-sideview"></span>
                                <span class="menu-text">Drivers</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('admin.food-items.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.food-items.index') }}" class="{{ request()->routeIs('admin.food-items.*') ? 'active' : '' }}">
                                <span class="nav-icon uil uil-restaurant"></span>
                                <span class="menu-text">Menu Makanan</span>
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.posts.index') }}" class="{{ request()->routeIs('admin.posts.*') ? 'active' : '' }}">
                                <span class="nav-icon uil uil-image"></span>
                                <span class="menu-text">Posts
                                    @php $reportCount = \Illuminate\Support\Facades\DB::table('post_reports')->count(); @endphp
                                    @if($reportCount > 0)
                                        <span class="order-badge-count">{{ $reportCount }}</span>
                                    @endif
                                </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="contents">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb-main">
                            <h4 class="text-capitalize breadcrumb-title">@yield('page-title', 'Dashboard')</h4>
                            <div class="breadcrumb-action justify-content-center flex-wrap">
                                @yield('breadcrumb')
                            </div>
                        </div>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert-custom alert-success-custom">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert-custom alert-danger-custom">
                        <ul style="margin: 0; padding-left: 1.5rem;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </main>

    <!-- Scripts -->
    <script src="{{ asset('admin-assets/vendor_assets/js/jquery/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/jquery/jquery-ui.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/bootstrap/popper.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/moment/moment.min.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/accordion.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/autoComplete.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/Chart.min.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/daterangepicker.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/drawer.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/dynamicBadge.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/dynamicCheckbox.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/footable.min.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/jquery.filterizr.min.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/jquery.star-rating-svg.min.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/message.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/moment.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/notification.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/popover.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/trumbowyg.min.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/wickedpicker.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            if ($('.date-picker').length > 0) {
                $('.date-picker').datepicker();
            }
        });
    </script>

    <script src="{{ asset('admin-assets/theme_assets/js/main.js') }}"></script>
    @livewireScripts
    @stack('scripts')
</body>
</html>
