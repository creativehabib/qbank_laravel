@props([
    'title',
    'description',
    'modelName' => 'item',
])

<div class="pb-2">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div>
            <x-ui.heading size="xl" class="!font-semibold">{{ $title }}</x-ui.heading>
            <x-ui.text class="mt-1 !text-sm">{{ $description }}</x-ui.text>
        </div>

        <div class="flex items-center gap-3">
            <!-- View Toggle -->
            <div class="hidden sm:flex items-center bg-zinc-100 dark:bg-zinc-800/80 rounded-lg p-1">
                <button class="flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium rounded-md bg-white dark:bg-zinc-700 shadow-sm text-zinc-900 dark:text-white">
                    <x-ui.icon icon="list-bullet" class="size-4" /> Table
                </button>
                <button class="flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium rounded-md text-zinc-500 hover:text-zinc-700 dark:text-zinc-400 dark:hover:text-zinc-300">
                    <x-ui.icon icon="bars-3-bottom-left" class="size-4" /> Tree
                </button>
            </div>

            <div class="hidden sm:block w-px h-6 bg-zinc-200 dark:bg-zinc-700"></div>

            <!-- Import -->
            <x-ui.button variant="ghost" icon="arrow-down-tray" class="!text-zinc-600 dark:!text-zinc-400">Import</x-ui.button>

            <!-- Export Dropdown -->
            <x-ui.dropdown position="bottom-end">
                <x-ui.button variant="ghost" icon="arrow-up-tray" icon-trailing="chevron-down" class="!text-zinc-600 dark:!text-zinc-400">Export</x-ui.button>
                <x-ui.menu>
                    <x-ui.menu.item icon="document-text">Export as CSV</x-ui.menu.item>
                    <x-ui.menu.item icon="table-cells">Export as Excel</x-ui.menu.item>
                    <x-ui.menu.item icon="document">Export as PDF</x-ui.menu.item>
                </x-ui.menu>
            </x-ui.dropdown>

            <!-- Custom slot for extra buttons (like Subject dropdown in Topics) -->
            @if(isset($actions))
                {{ $actions }}
            @endif

            <!-- New Button -->
            <x-ui.button variant="primary" icon="plus" data-page-click="create">New {{ $modelName }}</x-ui.button>
        </div>
    </div>
</div>
