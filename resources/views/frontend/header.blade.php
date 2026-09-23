<div class="sticky top-0 z-[100] w-full flex flex-col">
@auth
    @if(auth()->user()->hasRole(['super_admin', 'admin', 'teacher']))
        <!-- Admin Bar -->
        <div id="wpadminbar" data-turbo="false" class="bg-[#1d2327] text-[#c3c4c7] text-[13px] h-8 flex items-center justify-between z-[99999] relative w-full font-sans leading-none">

            <!-- Left Side -->
            <div class="flex items-center h-full">
                <!-- Site/Dashboard -->
                <a href="{{ route('dashboard') }}" class="flex items-center justify-center w-8 h-full hover:text-[#72aee6] hover:bg-[#2c3338] transition-none">
                    <svg class="w-4 h-4 text-red-500" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"/></svg>
                </a>

                <!-- Appearance / Menus -->
                <div x-data="{ open: false }" class="relative h-full flex items-center" @mouseenter="open = true" @mouseleave="open = false">
                    <a href="{{ route('admin.settings.menus') }}" class="hidden sm:flex items-center gap-1.5 h-full px-3 hover:text-[#72aee6] hover:bg-[#2c3338] transition-none cursor-pointer">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/></svg>
                        Appearance
                    </a>

                    <!-- Dropdown Content -->
                    <div x-show="open" x-transition.opacity.duration.200ms class="absolute top-full left-0 bg-[#2c3338] min-w-[200px] shadow-lg py-1" style="display: none;">
                        <a href="{{ route('admin.settings.menus') }}" class="flex items-center gap-2 px-4 py-1.5 text-[#c3c4c7] hover:text-[#72aee6] hover:bg-[#1d2327] transition-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
                            Menus
                        </a>
                        <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-2 px-4 py-1.5 text-[#c3c4c7] hover:text-[#72aee6] hover:bg-[#1d2327] transition-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Settings
                        </a>
                        <a href="{{ route('admin.theme-options') }}" class="flex items-center gap-2 px-4 py-1.5 text-[#c3c4c7] hover:text-[#72aee6] hover:bg-[#1d2327] transition-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            Themes
                        </a>
                        <a href="{{ route('admin.theme-options') }}" class="flex items-center gap-2 px-4 py-1.5 text-[#c3c4c7] hover:text-[#72aee6] hover:bg-[#1d2327] transition-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                            Theme Option
                        </a>
                    </div>
                </div>

                <!-- New -->
                <div x-data="{ open: false }" class="relative h-full flex items-center" @mouseenter="open = true" @mouseleave="open = false">
                    <a href="{{ route('questions.create') }}" class="hidden sm:flex items-center gap-1.5 h-full px-3 hover:text-[#72aee6] hover:bg-[#2c3338] transition-none cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        New
                    </a>

                    <!-- Dropdown Content -->
                    <div x-show="open" x-transition.opacity.duration.200ms class="absolute top-full left-0 bg-[#2c3338] min-w-[200px] shadow-lg py-1" style="display: none;">
                        <a href="{{ route('questions.create') }}" class="flex items-center gap-2 px-4 py-1.5 text-[#c3c4c7] hover:text-[#72aee6] hover:bg-[#1d2327] transition-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Question
                        </a>
                        <a href="{{ route('admin.model-tests.create') }}" class="flex items-center gap-2 px-4 py-1.5 text-[#c3c4c7] hover:text-[#72aee6] hover:bg-[#1d2327] transition-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Model Test
                        </a>
                        <a href="#" class="flex items-center gap-2 px-4 py-1.5 text-[#c3c4c7] hover:text-[#72aee6] hover:bg-[#1d2327] transition-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            User
                        </a>
                    </div>
                </div>

                <!-- Edit Question -->
                @if(request()->routeIs('question.show') && isset($question))
                    <a href="{{ route('questions.edit', $question->id) }}" class="flex items-center gap-1.5 h-full px-3 text-[#72aee6] hover:text-[#00a0d2] hover:bg-[#2c3338] font-medium transition-none">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg>
                        Edit this page
                    </a>
                @endif
            </div>

            <!-- Right Side -->
            <div class="flex items-center h-full">
                <!-- User Profile -->
                <div x-data="{ open: false }" class="relative h-full flex items-center" @mouseenter="open = true" @mouseleave="open = false">
                    <a href="{{ route('profile.edit') ?? '#' }}" class="flex items-center gap-2 h-full px-3 hover:text-[#72aee6] hover:bg-[#2c3338] transition-none cursor-pointer">
                        <span>Hi, {{ auth()->user()->name }}</span>
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=7F9CF5&background=EBF4FF" class="w-5 h-5 rounded-full" alt="Avatar">
                    </a>

                    <!-- Dropdown -->
                    <div x-show="open" x-transition.opacity.duration.200ms class="absolute top-full right-0 bg-[#2c3338] min-w-[200px] shadow-lg" style="display: none;">
                        <div class="p-3 border-b border-[#1d2327]">
                            <p class="text-[#c3c4c7] mb-1 font-semibold">{{ auth()->user()->name }}</p>
                            <p class="text-[#8c8f94] text-xs">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit') ?? '#' }}" class="block px-4 py-2 text-[#c3c4c7] hover:text-[#72aee6] hover:bg-[#1d2327] transition-none">
                            Edit Profile
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-[#c3c4c7] hover:text-[#72aee6] hover:bg-[#1d2327] transition-none">
                                Log Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endauth

<header class="relative z-40 bg-white/80 header-dynamic-bg backdrop-blur-xl border-b border-slate-200/80 dark:border-slate-800/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 gap-4">

            <!-- Logo & Brand -->
            <div class="flex items-center gap-6">
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

                <!-- Desktop Nav Links -->
                <nav class="hidden lg:flex items-center gap-2 text-sm font-semibold">
                    @php
                        $mainMenu = \App\Models\Menu::with('parentItems.children')->where('location', 'main')->where('is_active', true)->first();
                        $navItems = $mainMenu ? $mainMenu->parentItems : collect();
                    @endphp

                    @foreach($navItems as $item)
                        @php
                            // Check if current URL matches the item's URL for active state
                            $isActive = false;
                            if ($item->url === '/' && request()->is('/')) {
                                $isActive = true;
                            } elseif ($item->url !== '/' && $item->url !== '#' && request()->is(ltrim($item->url, '/') . '*')) {
                                $isActive = true;
                            }
                        @endphp
                        @if($item->url === '#search')
                        <button type="button" onclick="window.dispatchEvent(new CustomEvent('open-search'))" class="relative px-4 py-2 rounded-xl {{ $isActive ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-600' }} transition-colors outline-none border-0 bg-transparent text-left">
                        @else
                        <a href="{{ str_starts_with($item->url, '#') || str_starts_with($item->url, 'http') ? $item->url : url($item->url) }}"
                           target="{{ $item->target }}"
                           class="relative px-4 py-2 rounded-xl {{ $isActive ? 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-700 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-emerald-600' }} transition-colors">
                        @endif
                            @if($item->icon)
                                @if(str_contains($item->icon, '<svg'))
                                    <span class="w-4 h-4 mr-1 inline-block">{!! $item->icon !!}</span>
                                @else
                                    <flux:icon :icon="$item->icon" class="w-4 h-4 mr-1 inline-block" />
                                @endif
                            @endif
                            {{ $item->title }}

                            @if($item->badge)
                                <span class="absolute -top-1 -right-2 flex h-4 items-center">
                                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-50"></span>
                                    <span class="relative inline-flex rounded-full bg-rose-500 px-1.5 py-0.5 text-[9px] font-bold text-white shadow-sm">{{ $item->badge }}</span>
                                </span>
                            @endif
                        </a>
                    @endforeach
                </nav>
            </div>

            <!-- Right Action Bar -->
            <div class="flex items-center gap-2 sm:gap-3">

                <!-- Search Button -->
                <button type="button" class="hidden md:flex items-center gap-3 px-3 py-2 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors text-slate-500 dark:text-slate-400 cursor-pointer" onclick="window.dispatchEvent(new CustomEvent('open-search'))">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span class="text-sm font-medium">খুঁজুন...</span>
                    <kbd x-data="{ isMac: /Mac|iPhone|iPod|iPad/i.test(navigator.platform) }" class="hidden sm:inline-flex items-center gap-1 px-1.5 py-0.5 text-[10px] font-mono font-bold bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded text-slate-500 dark:text-slate-400 shadow-sm"><span x-text="isMac ? '⌘' : 'Ctrl'">Ctrl</span><span>K</span></kbd>
                </button>

                <!-- Download App Button -->
                <button type="button" id="installPwaBtn" aria-label="ডাউনলোড অ্যাপ" title="ডাউনলোড অ্যাপ" class="installPwaBtn hidden p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 rounded-full transition-colors cursor-pointer max-md:hidden">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                </button>

                <!-- Theme Toggle -->
                <button type="button" id="theme-toggle" aria-label="Toggle dark mode" class="p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 dark:text-slate-400 dark:hover:bg-slate-800 rounded-full transition-colors cursor-pointer">
                    <svg class="w-5 h-5 block dark:hidden pointer-events-none" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
                    <svg class="w-5 h-5 hidden dark:block pointer-events-none" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"></path></svg>
                </button>

                @guest
                    <!-- Login Button -->
                    <a href="{{ route('login') }}" data-turbo="false" aria-label="User profile" class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors shadow-sm cursor-pointer">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        <span class="text-sm font-bold text-slate-700 dark:text-slate-200">লগইন</span>
                    </a>

                    <!-- Mobile Login Icon -->
                    <a href="{{ route('login') }}" data-turbo="false" aria-label="User profile" class="sm:hidden p-2 rounded-xl bg-emerald-50 dark:bg-slate-800 text-emerald-600 dark:text-emerald-400 border border-slate-200 dark:border-slate-700 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                    </a>
                @endguest

                @auth
                    <!-- Dashboard/Profile Button -->
                    @php
                        $dashboardUrl = route('dashboard');
                    @endphp
                    <a href="{{ $dashboardUrl }}" data-turbo="false" aria-label="User Dashboard" class="hidden sm:flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-800 hover:bg-emerald-100 dark:hover:bg-emerald-900/50 transition-colors shadow-sm cursor-pointer">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <span class="text-sm font-bold text-emerald-700 dark:text-emerald-300">ড্যাশবোর্ড</span>
                    </a>

                    <!-- Mobile Dashboard Icon -->
                    <a href="{{ $dashboardUrl }}" data-turbo="false" aria-label="User Dashboard" class="sm:hidden p-2 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>

</div>
