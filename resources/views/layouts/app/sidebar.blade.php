@php
    $menuItems = [
        [
            'type' => 'link',
            'label' => __('Dashboard'),
            'route' => 'dashboard',
            'match' => 'dashboard',
            'icon' => 'home',
            'visible' => true,
        ],
        [
            'type' => 'group',
            'label' => __('Question Bank'),
            'icon' => 'circle-stack',
            'flyout' => 'question-bank',
            'active' => request()->routeIs(['questions.*', 'admin.model-tests.*', 'academic-classes.*', 'subjects.*', 'chapters.*', 'topics.*', 'tags.*']),
            'visible' => auth()->user()->hasRole(['teacher', 'admin', 'super_admin']),
            'items' => [
                ['label' => __('Questions'), 'route' => 'questions.index', 'match' => 'questions.*', 'icon' => 'document-text', 'visible' => true],
                ['label' => __('Model Tests'), 'route' => 'admin.model-tests.index', 'match' => 'admin.model-tests.*', 'icon' => 'clock', 'visible' => auth()->user()->hasRole(['admin', 'super_admin'])],
                ['label' => __('Academic Class'), 'route' => 'academic-classes.index', 'match' => 'academic-classes.*', 'icon' => 'academic-cap', 'visible' => auth()->user()->hasAnyPermission(['academic_classes.manage'])],
                ['label' => __('Subjects'), 'route' => 'subjects.index', 'match' => 'subjects.*', 'icon' => 'book-open', 'visible' => auth()->user()->hasAnyPermission(['subjects.manage'])],
                ['label' => __('Chapter'), 'route' => 'chapters.index', 'match' => 'chapters.*', 'icon' => 'bookmark', 'visible' => auth()->user()->hasAnyPermission(['chapters.manage'])],
                ['label' => __('Topics'), 'route' => 'topics.index', 'match' => 'topics.*', 'icon' => 'hashtag', 'visible' => auth()->user()->hasAnyPermission(['topics.manage'])],
                ['label' => __('Tags'), 'route' => 'tags.index', 'match' => 'tags.*', 'icon' => 'tag', 'visible' => auth()->user()->hasAnyPermission(['tags.create', 'tags.update', 'tags.delete'])],
            ]
        ],
        [
            'type' => 'group',
            'label' => __('Organizations'),
            'icon' => 'building-library',
            'flyout' => 'organizations',
            'active' => request()->routeIs(['admin.organizations.*', 'admin.past-exams.*', 'exam-categories.*']),
            'visible' => auth()->user()->hasRole(['admin', 'super_admin']),
            'items' => [
                ['label' => __('Organization'), 'route' => 'admin.organizations.index', 'match' => 'admin.organizations.*', 'icon' => 'building-office-2', 'visible' => true],
                ['label' => __('Past Exams'), 'route' => 'admin.past-exams.index', 'match' => 'admin.past-exams.*', 'icon' => 'document-text', 'visible' => true],
                ['label' => __('Categories'), 'route' => 'exam-categories.index', 'match' => 'exam-categories.*', 'icon' => 'folder', 'visible' => auth()->user()->hasAnyPermission(['exam_categories.manage'])],
            ]
        ],
        [
            'type' => 'link',
            'label' => __('Question Create'),
            'route' => 'question.set-create',
            'match' => 'question.set-create',
            'icon' => 'plus-circle',
            'visible' => auth()->user()->hasRole(['teacher', 'admin', 'super_admin']),
        ],
        [
            'type' => 'link',
            'label' => __('আমার তৈরি প্রশ্ন'),
            'route' => 'teacher.questions.index',
            'match' => 'teacher.questions.index',
            'icon' => 'document-text',
            'visible' => auth()->user()->hasRole(['teacher']),
        ],
        [
            'type' => 'link',
            'label' => __('OMR শীট তৈরি'),
            'route' => 'omr.generator',
            'match' => 'omr.generator',
            'icon' => 'custom-omr-frame',
            'visible' => auth()->user()->hasRole(['teacher', 'admin', 'super_admin']),
        ],
        [
            'type' => 'link',
            'label' => __('OMR স্ক্যানার'),
            'route' => 'student.omr-scanner',
            'match' => 'student.omr-scanner',
            'icon' => 'viewfinder-circle',
            'visible' => auth()->user()->hasRole(['teacher', 'admin', 'super_admin']),
        ],
        [
            'type' => 'link',
            'label' => __('প্রতিষ্ঠানের তথ্য'),
            'route' => 'teacher.organization-info',
            'match' => 'teacher.organization-info',
            'icon' => 'building-office',
            'visible' => auth()->user()->hasRole(['teacher']),
        ],
        [
            'type' => 'link',
            'label' => __('আমার সাবস্ক্রিপশন'),
            'route' => 'teacher.subscription',
            'match' => 'teacher.subscription',
            'icon' => 'book-open',
            'visible' => auth()->user()->hasRole(['teacher']),
        ],
        [
            'type' => 'link',
            'label' => __('প্রাইসিং'),
            'route' => 'teacher.pricing',
            'match' => 'teacher.pricing',
            'icon' => 'currency-dollar',
            'visible' => auth()->user()->hasRole(['teacher']),
        ],
        [
            'type' => 'link',
            'label' => __('আমার উপার্জন'),
            'route' => 'teacher.earnings',
            'match' => 'teacher.earnings',
            'icon' => 'banknotes',
            'visible' => auth()->user()->hasRole(['teacher']),
        ],
        [
            'type' => 'link',
            'label' => __('রিচার্জ/উইথড্র'),
            'route' => 'teacher.wallet',
            'match' => 'teacher.wallet',
            'icon' => 'wallet',
            'visible' => auth()->user()->hasRole(['teacher']),
        ],
        [
            'type' => 'link',
            'label' => __('Job Solutions'),
            'route' => 'job-solutions.index',
            'match' => 'job-solutions.*',
            'icon' => 'briefcase',
            'visible' => auth()->user()->isStudent() || auth()->user()->isJobSeeker(),
        ],
        [
            'type' => 'link',
            'label' => __('Practice'),
            'route' => 'students.practice.index',
            'match' => 'students.practice.*',
            'icon' => 'academic-cap',
            'visible' => auth()->user()->isStudent() || auth()->user()->isJobSeeker(),
        ],
        [
            'type' => 'link',
            'label' => __('My Goal'),
            'route' => 'student.goals',
            'match' => 'student.goals',
            'icon' => 'academic-cap',
            'visible' => auth()->user()->isStudent() || auth()->user()->isJobSeeker(),
        ],
        [
            'type' => 'link',
            'label' => __('Analytics'),
            'route' => 'student.analytics',
            'match' => 'student.analytics',
            'icon' => 'chart-bar',
            'visible' => auth()->user()->isStudent() || auth()->user()->isJobSeeker(),
        ],
        [
            'type' => 'link',
            'label' => __('Upgrade / Courses'),
            'route' => 'student.pricing',
            'match' => 'student.pricing*',
            'icon' => 'sparkles',
            'visible' => auth()->user()->isStudent() || auth()->user()->isJobSeeker(),
        ],
        [
            'type' => 'link',
            'label' => __('Model Tests'),
            'route' => 'student.model-tests.index',
            'match' => 'student.model-tests.*',

            'icon' => 'clock',
            'visible' => auth()->user()->isStudent() || auth()->user()->isJobSeeker(),
        ],
        [
            'type' => 'link',
            'label' => __('Bookmarks'),
            'route' => 'student.bookmarks',
            'match' => 'student.bookmarks',
            'icon' => 'bookmark',
            'visible' => auth()->user()->isStudent() || auth()->user()->isJobSeeker(),
        ],
        [
            'type' => 'group',
            'label' => __('Administration'),
            'icon' => 'shield-check',
            'flyout' => 'admin',
            'active' => request()->routeIs(['users.*', 'admin.theme-options', 'admin.wallet-approvals', 'admin.packages', 'permissions.*', 'roles-permissions.*']),
            'visible' => auth()->user()->hasPermission('users.manage_roles') || auth()->user()->hasPermission('users.manage_permissions'),
            'items' => [
                ['label' => __('User Management'), 'route' => 'users.index', 'match' => 'users.*', 'icon' => 'users', 'visible' => auth()->user()->hasPermission('users.manage_roles')],
                ['label' => __('Theme Options'), 'route' => 'admin.theme-options', 'match' => 'admin.theme-options', 'icon' => 'paint-brush', 'visible' => auth()->user()->hasPermission('users.manage_roles')],
                ['label' => __('Wallet Approvals'), 'route' => 'admin.wallet-approvals', 'match' => 'admin.wallet-approvals', 'icon' => 'banknotes', 'visible' => auth()->user()->hasPermission('users.manage_roles')],
                ['label' => __('Package Management'), 'route' => 'admin.packages', 'match' => 'admin.packages', 'icon' => 'cube', 'visible' => auth()->user()->hasPermission('users.manage_roles')],
                ['label' => __('Permissions'), 'route' => 'permissions.index', 'match' => 'permissions.*', 'icon' => 'key', 'visible' => auth()->user()->hasPermission('users.manage_permissions')],
                ['label' => __('Roles & Permissions'), 'route' => 'roles-permissions.index', 'match' => 'roles-permissions.*', 'icon' => 'lock-closed', 'visible' => auth()->user()->hasPermission('users.manage_permissions')],
            ]
        ],
        [
            'type' => 'link',
            'label' => __('Leaderboard'),
            'route' => 'student.leaderboard',
            'match' => 'student.leaderboard',
            'icon' => 'trophy',
            'visible' => auth()->user()->isStudent() || auth()->user()->isJobSeeker(),
        ],
        [
            'type' => 'link',
            'label' => __('Mistake Review'),
            'route' => 'student.mistakes',
            'match' => 'student.mistakes',
            'icon' => 'exclamation-circle',
            'visible' => auth()->user()->isStudent() || auth()->user()->isJobSeeker()
        ],
        [
            'type' => 'link',
            'label' => __("Test History"),
            'route' => 'student.test-history',
            'match' => 'student.test-history',
            'icon' => 'clock',
            'visible' => auth()->user()->isStudent() || auth()->user()->isJobSeeker()
        ],
        [
            'type' => 'group',
            'label' => __('OMR'),
            'icon' => 'document-check',
            'flyout' => 'omr-bank',
            'active' => request()->routeIs(['tokens.*', 'omr.*']),
            'visible' => true,
            'items' => [
                ['label' => __('Token List'), 'route' => 'tokens.list', 'match' => 'tokens.*', 'icon' => 'ticket', 'visible' => true],
                ['label' => __('Token Map'), 'route' => 'tokens.map-answers', 'match' => 'tokens.*', 'icon' => 'map-pin', 'visible' => auth()->user()->hasAnyPermission(['tokens.map-answers'])],
                ['label' => __('OMR'), 'route' => 'omr.evaluate', 'match' => 'omr.*', 'icon' => 'check-badge', 'visible' => auth()->user()->hasAnyPermission(['omr.evaluate'])],
            ]
        ],
        [
            'type'  => 'group',
            'label' =>  __('Settings'),
            'icon'  =>  'cog-8-tooth',
            'flyout'   => 'settings',
            'active'    => request()->routeIs(['admin.settings.*', 'users.index']),
            'visible'   => auth()->user()->hasRole(['admin', 'super_admin']),
            'items'     => [
                ['label' => __('General Setting'), 'route' => 'admin.settings.general', 'match' => 'admin.settings.general', 'icon' => 'adjustments-horizontal', 'visible' => true],
                ['label' => __('Brand Setting'), 'route' => 'admin.settings.branding', 'match' => 'admin.settings.branding', 'icon' => 'sparkles', 'visible' => true],
                ['label' => __('Global SEO'), 'route' => 'admin.settings.seo', 'match' => 'admin.settings.seo', 'icon' => 'globe-alt', 'visible' => true],
                ['label' => __('Menu Builder'), 'route' => 'admin.settings.menus', 'match' => 'admin.settings.menus', 'icon' => 'bars-3-center-left', 'visible' => true],
                ['label' => __('Frontend Footer'), 'route' => 'admin.settings.footer', 'match' => 'admin.settings.footer', 'icon' => 'queue-list', 'visible' => true],
                ['label' => __('Email Setting'), 'route' => 'admin.settings.email', 'match' => 'admin.settings.email', 'icon' => 'envelope', 'visible' => true],
                ['label' => __('AI Setting'), 'route' => 'admin.settings.ai', 'match' => 'admin.settings.ai', 'icon' => 'cpu-chip', 'visible' => true],
                ['label' => __('Languages'), 'route' => 'admin.settings.languages', 'match' => 'admin.settings.languages', 'icon' => 'language', 'visible' => true],
                ['label' => __('Website Tracking'), 'route' => 'admin.settings.tracking', 'match' => 'admin.settings.tracking', 'icon' => 'chart-bar', 'visible' => true],
                ['label' => __('Payment Gateways'), 'route' => 'admin.settings.payment', 'match' => 'admin.settings.payment', 'icon' => 'credit-card', 'visible' => true],
            ]
        ],
        [
            'type'  => 'group',
            'label' =>  __('System Settings'),
            'icon'  =>  'server-stack',
            'flyout'   => 'system-settings',
            'active'    => request()->routeIs(['superadmin.settings.*']),
            'visible'   => auth()->user()->hasRole('super_admin'),
            'items'     => [
                ['label' => __('Sitemap Setting'), 'route' => 'superadmin.settings.sitemap', 'match' => 'superadmin.settings.sitemap', 'icon' => 'globe-alt', 'visible' => true],
                ['label' => __('Robots.txt'), 'route' => 'superadmin.settings.robots-txt', 'match' => 'superadmin.settings.robots-txt', 'icon' => 'document-text', 'visible' => true],
                ['label' => __('Htaccess'), 'route' => 'superadmin.settings.htaccess', 'match' => 'superadmin.settings.htaccess', 'icon' => 'code-bracket', 'visible' => true],
                ['label' => __('Backups'), 'route' => 'superadmin.settings.backups', 'match' => 'superadmin.settings.backups', 'icon' => 'circle-stack', 'visible' => true],
                ['label' => __('Cache Management'), 'route' => 'superadmin.settings.cache', 'match' => 'superadmin.settings.cache', 'icon' => 'trash', 'visible' => true],
                ['label' => __('System Information'), 'route' => 'superadmin.settings.system-info', 'match' => 'superadmin.settings.system-info', 'icon' => 'information-circle', 'visible' => true],
                ['label' => __('Activity Logs'), 'route' => 'superadmin.settings.activity-logs', 'match' => 'superadmin.settings.activity-logs', 'icon' => 'clipboard-document-list', 'visible' => true],
            ]
        ]
    ];
@endphp

    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    @include('partials.head')
</head>
<body
    x-data="{
        settingsOpen: false,
        helpOpen: false,
        defaultTheme: '{{ strtolower(\App\Support\SettingsStore::group('branding')['default_theme'] ?? 'system') }}',
        mode: localStorage.getItem('app.appearance') || localStorage.getItem('theme') || '{{ strtolower(\App\Support\SettingsStore::group('branding')['default_theme'] ?? 'system') }}',
        applyAppearance(selected) {
            this.mode = selected;

            if (selected === 'dark') {
                localStorage.setItem('theme', 'dark');
                localStorage.setItem('app.appearance', 'dark');
                document.documentElement.classList.add('dark');
            } else if (selected === 'light') {
                localStorage.setItem('theme', 'light');
                localStorage.setItem('app.appearance', 'light');
                document.documentElement.classList.remove('dark');
            } else {
                localStorage.removeItem('theme');
                localStorage.setItem('app.appearance', 'system');
                document.documentElement.classList.toggle('dark', window.matchMedia('(prefers-color-scheme: dark)').matches);
            }

            window.dispatchEvent(new CustomEvent('theme-changed', { detail: { theme: selected } }));
        },
        init() {
            if (!localStorage.getItem('app.appearance') && !localStorage.getItem('theme')) {
                this.applyAppearance(this.defaultTheme);
            }
        }
    }"
    x-on:keydown.escape.window="settingsOpen = false; helpOpen = false"
    class="min-h-screen bg-white dark:bg-zinc-800"
>

<x-ui.header sticky collapsible="mobile" class="bg-zinc-50 dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
    <x-ui.sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

    <x-ui.navbar class="-mb-px max-lg:hidden">
        <x-ui.navbar.item icon="inbox" badge="12" href="#">{{ __('Inbox') }}</x-ui.navbar.item>
        <x-ui.separator vertical variant="subtle" class="my-2"/>
        <x-ui.dropdown class="max-lg:hidden">
            <x-ui.navbar.item icon:trailing="chevron-down">{{__('Favorites')}}</x-ui.navbar.item>
            <x-ui.navmenu>
                <x-ui.navmenu.item href="#">{{__('Marketing site')}}</x-ui.navmenu.item>
                <x-ui.navmenu.item href="#">{{__('Android app')}}</x-ui.navmenu.item>
                <x-ui.navmenu.item href="#">{{ __('Brand guidelines') }}</x-ui.navmenu.item>
            </x-ui.navmenu>
        </x-ui.dropdown>
    </x-ui.navbar>
    <x-ui.spacer />
    <x-ui.navbar class="me-4">
        <x-ui.navbar.item icon="magnifying-glass" href="#" label="Search" />
        <x-ui.navbar.item icon="globe-alt" :href="route('home')" target="_blank" label="{{ __('Visit Website') }}" />
        <x-ui.button type="button" variant="ghost" icon="cog-6-tooth" class="max-lg:hidden" x-on:click="settingsOpen = true" aria-label="{{ __('Open settings') }}" />

        <!-- Theme Toggle -->
        <x-ui.button type="button" variant="ghost" x-on:click="applyAppearance(mode === 'dark' ? 'light' : 'dark')" aria-label="{{ __('Toggle dark mode') }}">
            <x-ui.icon.moon x-show="mode !== 'dark'" class="size-5" />
            <x-ui.icon.sun x-show="mode === 'dark'" x-cloak class="size-5" />
        </x-ui.button>
    </x-ui.navbar>

    <x-ui.dropdown align="end">
        <button type="button" class="group flex items-center rounded-full bg-zinc-100/80 dark:bg-zinc-800 p-1 hover:bg-zinc-200/50 dark:hover:bg-zinc-700/50 transition" data-ui-profile>
            <x-ui.avatar :initials="auth()->user()->initials()" :src="filled(auth()->user()->picture) ? asset('storage/' . auth()->user()->picture) : null" size="sm" />
            @if(auth()->user()->isAdmin())
                <div class="px-2 hidden sm:flex items-center gap-1 text-xs font-bold text-indigo-500">
                    <x-ui.icon.shield-check class="size-3" /> Admin
                </div>
            @elseif(auth()->user()->hasActiveSubscription())
                <div class="px-2 hidden sm:flex items-center gap-1 text-xs font-bold text-amber-500">
                    <x-ui.icon.sparkles class="size-3" /> Pro
                </div>
            @endif
        </button>

        <x-ui.menu class="min-w-72">
            <div class="px-3 py-3">
                <div class="flex items-start gap-3">
                    <div class="min-w-0 flex-1">
                        <x-ui.heading class="truncate">{{ auth()->user()->name }}</x-ui.heading>
                        <x-ui.text size="sm" class="truncate">{{ auth()->user()->email }}</x-ui.text>
                        <div class="mt-2 flex flex-wrap gap-1.5"></div>
                    </div>
                </div>
            </div>

            <x-ui.menu.separator />

            <x-ui.menu.item :href="route('profile.edit')" icon="user">
                {{ __('Profile Settings') }}
            </x-ui.menu.item>
            <x-ui.menu.item :href="route('security.edit')" icon="shield-check">
                {{ __('Security') }}
            </x-ui.menu.item>
            <x-ui.menu.item :href="route('appearance.edit')" icon="paint-brush">
                {{ __('Appearance') }}
            </x-ui.menu.item>
            <x-ui.menu.item icon="cog-6-tooth" x-on:click="settingsOpen = true">
                {{ __('Quick Settings') }}
            </x-ui.menu.item>

            <x-ui.menu.separator />

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button
                    type="submit"
                    class="flex w-full items-center gap-2 rounded-md px-3 py-2 text-left text-sm text-red-600 transition hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/30"
                    data-test="logout-button"
                >
                    <x-ui.icon.arrow-right-start-on-rectangle class="size-4" />
                    <span>{{ __('Log out') }}</span>
                </button>
            </form>
        </x-ui.menu>
    </x-ui.dropdown>
</x-ui.header>

<x-ui.sidebar sticky collapsible class="min-h-dvh border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
    <x-ui.sidebar.header class="sticky top-0 z-20 bg-zinc-50 dark:bg-zinc-900">
        <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" />
        <x-ui.sidebar.collapse class="in-data-ui-sidebar-on-desktop:not-in-data-ui-sidebar-collapsed-desktop:-mr-2" />
    </x-ui.sidebar.header>

    <x-ui.sidebar.nav>
        <!-- Dynamic Menu Loop -->
        @foreach($menuItems as $item)
            @if($item['visible'])

                @if($item['type'] === 'link')
                    @if($item['icon'] === 'custom-omr-frame')
                        <x-ui.sidebar.item :href="route($item['route'])" :current="request()->routeIs($item['match'])">
                            <x-slot:icon>
                                <x-omr-icon class="size-5 text-zinc-500 group-hover:text-emerald-600" />
                            </x-slot:icon>
                            {{ $item['label'] }}
                        </x-ui.sidebar.item>
                    @else
                        <x-ui.sidebar.item :icon="$item['icon']" :href="route($item['route'])" :current="request()->routeIs($item['match'])">
                            {{ $item['label'] }}
                        </x-ui.sidebar.item>
                    @endif

                @elseif($item['type'] === 'group')
                    <x-ui.sidebar.group expandable :icon="$item['icon']" :heading="$item['label']" :expanded="$item['active']" >
                        <div class="flex flex-col w-full ">
                            @foreach($item['items'] as $subItem)
                            @if($subItem['visible'])
                                <x-ui.sidebar.item
                                    :icon="$subItem['icon'] ?? null"
                                    :href="route($subItem['route'])"
                                    :current="filled($subItem['match']) ? request()->routeIs($subItem['match']) : false"

                                >
                                    {{ $subItem['label'] }}
                                </x-ui.sidebar.item>
                            @endif
                        @endforeach
                        </div>
                    </x-ui.sidebar.group>
                @endif

            @endif
        @endforeach
    </x-ui.sidebar.nav>

    <x-ui.spacer />

    <div class="sticky bottom-0 z-20 bg-zinc-50 dark:bg-zinc-900 pt-2 pb-1 border-t border-zinc-200/80 dark:border-zinc-700/80 mt-2">
        <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
    </div>
</x-ui.sidebar>

<!-- Mobile User Menu -->
<x-ui.header class="hidden">
    <x-ui.sidebar.toggle class="hidden" icon="bars-2" inset="left" />

    <x-ui.spacer />

    <!-- Mobile Theme Toggle -->
    <x-ui.button type="button" variant="ghost" x-on:click="applyAppearance(mode === 'dark' ? 'light' : 'dark')" aria-label="{{ __('Toggle dark mode') }}" class="mr-2">
        <x-ui.icon.moon x-show="mode !== 'dark'" class="size-5" />
        <x-ui.icon.sun x-show="mode === 'dark'" x-cloak class="size-5" />
    </x-ui.button>

    <x-ui.dropdown position="top" align="end">
        <button type="button" class="group flex items-center rounded-full bg-zinc-100/80 dark:bg-zinc-800 p-1 hover:bg-zinc-200/50 dark:hover:bg-zinc-700/50 transition" data-ui-profile>
            <x-ui.avatar :initials="auth()->user()->initials()" size="sm" />
            @if(auth()->user()->isAdmin())
                <div class="px-2 flex items-center gap-1 text-xs font-bold text-indigo-500">
                    <x-ui.icon.shield-check class="size-3" /> Admin
                </div>
            @elseif(auth()->user()->hasActiveSubscription())
                <div class="px-2 flex items-center gap-1 text-xs font-bold text-amber-500">
                    <x-ui.icon.sparkles class="size-3" /> Pro
                </div>
            @endif
        </button>

        <x-ui.menu>
            <x-ui.menu.radio.group>
                <div class="p-0 text-sm font-normal">
                    <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                        <x-ui.avatar
                            :name="auth()->user()->name"
                            :initials="auth()->user()->initials()"
                        />

                        <div class="grid flex-1 text-start text-sm leading-tight">
                            <x-ui.heading class="truncate">{{ auth()->user()->name }}</x-ui.heading>
                            <x-ui.text class="truncate">{{ auth()->user()->email }}</x-ui.text>
                        </div>
                    </div>
                </div>
            </x-ui.menu.radio.group>

            <x-ui.menu.separator />

            <x-ui.menu.radio.group>
                <x-ui.menu.item :href="route('profile.edit')" icon="cog">
                    {{ __('Settings') }}
                </x-ui.menu.item>
            </x-ui.menu.radio.group>

            <x-ui.menu.separator />

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <x-ui.menu.item
                    as="button"
                    type="submit"
                    icon="arrow-right-start-on-rectangle"
                    class="w-full cursor-pointer"
                    data-test="logout-button"
                >
                    {{ __('Log out') }}
                </x-ui.menu.item>
            </form>
        </x-ui.menu>
    </x-ui.dropdown>
</x-ui.header>


{{ $slot }}


<x-ui.toast />

@if(session('toast'))
    <script>
        document.addEventListener('DOMContentLoaded', () => window.AppUI.toast(@json([
            'text' => session('toast.message'),
            'heading' => session('toast.heading'),
            'variant' => session('toast.variant'),
        ])));
    </script>
@endif

@if(session('page_event'))
    <script>
        document.addEventListener('DOMContentLoaded', () => window.dispatchEvent(new CustomEvent(
            @json(session('page_event.name')),
            { detail: @json(session('page_event.detail')) },
        )));
    </script>
@endif

<x-delete-confirmation />


@stack('scripts')



@php
    $tracking = \App\Support\SettingsStore::group('tracking');
@endphp
@if(!empty($tracking['custom_footer_script']))
    {!! $tracking['custom_footer_script'] !!}
@endif
</body>
</html>
