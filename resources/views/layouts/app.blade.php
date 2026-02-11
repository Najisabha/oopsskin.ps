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
            --brand-primary: #000000;
            --brand-secondary: #E91E63;
            --brand-accent: #FF6B9D;
            --brand-gold: #D4AF37;
            --bg-light: #FFFFFF;
            --bg-cream: #FAF9F6;
            --text-dark: #000000;
            --text-gray: #666666;
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--bg-light);
            color: var(--text-dark);
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* --- Top Announcement Bar (Like Huda Beauty) --- */
        .announcement-bar {
            background: var(--brand-primary);
            color: white;
            text-align: center;
            padding: 8px 0;
            font-size: 0.85rem;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .announcement-bar a {
            color: white;
            text-decoration: underline;
            font-weight: 600;
        }

        /* --- Modern Navbar (Huda Beauty Style) --- */
        .top-navbar {
            background: var(--bg-light);
            border-bottom: 1px solid #f0f0f0;
            padding: 15px 0;
            transition: var(--transition);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 800;
            font-size: 1.6rem;
            letter-spacing: 2px;
            color: var(--brand-primary) !important;
            text-transform: uppercase;
        }

        .nav-link {
            font-weight: 600;
            font-size: 0.75rem;
            color: var(--text-dark) !important;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0.5rem 1rem !important;
            position: relative;
            transition: var(--transition);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--brand-secondary);
            transition: var(--transition);
            transform: translateX(-50%);
        }

        .nav-link:hover {
            color: var(--brand-secondary) !important;
        }

        .nav-link:hover::after {
            width: 80%;
        }

        /* --- Search Bar (Huda Beauty Style) --- */
        .search-container {
            position: relative;
            max-width: 350px;
            width: 100%;
        }

        .search-input {
            border-radius: 4px;
            border: 1px solid #e0e0e0;
            padding: 10px 45px 10px 15px;
            font-size: 0.85rem;
            background: #fafafa;
            transition: var(--transition);
            width: 100%;
        }

        .search-input:focus {
            background: #fff;
            outline: none;
            border-color: var(--text-dark);
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .search-input::placeholder {
            color: #999;
            font-size: 0.85rem;
        }

        .search-icon-btn {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            border: none;
            background: none;
            color: var(--text-gray);
            cursor: pointer;
            font-size: 1.1rem;
        }

        .search-icon-btn:hover {
            color: var(--text-dark);
        }

        /* --- Icons & Badges (Minimalist) --- */
        .action-icon {
            font-size: 1.4rem;
            color: var(--text-dark);
            position: relative;
            transition: var(--transition);
            text-decoration: none;
        }

        .action-icon:hover {
            color: var(--brand-secondary);
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -10px;
            background: var(--brand-secondary);
            color: white;
            font-size: 0.65rem;
            font-weight: 700;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
        }

        /* --- Dropdowns (Clean & Modern) --- */
        .dropdown-menu {
            border: 1px solid #f0f0f0;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            border-radius: 0;
            padding: 20px;
            margin-top: 10px;
            min-width: 220px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .dropdown-item {
            border-radius: 0;
            padding: 10px 15px;
            font-weight: 500;
            font-size: 0.85rem;
            color: var(--text-dark);
            transition: var(--transition);
            text-transform: none;
        }

        .dropdown-item:hover {
            background: var(--bg-cream);
            color: var(--brand-secondary);
            padding-right: 20px;
        }

        .dropdown-divider {
            margin: 15px 0;
            border-color: #f0f0f0;
        }

        /* --- Footer (Premium Black Style) --- */
        .footer {
            background: var(--brand-primary);
            color: #ffffff;
            padding: 70px 0 25px;
            margin-top: 80px;
        }

        .footer-title {
            font-family: 'Cairo', sans-serif;
            font-size: 1.1rem;
            font-weight: 800;
            margin-bottom: 25px;
            color: #ffffff;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .footer-link {
            color: #cccccc;
            text-decoration: none;
            display: block;
            margin-bottom: 12px;
            font-size: 0.9rem;
            transition: var(--transition);
        }

        .footer-link:hover {
            color: var(--brand-secondary);
            transform: translateX(-3px);
        }

        .footer .social-icon {
            width: 40px;
            height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            color: white;
            transition: var(--transition);
            text-decoration: none;
        }

        .footer .social-icon:hover {
            background: var(--brand-secondary);
            transform: translateY(-3px);
        }

        /* --- Buttons (Huda Beauty Style) --- */
        .btn-primary-brand {
            background: var(--text-dark);
            color: white;
            border: none;
            padding: 12px 30px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: var(--transition);
            border-radius: 0;
        }

        .btn-primary-brand:hover {
            background: var(--brand-secondary);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(233, 30, 99, 0.3);
        }

        .btn-secondary-brand {
            background: transparent;
            color: var(--text-dark);
            border: 2px solid var(--text-dark);
            padding: 12px 30px;
            font-size: 0.85rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: var(--transition);
            border-radius: 0;
        }

        .btn-secondary-brand:hover {
            background: var(--text-dark);
            color: white;
        }

        /* --- Mobile Responsive --- */
        @media (max-width: 991px) {
            .navbar-brand { 
                font-size: 1.3rem;
                letter-spacing: 1px;
            }
            .desktop-nav { display: none; }
            .search-container { max-width: 100%; }
        }
    </style>
    @stack('styles')
</head>
<body>

    <!-- Announcement Bar -->
    <div class="announcement-bar">
        <div class="container">
            <p class="mb-0">
                🎉 شحن مجاني للطلبات فوق 200₪ | <a href="{{ route('products.index') }}">تسوقي الآن</a>
            </p>
        </div>
    </div>

    <nav class="top-navbar">
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
            <div class="row g-5 mb-5">
                <div class="col-lg-4 col-md-6">
                    <h5 class="footer-title mb-4">OOPSSKIN</h5>
                    <p class="text-white-50 mb-4" style="line-height: 1.8; font-size: 0.9rem;">
                        وجهتِك الأولى لعالم الجمال الفاخر. نختار منتجاتنا بعناية فائقة لنضمن لكِ الجودة والأناقة التي تستحقينها.
                    </p>
                    <div class="d-flex gap-3 mt-4">
                        <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-snapchat"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-tiktok"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <h6 class="footer-title">التسوق</h6>
                    <a href="{{ route('products.index') }}" class="footer-link">جميع المنتجات</a>
                    <a href="{{ route('categories.index') }}" class="footer-link">الفئات</a>
                    <a href="#" class="footer-link">وصل حديثاً</a>
                    <a href="#" class="footer-link">الأكثر مبيعاً</a>
                    <a href="#" class="footer-link">العروض الخاصة</a>
                </div>
                <div class="col-lg-2 col-md-3 col-6">
                    <h6 class="footer-title">الدعم</h6>
                    <a href="{{ route('about') }}" class="footer-link">من نحن</a>
                    <a href="{{ route('contact') }}" class="footer-link">تواصل معنا</a>
                    <a href="{{ route('story') }}" class="footer-link">قصتنا</a>
                    <a href="#" class="footer-link">سياسة الخصوصية</a>
                    <a href="#" class="footer-link">الشحن والتوصيل</a>
                </div>
                <div class="col-lg-4 col-md-6">
                    <h6 class="footer-title">اشتركي معنا</h6>
                    <p class="text-white-50 mb-4" style="font-size: 0.9rem;">
                        احصلي على آخر العروض والمنتجات الجديدة مباشرة على بريدك الإلكتروني.
                    </p>
                    <form class="d-flex flex-column gap-3">
                        <input type="email" class="form-control border-0 p-3" 
                               placeholder="أدخلي بريدك الإلكتروني" 
                               style="background: rgba(255,255,255,0.1); color: white; border-radius: 0;">
                        <button class="btn btn-primary-brand w-100">اشتراك الآن</button>
                    </form>
                </div>
            </div>
            
            <div class="border-top pt-4 mt-4" style="border-color: rgba(255,255,255,0.1) !important;">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <p class="mb-0" style="font-size: 0.85rem; color: #999;">
                            &copy; {{ date('Y') }} <strong>OOPSSKIN</strong>. جميع الحقوق محفوظة.
                        </p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="d-flex justify-content-center justify-content-md-end gap-3">
                            <i class="bi bi-credit-card fs-4" style="color: #999;"></i>
                            <i class="bi bi-paypal fs-4" style="color: #999;"></i>
                            <i class="bi bi-apple fs-4" style="color: #999;"></i>
                            <i class="bi bi-google fs-4" style="color: #999;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>