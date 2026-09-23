@php
    $footerSettings = \App\Support\SettingsStore::group('frontend_footer');

    $aboutText = $footerSettings['about_text'] ?? 'একাডেমিক, এডমিশন এবং জব প্রিপারেশনের জন্য বাংলাদেশের সেরা ডিজিটাল প্রশ্নব্যাংক ও সমাধান প্ল্যাটফর্ম।';
    $copyrightText = $footerSettings['copyright_text'] ?? '&copy; ' . date('Y') . ' Qerobi.com সর্বস্বত্ব সংরক্ষিত।';

    $socials = [
        'facebook' => $footerSettings['facebook_url'] ?? '#',
        'youtube' => $footerSettings['youtube_url'] ?? '#',
        'twitter' => $footerSettings['twitter_url'] ?? '#',
        'linkedin' => $footerSettings['linkedin_url'] ?? '#',
    ];

    // Fetch Footer Menus from Database (Menu Builder)
    $footer1 = \App\Models\Menu::with('parentItems')->where('location', 'footer_1')->where('is_active', true)->first();
    $footer2 = \App\Models\Menu::with('parentItems')->where('location', 'footer_2')->where('is_active', true)->first();
    $footer3 = \App\Models\Menu::with('parentItems')->where('location', 'footer_3')->where('is_active', true)->first();
    $footer4 = \App\Models\Menu::with('parentItems')->where('location', 'footer_4')->where('is_active', true)->first();

    $columns = [
        [
            'title' => $footer1 ? $footer1->name : 'Footer Column 1',
            'links' => $footer1 ? $footer1->parentItems : collect()
        ],
        [
            'title' => $footer2 ? $footer2->name : 'Footer Column 2',
            'links' => $footer2 ? $footer2->parentItems : collect()
        ],
        [
            'title' => $footer3 ? $footer3->name : 'Footer Column 3',
            'links' => $footer3 ? $footer3->parentItems : collect()
        ],
        [
            'title' => $footer4 ? $footer4->name : 'Footer Column 4',
            'links' => $footer4 ? $footer4->parentItems : collect()
        ],
    ];
@endphp

<footer class="bg-slate-50 dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-11 gap-12 lg:gap-8">

            <div class="lg:col-span-3">
                <a href="/" class="group inline-flex items-center">
                    @php
                        $branding = \App\Support\SettingsStore::group('branding');
                        $appName = $branding['app_name'] ?? config('app.name', 'Question Bank');
                        $logoLight = !empty($branding['logo_light']) ? (\Illuminate\Support\Str::startsWith($branding['logo_light'], ['http://', 'https://']) ? $branding['logo_light'] : asset('storage/'.$branding['logo_light'])) : asset('images/logo_dark.png');
                        $logoDark = !empty($branding['logo_dark']) ? (\Illuminate\Support\Str::startsWith($branding['logo_dark'], ['http://', 'https://']) ? $branding['logo_dark'] : asset('storage/'.$branding['logo_dark'])) : asset('images/logo_light.png');
                    @endphp
                    <img src="{{ $logoLight }}" alt="{{ $appName }}" class="h-7 md:h-8 w-auto block dark:hidden">
                    <img src="{{ $logoDark }}" alt="{{ $appName }}" class="h-7 md:h-8 w-auto hidden dark:block">
                </a>
                <p class="text-[13px] leading-relaxed text-slate-500 dark:text-slate-400">
                    {{ $aboutText }}
                </p>
                <div class="mt-6 flex items-center gap-3">
                    @if($socials['facebook'] && $socials['facebook'] !== '#')
                    <a href="{{ $socials['facebook'] }}" target="_blank" class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:bg-emerald-500 hover:text-white dark:hover:bg-emerald-500 dark:hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    @endif

                    @if($socials['youtube'] && $socials['youtube'] !== '#')
                    <a href="{{ $socials['youtube'] }}" target="_blank" class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:bg-emerald-500 hover:text-white dark:hover:bg-emerald-500 dark:hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </a>
                    @endif

                    @if($socials['linkedin'] && $socials['linkedin'] !== '#')
                    <a href="{{ $socials['linkedin'] }}" target="_blank" class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:bg-emerald-500 hover:text-white dark:hover:bg-emerald-500 dark:hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                    </a>
                    @endif

                    @if($socials['twitter'] && $socials['twitter'] !== '#')
                    <a href="{{ $socials['twitter'] }}" target="_blank" class="flex items-center justify-center w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-800 text-slate-500 dark:text-slate-400 hover:bg-emerald-500 hover:text-white dark:hover:bg-emerald-500 dark:hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                    @endif
                </div>
            </div>

            @foreach($columns as $column)
            <div class="lg:col-span-2">
                <h3 class="text-[11px] font-bold uppercase tracking-wide text-slate-400 dark:text-slate-500 mb-4">{{ $column['title'] }}</h3>
                <ul class="space-y-2.5 text-sm">
                    @foreach($column['links'] as $link)
                    <li>
                        <a href="{{ str_starts_with($link->url, '#') || str_starts_with($link->url, 'http') ? $link->url : url($link->url) }}"
                           target="{{ $link->target }}"
                           class="text-slate-600 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 hover:pl-1 transition-all">
                           @if($link->icon) <i class="{{ $link->icon }} mr-1"></i> @endif
                           {{ $link->title }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endforeach

        </div>

        <div class="mt-12 pt-8 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-5">
            <div>
                <h3 class="text-sm font-bold text-slate-900 dark:text-white">নতুন প্রশ্ন যুক্ত হলেই জানতে চান?</h3>
                <p class="text-[13px] text-slate-500 dark:text-slate-400 mt-0.5">সপ্তাহে একবার, শুধু নতুন সমাধান ও গুরুত্বপূর্ণ বিজ্ঞপ্তি।</p>
            </div>
            <form action="#" method="post" class="allow-select flex items-stretch border-b-2 border-slate-900 dark:border-slate-600 focus-within:border-emerald-500 dark:focus-within:border-emerald-400 transition-colors max-w-sm w-full shrink-0">
                <input type="email" required placeholder="আপনার ইমেইল" class="w-full bg-transparent py-2.5 text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-500 focus:outline-none">
                <button type="submit" class="shrink-0 px-4 text-sm font-bold text-emerald-600 dark:text-emerald-400 hover:text-slate-900 dark:hover:text-white transition-colors">সাবস্ক্রাইব</button>
            </form>
        </div>

        <div class="mt-8 pt-6 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4 text-[12px] text-slate-500 dark:text-slate-400">
            <p>{!! $copyrightText !!}</p>
            <div class="flex items-center gap-5">
                <a href="{{ route('pages.privacy') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">গোপনীয়তা নীতি</a>
                <a href="#" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">ব্যবহারের শর্তাবলী</a>
                <a href="#" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">যোগাযোগ</a>
                <button type="button" onclick="window.scrollTo({top:0,behavior:'smooth'})" class="group inline-flex items-center gap-1 font-semibold text-slate-700 dark:text-slate-300 hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">
                    উপরে যান
                    <span class="inline-block transition-transform group-hover:-translate-y-0.5">↑</span>
                </button>
            </div>
        </div>
    </div>
</footer>
