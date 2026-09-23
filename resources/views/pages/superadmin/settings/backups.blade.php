<div class="max-w-7xl mx-auto space-y-6 pb-12">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <x-ui.heading size="xl">System Backups</x-ui.heading>
            <x-ui.subheading>ডাটাবেজ এবং সম্পূর্ণ প্রজেক্টের ব্যাকআপ তৈরি, ডাউনলোড বা মুছে ফেলুন।</x-ui.subheading>
        </div>

        <div class="flex items-center gap-3">
            <x-ui.button data-page-click="cleanBackups" data-page-loading.attr="disabled" icon="trash" size="sm" variant="danger">
                <span data-page-loading.remove data-page-target="cleanBackups">Clean Old</span>
                <span data-page-loading data-page-target="cleanBackups">Cleaning...</span>
            </x-ui.button>
            <x-ui.button data-page-click="runBackup(true)" data-page-loading.attr="disabled" icon="circle-stack" size="sm" variant="outline">
                <span data-page-loading.remove data-page-target="runBackup(true)">Database Only</span>
                <span data-page-loading data-page-target="runBackup(true)">Processing...</span>
            </x-ui.button>
            <x-ui.button data-page-click="runBackup(false)" data-page-loading.attr="disabled" icon="folder-arrow-down" size="sm" variant="primary">
                <span data-page-loading.remove data-page-target="runBackup(false)">Full Backup</span>
                <span data-page-loading data-page-target="runBackup(false)">Processing...</span>
            </x-ui.button>
        </div>
    </div>

    <x-ui.card class="!p-0 overflow-hidden">
        <x-ui.table class="px-6">
            <x-ui.table.columns>
                <x-ui.table.column>BACKUP NAME</x-ui.table.column>
                <x-ui.table.column>SIZE</x-ui.table.column>
                <x-ui.table.column>CREATED AT</x-ui.table.column>
                <x-ui.table.column align="right">ACTIONS</x-ui.table.column>
            </x-ui.table.columns>

            <x-ui.table.rows>
                @forelse($this->backups as $backup)
                    <x-ui.table.row>
                        <x-ui.table.cell>
                            <div class="flex items-center gap-2">
                                <x-ui.icon.archive-box class="w-5 h-5 text-zinc-400" />
                                <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $backup['file_name'] }}</span>
                            </div>
                        </x-ui.table.cell>
                        <x-ui.table.cell class="text-zinc-600 dark:text-zinc-400">
                            {{ $backup['file_size'] }}
                        </x-ui.table.cell>
                        <x-ui.table.cell class="text-zinc-600 dark:text-zinc-400">
                            {{ $backup['date']->format('d M Y, h:i A') }}
                            <span class="text-xs text-zinc-400 ml-1">({{ $backup['date']->diffForHumans() }})</span>
                        </x-ui.table.cell>
                        <x-ui.table.cell align="right">
                            <div class="flex justify-end gap-2">
                                <x-ui.button data-page-click="downloadBackup('{{ $backup['path'] }}')" icon="arrow-down-tray" size="sm" variant="outline">
                                    Download
                                </x-ui.button>
                                <x-ui.button data-page-click="deleteBackup('{{ $backup['path'] }}')" data-page-confirm="আপনি কি নিশ্চিত যে এই ব্যাকআপটি ডিলিট করতে চান?" icon="trash" size="sm" variant="danger" />
                            </div>
                        </x-ui.table.cell>
                    </x-ui.table.row>
                @empty
                    <x-ui.table.row>
                        <x-ui.table.cell colspan="4" class="py-12 text-center text-zinc-500">
                            <x-ui.icon.exclamation-triangle class="w-12 h-12 mx-auto text-zinc-300 mb-3" />
                            <p class="text-base font-medium text-zinc-900 dark:text-zinc-100">কোনো ব্যাকআপ পাওয়া যায়নি!</p>
                            <p class="text-sm mt-1">উপরে ডানদিকের বাটন থেকে নতুন ব্যাকআপ তৈরি করুন।</p>
                        </x-ui.table.cell>
                    </x-ui.table.row>
                @endforelse
            </x-ui.table.rows>
        </x-ui.table>
    </x-ui.card>
</div>
