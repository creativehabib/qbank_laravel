<div class="space-y-6 pb-12">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <x-ui.heading size="xl">Organizations</x-ui.heading>
            <x-ui.subheading>Manage organizations for past exams.</x-ui.subheading>
        </div>
        <x-ui.button data-page-click="create" variant="primary" icon="plus">
            Add Organization
        </x-ui.button>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <!-- Form Section -->
        @if($showModal)
        <div class="xl:col-span-1">
            <x-ui.card>
                <x-ui.heading size="lg" class="mb-4">{{ $editingId ? 'Edit Organization' : 'Create Organization' }}</x-ui.heading>

                <form data-page-submit.prevent="save" data-page-key="form-{{ $editingId ?? 'create' }}" class="space-y-5">

                    <x-ui.field>
                        <x-ui.label>Organization Name</x-ui.label>
                        <x-ui.input data-page-model="name" placeholder="e.g., BPSC" />
                        <x-ui.error name="name" />
                    </x-ui.field>

                    <x-ui.field>
                        <x-ui.label>Slug (URL)</x-ui.label>
                        <x-ui.input data-page-model="slug" placeholder="e.g. bpsc" />
                        <x-ui.error name="slug" />
                    </x-ui.field>

                    <x-ui.field>
                        <x-ui.label>Description (Optional)</x-ui.label>
                        <x-ui.textarea data-page-model="description" placeholder="About the organization..." />
                        <x-ui.error name="description" />
                    </x-ui.field>

                    <x-ui.field>
                        <x-ui.label>Official Website (Optional)</x-ui.label>
                        <x-ui.input data-page-model="official_website" placeholder="https://example.com" />
                        <x-ui.error name="official_website" />
                    </x-ui.field>

                    <x-ui.field>
                        <input type="text" name="logo_path" value="{{ old('logo_path', $logo_path) }}" class="w-full rounded-lg border border-zinc-300 px-3 py-2" placeholder="Storage path or image URL">
                        <x-ui.error name="logo_path" />
                    </x-ui.field>

                    <div class="flex gap-2 pt-2">
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
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300">Name</th>
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300">Slug</th>
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300">Website</th>
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse($organizations as $inst)
                                <tr data-page-key="item-{{ $inst->id }}" class="hover:bg-zinc-50/50 dark:hover:bg-zinc-800/50">
                                    <td class="px-4 py-4">
                                        <div class="font-medium text-zinc-900 dark:text-zinc-100">{{ $inst->name }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-zinc-500 dark:text-zinc-400">
                                        {{ $inst->slug ?: '-' }}
                                    </td>
                                    <td class="px-4 py-4 text-zinc-500 dark:text-zinc-400">
                                        @if($inst->official_website)
                                            <a href="{{ $inst->official_website }}" target="_blank" class="text-blue-500 hover:underline">Link</a>
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            <x-ui.button data-page-click="edit({{ $inst->id }})" size="sm" variant="subtle" icon="pencil-square" />
                                            <x-ui.button data-page-click="delete({{ $inst->id }})" size="sm" variant="danger" icon="trash" data-page-confirm="Are you sure?" />
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-zinc-500">
                                        No organizations found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($organizations->hasPages())
                    <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                        {{ $organizations->links() }}
                    </div>
                @endif
            </x-ui.card>
        </div>
    </div>
</div>
