<x-split-layout>
    <x-slot:header>
        <x-modern-page-header title="Exam Categories"
                    subtitle="{{ $examCat->questions_count ?? 0 }} Questions" description="Manage exam categories like Admission Exam, Board Exam etc." modelName="category"></x-modern-page-header>
    </x-slot:header>

    <x-slot:form>
        <div>
            @if(!$isCreating && !$editId)
            <div>
                <x-modern-empty-state icon="academic-cap" title="Select an exam"
                    subtitle="{{ $examCat->questions_count ?? 0 }} Questions" description='Pick a row to view its details, or click "New exam" to add one.' />
            </div>
        @else
            <form data-page-submit="save" data-page-key="form-{{ $editId ?? 'create' }}" class="space-y-4">
            <div>
                <x-ui.heading size="lg">{{ $editId ? 'Edit Exam Category' : 'Create Exam Category' }}</x-ui.heading>
                <x-ui.text class="mt-1">Add or update exam category details.</x-ui.text>
            </div>

            <x-ui.field>
                <x-ui.label>Exam Name</x-ui.label>
                <x-ui.input data-page-model="name" placeholder="e.g. Admission Exam" />
                <x-ui.error name="name" />
            </x-ui.field>

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

        <x-modern-list-header :total="$examCategories->total()" model="search" />

        <x-modern-list>
            @forelse($examCategories as $examCat)
                <x-modern-list-item data-page-key="item-{{ $examCat->id }}"
                    :active="$editId === $examCat->id"
                    icon="academic-cap"
                    title="{{ $examCat->name }}"
                    subtitle="{{ $examCat->questions_count ?? 0 }} Questions"
                    editAction="edit({{ $examCat->id }})"
                    deleteAction="delete({{ $examCat->id }})"
                >

                                            <x-slot:end>
            <div class="text-xs font-medium text-zinc-500 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2.5 py-1 rounded-md">
                {{ $examCat->is_premium ? 'Premium' : 'Standard' }}
            </div>
        </x-slot:end>
                </x-modern-list-item>
            @empty
                <div class="py-10 text-center flex flex-col items-center justify-center text-gray-400">
                    <x-ui.icon icon="academic-cap" class="size-10 mb-2 opacity-20" />
                    <p class="text-lg font-medium">No exam found</p>
                    <p class="text-sm mt-1">Get started by creating a new exam.</p>
                </div>
            @endforelse
        </x-modern-list>

        {{ $examCategories->links('components.modern-pagination') }}
    </x-slot:table>
    <x-modern-toggle-modal />
</x-split-layout>
