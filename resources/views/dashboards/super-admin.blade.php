<x-layouts.app title="Super Admin Dashboard">
    <div class="space-y-6">

        @if (session('success'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-3 text-sm text-emerald-700 dark:border-emerald-500/40 dark:bg-emerald-500/10 dark:text-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-1 mb-2">
            <x-ui.heading size="xl">Super Admin Overview</x-ui.heading>
            <x-ui.subheading size="lg">Manage platform content, users, and overall system health.</x-ui.subheading>
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-5">
            <x-ui.card class="relative overflow-hidden group">
                <div class="absolute -right-2 -top-2 size-12 text-zinc-100 dark:text-zinc-800 opacity-20 transition-transform group-hover:scale-110">
                    <x-ui.icon.document-text class="size-12" />
                </div>
                <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">Total Questions</p>
                <p class="mt-2 text-3xl font-black text-zinc-900 dark:text-white">{{ $overviewStats['total_questions'] }}</p>
            </x-ui.card>
            <x-ui.card class="relative overflow-hidden group">
                <div class="absolute -right-2 -top-2 size-12 text-zinc-100 dark:text-zinc-800 opacity-20 transition-transform group-hover:scale-110">
                    <x-ui.icon.users class="size-12" />
                </div>
                <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">Total Users</p>
                <p class="mt-2 text-3xl font-black text-zinc-900 dark:text-white">{{ $overviewStats['total_users'] }}</p>
            </x-ui.card>
            <x-ui.card class="relative overflow-hidden group">
                <div class="absolute -right-2 -top-2 size-12 text-zinc-100 dark:text-zinc-800 opacity-20 transition-transform group-hover:scale-110">
                    <x-ui.icon.academic-cap class="size-12" />
                </div>
                <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">Total Exams</p>
                <p class="mt-2 text-3xl font-black text-zinc-900 dark:text-white">{{ $overviewStats['total_exam_categories'] }}</p>
            </x-ui.card>
            <x-ui.card class="relative overflow-hidden group">
                <div class="absolute -right-2 -top-2 size-12 text-zinc-100 dark:text-zinc-800 opacity-20 transition-transform group-hover:scale-110">
                    <x-ui.icon.currency-dollar class="size-12" />
                </div>
                <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">Revenue</p>
                <p class="mt-2 text-3xl font-black text-zinc-900 dark:text-white">৳ {{ number_format($overviewStats['monthly_revenue']) }}</p>
            </x-ui.card>
            <x-ui.card class="relative overflow-hidden group border-amber-200 dark:border-amber-900/50">
                <div class="absolute -right-2 -top-2 size-12 text-amber-100 dark:text-amber-900/30 opacity-20 transition-transform group-hover:scale-110">
                    <x-ui.icon.clock class="size-12" />
                </div>
                <p class="text-xs font-bold uppercase tracking-widest text-amber-600 dark:text-amber-500">Pending Approval</p>
                <p class="mt-2 text-3xl font-black text-amber-600 dark:text-amber-500">{{ $overviewStats['pending_approval'] }}</p>
            </x-ui.card>
        </div>

        <x-ui.card class="!p-0 overflow-hidden">
            <div class="p-5 border-b border-zinc-200 dark:border-zinc-700">
                <x-ui.heading size="lg">Creator Summary</x-ui.heading>
                <x-ui.text class="!text-sm">Summary of content created by teachers.</x-ui.text>
            </div>

            <x-ui.table>
                <x-ui.table.columns>
                    <x-ui.table.column>User</x-ui.table.column>
                    <x-ui.table.column>Total Sets</x-ui.table.column>
                    <x-ui.table.column>Total Questions</x-ui.table.column>
                    <x-ui.table.column>Types</x-ui.table.column>
                </x-ui.table.columns>
                <x-ui.table.rows>
                    @forelse ($creatorSummary as $item)
                        <x-ui.table.row>
                            <x-ui.table.cell class="font-medium">{{ $item['user_name'] }}</x-ui.table.cell>
                            <x-ui.table.cell>{{ $item['question_set_count'] }}</x-ui.table.cell>
                            <x-ui.table.cell>{{ $item['question_total'] }}</x-ui.table.cell>
                            <x-ui.table.cell>
                                <div class="flex flex-wrap gap-1">
                                @foreach ($item['types'] as $type => $count)
                                    <x-ui.badge size="sm" color="zinc">{{ strtoupper($type) }}: {{ $count }}</x-ui.badge>
                                @endforeach
                                </div>
                            </x-ui.table.cell>
                        </x-ui.table.row>
                    @empty
                        <x-ui.table.row>
                            <x-ui.table.cell colspan="4" class="text-center text-zinc-500">No data found.</x-ui.table.cell>
                        </x-ui.table.row>
                    @endforelse
                </x-ui.table.rows>
            </x-ui.table>
        </x-ui.card>

        <x-ui.card>
            <x-ui.heading size="lg" class="mb-4">Question Sets Management</x-ui.heading>

            <div class="space-y-4">
                @forelse ($questionSets as $questionSet)
                    <div class="rounded-lg border border-zinc-200 p-4 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/50">
                        <div class="mb-3 text-sm text-zinc-500 dark:text-zinc-400">
                            Created by: <span class="font-semibold text-zinc-700 dark:text-zinc-200">{{ $questionSet->user?->name ?? 'Unknown' }}</span>
                            · Date: {{ $questionSet->created_at?->format('d M Y, h:i A') }}
                        </div>

                        <form method="POST" action="{{ route('dashboard.question-sets.update', $questionSet) }}" class="flex flex-col sm:flex-row gap-3 items-end">
                            @csrf
                            @method('PATCH')
                            <div class="w-full sm:w-1/3">
                                <x-ui.input type="text" name="name" value="{{ $questionSet->name }}" label="Name" required />
                            </div>
                            <div class="w-full sm:w-1/4">
                                <x-ui.select name="type" label="Type" required>
                                    @foreach (['mcq' => 'MCQ', 'cq' => 'CQ', 'short' => 'SHORT', 'written' => 'WRITTEN', 'combine' => 'COMBINE'] as $key => $label)
                                        <option value="{{ $key }}" @selected(($questionSet->generation_criteria['type'] ?? 'mcq') === $key)>{{ $label }}</option>
                                    @endforeach
                                </x-ui.select>
                            </div>
                            <div class="w-full sm:w-1/4">
                                <x-ui.input type="number" min="1" max="500" name="quantity" value="{{ (int) ($questionSet->generation_criteria['quantity'] ?? 1) }}" label="Quantity" required />
                            </div>
                            <div class="w-full sm:w-auto mt-2 sm:mt-0 flex gap-2">
                                <x-ui.button type="submit" variant="primary" class="w-full sm:w-auto">Update</x-ui.button>
                                <x-ui.button type="button" variant="danger" icon="trash" class="w-full sm:w-auto" onclick="if(confirm('Are you sure?')) document.getElementById('delete-form-{{ $questionSet->id }}').submit();" />
                            </div>
                        </form>

                        <form id="delete-form-{{ $questionSet->id }}" method="POST" action="{{ route('dashboard.question-sets.destroy', $questionSet) }}" class="hidden">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                @empty
                    <div class="text-center text-sm text-zinc-500 py-4">No Question Sets found.</div>
                @endforelse
            </div>
        </x-ui.card>
    </div>
</x-layouts.app>
