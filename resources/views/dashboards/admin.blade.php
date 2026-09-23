<x-layouts.app title="Admin Dashboard">
    <div class="space-y-6">
        <div class="space-y-1 mb-2">
            <x-ui.heading size="xl">System Overview</x-ui.heading>
            <x-ui.subheading size="lg">Manage your digital school, academic contents, and user activities.</x-ui.subheading>
        </div>


                    {{-- ১. Overview Counters --}}
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        <x-ui.card class="relative overflow-hidden group">
                            <div class="absolute -right-2 -top-2 size-12 text-zinc-100 dark:text-zinc-800 opacity-20 transition-transform group-hover:scale-110">
                                <x-ui.icon.document-text class="size-12" />
                            </div>
                            <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">Total Questions</p>
                            <p class="mt-2 text-3xl font-black text-zinc-900 dark:text-white">
                                {{ number_format($adminStats['total_questions'] ?? 0) }}
                                @if(($adminStats['today_questions'] ?? 0) > 0)
                                    <x-ui.badge size="sm" color="emerald" class="ml-1">+{{ $adminStats['today_questions'] }} today</x-ui.badge>
                                @endif
                            </p>
                        </x-ui.card>

                        <x-ui.card class="relative overflow-hidden group">
                            <div class="absolute -right-2 -top-2 size-12 text-amber-100 dark:text-amber-900 opacity-20 transition-transform group-hover:scale-110">
                                <x-ui.icon.clock class="size-12" />
                            </div>
                            <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">Pending Reviews</p>
                            <p class="mt-2 text-3xl font-black {{ ($adminStats['pending_reviews'] ?? 0) > 0 ? 'text-amber-500' : 'text-zinc-400' }}">
                                {{ $adminStats['pending_reviews'] ?? 0 }}
                            </p>
                        </x-ui.card>

                        <x-ui.card class="relative overflow-hidden group">
                            <div class="absolute -right-2 -top-2 size-12 text-rose-100 dark:text-rose-900 opacity-20 transition-transform group-hover:scale-110">
                                <x-ui.icon.banknotes class="size-12" />
                            </div>
                            <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">Pending Withdrawals</p>
                            <p class="mt-2 text-3xl font-black {{ ($pendingWithdrawSum ?? 0) > 0 ? 'text-rose-500' : 'text-zinc-400' }}">
                                ৳{{ number_format($pendingWithdrawSum ?? 0, 2) }}
                            </p>
                        </x-ui.card>

                        <x-ui.card class="relative overflow-hidden group">
                            <div class="absolute -right-2 -top-2 size-12 text-emerald-100 dark:text-emerald-900 opacity-20 transition-transform group-hover:scale-110">
                                <x-ui.icon.adjustments-horizontal class="size-12" />
                            </div>
                            <p class="text-xs font-bold uppercase tracking-widest text-zinc-400">OMR Evaluations</p>
                            <p class="mt-2 text-3xl font-black text-emerald-600 dark:text-emerald-400">
                                {{ number_format($adminStats['total_omr_evaluations'] ?? 0) }}
                                @if(isset($omrStats['started']) && $omrStats['started'] > 0)
                                    <span class="text-[10px] font-medium text-zinc-400 block mt-0.5">Running OMR Exams: {{ $omrStats['started'] }}</span>
                                @endif
                            </p>
                        </x-ui.card>
                    </div>

                    {{-- 2. Class-wise Question Distribution & Top Contributors --}}
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                        <x-ui.card class="lg:col-span-2 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-2 border-b border-zinc-100 pb-3 dark:border-zinc-800">
                                    <x-ui.icon.chart-pie class="size-5 text-indigo-500" />
                                    <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-200 uppercase tracking-tight">Class-wise Question Distribution</h3>
                                </div>
                                <div class="mt-4 space-y-4 max-h-60 overflow-y-auto pr-1">
                                    @forelse($classWiseDistribution ?? [] as $class)
                                        <div class="space-y-1">
                                            <div class="flex justify-between text-xs font-medium">
                                                <span class="text-zinc-700 dark:text-zinc-300 font-semibold">{{ $class->name }}</span>
                                                <span class="text-zinc-500">{{ $class->questions_count }} questions</span>
                                            </div>
                                            <div class="w-full bg-zinc-100 dark:bg-zinc-800 h-2 rounded-full overflow-hidden">
                                                @php
                                                    $percentage = $adminStats['total_questions'] > 0 ? ($class->questions_count / $adminStats['total_questions']) * 100 : 0;
                                                @endphp
                                                <div class="bg-indigo-600 h-full rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center text-xs text-zinc-500 py-8">No data available.</div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-t border-zinc-100 dark:border-zinc-800 flex justify-between text-[11px] font-semibold text-zinc-400 uppercase">
                                <span class="flex items-center gap-1"><span class="size-2 rounded-full bg-blue-500"></span> {{ $adminStats['total_teachers'] ?? 0 }} Teachers</span>
                                <span class="flex items-center gap-1"><span class="size-2 rounded-full bg-emerald-500"></span> {{ $adminStats['total_students'] ?? 0 }} Students</span>
                                <span class="flex items-center gap-1"><span class="size-2 rounded-full bg-zinc-400"></span> {{ $adminStats['total_users'] ?? 0 }} Accounts</span>
                            </div>
                        </x-ui.card>

                        <x-ui.card class="flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-2 border-b border-zinc-100 pb-3 dark:border-zinc-800">
                                    <x-ui.icon.trophy class="size-5 text-amber-500" />
                                    <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-200 uppercase tracking-tight">Top Contributors (Teachers)</h3>
                                </div>
                                <div class="mt-4 space-y-3">
                                    @forelse($topTeachers ?? [] as $index => $teacher)
                                        <div class="flex items-center justify-between text-xs">
                                            <div class="flex items-center gap-2 min-w-0">
                                                <span class="flex size-5 shrink-0 items-center justify-center rounded-md bg-amber-50 dark:bg-amber-950/30 text-amber-700 text-[10px] font-bold">
                                                    #{{ $index + 1 }}
                                                </span>
                                                <span class="font-medium text-zinc-700 dark:text-zinc-300 truncate" title="{{ $teacher->user?->name }}">
                                                    {{ $teacher->user?->name ?? 'Unknown Teacher' }}
                                                </span>
                                            </div>
                                            <span class="font-bold text-zinc-500 shrink-0 ml-2">{{ $teacher->total_added }} added</span>
                                        </div>
                                    @empty
                                        <div class="text-center text-xs text-zinc-500 py-4">No questions added yet.</div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="mt-6 space-y-2">
                                <h4 class="text-[10px] font-bold uppercase tracking-wider text-zinc-400 mb-1">Quick Links</h4>
                                <x-ui.button href="{{ route('questions.index') }}" class="w-full justify-center">
                                    <x-ui.icon.check-circle class="size-4" /> Moderate New Questions
                                </x-ui.button>
                                <x-ui.button href="{{ route('admin.wallet-approvals') }}" variant="outline" class="w-full justify-center">
                                    <x-ui.icon.wallet class="size-4" /> Wallet & Token Requests
                                </x-ui.button>
                            </div>
                        </x-ui.card>
                    </div>

                    {{-- 3. Advanced Content Health and Error Alerts --}}
                    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                        <x-ui.card>
                            <div class="flex items-center gap-2 border-b border-zinc-100 pb-3 dark:border-zinc-800 mb-3">
                                <x-ui.icon.exclamation-circle class="size-5 text-amber-500" />
                                <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-200 uppercase tracking-tight">
                                    Low Content Chapters
                                </h3>
                            </div>
                            <ul class="divide-y divide-zinc-100 dark:divide-zinc-800 text-xs">
                                @forelse($weakChapters ?? [] as $chapter)
                                    <li class="py-2.5 flex justify-between items-center">
                                        <span class="text-zinc-700 dark:text-zinc-300 font-medium">{{ $chapter->name }}</span>
                                        <x-ui.badge size="sm" color="amber">{{ $chapter->questions_count }} Questions</x-ui.badge>
                                    </li>
                                @empty
                                    <div class="text-center text-xs text-zinc-400 py-6">All chapters have enough questions! 👍</div>
                                @endforelse
                            </ul>
                        </x-ui.card>

                        <x-ui.card>
                            <div class="flex items-center gap-2 border-b border-zinc-100 pb-3 dark:border-zinc-800 mb-3">
                                <x-ui.icon.flag class="size-5 text-red-500" />
                                <h3 class="text-sm font-bold text-zinc-800 dark:text-zinc-200 uppercase tracking-tight">
                                    Critical Question Errors
                                </h3>
                            </div>
                            <div class="mt-4 space-y-4 max-h-[350px] overflow-y-auto pr-1">
                                @forelse($criticalAlerts ?? [] as $alert)
                                    <div class="p-3 rounded-lg border border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-800/20 space-y-2">
                                        <div class="flex justify-between items-start gap-2">
                                            <div class="min-w-0 flex-1">
                                                <p class="text-zinc-800 dark:text-zinc-200 font-bold text-xs truncate">
                                                    {{ Str::limit(strip_tags($alert->question->title ?? 'Question Not Found'), 55) }}
                                                </p>
                                                <span class="text-[10px] text-zinc-400 block mt-0.5">
                                                    👨‍🏫 Teacher: <span class="font-semibold text-zinc-500 dark:text-zinc-400">{{ $alert->question->user->name ?? 'Unknown' }}</span>
                                                </span>
                                            </div>
                                            <x-ui.button href="{{ route('questions.edit', $alert->question_id) }}" size="sm" variant="outline" class="shrink-0">
                                                Fix It &rarr;
                                            </x-ui.button>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-1.5 pt-1 text-[10px] font-medium">
                                            @php
                                                $reasonLabels = [
                                                    'wrong_answer' => 'Wrong Answer',
                                                    'typing_mistake' => 'Typing Mistake',
                                                    'wrong_explanation' => 'Wrong Explanation',
                                                    'blurry_image' => 'Blurry Image',
                                                    'other' => 'Other'
                                                ];
                                            @endphp
                                            <x-ui.badge size="sm" color="{{ $alert->reason === 'wrong_answer' ? 'red' : 'amber' }}">
                                                ⚠️ {{ $reasonLabels[$alert->reason] ?? 'Other' }}
                                            </x-ui.badge>
                                            <span class="text-zinc-400">by {{ $alert->user->name ?? 'Student' }}</span>
                                        </div>

                                        @if(filled($alert->description))
                                            <div class="bg-white dark:bg-zinc-900 border border-dashed border-zinc-200 dark:border-zinc-800 p-2 rounded text-[11px] text-zinc-600 dark:text-zinc-400 italic">
                                                "{{ $alert->description }}"
                                            </div>
                                        @endif
                                    </div>
                                @empty
                                    <div class="text-center text-xs text-zinc-400 py-8">No reported question errors, database content is healthy! ✨</div>
                                @endforelse
                            </div>
                        </x-ui.card>
                    </div>

    </div>
</x-layouts.app>
