<div class="space-y-6">
    @php
        $currentUser = auth()->user();
        $canCreateQuestion = $currentUser?->hasPermission('questions.create');
        $canDeleteQuestion = $currentUser?->hasPermission('questions.delete');
        $canPublishQuestion = $currentUser?->hasPermission('questions.publish');
    @endphp

    <x-ui.card class="overflow-hidden !p-0">
        <div class="border-b border-zinc-200 bg-zinc-50/70 p-5 dark:border-zinc-700 dark:bg-zinc-800/40">
            <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">
                <div>
                    <x-ui.heading size="lg">Question Bank</x-ui.heading>
                    <x-ui.subheading>Review, publish, archive, and restore submitted questions.</x-ui.subheading>
                </div>

                <div class="flex flex-wrap gap-2">
                    @if($canCreateQuestion)
                        <x-ui.button href="{{ route('questions.bulk-upload') }}" data-navigate="false" variant="outline" icon="arrow-up-tray">Bulk upload</x-ui.button>
                        <x-ui.button href="{{ route('questions.create') }}" data-navigate="false" variant="primary" icon="plus">New question</x-ui.button>
                    @endif
                </div>
            </div>

            <div class="mt-5 flex flex-wrap gap-x-4 gap-y-2 text-sm">
                @foreach([
                    'all' => ['All', $allQuestionsCount],
                    'mine' => ['Mine', $mineQuestionsCount],
                    'published' => ['Published', $publishedQuestionsCount],
                    'pending' => ['Pending', $pendingQuestionsCount],
                    'rejected' => ['Rejected', $rejectedQuestionsCount],
                    'trash' => ['Trash', $trashedQuestionsCount],
                ] as $filter => [$label, $count])
                    <button data-page-click="setQuickFilter('{{ $filter }}')" @class([
                        'rounded-full px-3 py-1.5 font-medium transition',
                        'bg-zinc-900 text-white dark:bg-white dark:text-zinc-900' => $quickFilter === $filter,
                        'text-zinc-600 hover:bg-zinc-200 dark:text-zinc-300 dark:hover:bg-zinc-700' => $quickFilter !== $filter,
                    ])>
                        {{ $label }} <span class="opacity-70">{{ $count }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        <div class="space-y-4 p-5">
            <div class="grid gap-3 md:grid-cols-3 xl:grid-cols-6">
                <x-ui.input data-page-model.live.debounce.400ms="search" icon="magnifying-glass" placeholder="Search questions..."  />

                <x-ui.select data-page-model.live="academicClassId" placeholder="All classes">
                    <x-ui.select.option value="">All classes</x-ui.select.option>
                    @foreach($academicClasses as $academicClass)
                        <x-ui.select.option value="{{ $academicClass->id }}">{{ $academicClass->name }}</x-ui.select.option>
                    @endforeach
                </x-ui.select>

                <x-ui.select data-page-model.live="subjectId" :disabled="$academicClassId === ''" placeholder="All subjects">
                    <x-ui.select.option value="">All subjects</x-ui.select.option>
                    @foreach($subjects as $subject)
                        <x-ui.select.option value="{{ $subject->id }}">{{ $subject->name }}</x-ui.select.option>
                    @endforeach
                </x-ui.select>

                <x-ui.select data-page-model.live="questionTypeFilter" placeholder="All formats">
                    <x-ui.select.option value="">All formats</x-ui.select.option>
                    <x-ui.select.option value="mcq">MCQ</x-ui.select.option>
                    <x-ui.select.option value="cq">CQ</x-ui.select.option>
                    <x-ui.select.option value="short">Short</x-ui.select.option>
                    <x-ui.select.option value="written">Written</x-ui.select.option>
                </x-ui.select>

                <x-ui.select data-page-model.live="chapterId" :disabled="$subjectId === ''" placeholder="All chapters">
                    <x-ui.select.option value="">All chapters</x-ui.select.option>
                    @foreach($chapters as $chapter)
                        <x-ui.select.option value="{{ $chapter->id }}">{{ $chapter->name }}</x-ui.select.option>
                    @endforeach
                </x-ui.select>

                <x-ui.select data-page-model.live="topicId" :disabled="$chapterId === ''" placeholder="All topics">
                    <x-ui.select.option value="">All topics</x-ui.select.option>
                    @foreach($topics as $topic)
                        <x-ui.select.option value="{{ $topic->id }}">{{ $topic->name }}</x-ui.select.option>
                    @endforeach
                </x-ui.select>
            </div>

            @if($canDeleteQuestion && $selectedQuestionIds !== [])
                <div class="flex flex-wrap items-center justify-between gap-3 rounded-lg border border-indigo-200 bg-indigo-50 px-4 py-3 dark:border-indigo-800 dark:bg-indigo-950/30">
                    <x-ui.text><strong>{{ count($selectedQuestionIds) }}</strong> question(s) selected.</x-ui.text>
                    <div class="flex gap-2">
                        @if($quickFilter === 'trash')
                            <x-ui.button size="sm" variant="outline" icon="arrow-uturn-left" data-page-click="confirmAction('restore')">Restore</x-ui.button>
                            <x-ui.button size="sm" variant="danger" icon="trash" data-page-click="confirmAction('force_delete')">Delete permanently</x-ui.button>
                        @else
                            <x-ui.button size="sm" variant="danger" icon="trash" data-page-click="confirmAction('trash')">Move to trash</x-ui.button>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <div class="overflow-x-auto border-t border-zinc-200 dark:border-zinc-700">
            <x-ui.table class="px-6">
                <x-ui.table.columns>
                    @if($canDeleteQuestion)<x-ui.table.column class="w-16 pl-4"><x-ui.checkbox data-page-model.live="selectPage" aria-label="Select all questions" /></x-ui.table.column>@endif
                    <x-ui.table.column>QUESTION</x-ui.table.column>
                    <x-ui.table.column>TAXONOMY</x-ui.table.column>
                    <x-ui.table.column>TYPE</x-ui.table.column>
                    <x-ui.table.column>MARKS</x-ui.table.column>
                    <x-ui.table.column>PAYMENT</x-ui.table.column>
                    <x-ui.table.column>STATUS</x-ui.table.column>
                    <x-ui.table.column align="right">ACTIONS</x-ui.table.column>
                </x-ui.table.columns>

                <x-ui.table.rows>
                    @forelse($questions as $question)
                        <x-ui.table.row data-page-key="question-{{ $quickFilter }}-{{ $question->id }}">
                            @if($canDeleteQuestion)
                                <x-ui.table.cell class="w-16 pl-4"><x-ui.checkbox data-page-model.live="selectedQuestionIds" value="{{ $question->id }}" aria-label="Select question {{ $question->id }}" /></x-ui.table.cell>
                            @endif
                            <x-ui.table.cell class="min-w-80">
                                <div class="font-medium text-zinc-900 dark:text-zinc-100">{{ str(strip_tags($question->title))->limit(100) }}</div>
                                <div class="mt-1 flex flex-wrap items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                                    <span>#{{ $question->id }}</span><span>•</span><span>{{ $question->user?->name ?? 'Unknown teacher' }}</span>
                                </div>
                            </x-ui.table.cell>
                            <x-ui.table.cell>
                                <div class="space-y-1 text-sm">
                                    <div>{{ $question->academicClass?->name ?? '—' }} <span class="text-zinc-400">/</span> {{ $question->subject?->name ?? '—' }}</div>
                                    <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $question->chapter?->name ?? 'No chapter' }} <span class="text-zinc-400">/</span> {{ $question->topic?->name ?? 'No topic' }}</div>
                                </div>
                            </x-ui.table.cell>
                            <x-ui.table.cell><x-ui.badge size="sm" variant="outline">{{ strtoupper($question->question_type) }}</x-ui.badge></x-ui.table.cell>
                            <x-ui.table.cell>{{ $question->marks }}</x-ui.table.cell>
                            <x-ui.table.cell><x-ui.badge size="sm" :color="$question->is_paid ? 'green' : 'zinc'">{{ $question->is_paid ? 'PAID' : 'UNPAID' }}</x-ui.badge></x-ui.table.cell>
                            <x-ui.table.cell>
                                <x-ui.badge size="sm" :color="match($question->status) { 'active' => 'green', 'pending' => 'amber', default => 'red' }">{{ $question->status === 'inactive' ? 'REJECTED' : strtoupper($question->status) }}</x-ui.badge>
                            </x-ui.table.cell>
                            <x-ui.table.cell align="right">
                                <div class="flex justify-end gap-1">
                                    <x-ui.button size="sm" variant="ghost" icon="eye" data-page-click="openQuestionModal({{ $question->id }})" aria-label="View question" />
                                    @if($quickFilter === 'trash' && $canDeleteQuestion)
                                        <x-ui.button size="sm" variant="ghost" icon="arrow-uturn-left" data-page-click="confirmAction('restore', {{ $question->id }})" aria-label="Restore question" />
                                        <x-ui.button size="sm" variant="danger" icon="trash" data-page-click="confirmAction('force_delete', {{ $question->id }})" aria-label="Permanently delete question" />
                                    @elseif($quickFilter !== 'trash')
                                        @if($canPublishQuestion)
                                            @if($question->status === 'pending')
                                                <x-ui.button size="sm" variant="primary" icon="check" data-page-click="confirmAction('approve', {{ $question->id }})">Approve</x-ui.button>
                                                <x-ui.button size="sm" variant="danger" icon="x-mark" data-page-click="confirmAction('reject', {{ $question->id }})">Reject</x-ui.button>
                                            @elseif($question->status === 'active')
                                                <x-ui.button size="sm" variant="outline" icon="arrow-path" data-page-click="confirmAction('unapprove', {{ $question->id }})">Unapprove</x-ui.button>
                                            @endif
                                        @endif
                                        @if($currentUser?->hasPermission('questions.update') && (! $currentUser->isTeacher() || $question->user_id === $currentUser->id))
                                            <x-ui.button size="sm" variant="ghost" icon="pencil-square" href="{{ route('questions.edit', $question) }}" data-navigate="false" aria-label="Edit question" />
                                        @endif
                                        @if($canDeleteQuestion && (! $currentUser->isTeacher() || $question->user_id === $currentUser->id))
                                            <x-ui.button size="sm" variant="danger" icon="trash" data-page-click="confirmAction('trash', {{ $question->id }})" aria-label="Move question to trash" />
                                        @endif
                                    @endif
                                </div>
                            </x-ui.table.cell>
                        </x-ui.table.row>
                    @empty
                        <x-ui.table.row><x-ui.table.cell :colspan="$canDeleteQuestion ? 8 : 7" class="py-14 text-center text-zinc-500">No questions found for the selected filters.</x-ui.table.cell></x-ui.table.row>
                    @endforelse
                </x-ui.table.rows>
            </x-ui.table>
        </div>

        @if($questions->hasPages())<div class="border-t border-zinc-200 p-4 dark:border-zinc-700">{{ $questions->links() }}</div>@endif
    </x-ui.card>

    <x-ui.modal data-page-model="showQuestionModal" class="w-full max-w-4xl">
        @if($selectedQuestion)
            <div class="space-y-5">
                <div class="flex items-start justify-between gap-4"><div><x-ui.heading size="lg">Question review</x-ui.heading><x-ui.subheading>Submitted by {{ $selectedQuestion->user?->name ?? 'Unknown teacher' }}</x-ui.subheading></div><x-ui.badge :color="match($selectedQuestion->status) { 'active' => 'green', 'pending' => 'amber', default => 'red' }">{{ strtoupper($selectedQuestion->status) }}</x-ui.badge></div>
                <x-ui.card class="!p-4"><div class="prose max-w-none dark:prose-invert" data-math-content>{!! $selectedQuestion->title !!}</div>@if($selectedQuestion->description)<div class="mt-4 border-t pt-4 text-sm text-zinc-600 dark:text-zinc-300" data-math-content>{!! $selectedQuestion->description !!}</div>@endif</x-ui.card>
                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4"><x-ui.card class="!p-3"><x-ui.text class="text-xs">Class</x-ui.text><div class="font-medium">{{ $selectedQuestion->academicClass?->name ?? '—' }}</div></x-ui.card><x-ui.card class="!p-3"><x-ui.text class="text-xs">Subject</x-ui.text><div class="font-medium">{{ $selectedQuestion->subject?->name ?? '—' }}</div></x-ui.card><x-ui.card class="!p-3"><x-ui.text class="text-xs">Chapter</x-ui.text><div class="font-medium">{{ $selectedQuestion->chapter?->name ?? '—' }}</div></x-ui.card><x-ui.card class="!p-3"><x-ui.text class="text-xs">Topic</x-ui.text><div class="font-medium">{{ $selectedQuestion->topic?->name ?? '—' }}</div></x-ui.card></div>
                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4"><x-ui.card class="!p-3"><x-ui.text class="text-xs">Type</x-ui.text><div class="font-medium uppercase">{{ $selectedQuestion->question_type }}</div></x-ui.card><x-ui.card class="!p-3"><x-ui.text class="text-xs">Difficulty</x-ui.text><div class="font-medium capitalize">{{ $selectedQuestion->difficulty }}</div></x-ui.card><x-ui.card class="!p-3"><x-ui.text class="text-xs">Marks</x-ui.text><div class="font-medium">{{ $selectedQuestion->marks }}</div></x-ui.card><x-ui.card class="!p-3"><x-ui.text class="text-xs">Payment</x-ui.text><div class="font-medium">{{ $selectedQuestion->is_paid ? 'Paid' : 'Unpaid' }}</div></x-ui.card></div>
                @if($selectedQuestion->question_type === 'mcq' && filled($selectedQuestion->extra_content))
                    <div><x-ui.heading size="sm">Options</x-ui.heading><div class="mt-3 grid gap-3 sm:grid-cols-2">@foreach($selectedQuestion->extra_content as $option)<div class="rounded-lg border p-3 {{ !empty($option['is_correct']) ? 'border-emerald-300 bg-emerald-50 dark:border-emerald-700 dark:bg-emerald-950/30' : 'border-zinc-200 dark:border-zinc-700' }}"><div class="flex gap-2"><x-ui.badge size="sm" :color="!empty($option['is_correct']) ? 'green' : 'zinc'">{{ !empty($option['is_correct']) ? 'Correct' : 'Option' }}</x-ui.badge><div class="text-sm" data-math-content>{!! $option['option_text'] ?? '' !!}</div></div></div>@endforeach</div></div>
                @elseif($selectedQuestion->question_type === 'cq' && filled($selectedQuestion->extra_content))
                    <div><x-ui.heading size="sm">Creative question parts</x-ui.heading><div class="mt-3 space-y-3">@foreach($selectedQuestion->extra_content as $part)<x-ui.card class="!p-3"><div class="flex items-start justify-between gap-3"><div class="font-medium" data-math-content>{{ $part['label'] ?? 'Part' }}. {!! $part['text'] ?? '' !!}</div><x-ui.badge size="sm" variant="outline">{{ $part['marks'] ?? 0 }} marks</x-ui.badge></div>@if(filled($part['answer'] ?? null))<div class="mt-2 border-t pt-2 text-sm text-zinc-600 dark:text-zinc-300" data-math-content><strong>Answer:</strong> {!! $part['answer'] !!}</div>@endif</x-ui.card>@endforeach</div></div>
                @endif
                <div class="flex justify-end gap-2"><x-ui.modal.close><x-ui.button variant="ghost">Close</x-ui.button></x-ui.modal.close>@if($canPublishQuestion && $selectedQuestion->status === 'pending')<x-ui.button variant="danger" icon="x-mark" data-page-click="confirmAction('reject', {{ $selectedQuestion->id }})">Reject</x-ui.button><x-ui.button variant="primary" icon="check" data-page-click="confirmAction('approve', {{ $selectedQuestion->id }})">Approve</x-ui.button>@endif@if($canPublishQuestion && $selectedQuestion->status === 'active')<x-ui.button variant="outline" icon="arrow-path" data-page-click="confirmAction('unapprove', {{ $selectedQuestion->id }})">Unapprove</x-ui.button>@endif</div>
            </div>
        @endif
    </x-ui.modal>

    <x-ui.modal data-page-model="showConfirmationModal" class="w-full max-w-lg">
        <div class="space-y-5"><div><x-ui.heading size="lg">{{ $confirmationTitle }}</x-ui.heading><x-ui.text class="mt-2">{{ $confirmationDescription }}</x-ui.text></div><div class="flex justify-end gap-2"><x-ui.modal.close><x-ui.button variant="ghost">Cancel</x-ui.button></x-ui.modal.close><x-ui.button :variant="in_array($confirmationAction, ['trash', 'force_delete', 'reject'], true) ? 'danger' : 'primary'" data-page-click="executeConfirmation">{{ $confirmationButton }}</x-ui.button></div></div>
    </x-ui.modal>
</div>
