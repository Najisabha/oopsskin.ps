<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'OOPSSKIN | متجر المكياج الأول')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <style>
        :root {
            --brand-primary: #d63384;
            --brand-dark: #121212;
            --brand-accent: #ffc107;
            --bg-light: #fdfdfd;
            --transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: var(--bg-light);
            color: var(--brand-dark);
            overflow-x: hidden;
        }

        /* --- Luxury Navbar --- */
        .top-navbar {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 15px 0;
            transition: var(--transition);
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 800;
            font-size: 1.8rem;
            letter-spacing: 1px;
            color: var(--brand-dark) !important;
        }

        .nav-link {
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--brand-dark) !important;
            text-transform: uppercase;
            padding: 0.5rem 1rem !important;
            position: relative;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--brand-primary);
            transition: var(--transition);
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 70%;
        }

        /* --- Search Bar Modern --- */
        .search-container {
            position: relative;
            max-width: 400px;
            width: 100%;
        }

        .search-input {
            border-radius: 50px;
            border: 1px solid #eee;
            padding: 8px 45px 8px 20px;
            font-size: 0.9rem;
            background: #f8f8f8;
            transition: var(--transition);
        }

        .search-input:focus {
            background: #fff;
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            border-color: var(--brand-primary);
        }

        .search-icon-btn {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            color: #888;
        }

        /* --- Icons & Badges --- */
        .action-icon {
            font-size: 1.3rem;
            color: var(--brand-dark);
            position: relative;
            transition: var(--transition);
        }

        .action-icon:hover {
            color: var(--brand-primary);
            transform: translateY(-2px);
        }

        .cart-badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background: var(--brand-primary);
            color: white;
            font-size: 0.65rem;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid #fff;
        }

        /* --- Dropdowns Luxury --- */
        .dropdown-menu {
            border: none;
            box-shadow: 0 15px 50px rgba(0,0,0,0.1);
            border-radius: 12px;
            padding: 15px;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dropdown-item {
            border-radius: 8px;
            padding: 8px 15px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: var(--transition);
        }

        .dropdown-item:hover {
            background: var(--secondary-color);
            color: var(--brand-primary);
            padding-right: 20px;
        }

        /* --- Footer Luxury --- */
        .footer {
            background: #090909;
            color: #fff;
            padding: 80px 0 30px;
        }

        .footer-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            margin-bottom: 25px;
            color: #fff;
        }

        .footer-link {
            color: #999;
            text-decoration: none;
            display: block;
            margin-bottom: 12px;
            transition: var(--transition);
        }

        .footer-link:hover {
            color: var(--brand-primary);
            transform: translateX(-5px);
        }

        /* --- Floating Action Button (Mobile) --- */
        @media (max-width: 991px) {
            .navbar-brand { font-size: 1.4rem; }
            .desktop-nav { display: none; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <nav class="top-navbar sticky-top">
        <div class="container">
            <div class="row align-items-center">
                
                <div class="col-lg-3 col-6 order-1">
                    <a class="navbar-brand" href="{{ route('home') }}">
                        <span style="color: var(--brand-primary);">O</span>OPSSKIN
                    </a>
                </div>

                <div class="col-lg-6 d-none d-lg-block order-2">
                    <ul class="nav justify-content-center">
                        <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">الرئيسية</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">الأنواع</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('categories.index') }}">كل الفئات</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">مكياج عيون</a></li>
                                <li><a class="dropdown-item" href="#">عناية بالبشرة</a></li>
                                <li><a class="dropdown-item" href="#">عطور</a></li>
                            </ul>
                        </li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">المنتجات</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">من نحن</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">تواصل معنا</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-6 order-3">
                    <div class="d-flex align-items-center justify-content-end gap-3">
                        
                        <div class="d-none d-xl-block">
                            <form action="{{ route('search') }}" method="GET" class="search-container">
                                <input type="text" name="q" class="search-input w-100" placeholder="ابحثي عن جمالك..." value="{{ request('q') }}">
                                <button type="submit" class="search-icon-btn"><i class="bi bi-search"></i></button>
                            </form>
                        </div>

                        <a href="{{ route('cart.index') }}" class="action-icon">
                            <i class="bi bi-bag"></i>
                            <span class="cart-badge">0</span>
                        </a>

                        @auth
                        <div class="dropdown">
                            <a href="#" class="action-icon" data-bs-toggle="dropdown">
                                <i class="bi bi-person"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow">
                                <li class="px-3 py-2 small fw-bold text-muted border-bottom mb-2">أهلاً، {{ Auth::user()->name }}</li>
                                <li><a class="dropdown-item" href="{{ route('settings') }}"><i class="bi bi-gear me-2"></i> الإعدادات</a></li>
                                <li><a class="dropdown-item" href="{{ route('addresses.index') }}"><i class="bi bi-geo-alt me-2"></i> العناوين</a></li>
                                <li><a class="dropdown-item" href="{{ route('invoices.index') }}"><i class="bi bi-receipt me-2"></i> الفواتير</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger fw-bold border-0 bg-transparent w-100 text-end">
                                            <i class="bi bi-box-arrow-right me-2"></i> تسجيل الخروج
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                        @else
                        <div class="dropdown">
                            <a href="#" class="action-icon" data-bs-toggle="dropdown">
                                <i class="bi bi-person"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item fw-bold" href="{{ route('login') }}">تسجيل الدخول</a></li>
                                <li><a class="dropdown-item" href="{{ route('register') }}">إنشاء حساب</a></li>
                            </ul>
                        </div>
                        @endauth

                        <button class="btn d-lg-none p-0 border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                            <i class="bi bi-list fs-2"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold">OOPSSKIN</h5>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form action="{{ route('search') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="q" class="form-control rounded-start-pill border-end-0" placeholder="بحث...">
                    <button class="btn btn-outline-secondary rounded-end-pill border-start-0" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
            <ul class="nav flex-column gap-2">
                <li class="nav-item"><a class="nav-link fs-5" href="{{ route('home') }}">الرئيسية</a></li>
                <li class="nav-item"><a class="nav-link fs-5" href="{{ route('categories.index') }}">الأنواع</a></li>
                <li class="nav-item"><a class="nav-link fs-5" href="{{ route('products.index') }}">كل المنتجات</a></li>
                <li class="nav-item"><a class="nav-link fs-5" href="{{ route('about') }}">من نحن</a></li>
                <li class="nav-item"><a class="nav-link fs-5" href="{{ route('contact') }}">تواصل معنا</a></li>
            </ul>
        </div>
    </div>

    <main class="flex-grow-1">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4 col-md-6">
                    <h5 class="footer-title">OOPSSKIN</h5>
                    <p class="text-muted" style="line-height: 2;">
                        وجهتِك الأولى لعالم الجمال الفاخر. نختار منتجاتنا بعناية فائقة لنضمن لكِ الجودة والأناقة التي تستحقينها.
                    </p>
                    <div class="d-flex gap-3 mt-4">
                        <a href="#" class="fs-5 text-white"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="fs-5 text-white"><i class="bi bi-snapchat"></i></a>
                        <a href="#" class="fs-5 text-white"><i class="bi bi-tiktok"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3">
                    <h6 class="text-white fw-bold mb-4">التسوق</h6>
                    <a href="{{ route('products.index') }}" class="footer-link">جميع المنتجات</a>
                    <a href="{{ route('categories.index') }}" class="footer-link">الفئات</a>
                    <a href="#" class="footer-link">وصل حديثاً</a>
                    <a href="#" class="footer-link">الأكثر مبيعاً</a>
                </div>
                <div class="col-lg-2 col-md-3">
                    <h6 class="text-white fw-bold mb-4">الدعم</h6>
                    <a href="{{ route('about') }}" class="footer-link">من نحن</a>
                    <a href="{{ route('contact') }}" class="footer-link">تواصل معنا</a>
                    <a href="{{ route('story') }}" class="footer-link">قصتنا</a>
                    <a href="#" class="footer-link">سياسة الخصوصية</a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h6 class="text-white fw-bold mb-4">النشرة البريدية</h6>
                    <p class="small text-muted mb-4">اشتركي للحصول على عروض حصرية وتحديثات الجمال.</p>
                    <form class="d-flex gap-2">
                        <input type="email" class="form-control bg-dark border-0 text-white p-3" placeholder="بريدك الإلكتروني">
                        <button class="btn btn-primary px-4 border-0" style="background: var(--brand-primary);">اشتراك</button>
                    </form>
                </div>
            </div>
            <div class="border-top border-secondary mt-5 pt-4 text-center">
                <p class="small text-muted mb-0">
                    &copy; {{ date('Y') }} <strong>OOPSSKIN</strong>. صُنع بكل حب لجمالك.
                </p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>