<!DOCTYPE html>
<html lang="bn" class="scroll-smooth">
<head>
    @include('frontend.partials.head', [
        'title' => View::hasSection('title') ? View::getSection('title') : null,
        'description' => View::hasSection('description') ? View::getSection('description') : null,
        'ogImage' => View::hasSection('og_image') ? View::getSection('og_image') : null
    ])

    <style>
        /* ১. কন্টেন্ট প্রটেকশন (কপি এবং ড্র্যাগ বন্ধ করা) */
        body, html {
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
        /* ২. ইনপুট ফিল্ডে সিলেকশন অন রাখা (যাতে আপনার ডায়নামিক থিম কালার দেখা যায়) */
        input, textarea, select, [contenteditable="true"], .allow-select, .selectable {
            -webkit-user-select: text !important;
            -moz-user-select: text !important;
            -ms-user-select: text !important;
            user-select: text !important;
        }
        /* ৩. ছবি ও লিংক ড্র্যাগ করা বন্ধ করা */
        img, a {
            -webkit-user-drag: none;
            user-drag: none;
        }

        /* ৪. Hide scrollbar for clean app-like drawer */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* ৫. MathJax loading protection */
        [data-math-content] {
            transition: opacity 0.3s ease-in-out;
            opacity: 1;
            line-height: 1.8 !important;
        }
        body.math-loading [data-math-content] {
            opacity: 0;
        }
    </style>

    @stack('style')

    @php
        $tracking = \App\Support\SettingsStore::group('tracking');
    @endphp

    <!-- Sitewide Content Protection & Anti-Inspection Shield -->
    <script>
        window.__SECURITY_CONFIG__ = {
            disableRightClick: true,
            disableTextCopy: true,
            disableInspect: true,
            isAdmin: @json(auth()->check() && auth()->user()->role === 'admin')
        };
    </script>
</head>
<body class="math-loading bg-slate-50 text-slate-800 dark:text-slate-200 font-sans antialiased min-h-screen flex flex-col pb-20 lg:pb-0 transition-colors duration-300">

    @include('frontend.header')

    <!-- Main Content Area -->
    <main class="flex-1">
        @yield('content')
    </main>

    @include('frontend.partials.footer')

    @include('frontend.bottom-nav')

    @include('frontend.mobile-drawer')

    @include('frontend.scripts')
    @include('frontend.search-modal')

    @if(!empty($tracking['custom_footer_script']))
        {!! $tracking['custom_footer_script'] !!}
    @endif

    @stack('script')
</body>
</html>
