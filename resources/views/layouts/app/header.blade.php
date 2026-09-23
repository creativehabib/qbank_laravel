<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        @stack('styles')
    </head>
    <body class="min-h-screen bg-gray-50 print:bg-white dark:bg-[var(--app-dark-bg)]">
        <x-ui.header container class="print:hidden border-b border-zinc-200 bg-zinc-50 dark:border-[var(--app-dark-border)] dark:bg-[var(--app-dark-panel)]">
            <x-ui.sidebar.toggle class="lg:hidden mr-2" icon="bars-2" inset="left" />

            <x-app-logo href="{{ route('dashboard') }}" />

            <x-ui.navbar class="-mb-px max-lg:hidden">
                <x-ui.navbar.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')">
                    {{ __('Dashboard') }}
                </x-ui.navbar.item>
            </x-ui.navbar>

            <x-ui.spacer />

            <x-ui.navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">
                <x-ui.tooltip :content="__('Search')" position="bottom">
                    <x-ui.navbar.item class="!h-10 [&>div>svg]:size-5" icon="magnifying-glass" href="#" :label="__('Search')" />
                </x-ui.tooltip>
                <x-ui.tooltip :content="__('Repository')" position="bottom">
                    <x-ui.navbar.item
                        class="h-10 max-lg:hidden [&>div>svg]:size-5"
                        icon="folder-git-2"
                        href="#"
                        target="_blank"
                        :label="__('Repository')"
                    />
                </x-ui.tooltip>
                <x-ui.tooltip :content="__('Documentation')" position="bottom">
                    <x-ui.navbar.item
                        class="h-10 max-lg:hidden [&>div>svg]:size-5"
                        icon="book-open-text"
                        href="https://laravel.com/docs"
                        target="_blank"
                        :label="__('Documentation')"
                    />
                </x-ui.tooltip>
            </x-ui.navbar>

            <x-desktop-user-menu />
        </x-ui.header>

        <!-- Mobile Menu -->
        <x-ui.sidebar collapsible="mobile" sticky class="print:hidden lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-[var(--app-dark-border)] dark:bg-[var(--app-dark-panel)]">
            <x-ui.sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" />
                <x-ui.sidebar.collapse class="in-data-ui-sidebar-on-desktop:not-in-data-ui-sidebar-collapsed-desktop:-mr-2" />
            </x-ui.sidebar.header>

            <x-ui.sidebar.nav>
                <x-ui.sidebar.group :heading="__('Platform')">
                    <x-ui.sidebar.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')">
                        {{ __('Dashboard')  }}
                    </x-ui.sidebar.item>
                </x-ui.sidebar.group>
            </x-ui.sidebar.nav>

            <x-ui.spacer />

            <x-ui.sidebar.nav>
                <x-ui.sidebar.item icon="folder-git-2" href="#" target="_blank">
                    {{ __('Repository') }}
                </x-ui.sidebar.item>
                <x-ui.sidebar.item icon="book-open-text" href="https://laravel.com/docs" target="_blank">
                    {{ __('Documentation') }}
                </x-ui.sidebar.item>
            </x-ui.sidebar.nav>
        </x-ui.sidebar>

        {{ $slot }}


    </body>
</html>
