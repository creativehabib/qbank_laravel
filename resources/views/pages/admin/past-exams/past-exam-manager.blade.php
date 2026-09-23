<div class="space-y-6 pb-12">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <x-ui.heading size="xl">{{ $exam->title }}</x-ui.heading>
            <x-ui.subheading>Manage questions attached to this exam paper.</x-ui.subheading>
        </div>
        <div class="flex gap-2">
            <x-ui.button href="{{ route('admin.past-exams.index') }}" variant="subtle" icon="arrow-left">Back</x-ui.button>
            <x-ui.button data-page-click="$set('showQuickModal', true)" variant="primary" icon="bolt">Instant Quick Create</x-ui.button>
        </div>
    </div>

    <!-- Quick Create Section -->
    @if($showQuickModal)
        <x-ui.card class="border-indigo-200 bg-indigo-50/10 dark:border-indigo-900/50">
            <x-ui.heading size="lg" class="mb-4">Instant Quick Create</x-ui.heading>

            <form data-page-submit.prevent="saveQuickQuestion" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-ui.field>
                        <x-ui.label>Subject <span class="text-red-500">*</span></x-ui.label>
                        <x-ui.select data-page-model.live="quickSubject">
                            <option value="">-- Select --</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                            @endforeach
                        </x-ui.select>
                        <x-ui.error name="quickSubject" />
                    </x-ui.field>

                    <x-ui.field>
                        <x-ui.label>Question Type <span class="text-red-500">*</span></x-ui.label>
                        <x-ui.select data-page-model.live="quickType">
                            <option value="mcq">Multiple Choice (MCQ)</option>
                            <option value="cq">Creative Question (CQ)</option>
                            <option value="short">Short Question</option>
                            <option value="written">Written Question (লিখিত)</option>
                        </x-ui.select>
                    </x-ui.field>
                </div>

                <x-ui.field>
                    <x-ui.label>Question Text <span class="text-red-500">*</span></x-ui.label>
                    <x-ui.textarea data-page-model="quickTitle" rows="3" placeholder="Write question here..." />
                    <x-ui.error name="quickTitle" />
                </x-ui.field>

                @if($quickType === 'mcq')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4 p-4 border rounded-lg bg-white dark:bg-zinc-800">
                        @foreach($quickOptions as $index => $option)
                            <div class="flex items-center gap-3">
                                <input type="radio" name="correct_option" data-page-click="setCorrectOption({{ $index }})" {{ $option['is_correct'] ? 'checked' : '' }} class="w-4 h-4 text-emerald-600 focus:ring-emerald-500 border-zinc-300">
                                <x-ui.field class="w-full">
                                    <x-ui.input data-page-model="quickOptions.{{ $index }}.text" placeholder="Option {{ $index + 1 }}" />
                                    <x-ui.error name="quickOptions.{{ $index }}.text" />
                                </x-ui.field>
                            </div>
                        @endforeach
                    </div>
                @endif

                <div class="flex justify-end gap-2 pt-2">
                    <x-ui.button data-page-click="$set('showQuickModal', false)" variant="subtle">Close</x-ui.button>
                    <x-ui.button type="submit" variant="primary">Save & Attach</x-ui.button>
                </div>
            </form>
        </x-ui.card>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        <!-- Attached Questions (40% width) -->
        <div class="lg:col-span-2">
            <x-ui.card>
                <x-ui.heading size="lg" class="mb-4">Attached Questions ({{ $exam->questions->count() }})</x-ui.heading>

                @if($exam->questions->isEmpty())
                    <p class="text-zinc-500 italic">No questions attached yet.</p>
                @else
                    <div class="space-y-3">
                        @foreach($exam->questions as $index => $question)
                            <div class="flex justify-between items-start p-3 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700">
                                <div class="flex gap-2">
                                    <span class="font-bold text-zinc-400 mt-0.5 text-xs">{{ $index + 1 }}.</span>
                                    <div>
                                        <div class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{!! strip_tags(Str::limit($question->title, 150)) !!}</div>
                                        <div class="text-xs text-zinc-500 mt-1">
                                            ID: {{ $question->id }} &bull; {{ strtoupper($question->question_type) }}
                                            @if($question->subject) &bull; {{ $question->subject->name }} @endif
                                        </div>
                                    </div>
                                </div>
                                <x-ui.button data-page-click="detachQuestion({{ $question->id }})" size="xs" variant="danger" icon="x-mark" class="!px-1.5 shrink-0" />
                            </div>
                        @endforeach
                    </div>
                @endif
            </x-ui.card>
        </div>

        <!-- Search & Add (60% width) -->
        <div class="lg:col-span-3">
            <x-ui.card class="sticky top-6">
                <x-ui.heading size="lg" class="mb-4">Search & Attach</x-ui.heading>

                <div class="space-y-4">
                    <x-ui.field>
                        <x-ui.input data-page-model.live.debounce.300ms="searchQuery" placeholder="Search keyword or ID..." icon="magnifying-glass" />
                    </x-ui.field>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <x-ui.field>
                            <x-ui.select data-page-model.live="searchSubject">
                                <option value="">-- All Subjects --</option>
                                @foreach($subjects as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </x-ui.select>
                        </x-ui.field>

                        <x-ui.field>
                            <x-ui.select data-page-model.live="searchTag">
                                <option value="">-- All Tags --</option>
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </x-ui.select>
                        </x-ui.field>

                        <x-ui.field>
                            <x-ui.select data-page-model.live="searchType">
                                <option value="">-- All Types --</option>
                                <option value="mcq">MCQ</option>
                                <option value="cq">CQ</option>
                                <option value="short">Short</option>
                                <option value="written">Written</option>
                            </x-ui.select>
                        </x-ui.field>
                    </div>

                    <div class="mt-4 space-y-2 max-h-[500px] overflow-y-auto pr-1">
                        @forelse($searchResults as $result)
                            <div class="p-3 border border-blue-100 dark:border-blue-900 rounded-lg bg-blue-50/50 dark:bg-blue-900/20 flex flex-col gap-2">
                                <div class="text-sm text-zinc-700 dark:text-zinc-300 line-clamp-2" title="{{ strip_tags($result->title) }}">
                                    {!! strip_tags($result->title) !!}
                                </div>
                                <div class="flex justify-between items-center">
                                    <div class="flex gap-2">
                                        <span class="text-[10px] text-blue-600 bg-blue-100 px-1.5 py-0.5 rounded">{{ $result->subject?->name ?? 'No Sub' }}</span>
                                        <span class="text-[10px] text-zinc-600 bg-zinc-200 px-1.5 py-0.5 rounded">{{ strtoupper($result->question_type) }}</span>
                                    </div>
                                    <x-ui.button data-page-click="attachQuestion({{ $result->id }})" size="xs" variant="primary" class="shrink-0">Add</x-ui.button>
                                </div>
                            </div>
                        @empty
                            @if(strlen($searchQuery) >= 2 || $searchSubject != '' || $searchTag != '' || $searchType != '')
                                <p class="text-sm text-zinc-500 text-center py-4">No questions found.</p>
                            @else
                                <p class="text-sm text-zinc-500 text-center py-4">Filter or type to search...</p>
                            @endif
                        @endforelse
                    </div>
                </div>
            </x-ui.card>
        </div>
    </div>
</div>
