<x-split-layout>
    <x-slot:header>
        <x-modern-page-header title="Tags"
                    subtitle="{{ $tag->questions_count ?? 0 }} Questions" description="Manage tags for subjects and questions." modelName="tag"></x-modern-page-header>
    </x-slot:header>

    <x-slot:form>
        <div>
            @if(!$isCreating && !$editingId)
            <div>
                <x-modern-empty-state icon="tag" title="Select a tag"
                    subtitle="{{ $tag->questions_count ?? 0 }} Questions" description='Pick a row to view its details, or click "New tag" to add one.' />
            </div>
        @else
            <form data-page-submit="save" data-page-key="form-{{ $editingId ?? 'create' }}" class="space-y-4">
            <div>
                <x-ui.heading size="lg">{{ $editingId ? 'Edit Tag' : 'Create Tag' }}</x-ui.heading>
                <x-ui.text class="mt-1">Add or update tag details.</x-ui.text>
            </div>

            <x-ui.field>
                <x-ui.label>Tag Name</x-ui.label>
                <x-ui.input data-page-model="name" placeholder="e.g. PHP" />
                <x-ui.error name="name" />
            </x-ui.field>

            <div class="flex justify-end gap-2 pt-2">
                <x-ui.button type="button" data-page-click="cancelEdit" variant="ghost">Cancel</x-ui.button>
                @if(($editingId && $canUpdate) || (!$editingId && $canCreate))
                    <x-ui.button type="submit" variant="primary">
                        <span data-page-loading.remove data-page-target="save">Save</span>
                        <span data-page-loading data-page-target="save">Saving...</span>
                    </x-ui.button>
                @endif
            </div>
        </form>
        @endif
        </div>
    </x-slot:form>

    <x-slot:table>

        <x-modern-list-header :total="$tags->total()" model="search" />

        <x-modern-list>
            @forelse($tags as $tag)
                <x-modern-list-item data-page-key="item-{{ $tag->id }}"
                    :active="$editingId === $tag->id"
                    icon="tag"
                    title="{{ $tag->name }}"
                    subtitle="{{ $tag->questions_count ?? 0 }} Questions"
                    editAction="{{ $canUpdate ? 'edit('.$tag->id.')' : null }}"
                    deleteAction="{{ $canDelete ? 'delete('.$tag->id.')' : null }}"
                >

                </x-modern-list-item>
            @empty
                <div class="py-10 text-center flex flex-col items-center justify-center text-gray-400">
                    <x-ui.icon icon="tag" class="size-10 mb-2 opacity-20" />
                    <p class="text-lg font-medium">No tags found</p>
                </div>
            @endforelse
        </x-modern-list>

        {{ $tags->links('components.modern-pagination') }}
    </x-slot:table>
    <x-modern-toggle-modal />
</x-split-layout>

@push('scripts')
<script>
    function confirmDelete(id) {
        window.confirmDeleteAction(() => {
            Page.('deleteTagConfirmed', { id: id });
        });
    }

    window.addEventListener('tag-saved', event => {
        if (window.AppUI) {
            window.AppUI.toast({ variant: 'success', text: event.detail.message });
        }
    });

    window.addEventListener('tag-deleted', event => {
        if (window.AppUI) {
            window.AppUI.toast({ variant: 'success', text: event.detail.message });
        }
    });

    window.addEventListener('tagSaved', e => {
        if (window.AppUI) window.AppUI.toast({ variant: 'success', text: e.detail.message || 'Tag added successfully.' });
    });

    window.addEventListener('tagUpdated', e => {
        if (window.AppUI) window.AppUI.toast({ variant: 'success', text: e.detail.message || 'Tag updated successfully.' });
    });

    window.addEventListener('tagDeleted', e => {
        if (window.AppUI) window.AppUI.toast({ variant: 'success', text: e.detail.message || 'Tag deleted successfully.' });
    });
</script>
@endpush
