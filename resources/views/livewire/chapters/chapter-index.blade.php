<x-split-layout>
    <x-slot:header>
        <x-modern-page-header title="Chapters" description="Manage chapters assigned to subjects." modelName="chapter"></x-modern-page-header>
    </x-slot:header>

    <x-slot:form>
        <div>
            @if(!$isCreating && !$editId)
            <div>
                <x-modern-empty-state icon="document-text" title="Select a chapter" description='Pick a row to view its details, or click "New chapter" to add one.' />
            </div>
        @else
            <form wire:submit="save" wire:key="form-{{ $editId ?? 'create' }}" class="space-y-4">
            <div>
                <flux:heading size="lg">{{ $editId ? 'Edit Chapter' : 'Create New Chapter' }}</flux:heading>
                <flux:text class="mt-1">Add the chapter details and assign it to a subject.</flux:text>
            </div>

            

                        <flux:field>
                <flux:label>Subject</flux:label>
                <flux:select wire:model="subject_id" placeholder="Choose a subject...">
                    @foreach($subjects as $subject)
                        <flux:select.option value="{{ $subject->id }}">
                            {{ $subject->name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
                <flux:error name="subject_id" />
            </flux:field>

                        <flux:field>
                <flux:label>Chapter Name</flux:label>
                <flux:input wire:model.live.debounce.1000ms="name" placeholder="e.g. Algebra" />
                <flux:error name="name" />
            </flux:field>

            <flux:field x-data="{ editingSlug: false }">
                <div class="flex justify-between items-center mb-2">
                    <flux:label class="mb-0">Slug</flux:label>
                    <button type="button" @click="editingSlug = true" x-show="!editingSlug" class="text-xs text-indigo-600 hover:text-indigo-700 font-medium flex items-center gap-1">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        Edit
                    </button>
                    <button type="button" @click="editingSlug = false" x-cloak x-show="editingSlug" class="text-xs text-gray-500 hover:text-gray-700 font-medium">
                        Lock
                    </button>
                </div>
                <flux:input wire:model="slug" x-bind:disabled="!editingSlug" placeholder="e.g. algebra" class="bg-gray-50 disabled:opacity-75" />
                <flux:error name="slug" />
            </flux:field>

            <flux:field>
                <flux:label>Image (Optional)</flux:label>
                @include('mediamanager::includes.media-input', [
                    'name'  => 'image',
                    'id'    => 'image',
                    'label' => 'Select Image',
                    'value' => $image,
                ])
                <flux:error name="image" />
            </flux:field>

            <flux:field>
                <flux:label>Description</flux:label>
                <flux:textarea wire:model="description" rows="3" placeholder="Enter chapter description..." />
                <flux:error name="description" />
            </flux:field>

            <div class="flex flex-wrap gap-4">
                <flux:checkbox wire:model="is_active" label="Active" />
                <flux:checkbox wire:model="is_premium" label="Premium" />
            </div>

            <div class="flex justify-end gap-2 pt-2">
                <flux:button type="button" wire:click="cancelEdit" variant="ghost">Cancel</flux:button>
                <flux:button type="submit" variant="primary">
                    <span wire:loading.remove wire:target="save">Save</span>
                    <span wire:loading wire:target="save">Saving...</span>
                </flux:button>
            </div>
        </form>
        @endif
        </div>
    </x-slot:form>

    <x-slot:table>

        <x-modern-list-header :total="$chapters->total()" model="search" />

        <x-modern-list>
            @forelse($chapters as $chapter)
                @php
                    $classes = $chapter->subject?->academicClasses;
                    $classNames = '';
                    if ($classes && $classes->isNotEmpty()) {
                        $classNames = $classes->count() > 2 
                            ? ' (' . $classes->take(2)->pluck('name')->join(', ') . ' + ' . ($classes->count() - 2) . ' more)'
                            : ' (' . $classes->pluck('name')->join(', ') . ')';
                    }
                @endphp
                <x-modern-list-item wire:key="item-{{ $chapter->id }}" 
                    :active="$editId === $chapter->id"
                    icon="document-text"
                    title="{{ $chapter->name }}"
                    subtitle="{{ $chapter->subject?->name ?? 'N/A' }}{{ $classNames }} • {{ $chapter->questions_count ?? 0 }} Questions"
                    editAction="edit({{ $chapter->id }})"
                    deleteAction="delete({{ $chapter->id }})"
                    :statusBadge="$chapter->is_active ? 'Active' : null"
                    toggleAction="toggleActive({{ $chapter->id }})"
                    :toggleState="$chapter->is_active"
                >

                                            <x-slot:end>
            <div class="text-xs font-medium text-zinc-500 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2.5 py-1 rounded-md">
                {{ $chapter->is_premium ? 'Premium' : 'Standard' }}
            </div>
        </x-slot:end>
                </x-modern-list-item>
            @empty
                <div class="py-10 text-center flex flex-col items-center justify-center text-gray-400">
                    <flux:icon icon="document-text" class="size-10 mb-2 opacity-20" />
                    <p class="text-lg font-medium">No chapters found</p>
                    <p class="text-sm mt-1">Try adjusting your search or filter.</p>
                </div>
            @endforelse
        </x-modern-list>

        {{ $chapters->links('components.modern-pagination') }}
    </x-slot:table>
    <x-modern-toggle-modal />
</x-split-layout>
