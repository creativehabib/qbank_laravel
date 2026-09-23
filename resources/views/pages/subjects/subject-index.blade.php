<x-split-layout>
    <x-slot:header>
        <x-modern-page-header title="Subjects" description="Manage subjects assigned to classes." modelName="subject"></x-modern-page-header>
    </x-slot:header>

    <x-slot:form>
        <div>
            @if(!$isCreating && !$editId)
            <div>
                <x-modern-empty-state icon="book-open" title="Select a subject" description="Pick a row to view its details, or click 'New subject' to add one." />
            </div>
        @else
            <form data-page-submit="save" data-page-key="form-{{ $editId ?? 'create' }}" class="space-y-4">
                <div>
                    <x-ui.heading size="lg">{{ $editId ? 'Edit Subject' : 'Create New Subject' }}</x-ui.heading>
                    <x-ui.text class="mt-1">Add the subject details and assign a class.</x-ui.text>
                </div>

                <x-ui.field>
                    <x-ui.label class="mb-2">Academic Classes</x-ui.label>
                    <div class="grid grid-cols-2 gap-2 mt-2 max-h-48 overflow-y-auto p-2 border border-gray-200 dark:border-gray-700 rounded-lg">
                        @foreach($classes as $class)
                            <x-ui.checkbox data-page-model="academic_class_ids" value="{{ $class->id }}" label="{{ $class->name }}" />
                        @endforeach
                    </div>
                    <x-ui.error name="academic_class_ids" />
                </x-ui.field>

                <x-ui.field>
                    <x-ui.label>Subject Name</x-ui.label>
                    <x-ui.input data-page-model.live.debounce.500ms="name" placeholder="e.g. Mathematics" />
                    <x-ui.error name="name" />
                </x-ui.field>

                <x-ui.field x-data="{ editingSlug: false }">
                    <div class="flex justify-between items-center mb-2">
                        <x-ui.label class="mb-0">Slug</x-ui.label>
                        <button type="button" @click="editingSlug = true" x-show="!editingSlug" class="text-xs text-indigo-600 hover:text-indigo-700 font-medium flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            Edit
                        </button>
                        <button type="button" @click="editingSlug = false" x-cloak x-show="editingSlug" class="text-xs text-gray-500 hover:text-gray-700 font-medium">
                            Lock
                        </button>
                    </div>
                    <x-ui.input data-page-model="slug" x-bind:disabled="!editingSlug" placeholder="e.g. mathematics" class="bg-gray-50 disabled:opacity-75" />
                    <x-ui.error name="slug" />
                </x-ui.field>

                <x-ui.field>
                    <x-ui.label>Subject Code (Optional)</x-ui.label>
                    <x-ui.input data-page-model="subject_code" placeholder="e.g. MTH-101" />
                    <x-ui.error name="subject_code" />
                </x-ui.field>

                <x-ui.field>
                    <x-ui.label>Image (Optional)</x-ui.label>
                    <input type="text" name="image" value="{{ old('image', $image) }}" class="w-full rounded-lg border border-zinc-300 px-3 py-2" placeholder="Storage path or image URL">
                    <x-ui.error name="image" />
                </x-ui.field>

                <x-ui.field>
                    <x-ui.label>Description</x-ui.label>
                    <x-ui.textarea data-page-model="description" rows="3" placeholder="Enter subject description..." />
                    <x-ui.error name="description" />
                </x-ui.field>

                <div class="flex flex-wrap gap-4">
                    <x-ui.checkbox data-page-model="is_active" label="Active" />
                    <x-ui.checkbox data-page-model="is_premium" label="Premium" />
                </div>

                <div class="flex justify-end gap-2 pt-2">
                    <x-ui.button type="button" data-page-click="cancelEdit" variant="ghost">Cancel</x-ui.button>
                    <x-ui.button type="submit" variant="primary">
                        <span data-page-loading.remove data-page-target="save">Save</span>
                        <span data-page-loading data-page-target="save">Saving...</span>
                    </x-ui.button>
                </div>
            </form>
        @endif
        </div>
    </x-slot:form>

    <x-slot:table>


        <x-modern-list-header :total="$subjects->total()" model="search" />

        <x-modern-list>
            @forelse($subjects as $subject)
                @php
                    $classes = $subject->academicClasses;
                    $classNames = 'Global';
                    if ($classes->isNotEmpty()) {
                        $classNames = $classes->count() > 2
                            ? $classes->take(2)->pluck('name')->join(', ') . ' (+' . ($classes->count() - 2) . ' more)'
                            : $classes->pluck('name')->join(', ');
                    }
                @endphp
                <x-modern-list-item data-page-key="item-{{ $subject->id }}"
                    :active="$editId === $subject->id"
                    icon="book-open"
                    title="{{ $subject->name }}"
                    subtitle="{{ $classNames }} {{ $subject->subject_code ? ' • '.$subject->subject_code : '' }} • {{ $subject->questions_count ?? 0 }} Questions"
                    editAction="edit({{ $subject->id }})"
                    deleteAction="delete({{ $subject->id }})"
                    :statusBadge="$subject->is_active ? 'Active' : null"
                    toggleAction="toggleActive({{ $subject->id }})"
                    :toggleState="$subject->is_active"
                >
                            <x-slot:end>
            <div class="text-xs font-medium text-zinc-500 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2.5 py-1 rounded-md">
                {{ $subject->is_premium ? 'Premium' : 'Standard' }}
            </div>
        </x-slot:end>
                </x-modern-list-item>
            @empty
                <div class="py-10 text-center flex flex-col items-center justify-center text-gray-400">
                    <x-ui.icon icon="book-open" class="size-10 mb-2 opacity-20" />
                    <p class="text-lg font-medium">No subjects found</p>
                    <p class="text-sm mt-1">Try adjusting your search or filter.</p>
                </div>
            @endforelse
        </x-modern-list>

        {{ $subjects->links('components.modern-pagination') }}
    </x-slot:table>
    <x-modern-toggle-modal />
</x-split-layout>
