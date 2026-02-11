<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'OOPSSKIN | Official Store')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Bootstrap RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --huda-pink: #F24293;
            --huda-pink-dark: #E91E7A;
            --huda-white: #FFFFFF;
            --huda-black: #000000;
            --huda-gray: #F5F5F5;
            --huda-text: #333333;
            --huda-border: #E5E5E5;
        }

        body {
            font-family: 'Montserrat', -apple-system, BlinkMacSystemFont, sans-serif;
            background: white;
            color: var(--huda-text);
            font-size: 14px;
            line-height: 1.6;
        }

        /* ============================================
           HEADER EXACTLY LIKE HUDA BEAUTY
        ============================================ */
        
        /* Announcement Bar */
        .announcement-bar {
            background: var(--huda-white);
            color: var(--huda-text);
            text-align: center;
            padding: 10px 0;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.5px;
            border-bottom: 1px solid var(--huda-border);
        }

        .announcement-bar a {
            color: white;
            text-decoration: underline;
        }

        /* Main Header - PINK LIKE HUDA */
        .main-header {
            background: var(--huda-pink);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(242, 66, 147, 0.3);
        }

        .header-top {
            padding: 20px 0;
            position: relative;
            min-height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Logo - WHITE ON PINK */
        .logo {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            margin-bottom: 0;
            opacity: 1;
            transition: all 0.4s ease;
            z-index: 2;
        }

        .logo.hide-logo {
            opacity: 0;
            visibility: hidden;
            transform: translate(-50%, -50%) scale(0.9);
            pointer-events: none;
        }

        .logo a {
            font-size: 32px;
            font-weight: 900;
            color: var(--huda-white);
            text-decoration: none;
            letter-spacing: 3px;
            text-transform: lowercase;
        }

        .logo a::first-letter {
            text-transform: lowercase;
        }

        /* Remove Search from Header */
        .search-wrapper {
            display: none;
        }

        /* Header Icons - WHITE ON PINK */
        .header-icons {
            position: absolute;
            left: 30px;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .header-icon {
            position: relative;
            color: var(--huda-white);
            font-size: 22px;
            text-decoration: none;
            transition: opacity 0.3s;
        }

        .header-icon:hover {
            opacity: 0.8;
        }

        .cart-count,
        .wishlist-count {
            position: absolute;
            top: -8px;
            right: -10px;
            background: var(--huda-white);
            color: var(--huda-pink);
            font-size: 10px;
            font-weight: 900;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Language Switcher */
        .language-switcher {
            position: absolute;
            right: 30px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--huda-white);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: opacity 0.3s;
        }

        .language-switcher:hover {
            opacity: 0.8;
        }

        .language-switcher i {
            font-size: 16px;
        }

        /* Navigation - PILLS STYLE LIKE HUDA */
        .main-nav {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s ease;
            z-index: 1;
            pointer-events: none;
        }

        .main-nav.show-nav {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .main-nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
            margin: 0;
            padding: 0;
            flex-wrap: wrap;
            gap: 10px;
            white-space: nowrap;
        }

        .main-nav li {
            position: relative;
        }

        .main-nav a {
            display: block;
            padding: 8px 18px;
            color: var(--huda-pink-dark);
            background: var(--huda-white);
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            border-radius: 25px;
            transition: all 0.3s;
            white-space: nowrap;
        }

        .main-nav a:hover,
        .main-nav a.active {
            background: rgba(255,255,255,0.9);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        /* Mega Menu Dropdown - CENTERED */
        .main-nav {
            position: relative;
        }

        .mega-menu-wrapper {
            position: static;
        }

        .mega-menu {
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            width: 700px;
            max-width: 90vw;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 9999;
            border-radius: 8px;
        }

        .mega-menu-wrapper:hover .mega-menu {
            opacity: 1;
            visibility: visible;
        }

        .mega-menu-inner {
            padding: 35px 25px;
        }

        .mega-menu-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 20px;
            text-align: center;
            direction: ltr;
        }

        .mega-menu-column {
            direction: ltr;
        }

        .mega-menu-column h3 {
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 15px;
            color: #000;
            border-bottom: 2px solid #F24293;
            padding-bottom: 8px;
            text-align: center;
            direction: ltr;
        }

        .mega-menu-column ul {
            list-style: none;
            padding: 0;
            margin: 0;
            direction: ltr;
        }

        .mega-menu-column ul li {
            margin-bottom: 8px;
            text-align: center;
        }

        .mega-menu-column ul li a {
            color: #666;
            text-decoration: none;
            font-size: 12px;
            transition: color 0.3s;
            display: inline-block;
        }

        /* Force LTR for mega menu content in both languages */
        html[dir="rtl"] .mega-menu-grid,
        html[dir="ltr"] .mega-menu-grid {
            direction: ltr;
        }

        html[dir="rtl"] .mega-menu-column,
        html[dir="ltr"] .mega-menu-column {
            direction: ltr;
        }

        .mega-menu-column ul li a:hover {
            color: #F24293;
        }

        .mega-menu-footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
        }

        .mega-menu-btn {
            display: inline-block;
            padding: 14px 45px;
            background: #F24293;
            color: white;
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            border-radius: 30px;
            transition: all 0.3s;
        }

        .mega-menu-btn:hover {
            background: #E91E7A;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(242, 66, 147, 0.4);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .mega-menu {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .mega-menu {
                width: 95vw;
            }
            
            .mega-menu-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 15px;
            }
        }

        /* ============================================
           FOOTER - PINK THEME
        ============================================ */
        
        .main-footer {
            background: #1a1a1a;
            color: white;
            padding: 60px 0 20px;
            margin-top: 80px;
        }

        .footer-title {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 25px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: #999;
            text-decoration: none;
            font-size: 13px;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: white;
        }

        .footer-social {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .footer-social a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            transition: all 0.3s;
        }

        .footer-social a:hover {
            background: var(--huda-pink);
            color: white;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            margin-top: 40px;
            padding-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }

        /* Newsletter */
        .newsletter-form {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .newsletter-input {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid rgba(255,255,255,0.2);
            background: rgba(255,255,255,0.1);
            color: white;
            border-radius: 0;
        }

        .newsletter-input::placeholder {
            color: rgba(255,255,255,0.5);
        }

        .newsletter-btn {
            padding: 12px 30px;
            background: var(--huda-pink);
            color: white;
            border: none;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .newsletter-btn:hover {
            background: var(--huda-pink-dark);
        }

        /* Mobile Menu Toggle */
        .mobile-menu-btn {
            display: none;
            font-size: 24px;
            background: none;
            border: none;
            color: var(--huda-white);
            cursor: pointer;
            padding: 5px;
            z-index: 10;
        }

        .mobile-menu-btn:hover {
            opacity: 0.8;
        }

        .mobile-menu-btn i {
            display: block;
        }

        /* Mobile Offcanvas Menu */
        .mobile-offcanvas {
            position: fixed;
            top: 0;
            width: 80%;
            max-width: 350px;
            height: 100vh;
            background: white;
            z-index: 99999;
            overflow-y: auto;
            box-shadow: -5px 0 20px rgba(0,0,0,0.3);
            transition: all 0.3s ease;
        }

        /* RTL: slide from right */
        html[dir="rtl"] .mobile-offcanvas {
            right: -100%;
        }

        html[dir="rtl"] .mobile-offcanvas.show {
            right: 0;
        }

        /* LTR: slide from left */
        html[dir="ltr"] .mobile-offcanvas {
            left: -100%;
        }

        html[dir="ltr"] .mobile-offcanvas.show {
            left: 0;
        }

        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0,0,0,0.5);
            z-index: 99998;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .mobile-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .mobile-menu-header {
            background: var(--huda-pink);
            color: white;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .mobile-menu-header h3 {
            font-size: 20px;
            font-weight: 900;
            margin: 0;
        }

        .mobile-close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 28px;
            cursor: pointer;
            padding: 0;
            line-height: 1;
        }

        .mobile-menu-content {
            padding: 30px 20px;
        }

        .mobile-menu-section {
            margin-bottom: 0;
        }

        .mobile-menu-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .mobile-menu-section ul li {
            margin-bottom: 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .mobile-menu-section ul li:last-child {
            border-bottom: none;
        }

        .mobile-menu-section ul li a {
            color: #333;
            text-decoration: none;
            font-size: 16px;
            font-weight: 500;
            display: block;
            padding: 18px 15px;
            transition: all 0.3s;
            background: white;
        }

        .mobile-menu-section ul li a:hover {
            color: #F24293;
            background: #fff5f9;
            padding-right: 20px;
        }

        /* Responsive */
        @media (max-width: 991px) {
            .main-nav {
                display: none !important;
            }

            .mobile-menu-btn {
                display: block;
                position: absolute;
                left: 15px;
                right: auto;
            }

            .header-top {
                padding: 0 15px;
            }

            .header-icons {
                position: absolute;
                right: 15px;
                left: auto;
                justify-content: flex-end;
                gap: 15px;
            }

            .header-icon {
                font-size: 20px;
            }

            .logo {
                position: static;
                transform: none;
                text-align: center;
                flex: 1;
            }

            .logo.hide-logo {
                transform: none;
            }

            .logo a {
                font-size: 22px;
                letter-spacing: 0.5px;
            }

            .language-switcher {
                display: none;
            }

            /* Hide announcement bar on mobile */
            .announcement-bar {
                font-size: 11px;
                padding: 8px;
            }

            /* Mobile-specific spacing */
            .container {
                padding-left: 15px;
                padding-right: 15px;
            }

            /* Mega menu adjustments */
            .mega-menu {
                width: 95vw;
                left: 2.5vw;
                transform: none;
            }
        }

        @media (max-width: 576px) {
            .announcement-bar {
                font-size: 10px;
                padding: 6px 10px;
            }

            .main-header {
                padding: 12px 0;
            }

            .header-top {
                display: grid;
                grid-template-columns: 50px 1fr 100px;
                align-items: center;
                gap: 10px;
            }

            .mobile-menu-btn {
                grid-column: 1;
                position: static;
                transform: none;
                justify-self: start;
            }

            .logo {
                grid-column: 2;
                position: static;
            }

            .logo a {
                font-size: 18px;
                letter-spacing: 0.5px;
            }

            .header-icons {
                grid-column: 3;
                position: static;
                transform: none;
                gap: 15px;
                justify-self: end;
            }

            .header-icon {
                font-size: 22px;
            }

            /* Hide wishlist and account on very small screens */
            .header-icons .header-icon:nth-child(2),
            .header-icons .header-icon:nth-child(3) {
                display: none;
            }

            .cart-count,
            .wishlist-count {
                font-size: 9px;
                width: 18px;
                height: 18px;
            }

            .language-switcher {
                display: none !important;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>

    <!-- Announcement Bar -->
    <div class="announcement-bar">
        Free Sample on Every Order
    </div>

    <!-- Main Header -->
    <header class="main-header">
        <div class="container" style="position: relative;">
            <div class="header-top">
                <!-- Mobile Menu Button (Right) -->
                <button class="mobile-menu-btn" onclick="openMobileMenu()">
                    <i class="bi bi-list"></i>
                </button>

                <!-- Header Icons Left -->
                <div class="header-icons">
                    <a href="{{ route('cart.index') }}" class="header-icon" title="Cart">
                        <i class="bi bi-bag"></i>
                        <span class="cart-count">0</span>
                    </a>

                    <a href="#" class="header-icon" title="Wishlist">
                        <i class="bi bi-heart"></i>
                        <span class="wishlist-count">0</span>
                    </a>

                    @auth
                    <a href="{{ route('settings') }}" class="header-icon" title="Account">
                        <i class="bi bi-person"></i>
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="header-icon" title="Log in">
                        <i class="bi bi-person"></i>
                    </a>
                    @endauth

                    <a href="{{ route('search') }}" class="header-icon" title="Search">
                        <i class="bi bi-search"></i>
                    </a>
                </div>

                <!-- Logo Center -->
                <div class="logo">
                    <a href="{{ route('home') }}">oopsskin</a>
                </div>

                <!-- Language Switcher Right -->
                <div class="language-switcher" onclick="toggleLanguage()">
                    <i class="bi bi-globe"></i>
                    <span id="current-lang">العربية</span>
                    <i class="bi bi-chevron-down" style="font-size: 10px;"></i>
                </div>
            </div>
        </div>

        <!-- Navigation Pills -->
        <nav class="main-nav">
            <div class="container">
                <ul id="nav-pills">
                    <li><a href="{{ route('home') }}" data-ar="الرئيسية" data-en="Home">الرئيسية</a></li>
                    <li><a href="#" data-ar="الأكثر مبيعاً" data-en="Best Sellers">الأكثر مبيعاً</a></li>
                    <li><a href="#" data-ar="جديد" data-en="New">جديد</a></li>
                    <li><a href="{{ route('categories.index') }}" data-ar="ميكاب" data-en="Makeup">ميكاب</a></li>
                    <li><a href="#" data-ar="باكيجات" data-en="Packages">باكيجات</a></li>
                    <li><a href="#" data-ar="سكين كير" data-en="Skincare">سكين كير</a></li>
                    <li class="mega-menu-wrapper">
                        <a href="{{ route('products.index') }}" data-ar="جميع المنتجات" data-en="All Products">جميع المنتجات</a>
                        
                        <!-- Mega Menu -->
                        <div class="mega-menu">
                            <div class="mega-menu-inner">
                                <div class="mega-menu-grid">
                                <!-- FACE Column -->
                                <div class="mega-menu-column">
                                    <h3 data-ar="الوجه" data-en="FACE" class="menu-title">الوجه</h3>
                                    <ul>
                                        <li><a href="#" data-ar="فاونديشن" data-en="Foundation">فاونديشن</a></li>
                                        <li><a href="#" data-ar="بودرة وسبراي" data-en="Powder & Setting Spray">بودرة وسبراي</a></li>
                                        <li><a href="#" data-ar="برايمر" data-en="Primer">برايمر</a></li>
                                        <li><a href="#" data-ar="كونسيلر" data-en="Concealer & Corrector">كونسيلر</a></li>
                                        <li><a href="#" data-ar="كونتور" data-en="Contour & Highlight">كونتور</a></li>
                                    </ul>
                                </div>

                                <!-- EYES Column -->
                                <div class="mega-menu-column">
                                    <h3 data-ar="العيون" data-en="EYES" class="menu-title">العيون</h3>
                                    <ul>
                                        <li><a href="#" data-ar="ظلال عيون" data-en="Eyeshadow">ظلال عيون</a></li>
                                        <li><a href="#" data-ar="حواجب" data-en="Eyebrows">حواجب</a></li>
                                        <li><a href="#" data-ar="آيلاينر" data-en="Eyeliner">آيلاينر</a></li>
                                        <li><a href="#" data-ar="ماسكارا" data-en="Mascara">ماسكارا</a></li>
                                        <li><a href="#" data-ar="رموش صناعية" data-en="Fake Eyelashes">رموش صناعية</a></li>
                                    </ul>
                                </div>

                                <!-- LIPS Column -->
                                <div class="mega-menu-column">
                                    <h3 data-ar="الشفاه" data-en="LIPS" class="menu-title">الشفاه</h3>
                                    <ul>
                                        <li><a href="#" data-ar="أحمر شفاه جيلي" data-en="Jelly Stained Lips">أحمر شفاه جيلي</a></li>
                                        <li><a href="#" data-ar="ليب جلوس" data-en="Lip Gloss">ليب جلوس</a></li>
                                        <li><a href="#" data-ar="أحمر شفاه" data-en="Lipstick">أحمر شفاه</a></li>
                                        <li><a href="#" data-ar="محدد شفاه" data-en="Lip Liner">محدد شفاه</a></li>
                                        <li><a href="#" data-ar="مرطب شفاه" data-en="Lip Balm">مرطب شفاه</a></li>
                                    </ul>
                                </div>

                                <!-- CHEEK Column -->
                                <div class="mega-menu-column">
                                    <h3 data-ar="الخدود" data-en="CHEEK" class="menu-title">الخدود</h3>
                                    <ul>
                                        <li><a href="#" data-ar="بلاشر" data-en="Blush">بلاشر</a></li>
                                        <li><a href="#" data-ar="برونزر" data-en="Bronzer">برونزر</a></li>
                                    </ul>
                                </div>

                                <!-- BRUSHES & TOOLS Column -->
                                <div class="mega-menu-column">
                                    <h3 data-ar="الفرش والأدوات" data-en="BRUSHES & TOOLS" class="menu-title">الفرش والأدوات</h3>
                                    <ul>
                                        <li><a href="#" data-ar="فرش المكياج" data-en="Brushes">فرش المكياج</a></li>
                                        <li><a href="#" data-ar="أدوات ومستلزمات" data-en="Tools & Accessories">أدوات ومستلزمات</a></li>
                                    </ul>
                                    <h3 data-ar="ميني" data-en="MINIS" class="menu-title" style="margin-top: 30px;">ميني</h3>
                                    <ul>
                                        <li><a href="#" data-ar="منتجات مصغرة" data-en="Mini Products">منتجات مصغرة</a></li>
                                    </ul>
                                </div>
                                </div>

                                <!-- Mega Menu Footer Button -->
                                <div class="mega-menu-footer">
                                    <a href="{{ route('products.index') }}" class="mega-menu-btn" data-ar="تسوق جميع المنتجات" data-en="SHOP ALL PRODUCTS">تسوق جميع المنتجات</a>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-overlay" id="mobileOverlay" onclick="closeMobileMenu()"></div>

    <!-- Mobile Menu Offcanvas -->
    <div class="mobile-offcanvas" id="mobileMenu">
        <div class="mobile-menu-header">
            <h3>OOPSSKIN</h3>
            <button class="mobile-close-btn" onclick="closeMobileMenu()">
                <i class="bi bi-x"></i>
            </button>
        </div>

        <div class="mobile-menu-content">
            <!-- Main Menu -->
            <div class="mobile-menu-section">
                <ul>
                    <li><a href="{{ route('home') }}" data-ar="🏠 الرئيسية" data-en="🏠 Home">🏠 الرئيسية</a></li>
                    <li><a href="#" data-ar="⭐ الأكثر مبيعاً" data-en="⭐ Best Sellers">⭐ الأكثر مبيعاً</a></li>
                    <li><a href="#" data-ar="✨ جديد" data-en="✨ New">✨ جديد</a></li>
                    <li><a href="{{ route('categories.index') }}" data-ar="💄 ميكاب" data-en="💄 Makeup">💄 ميكاب</a></li>
                    <li><a href="#" data-ar="🎁 باكيجات" data-en="🎁 Packages">🎁 باكيجات</a></li>
                    <li><a href="#" data-ar="🧴 سكين كير" data-en="🧴 Skincare">🧴 سكين كير</a></li>
                    <li><a href="{{ route('products.index') }}" data-ar="🛍️ جميع المنتجات" data-en="🛍️ All Products">🛍️ جميع المنتجات</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="main-footer">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6">
                    <h3 class="footer-title">SHOP</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('products.index') }}">All Products</a></li>
                        <li><a href="#">New Arrivals</a></li>
                        <li><a href="#">Best Sellers</a></li>
                        <li><a href="#">Sale</a></li>
                        <li><a href="#">Gift Cards</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h3 class="footer-title">SUPPORT</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('contact') }}">Contact Us</a></li>
                        <li><a href="#">Shipping & Returns</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Track Order</a></li>
                        <li><a href="#">Store Locator</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h3 class="footer-title">ABOUT</h3>
                    <ul class="footer-links">
                        <li><a href="{{ route('about') }}">Our Story</a></li>
                        <li><a href="#">Press</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Sustainability</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h3 class="footer-title">NEWSLETTER</h3>
                    <p style="color: #999; font-size: 13px; margin-bottom: 15px;">
                        Sign up to get the latest on sales, new releases and more...
                    </p>
                    <form class="newsletter-form">
                        <input type="email" 
                               class="newsletter-input" 
                               placeholder="Your email address">
                        <button type="submit" class="newsletter-btn">JOIN</button>
                    </form>

                    <div class="footer-social">
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-tiktok"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                        <a href="#"><i class="bi bi-facebook"></i></a>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p>&copy; {{ date('Y') }} OOPSSKIN. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Language Switcher
        let currentLang = 'ar'; // Default Arabic
        
        function updateNavigationLanguage() {
            // Update nav pills
            const navLinks = document.querySelectorAll('#nav-pills > li > a');
            navLinks.forEach(link => {
                if (currentLang === 'ar') {
                    link.textContent = link.getAttribute('data-ar');
                } else {
                    link.textContent = link.getAttribute('data-en');
                }
            });

            // Update mega menu titles
            const menuTitles = document.querySelectorAll('.menu-title');
            menuTitles.forEach(title => {
                if (currentLang === 'ar') {
                    title.textContent = title.getAttribute('data-ar');
                } else {
                    title.textContent = title.getAttribute('data-en');
                }
            });

            // Update mega menu links
            const menuLinks = document.querySelectorAll('.mega-menu a');
            menuLinks.forEach(link => {
                const arText = link.getAttribute('data-ar');
                const enText = link.getAttribute('data-en');
                if (arText && enText) {
                    if (currentLang === 'ar') {
                        link.textContent = arText;
                    } else {
                        link.textContent = enText;
                    }
                }
            });

            // Update mobile menu links
            const mobileLinks = document.querySelectorAll('.mobile-menu-section a');
            mobileLinks.forEach(link => {
                const arText = link.getAttribute('data-ar');
                const enText = link.getAttribute('data-en');
                if (arText && enText) {
                    if (currentLang === 'ar') {
                        link.textContent = arText;
                    } else {
                        link.textContent = enText;
                    }
                }
            });
        }
        
        function toggleLanguage() {
            const langElement = document.getElementById('current-lang');
            const htmlElement = document.documentElement;
            
            if (currentLang === 'ar') {
                currentLang = 'en';
                langElement.textContent = 'English';
                htmlElement.setAttribute('lang', 'en');
                htmlElement.setAttribute('dir', 'ltr');
            } else {
                currentLang = 'ar';
                langElement.textContent = 'العربية';
                htmlElement.setAttribute('lang', 'ar');
                htmlElement.setAttribute('dir', 'rtl');
            }
            
            // Update navigation pills
            updateNavigationLanguage();
            
            // Save preference
            localStorage.setItem('preferred-language', currentLang);
        }
        
        // Load saved language preference
        document.addEventListener('DOMContentLoaded', function() {
            const savedLang = localStorage.getItem('preferred-language');
            if (savedLang === 'en') {
                toggleLanguage();
            } else {
                updateNavigationLanguage();
            }
        });

        // Show/Hide Navigation Pills and Logo on Scroll
        const mainNav = document.querySelector('.main-nav');
        const logo = document.querySelector('.logo');
        
        window.addEventListener('scroll', function() {
            const currentScroll = window.pageYOffset || document.documentElement.scrollTop;
            
            // When scrolling down past 20px: hide logo and show nav
            if (currentScroll > 20) {
                mainNav.classList.add('show-nav');
                logo.classList.add('hide-logo');
            } else {
                mainNav.classList.remove('show-nav');
                logo.classList.remove('hide-logo');
            }
        });

        // Mobile Menu Functions
        function openMobileMenu() {
            document.getElementById('mobileMenu').classList.add('show');
            document.getElementById('mobileOverlay').classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeMobileMenu() {
            document.getElementById('mobileMenu').classList.remove('show');
            document.getElementById('mobileOverlay').classList.remove('show');
            document.body.style.overflow = '';
        }
    </script>
    
    @stack('scripts')
</body>
</html>
