<x-split-layout>
    <x-slot:header>
        <x-modern-page-header title="Topics" description="Manage topics under subjects and chapters." modelName="topic">
            <x-slot:actions>
                <x-ui.select data-page-model.live="subjectId" class="w-full sm:w-48">
                    <x-ui.select.option value="">All Subjects</x-ui.select.option>
                    @foreach($subjects as $sub)
                        <x-ui.select.option value="{{ $sub->id }}">{{ $sub->name }}</x-ui.select.option>
                    @endforeach
                </x-ui.select>
            </x-slot:actions></x-modern-page-header>
    </x-slot:header>

    <x-slot:form>
        <div>
            @if(!$isCreating && !$editId)
            <div>
                <x-modern-empty-state icon="hashtag" title="Select a topic" description='Pick a row to view its details, or click "New topic" to add one.' />
            </div>
        @else
            <form data-page-submit="save" data-page-key="form-{{ $editId ?? 'create' }}" class="space-y-4">
            <div>
                <x-ui.heading size="lg">{{ $editId ? 'Edit Topic' : 'Create New Topic' }}</x-ui.heading>
                <x-ui.text class="mt-1">Add a topic and assign it to a subject and chapter.</x-ui.text>
            </div>

            <x-ui.field>
                <x-ui.label>Select Subject</x-ui.label>
                <x-ui.select data-page-model.live="modalSubjectId" placeholder="Choose a subject...">
                    @foreach($subjects as $s)
                        <x-ui.select.option value="{{ $s->id }}">{{ $s->name }}</x-ui.select.option>
                    @endforeach
                </x-ui.select>
                <x-ui.error name="modalSubjectId" />
            </x-ui.field>

            <div data-page-key="chapter-group-{{ $modalSubjectId ?? 'empty' }}">
                <x-ui.field>
                    <x-ui.label>Select Chapter (Optional)</x-ui.label>
                    <x-ui.select data-page-model="modalChapterId" placeholder="Choose a chapter..." :disabled="!$modalSubjectId">
                        @foreach($modalChapters as $mc)
                            <x-ui.select.option value="{{ $mc->id }}">{{ $mc->name }}</x-ui.select.option>
                        @endforeach
                    </x-ui.select>
                    <x-ui.error name="modalChapterId" />
                </x-ui.field>
            </div>

                        <x-ui.field>
                <x-ui.label>Topic Name</x-ui.label>
                <x-ui.input data-page-model.live.debounce.1000ms="name" placeholder="e.g. Grammar" />
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
                <x-ui.input data-page-model="slug" x-bind:disabled="!editingSlug" placeholder="e.g. grammar" class="bg-gray-50 disabled:opacity-75" />
                <x-ui.error name="slug" />
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


        <x-modern-list-header :total="$topics->total()" model="search" />

        <x-modern-list>
            @forelse($topics as $topic)
                <x-modern-list-item data-page-key="item-{{ $topic->id }}"
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
                    <x-ui.icon icon="hashtag" class="size-10 mb-2 opacity-20" />
                    <p class="text-lg font-medium">No topics found</p>
                    <p class="text-sm mt-1">Try adjusting your search or filter.</p>
                </div>
            @endforelse
        </x-modern-list>

        {{ $topics->links('components.modern-pagination') }}
    </x-slot:table>
    <x-modern-toggle-modal />
</x-split-layout>
