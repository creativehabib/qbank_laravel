<x-split-layout>
    <x-slot:header>
        <x-modern-page-header title="Topics" description="Manage topics under subjects and chapters." modelName="topic">
            <x-slot:actions>
                <flux:select wire:model.live="subjectId" class="w-full sm:w-48">
                    <flux:select.option value="">All Subjects</flux:select.option>
                    @foreach($subjects as $sub)
                        <flux:select.option value="{{ $sub->id }}">{{ $sub->name }}</flux:select.option>
                    @endforeach
                </flux:select>
            </x-slot:actions></x-modern-page-header>
    </x-slot:header>

    <x-slot:form>
        <div>
            @if(!$isCreating && !$editId)
            <div>
                <x-modern-empty-state icon="hashtag" title="Select a topic" description='Pick a row to view its details, or click "New topic" to add one.' />
            </div>
        @else
            <form wire:submit="save" wire:key="form-{{ $editId ?? 'create' }}" class="space-y-4">
            <div>
                <flux:heading size="lg">{{ $editId ? 'Edit Topic' : 'Create New Topic' }}</flux:heading>
                <flux:text class="mt-1">Add a topic and assign it to a subject and chapter.</flux:text>
            </div>

            <flux:field>
                <flux:label>Select Subject</flux:label>
                <flux:select wire:model.live="modalSubjectId" placeholder="Choose a subject...">
                    @foreach($subjects as $s)
                        <flux:select.option value="{{ $s->id }}">{{ $s->name }}</flux:select.option>
                    @endforeach
                </flux:select>
                <flux:error name="modalSubjectId" />
            </flux:field>

            <div wire:key="chapter-group-{{ $modalSubjectId ?? 'empty' }}">
                <flux:field>
                    <flux:label>Select Chapter (Optional)</flux:label>
                    <flux:select wire:model="modalChapterId" placeholder="Choose a chapter..." :disabled="!$modalSubjectId">
                        @foreach($modalChapters as $mc)
                            <flux:select.option value="{{ $mc->id }}">{{ $mc->name }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:error name="modalChapterId" />
                </flux:field>
            </div>

                        <flux:field>
                <flux:label>Topic Name</flux:label>
                <flux:input wire:model.live.debounce.1000ms="name" placeholder="e.g. Grammar" />
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
                <flux:input wire:model="slug" x-bind:disabled="!editingSlug" placeholder="e.g. grammar" class="bg-gray-50 disabled:opacity-75" />
                <flux:error name="slug" />
            </flux:field>

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
        

        <x-modern-list-header :total="$topics->total()" model="search" />

        <x-modern-list>
            @forelse($topics as $topic)
                <x-modern-list-item wire:key="item-{{ $topic->id }}" 
                    :active="$editId === $topic->id"
                    icon="hashtag"
                    title="{{ $topic->name }}"
                    subtitle="{{ $topic->subject->name ?? 'No Subject' }} {{ $topic->chapter ? ' • '.$topic->chapter->name : '' }} • {{ $topic->questions_count ?? 0 }} Questions"
                    editAction="edit({{ $topic->id }})"
                    deleteAction="delete({{ $topic->id }})"
                    :statusBadge="$topic->is_active ? 'Active' : null"
                    toggleAction="toggleActive({{ $topic->id }})"
                    :toggleState="$topic->is_active"
                >
                    
                                            <x-slot:end>
            <div class="text-xs font-medium text-zinc-500 dark:text-zinc-400 bg-zinc-100 dark:bg-zinc-800 px-2.5 py-1 rounded-md">
                {{ $topic->is_premium ? 'Premium' : 'Standard' }}
            </div>
        </x-slot:end>
                </x-modern-list-item>
            @empty
                <div class="py-10 text-center flex flex-col items-center justify-center text-gray-400">
                    <flux:icon icon="hashtag" class="size-10 mb-2 opacity-20" />
                    <p class="text-lg font-medium">No topics found</p>
                    <p class="text-sm mt-1">Try adjusting your search or filter.</p>
                </div>
            @endforelse
        </x-modern-list>

        {{ $topics->links('components.modern-pagination') }}
    </x-slot:table>
    <x-modern-toggle-modal />
</x-split-layout>
