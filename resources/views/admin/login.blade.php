<!doctype html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - SIRI Admin</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- HexaDash CSS -->
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor_assets/css/bootstrap/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor_assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/vendor_assets/css/line-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin-assets/style.css') }}">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.0/css/line.css">

    <style>
        /* Pink Theme Customization */
        .btn-primary {
            background: linear-gradient(135deg, #EC4899, #A855F7) !important;
            border-color: #EC4899 !important;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #DB2777, #9333EA) !important;
        }

        .form-control:focus {
            border-color: #EC4899;
            box-shadow: 0 0 0 0.2rem rgba(236, 72, 153, 0.25);
        }

        .color-primary {
            color: #EC4899 !important;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: #EF4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
    </style>
</head>

<body>
    <main class="main-content">
        <div class="admin">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-xxl-3 col-xl-4 col-md-6 col-sm-8">
                        <div class="edit-profile">
                            <div class="edit-profile__logos">
                                <a href="{{ route('admin.login') }}">
                                    <img class="dark" src="{{ asset('admin-assets/img/logo-dark.png') }}" alt="">
                                    <img class="light" src="{{ asset('admin-assets/img/logo-white.png') }}" alt="">
                                </a>
                            </div>
                            <div class="card border-0">
                                <div class="card-header">
                                    <div class="edit-profile__title">
                                        <h6>Sign in to SIRI Admin</h6>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if($errors->any())
                                        <div class="alert-danger">
                                            <ul style="margin: 0; padding-left: 1.5rem;">
                                                @foreach($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="edit-profile__body">
                                        <form action="{{ route('admin.authenticate') }}" method="POST">
                                            @csrf
                                            <div class="form-group mb-25">
                                                <label for="email">Email Address</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="{{ old('email') }}" required>
                                            </div>
                                            <div class="form-group mb-15">
                                                <label for="password-field">Password</label>
                                                <div class="position-relative">
                                                    <input id="password-field" type="password" class="form-control" name="password" placeholder="Password" required>
                                                    <div class="uil uil-eye-slash text-lighten fs-15 field-icon toggle-password2"></div>
                                                </div>
                                            </div>
                                            <div class="admin-condition">
                                                <div class="checkbox-theme-default custom-checkbox">
                                                    <input class="checkbox" type="checkbox" id="check-1" name="remember">
                                                    <label for="check-1">
                                                        <span class="checkbox-text">Keep me logged in</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="admin__button-group button-group d-flex pt-1 justify-content-md-start justify-content-center">
                                                <button type="submit" class="btn btn-primary btn-default w-100 btn-squared text-capitalize lh-normal px-50 signIn-createBtn">
                                                    Sign In
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="overlayer">
        <div class="loader-overlay">
            <div class="dm-spin-dots spin-lg">
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
                <span class="spin-dot badge-dot dot-primary"></span>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('admin-assets/vendor_assets/js/jquery/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/bootstrap/popper.js') }}"></script>
    <script src="{{ asset('admin-assets/vendor_assets/js/bootstrap/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin-assets/theme_assets/js/main.js') }}"></script>
</body>
</html>
