<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'متجر المكياج')</title>
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #d63384;
            --secondary-color: #ffc107;
            --dark-color: #212529;
            --light-color: #f8f9fa;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 76px;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, #c2185b 100%);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .nav-link:hover {
            color: #fff !important;
            transform: translateY(-2px);
        }
        
        .footer {
            background: linear-gradient(135deg, var(--dark-color) 0%, #1a1a1a 100%);
            color: #fff;
            margin-top: auto;
        }
        
        .footer a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer a:hover {
            color: var(--primary-color);
        }
        
        .main-content {
            min-height: calc(100vh - 200px);
        }
        
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--secondary-color);
            color: var(--dark-color);
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
        }
    </style>
    
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="bi bi-palette-fill"></i> OOPSSKIN </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">
                            <i class="bi bi-house-door"></i> الرئيسية
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories.index') }}">
                            <i class="bi bi-grid"></i> الأنواع
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('products.index') }}">
                            <i class="bi bi-box-seam"></i> جميع المنتجات
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">
                            <i class="bi bi-info-circle"></i> من نحن
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">
                            <i class="bi bi-envelope"></i> تواصل معنا
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <form class="d-flex me-3" action="{{ route('search') }}" method="GET">
                            <input class="form-control form-control-sm" type="search" name="q" placeholder="بحث..." value="{{ request('q') }}">
                            <button class="btn btn-outline-light btn-sm me-2" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </form>
                    </li>
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('settings') }}"><i class="bi bi-gear"></i> الإعدادات</a></li>
                                <li><a class="dropdown-item" href="{{ route('addresses.index') }}"><i class="bi bi-geo-alt"></i> العناوين</a></li>
                                <li><a class="dropdown-item" href="{{ route('invoices.index') }}"><i class="bi bi-receipt"></i> الفواتير</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="bi bi-box-arrow-right"></i> تسجيل الخروج
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right"></i> تسجيل الدخول
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="bi bi-person-plus"></i> إنشاء حساب
                            </a>
                        </li>
                    @endauth
                    <li class="nav-item position-relative">
                        <a class="nav-link" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart3"></i> السلة
                            <span class="cart-badge">0</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content flex-grow-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5 class="mb-3">متجر المكياج</h5>
                    <p>نوفر لك أفضل منتجات المكياج والعناية بالبشرة من أشهر الماركات العالمية</p>
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="mb-3">روابط سريعة</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}">الرئيسية</a></li>
                        <li><a href="{{ route('categories.index') }}">الأنواع</a></li>
                        <li><a href="{{ route('products.index') }}">المنتجات</a></li>
                        <li><a href="{{ route('about') }}">من نحن</a></li>
                    </ul>
                </div>
                <div class="col-md-2 mb-4">
                    <h6 class="mb-3">معلومات</h6>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('story') }}">قصتنا</a></li>
                        <li><a href="{{ route('contact') }}">تواصل معنا</a></li>
                        <li><a href="#">الشروط والأحكام</a></li>
                        <li><a href="#">سياسة الخصوصية</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-4">
                    <h6 class="mb-3">تابعنا</h6>
                    <div class="d-flex gap-3">
                        <a href="#" class="fs-4"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="fs-4"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="fs-4"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="fs-4"><i class="bi bi-youtube"></i></a>
                    </div>
                    <p class="mt-3 mb-0">
                        <i class="bi bi-envelope"></i> info@makeupstore.com<br>
                        <i class="bi bi-telephone"></i> +966 50 123 4567
                    </p>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(255,255,255,0.2);">
            <div class="text-center">
                <p class="mb-0">&copy; {{ date('Y') }} متجر المكياج. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    @stack('scripts')
</body>
</html>

