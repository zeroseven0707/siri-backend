<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - Push</title>

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
        /* Green theme override */
        :root {
            --color-primary: #22C55E !important;
            --bg-primary: #22C55E !important;
            --bg-primary-hover: #16A34A !important;
            --color-primary-rgba: 34, 197, 94 !important;
            --color-primary-rgba-shadow: rgba(34, 197, 94, 0.20) !important;
        }
        .btn-primary, .btn-primary:focus {
            background-color: #22C55E !important;
            border-color: #22C55E !important;
        }
        .btn-primary:hover { background-color: #16A34A !important; border-color: #16A34A !important; }
        a:not(.btn):not(.nav-link):not(.navbar-brand):not([class*="uil"]):hover { color: #22C55E; }
        /* Logo */
        .navbar-brand { display: flex !important; align-items: center; gap: 8px; text-decoration: none !important; margin-right: 16px !important; }
        .navbar-left .navbar-brand img,
        .navbar-left .navbar-brand svg { max-width: 30px !important; min-width: 30px !important; height: 30px; width: 30px; object-fit: contain; border-radius: 6px; flex-shrink: 0; }
        .navbar-brand .brand-name { font-size: 15px; font-weight: 700; color: #0A0A0A; letter-spacing: -0.2px; white-space: nowrap; }
        .navbar-brand .brand-name span { color: #22C55E; }
        .logo-area { gap: 0; }
        /* Alert styles */
        .alert-custom { padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; }
        .alert-success-custom { background: rgba(16,185,129,.1); color: #10B981; border: 1px solid rgba(16,185,129,.2); }
        .alert-danger-custom  { background: rgba(239,68,68,.1);  color: #EF4444;  border: 1px solid rgba(239,68,68,.2); }

        /* ── Sidebar redesign ── */
        .sidebar-wrapper .sidebar { display: flex; flex-direction: column; height: 100%; }
        .sidebar__menu-group { display: flex; flex-direction: column; height: 100%; }

        /* User info card at top of sidebar */
        .sidebar-user-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 16px 20px;
            margin: 12px 12px 4px;
            background: linear-gradient(135deg, rgba(34,197,94,.12), rgba(22,163,74,.06));
            border-radius: 12px;
            border: 1px solid rgba(34,197,94,.15);
        }
        .sidebar-user-card .avatar {
            width: 38px; height: 38px; border-radius: 10px;
            background: linear-gradient(135deg, #22C55E, #16A34A);
            display: flex; align-items: center; justify-content: center;
            color: white; font-weight: 700; font-size: 15px; flex-shrink: 0;
        }
        .sidebar-user-card .info { overflow: hidden; }
        .sidebar-user-card .info strong { display: block; font-size: 13px; font-weight: 600; color: #0A0A0A; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sidebar-user-card .info span { font-size: 11px; color: #8C90A4; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; display: block; }

        /* Nav list spacing */
        .sidebar_nav { flex: 1; padding: 8px 0; }

        /* Menu title labels */
        .sidebar_nav .menu-title { padding: 18px 20px 6px !important; }
        .sidebar_nav .menu-title span { font-size: 10px; font-weight: 700; letter-spacing: 0.8px; text-transform: uppercase; color: #A0A0A0; }

        /* Nav items */
        .sidebar_nav > li > a {
            display: flex !important;
            align-items: center;
            gap: 10px;
            padding: 8px 20px !important;
            margin: 1px 8px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 500;
            color: #5A5F7D;
            transition: all 0.18s ease;
        }
        .sidebar_nav > li > a:hover {
            background: rgba(34,197,94,.08) !important;
            color: #16A34A !important;
        }
        .sidebar_nav > li.active > a,
        .sidebar_nav > li > a.active {
            background: rgba(34,197,94,.12) !important;
            color: #16A34A !important;
            font-weight: 600;
        }
        .sidebar_nav > li > a .nav-icon {
            font-size: 18px;
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-logout-item {
            margin: 4px 8px 16px !important;
            border-top: 1px solid #f1f2f6 !important;
            padding-top: 8px !important;
        }
        .sidebar-logout-item button {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            padding: 10px 12px;
            border-radius: 10px;
            border: none;
            background: none;
            cursor: pointer;
            font-size: 13.5px;
            font-weight: 500;
            color: #e85347;
            transition: background 0.18s;
            text-align: left;
        }
        .sidebar-logout-item button:hover { background: rgba(232,83,71,.08); }
        .sidebar-logout-item button .nav-icon { font-size: 18px; width: 20px; text-align: center; color: #e85347; }
        .sidebar-logout-item a {
            display: flex !important;
            align-items: center;
            gap: 10px;
            padding: 10px 12px !important;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 500;
            color: #e85347 !important;
            transition: background 0.18s;
        }
        .sidebar-logout-item a:hover { background: rgba(232,83,71,.08) !important; }
        .sidebar-logout-item .nav-icon { color: #e85347 !important; font-size: 18px; width: 20px; text-align: center; }
        @media (max-width: 767px) {
            /* Reposition mobile-author-actions to be inside the header */
            .mobile-author-actions {
                display: flex !important;
                align-items: center;
                position: absolute;
                right: 56px; /* leave room for burger */
                top: 0;
                height: 72px;
            }
            .mobile-author-actions .navbar-right__menu {
                display: flex !important;
                align-items: center;
                margin: 0; padding: 0; list-style: none;
            }

            /* Header must be relative so absolute child works */
            .header-top { position: relative; }
            .header-top .navbar { position: static; }

            /* Logo area: no desktop sidebar-toggle */
            .logo-area { min-width: unset !important; padding-left: 16px !important; background: transparent !important; height: 72px !important; }
            .logo-area .sidebar-toggle { display: none !important; }

            /* Burger button on the far right */
            .mobile-burger {
                display: flex !important;
                align-items: center;
                justify-content: center;
                width: 40px; height: 40px;
                border-radius: 8px;
                background: #f4f5f7;
                font-size: 20px;
                color: #0A0A0A;
                flex-shrink: 0;
                position: absolute;
                right: 12px;
                top: 50%;
                transform: translateY(-50%);
            }

            /* Dropdown position fix */
            .nav-author .dropdown-parent-wrapper { right: 0 !important; left: auto !important; }
        }

        .sidebar-toggle svg {
            color: #5A5F7D;
            transition: color 0.3s;
        }
        .sidebar-toggle:hover svg {
            color: #22C55E;
        }

        @media (min-width: 768px) {
            .mobile-burger { display: none !important; }
        }
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
                        <span class="brand-name">Push <span>Admin</span></span>
                    </a>
                    <a href="#" class="sidebar-toggle">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6H20M4 12H20M4 18H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
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
                                            <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #22C55E, #16A34A); display: flex; align-items: center; justify-content: center; color: white; font-weight: 600;">
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
                {{-- Mobile burger: hanya tampil di mobile, trigger sidebar-toggle --}}
                <a href="#" class="sidebar-toggle mobile-burger">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6H20M4 12H20M4 18H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </div>
        </nav>
    </header>

    <main class="main-content">
        <!-- Sidebar -->
        <div class="sidebar-wrapper">
            <div class="sidebar sidebar-collapse" id="sidebar">
                <div class="sidebar__menu-group">
                    {{-- User info card --}}
                    <ul class="sidebar_nav">

                        {{-- Dashboard --}}
                        <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                                <span class="nav-icon uil uil-create-dashboard"></span>
                                <span class="menu-text">Dashboard</span>
                            </a>
                        </li>

                        {{-- Content Management --}}
                        <li class="menu-title mt-20"><span>Content & Marketing</span></li>
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

                        {{-- Business --}}
                        <li class="menu-title mt-20"><span>Business Operations</span></li>
                        <li class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }} sidebar-order-link">
                                <span class="nav-icon uil uil-shopping-cart-alt"></span>
                                <span class="menu-text">Orders</span>
                                @livewire('order-badge', [], key('order-badge'))
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.transactions.index') }}" class="{{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
                                <span class="nav-icon uil uil-usd-circle"></span>
                                <span class="menu-text">Transactions</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin.stores.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.stores.index') }}" class="{{ request()->routeIs('admin.stores.*') ? 'active' : '' }}">
                                <span class="nav-icon uil uil-store"></span>
                                <span class="menu-text">Stores</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin.food-items.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.food-items.index') }}" class="{{ request()->routeIs('admin.food-items.*') ? 'active' : '' }}">
                                <span class="nav-icon uil uil-restaurant"></span>
                                <span class="menu-text">Food Items</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.services.index') }}" class="{{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                                <span class="nav-icon uil uil-car"></span>
                                <span class="menu-text">Services</span>
                            </a>
                        </li>

                        {{-- People --}}
                        <li class="menu-title mt-20"><span>Users & Drivers</span></li>
                        <li class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                                <span class="nav-icon uil uil-users-alt"></span>
                                <span class="menu-text">Customers</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin.drivers.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.drivers.index') }}" class="{{ request()->routeIs('admin.drivers.*') ? 'active' : '' }}">
                                <span class="nav-icon uil uil-car-sideview"></span>
                                <span class="menu-text">Drivers</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('admin.account-deletions.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.account-deletions.index') }}" class="{{ request()->routeIs('admin.account-deletions.*') ? 'active' : '' }}">
                                <span class="nav-icon uil uil-user-times"></span>
                                <span class="menu-text">Account Deletions</span>
                            </a>
                        </li>

                        {{-- Logout --}}
                        <li class="sidebar-logout-item">
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit">
                                    <span class="nav-icon uil uil-sign-out-alt"></span>
                                    <span class="menu-text">Sign Out</span>
                                </button>
                            </form>
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

    <script>
        // Bind mobile burger to sidebar collapse (theme JS only binds first .sidebar-toggle)
        $(document).on('click', '.mobile-burger', function(e) {
            e.preventDefault();
            $('.overlay-dark-sidebar').toggleClass('show');
            document.querySelector('.sidebar').classList.toggle('collapsed');
            document.querySelector('.contents').classList.toggle('expanded');
        });
    </script>
    @livewireScripts
    @stack('scripts')
</body>
</html>
