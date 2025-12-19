<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Home - {{ config('app.name', 'Laravel') }}</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
        
        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] min-h-screen flex items-center justify-center p-6">
        <div class="max-w-4xl w-full">
            <div class="bg-white dark:bg-[#161615] rounded-lg shadow-lg p-8">
                <h1 class="text-4xl font-bold mb-4 text-[#1b1b18] dark:text-[#EDEDEC]">
                    صفحة Home
                </h1>
                <p class="text-lg mb-6 text-[#706f6c] dark:text-[#A1A09A]">
                    هذه صفحة للاختبار - إذا رأيت التحديثات تلقائياً، فالتحديث التلقائي يعمل بشكل صحيح!
                </p>
                <div class="bg-[#fff2f2] dark:bg-[#1D0002] p-4 rounded-lg mb-4">
                    <p class="text-sm text-[#f53003] dark:text-[#FF4433]">
                        🎉 جرب تعديل هذا الملف وسترى التغييرات تلقائياً!
                    </p>
                </div>
                <div class="flex gap-4">
                    <a href="/" class="inline-block px-5 py-2 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1C1C1A] rounded-sm hover:bg-black dark:hover:bg-white transition-colors">
                        العودة للصفحة الرئيسية
                    </a>
                </div>
            </div>
        </div>
    </body>
</html>
