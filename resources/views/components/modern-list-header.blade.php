@props(['total' => 0, 'model' => 'search'])

<div class="flex items-center justify-between px-4 py-3 border-b border-zinc-100 dark:border-zinc-800">
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <span class="font-medium text-sm whitespace-nowrap text-zinc-700 dark:text-zinc-300">All items ({{ $total }})</span>
        <div class="relative">
            <x-ui.input data-page-model.live.debounce.300ms="{{ $model }}" icon="magnifying-glass" placeholder="Search..." class="w-full sm:w-64" />
        </div>
    </div>
    <div class="hidden lg:block text-xs text-zinc-400">
        Drag the handle to reorder
    </div>
    <div class="flex items-center gap-2">
                <x-ui.dropdown>
            <x-ui.button variant="ghost" size="sm" icon="arrows-up-down" icon-trailing="chevron-down" class="text-zinc-500">Sort</x-ui.button>
            <x-ui.menu class="w-48">
                <x-ui.menu.radio.group data-page-model.live="sortField">
                    <x-ui.menu.radio value="default">Default order</x-ui.menu.radio>
                    <x-ui.menu.separator />
                    <x-ui.menu.radio value="name_asc">Name A &rarr; Z</x-ui.menu.radio>
                    <x-ui.menu.radio value="name_desc">Name Z &rarr; A</x-ui.menu.radio>
                </x-ui.menu.radio.group>
            </x-ui.menu>
        </x-ui.dropdown>
        <x-ui.button variant="ghost" size="sm" icon="arrow-path" data-page-click="$refresh" class="text-zinc-500" />
    </div>
</div>
