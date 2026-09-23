<div class="space-y-6 pb-12">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <x-ui.heading size="xl">Past Exams (বিগত পরীক্ষা)</x-ui.heading>
            <x-ui.subheading>Manage past exam papers and assign questions to them.</x-ui.subheading>
        </div>
        <x-ui.button data-page-click="create" variant="primary" icon="plus">
            Add Past Exam
        </x-ui.button>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <!-- Form Section -->
        @if($showModal)
        <div class="xl:col-span-1">
            <x-ui.card>
                <x-ui.heading size="lg" class="mb-4">{{ $editingId ? 'Edit Exam' : 'Create Exam' }}</x-ui.heading>

                <form data-page-submit.prevent="save" data-page-key="form-{{ $editingId ?? 'create' }}" class="space-y-4">
                    <x-ui.field>
                        <x-ui.label>Title (e.g. 45th BCS Preliminary)</x-ui.label>
                        <x-ui.input data-page-model="title" />
                        <x-ui.error name="title" />
                    </x-ui.field>

                    <x-ui.field>
                        <x-ui.label>Slug (URL)</x-ui.label>
                        <x-ui.input data-page-model="slug" placeholder="e.g. bcs-preli-45" />
                        <x-ui.error name="slug" />
                    </x-ui.field>

                    <div class="mt-4 mb-4">
                        <input type="text" name="thumbnail" value="{{ old('thumbnail', $thumbnail) }}" class="w-full rounded-lg border border-zinc-300 px-3 py-2" placeholder="Storage path or image URL">
                    </div>

                    <x-ui.field>
                        <x-ui.label>Description / Details</x-ui.label>
                        <x-ui.textarea data-page-model="description" rows="3" placeholder="Enter exam details..." />
                        <x-ui.error name="description" />
                    </x-ui.field>

                    <x-ui.field>
                        <x-ui.label>Exam Type</x-ui.label>
                        <x-ui.select data-page-model="type">
                            <option value="mcq">Multiple Choice (MCQ)</option>
                            <option value="cq">Creative Question (CQ)</option>
                            <option value="short">Short Question</option>
                            <option value="written">Written Question (লিখিত)</option>
                            <option value="both">Mix / Both</option>
                        </x-ui.select>
                        <x-ui.error name="type" />
                    </x-ui.field>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-ui.field>
                            <x-ui.label>Organization</x-ui.label>
                            <x-ui.select data-page-model="organization_id">
                                <option value="">-- None --</option>
                                @foreach($organizations as $inst)
                                    <option value="{{ $inst->id }}">{{ $inst->name }}</option>
                                @endforeach
                            </x-ui.select>
                        </x-ui.field>

                        <x-ui.field>
                            <x-ui.label>Category</x-ui.label>
                            <x-ui.select data-page-model="exam_category_id">
                                <option value="">-- None --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </x-ui.select>
                        </x-ui.field>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-ui.field>
                            <x-ui.label>Exam Date</x-ui.label>
                            <x-ui.input type="date" data-page-model="exam_date" />
                        </x-ui.field>
                        <x-ui.field>
                            <x-ui.label>Grade (e.g. 9th-10th)</x-ui.label>
                            <x-ui.input data-page-model="grade" />
                        </x-ui.field>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-ui.field>
                            <x-ui.label>Total Marks</x-ui.label>
                            <x-ui.input type="number" data-page-model="total_marks" />
                        </x-ui.field>
                        <x-ui.field>
                            <x-ui.label>Total Questions</x-ui.label>
                            <x-ui.input type="number" data-page-model="total_questions" />
                        </x-ui.field>

                        <x-ui.field>
                            <x-ui.label>Duration (Minutes)</x-ui.label>
                            <x-ui.input type="number" data-page-model="duration" />
                        </x-ui.field>
                    </div>

                    <div class="flex justify-end gap-2 pt-4">
                        <x-ui.button data-page-click="$set('showModal', false)" variant="subtle" class="w-full">Cancel</x-ui.button>
                        <x-ui.button type="submit" variant="primary" class="w-full">Save</x-ui.button>
                    </div>
                </form>
            </x-ui.card>
        </div>
        @endif

        <!-- List Section -->
        <div class="{{ $showModal ? 'xl:col-span-2' : 'xl:col-span-3' }}">
            <x-ui.card class="!p-0 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-700">
                            <tr>
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300">Title</th>
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300">Organization</th>
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300">Type</th>
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300">Questions</th>
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300">Duration (m)</th>
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse($exams as $exam)
                                <tr data-page-key="item-{{ $exam->id }}" class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/50">
                                    <td class="px-4 py-4 font-medium text-zinc-900 dark:text-zinc-100">{{ $exam->title }}</td>
                                    <td class="px-4 py-4 text-zinc-500 dark:text-zinc-400">{{ $exam->organization?->name ?? '-' }}</td>
                                    <td class="px-4 py-4 text-zinc-500 dark:text-zinc-400">
                                        <span class="bg-zinc-100 dark:bg-zinc-700 px-2 py-1 rounded text-xs uppercase font-bold">{{ $exam->type }}</span>
                                    </td>
                                    <td class="px-4 py-4 text-zinc-500 dark:text-zinc-400">{{ $exam->questions()->count() }} / {{ $exam->total_questions ?? '-' }}</td>
                                    <td class="px-4 py-4 text-zinc-500 dark:text-zinc-400">{{ $exam->duration ?? '-' }}</td>
                                    <td class="px-4 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <x-ui.button href="{{ route('admin.past-exams.manage', $exam->id) }}" size="sm" variant="outline" icon="document-text">Manage</x-ui.button>
                                            <x-ui.button data-page-click="edit({{ $exam->id }})" size="sm" variant="subtle" icon="pencil-square" />
                                            <x-ui.button data-page-click="delete({{ $exam->id }})" size="sm" variant="danger" icon="trash" data-page-confirm="Are you sure?" />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-8 text-center text-zinc-500">No exams found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($exams->hasPages())
                    <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                        {{ $exams->links() }}
                    </div>
                @endif
            </x-ui.card>
        </div>
    </div>
</div>
