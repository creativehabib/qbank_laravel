<div class="space-y-6 pb-12">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <x-ui.heading size="xl">Package Management</x-ui.heading>
            <x-ui.subheading>Create and manage Subscriptions and Special Courses.</x-ui.subheading>
        </div>
        <x-ui.button data-page-click="resetForm" variant="primary" icon="plus">
            New Package
        </x-ui.button>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <!-- Form Section -->
        <div class="xl:col-span-1">
            <x-ui.card>
                <x-ui.heading size="lg" class="mb-4">{{ $editingId ? 'Edit Package' : 'Create Package' }}</x-ui.heading>

                <form data-page-submit.prevent="save" class="space-y-5">

                    <x-ui.radio.group data-page-model="type" label="Package Type">
                        <x-ui.radio value="subscription" label="Pro Subscription (Unlocks all premium content)" />
                        <x-ui.radio value="course" label="Special Course (Unlocks specific targeted content)" />
                    </x-ui.radio.group>

                    <x-ui.field>
                        <x-ui.label>Package Name</x-ui.label>
                        <x-ui.input data-page-model="name" placeholder="e.g., 46th BCS Special" />
                        <x-ui.error name="name" />
                    </x-ui.field>

                    <x-ui.field>
                        <x-ui.label>Description (Optional)</x-ui.label>
                        <x-ui.textarea data-page-model="description" placeholder="Short details about the package..." rows="3" />
                        <x-ui.error name="description" />
                    </x-ui.field>

                    <div class="grid grid-cols-2 gap-4">
                        <x-ui.field>
                            <x-ui.label>Price (৳)</x-ui.label>
                            <x-ui.input data-page-model="price" type="number" step="0.01" min="0" placeholder="0.00" />
                            <x-ui.error name="price" />
                        </x-ui.field>

                        <x-ui.field>
                            <x-ui.label>Validity (Days)</x-ui.label>
                            <x-ui.input data-page-model="validityDays" type="number" min="1" />
                            <x-ui.error name="validityDays" />
                        </x-ui.field>
                    </div>

                    <x-ui.field>
                        <x-ui.label>Course Thumbnail (Optional)</x-ui.label>
                        <div class="mt-2 flex items-center gap-4">
                            @if ($thumbnail_image)
                                <img src="{{ $thumbnail_image->temporaryUrl() }}" class="size-16 rounded object-cover border border-zinc-200">
                            @elseif ($existing_thumbnail)
                                <img src="{{ $existing_thumbnail }}" class="size-16 rounded object-cover border border-zinc-200">
                            @else
                                <div class="size-16 rounded bg-zinc-100 flex items-center justify-center text-zinc-400 border border-zinc-200 border-dashed">
                                    <x-ui.icon.photo class="size-6" />
                                </div>
                            @endif
                            <input type="file" data-page-model="thumbnail_image" class="text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-400">
                        </div>
                        <x-ui.error name="thumbnail_image" />
                    </x-ui.field>

                    <x-ui.checkbox data-page-model="isActive" label="Active (Visible to users)" />

                    <div class="pt-2">
                        <x-ui.button type="submit" variant="primary" class="w-full">
                            {{ $editingId ? 'Update Package' : 'Save Package' }}
                        </x-ui.button>
                        @if($editingId)
                            <x-ui.button data-page-click="resetForm" variant="ghost" class="w-full mt-2">Cancel</x-ui.button>
                        @endif
                    </div>
                </form>
            </x-ui.card>
        </div>

        <!-- List Section -->
        <div class="xl:col-span-2">
            <x-ui.card class="p-0">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-700">
                            <tr>
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300">Package</th>
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300">Type</th>
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300">Price</th>
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300">Validity</th>
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300">Status</th>
                                <th class="px-4 py-3 font-semibold text-zinc-700 dark:text-zinc-300 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse ($packages as $package)
                                <tr data-page-key="pkg-{{ $package->id }}" class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition">
                                    <td class="px-4 py-3">
                                        <div class="flex items-center gap-3">
                                            @if($package->thumbnail_image)
                                                <img src="{{ $package->thumbnail_image }}" class="size-10 rounded object-cover">
                                            @else
                                                <div class="size-10 rounded bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-500">
                                                    <x-ui.icon name="{{ $package->type === 'course' ? 'academic-cap' : 'sparkles' }}" class="size-5" />
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-bold text-zinc-900 dark:text-zinc-100">{{ $package->name }}</div>
                                                <div class="text-xs text-zinc-500 line-clamp-1 max-w-[200px]">{{ $package->description }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <x-ui.badge size="sm" :color="$package->type === 'course' ? 'emerald' : 'indigo'">
                                            {{ ucfirst($package->type) }}
                                        </x-ui.badge>
                                    </td>
                                    <td class="px-4 py-3 font-bold">৳{{ number_format($package->price) }}</td>
                                    <td class="px-4 py-3 text-zinc-500">{{ $package->validity_days }} Days</td>
                                    <td class="px-4 py-3">
                                        <x-ui.badge size="sm" :color="$package->is_active ? 'green' : 'zinc'">{{ $package->is_active ? 'Active' : 'Inactive' }}</x-ui.badge>
                                    </td>
                                    <td class="px-4 py-3 text-right">
                                        <x-ui.dropdown>
                                            <x-ui.button variant="ghost" size="sm" icon="ellipsis-horizontal" />
                                            <x-ui.menu>
                                                <x-ui.menu.item data-page-click="edit({{ $package->id }})" icon="pencil-square">Edit</x-ui.menu.item>
                                                <x-ui.menu.separator />
                                                <x-ui.menu.item x-on:click="window.confirmDeleteAction(() => $page.delete({{ $package->id }}))" icon="trash" variant="danger">Delete</x-ui.menu.item>
                                            </x-ui.menu>
                                        </x-ui.dropdown>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-12 text-center text-zinc-500">
                                        <x-ui.icon.cube class="size-12 mx-auto mb-3 opacity-20" />
                                        No packages found. Create your first subscription or course!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </x-ui.card>
        </div>

    </div>
</div>
