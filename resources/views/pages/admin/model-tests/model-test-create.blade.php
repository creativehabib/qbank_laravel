<div>
    <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Create Model Test</h1>
            <p class="text-sm text-zinc-600 dark:text-zinc-400">Add a new time-bound model test</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.model-tests.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-semibold text-zinc-700 border border-zinc-300 shadow-sm transition hover:bg-zinc-50 dark:bg-zinc-800 dark:text-zinc-300 dark:border-zinc-700 dark:hover:bg-zinc-700">
                Cancel
            </a>
            <button type="button" data-page-click="save" data-page-loading.attr="disabled" data-page-target="save" class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-indigo-700 disabled:opacity-75 disabled:cursor-wait">
                <x-ui.icon.check-circle class="size-4" data-page-loading.remove data-page-target="save" />
                <x-ui.icon.arrow-path class="size-4 animate-spin hidden" data-page-loading.class.remove="hidden" data-page-target="save" />
                <span data-page-loading.remove data-page-target="save">Save Model Test</span>
                <span data-page-loading data-page-target="save">Saving...</span>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Settings Panel --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900 space-y-4">
                <h3 class="text-lg font-bold text-zinc-900 dark:text-zinc-100">Test Settings</h3>

                <div>
                    <x-ui.input data-page-model="title" label="Title" placeholder="e.g. 45th BCS Model Test 1" />
                </div>

                <div>
                    <x-ui.input type="number" data-page-model="duration_minutes" label="Duration (Minutes)" />
                </div>

                <div>
                    <x-ui.select data-page-model="negative_mark_weight" label="Negative Mark Weight">
                        <x-ui.select.option value="0">No Negative Marking</x-ui.select.option>
                        <x-ui.select.option value="0.25">0.25 (1/4th)</x-ui.select.option>
                        <x-ui.select.option value="0.50">0.50 (1/2)</x-ui.select.option>
                    </x-ui.select>
                </div>

                <div>
                    <x-ui.switch data-page-model="is_published" label="Publish Immediately" />
                </div>

                <div class="pt-4 border-t border-zinc-200 dark:border-zinc-800 mt-4 space-y-4">
                    <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100 uppercase tracking-wider">Premium Access</h3>

                    <div>
                        <x-ui.switch data-page-model="is_premium" label="Require Pro Subscription" />
                    </div>

                    <div>
                        <x-ui.select data-page-model="package_id" label="Link to Specific Course" description="If set, users MUST buy this course to unlock.">
                            <x-ui.select.option value="">No specific course</x-ui.select.option>
                            @foreach($courses as $course)
                                <x-ui.select.option value="{{ $course->id }}">{{ $course->name }}</x-ui.select.option>
                            @endforeach
                        </x-ui.select>
                    </div>
                </div>

                <div class="pt-4 border-t border-zinc-200 dark:border-zinc-800">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-zinc-600 dark:text-zinc-400">Selected Questions:</span>
                        <span class="text-lg font-black text-indigo-600 dark:text-indigo-400">{{ count($selectedQuestions) }}</span>
                    </div>
                    @error('selectedQuestions') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        {{-- Question Selection Panel --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="rounded-xl border border-zinc-200 bg-white p-5 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <x-ui.select data-page-model.live="class_id">
                            <x-ui.select.option value="">All Categories/Classes</x-ui.select.option>
                            @foreach($classes as $c)
                                <x-ui.select.option value="{{ $c->id }}">{{ $c->name }}</x-ui.select.option>
                            @endforeach
                        </x-ui.select>
                    </div>
                    <div>
                        <x-ui.select data-page-model.live="subject_id">
                            <x-ui.select.option value="">All Subjects</x-ui.select.option>
                            @foreach($subjects as $s)
                                <x-ui.select.option value="{{ $s->id }}">{{ $s->name }}</x-ui.select.option>
                            @endforeach
                        </x-ui.select>
                    </div>
                    <div>
                        <x-ui.input type="text" data-page-model.live.debounce.500ms="search" placeholder="Search questions..." icon="magnifying-glass" />
                    </div>
                </div>

                <div class="space-y-3">
                    @forelse($questions as $question)
                        @php
                            $isSelected = in_array($question->id, $selectedQuestions);
                        @endphp
                        <div class="flex items-start gap-3 p-3 rounded-lg border {{ $isSelected ? 'border-indigo-500 bg-indigo-50 dark:bg-indigo-900/20' : 'border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-800/50' }} transition cursor-pointer" data-page-click="toggleQuestion({{ $question->id }})">
                            <div class="mt-1">
                                <input type="checkbox" @checked($isSelected) class="w-5 h-5 rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500 pointer-events-none">
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 leading-tight">
                                    {!! strip_tags($question->title) !!}
                                </div>
                                <div class="mt-1 flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                                    <span>{{ $question->academicClass?->name }}</span> •
                                    <span>{{ $question->subject?->name }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-zinc-500">
                            No questions found.
                        </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $questions->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
