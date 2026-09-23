<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <x-ui.heading size="xl">Roles & Permissions</x-ui.heading>
            <x-ui.subheading>Role CRUD এবং permission assign system.</x-ui.subheading>
        </div>
        <x-ui.button data-page-click="createRole" variant="primary" icon="plus">
            Create role
        </x-ui.button>
    </div>

    @error('roleName')
    <div class="rounded-md border border-red-200 bg-red-50 dark:border-red-900/50 dark:bg-red-900/20 px-3 py-2 text-sm text-red-600 dark:text-red-400">
        {{ $message }}
    </div>
    @enderror

    <x-ui.card>
        <div class="mb-4 text-sm text-zinc-600 dark:text-zinc-400">
            Role overview and assigned permissions
        </div>

        <x-ui.table>
            <x-ui.table.columns>
                <x-ui.table.column>NAME</x-ui.table.column>
                <x-ui.table.column>PERMISSIONS</x-ui.table.column>
                <x-ui.table.column align="right">ACTIONS</x-ui.table.column>
            </x-ui.table.columns>

            <x-ui.table.rows>
                @forelse($roles as $role)
                    <x-ui.table.row>
                        <x-ui.table.cell>
                            <div class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $role->name }}</div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">Guard: {{ $role->guard_name }}</div>
                        </x-ui.table.cell>

                        <x-ui.table.cell>
                            <div class="flex flex-wrap gap-2">
                                @forelse($role->permissions->take(5) as $permission)
                                    <x-ui.badge size="sm" variant="outline">{{ $permission->name }}</x-ui.badge>
                                @empty
                                    <span class="text-sm text-zinc-500 dark:text-zinc-400">None</span>
                                @endforelse

                                @if($role->permissions->count() > 5)
                                    <x-ui.badge size="sm" variant="solid">
                                        +{{ $role->permissions->count() - 5 }}
                                    </x-ui.badge>
                                @endif
                            </div>
                        </x-ui.table.cell>

                        <x-ui.table.cell align="right">
                            <div class="flex justify-end gap-2">
                                <x-ui.button size="sm" variant="outline" data-page-click="editRole({{ $role->id }})">
                                    Edit
                                </x-ui.button>
                                <x-ui.button
                                    size="sm"
                                    variant="danger"
                                    x-data
                                    x-on:click="window.confirmDeleteAction(() => $page.deleteRole({{ $role->id }}))"
                                >
                                    Delete
                                </x-ui.button>
                            </div>
                        </x-ui.table.cell>
                    </x-ui.table.row>
                @empty
                    <x-ui.table.row>
                        <x-ui.table.cell colspan="3" class="py-8 text-center text-zinc-500 dark:text-zinc-400">
                            No roles found.
                        </x-ui.table.cell>
                    </x-ui.table.row>
                @endforelse
            </x-ui.table.rows>
        </x-ui.table>
    </x-ui.card>

    <x-ui.modal data-page-model="showModal" class="md:w-[800px] max-w-4xl space-y-6">
        <div>
            <x-ui.heading size="lg">{{ $editingRoleId ? 'Edit Role' : 'Create Role' }}</x-ui.heading>
        </div>

        <x-ui.input
            data-page-model="roleName"
            label="Role Name *"
            placeholder="Enter role name"
        />

        <div class="space-y-4">
            <div>
                <x-ui.heading size="sm" class="mb-3">Assign Permissions</x-ui.heading>
                <x-ui.checkbox
                    data-page-change="toggleAllPermissions($event.target.checked)"
                    :checked="count($selectedPermissions) === $permissions->count() && $permissions->count() > 0"
                    label="Select all permissions"
                />
            </div>

            <div class="space-y-3 pr-2">
                @foreach($groupedPermissions as $group => $groupPermissions)
                    <x-ui.card class="!p-4">
                        <x-ui.subheading class="mb-3 uppercase tracking-wide">{{ $group }}</x-ui.subheading>
                        <div class="grid gap-3 md:grid-cols-3">
                            @foreach($groupPermissions as $permission)
                                <x-ui.checkbox
                                    data-page-model="selectedPermissions"
                                    value="{{ $permission->id }}"
                                    label="{{ $permission->name }}"
                                />
                            @endforeach
                        </div>
                    </x-ui.card>
                @endforeach
            </div>
        </div>

        <div class="flex justify-end gap-2">
            <x-ui.button data-page-click="$set('showModal', false)" @class('cursor-pointer') variant="ghost">Cancel</x-ui.button>
            <x-ui.button data-page-click="saveRole" variant="primary" @class('cursor-pointer')>Save Role</x-ui.button>
        </div>
    </x-ui.modal>
</div>
