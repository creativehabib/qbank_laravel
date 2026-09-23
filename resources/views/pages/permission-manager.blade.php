<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <x-ui.badge size="sm" class="mb-2 uppercase tracking-widest">Access Control</x-ui.badge>
            <x-ui.heading size="xl">Permissions</x-ui.heading>
            <x-ui.subheading>Manage granular access by assigning permissions to roles and system users.</x-ui.subheading>
        </div>
        <div class="flex items-center gap-3">
            <x-ui.badge variant="outline" class="text-sm">
                {{ $permissions->count() }} permissions
            </x-ui.badge>
            <x-ui.button data-page-click="createPermission" variant="primary" icon="plus">
                Create permission
            </x-ui.button>
        </div>
    </div>

    <x-ui.card>
        <x-ui.table>
            <x-ui.table.columns>
                <x-ui.table.column>#</x-ui.table.column>
                <x-ui.table.column>NAME</x-ui.table.column>
                <x-ui.table.column>GROUP</x-ui.table.column>
                <x-ui.table.column align="right">ACTIONS</x-ui.table.column>
            </x-ui.table.columns>

            <x-ui.table.rows>
                @forelse($permissions as $index => $permission)
                    <x-ui.table.row>
                        <x-ui.table.cell class="text-zinc-500">
                            {{ $index + 1 }}
                        </x-ui.table.cell>

                        <x-ui.table.cell>
                            <p class="font-medium text-zinc-900 dark:text-zinc-100">{{ $permission->name }}</p>
                            <div class="mt-1 flex items-center gap-1 text-xs text-zinc-500">
                                System key: <x-ui.badge size="sm" variant="outline">{{ $permission->name }}</x-ui.badge>
                            </div>
                        </x-ui.table.cell>

                        <x-ui.table.cell>
                            <x-ui.badge variant="primary" size="sm">
                                {{ str($permission->name)->before('.')->replace('_', ' ')->title() }}
                            </x-ui.badge>
                        </x-ui.table.cell>

                        <x-ui.table.cell align="right">
                            <div class="flex justify-end gap-2">
                                <x-ui.button size="sm" variant="outline" data-page-click="editPermission({{ $permission->id }})">
                                    Edit
                                </x-ui.button>
                                <x-ui.button
                                    size="sm"
                                    variant="danger"
                                    x-data
                                    x-on:click="window.confirmDeleteAction(() => $page.deletePermission({{ $permission->id }}))"
                                >
                                    Delete
                                </x-ui.button>
                            </div>
                        </x-ui.table.cell>
                    </x-ui.table.row>
                @empty
                    <x-ui.table.row>
                        <x-ui.table.cell colspan="4" class="py-8 text-center text-zinc-500 dark:text-zinc-400">
                            No permissions found.
                        </x-ui.table.cell>
                    </x-ui.table.row>
                @endforelse
            </x-ui.table.rows>
        </x-ui.table>
    </x-ui.card>

    <x-ui.modal data-page-model="showModal" class="md:w-[600px] max-w-2xl space-y-6">
        <div>
            <x-ui.heading size="lg">{{ $editingPermissionId ? 'Edit Permission' : 'Create Permission' }}</x-ui.heading>
        </div>

        <div class="grid gap-4">
            <x-ui.input
                data-page-model="name"
                label="Permission name *"
                placeholder="Enter permission name"
                autofocus
            />

            <x-ui.input
                data-page-model="slug"
                label="Permission Slug *"
                placeholder="Enter permission slug"
            />
        </div>

        <div class="flex justify-end gap-2 mt-4">
            <x-ui.button data-page-click="$set('showModal', false)" variant="ghost">Cancel</x-ui.button>
            <x-ui.button data-page-click="savePermission" variant="primary">Save</x-ui.button>
        </div>
    </x-ui.modal>
</div>
