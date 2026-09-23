<div class="max-w-7xl mx-auto space-y-6 pb-12">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.index') }}" class="p-2 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                <x-ui.icon name="arrow-left" class="h-5 w-5 text-zinc-500" />
            </a>
            <div>
                <x-ui.heading size="xl">Premium Menu Builder</x-ui.heading>
                <x-ui.subheading>Drag & Drop to arrange menus for Main Navbar, Footer, and Mobile App.</x-ui.subheading>
            </div>
        </div>
    </div>

    <!-- Include SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        <!-- Sidebar Menu List -->
        <div class="lg:col-span-1 space-y-2">
            @foreach($menus as $menu)
                <button
                    data-page-click="switchMenu({{ $menu->id }})"
                    class="w-full text-left px-4 py-3 rounded-lg border transition-colors flex items-center justify-between
                    {{ $activeMenuId === $menu->id
                        ? 'bg-accent/10 border-accent text-accent'
                        : 'bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-800 text-zinc-700 dark:text-zinc-300 hover:border-zinc-300 dark:hover:border-zinc-700'
                    }}"
                >
                    <span class="font-medium text-sm">{{ $menu->name }}</span>
                    <x-ui.icon name="chevron-right" class="w-4 h-4 opacity-50" />
                </button>
            @endforeach
        </div>

        <!-- Menu Editor Area -->
        <div class="lg:col-span-3">
            @if($this->activeMenu)
            <x-ui.card>
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <x-ui.heading size="lg">{{ $this->activeMenu->name }}</x-ui.heading>
                        <x-ui.text class="text-sm mt-1">Drag items to reorder them.</x-ui.text>
                        <div class="mt-3 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-lg flex gap-3 items-start">
                            <x-ui.icon name="information-circle" class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" />
                            <div class="text-xs text-blue-700 dark:text-blue-300">
                                <p class="font-semibold mb-1">নির্দেশনা:</p>
                                <ul class="list-disc pl-4 space-y-1">
                                    <li>বামপাশ থেকে মেনু সিলেক্ট করুন (যেমন: Main Navigation, Footer Column)।</li>
                                    <li>নতুন মেনু বা লিংক তৈরি করতে <strong>Add Item</strong> বাটনে ক্লিক করুন।</li>
                                    <li>মেনুর সিরিয়াল পরিবর্তন করতে আইটেমের বামপাশের আইকনে ক্লিক করে টেনে (Drag & Drop) উপরে-নিচে নিয়ে যান।</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <x-ui.button data-page-click="openItemModal" variant="primary" icon="plus">Add Item</x-ui.button>
                </div>

                @if($this->activeMenu->parentItems->isEmpty())
                    <div class="py-12 text-center text-zinc-500 bg-zinc-50 dark:bg-zinc-900/50 rounded-lg border border-dashed border-zinc-300 dark:border-zinc-700">
                        <x-ui.icon name="queue-list" class="w-10 h-10 mx-auto mb-3 opacity-50" />
                        <p>No items in this menu yet.</p>
                        <x-ui.button data-page-click="openItemModal" variant="outline" size="sm" class="mt-4">Add your first item</x-ui.button>
                    </div>
                @else
                    <!-- Sortable List -->
                    <div
                        x-data="{
                            init() {
                                new Sortable(this.$refs.sortableList, {
                                    animation: 150,
                                    handle: '.drag-handle',
                                    ghostClass: 'opacity-50',
                                    onEnd: (evt) => {
                                        let orderedIds = Array.from(this.$refs.sortableList.children).map(child => child.dataset.id);
                                        $page.updateOrder(orderedIds);
                                    }
                                });
                            }
                        }"
                    >
                        <ul x-ref="sortableList" class="space-y-2">
                            @foreach($this->activeMenu->parentItems as $item)
                                <li data-id="{{ $item->id }}" class="bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-sm overflow-hidden">
                                    <div class="flex items-center p-3 gap-3">
                                        <div class="drag-handle cursor-grab active:cursor-grabbing text-zinc-400 hover:text-zinc-600 transition-colors">
                                            <x-ui.icon name="bars-2" class="w-5 h-5" />
                                        </div>
                                        <div class="flex-1">
                                            <div class="font-semibold text-sm text-zinc-900 dark:text-white">{{ $item->title }}</div>
                                            <div class="text-xs text-zinc-500 font-mono mt-0.5">
                                                {{ $item->url ?? '#' }}
                                                @if($item->badge)
                                                    <span class="ml-2 inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-rose-100 text-rose-800 dark:bg-rose-900/30 dark:text-rose-400">
                                                        {{ $item->badge }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <x-ui.button data-page-click="editItem({{ $item->id }})" variant="ghost" size="sm" icon="pencil-square" class="text-zinc-500 hover:text-accent" />
                                            <x-ui.button data-page-click="deleteItem({{ $item->id }})" data-page-confirm="Are you sure you want to delete this item?" variant="ghost" size="sm" icon="trash" class="text-red-500 hover:text-red-600 dark:text-red-400" />
                                        </div>
                                    </div>

                                    <!-- Child Items (Simple view for MVP) -->
                                    @if($item->children->count() > 0)
                                        <ul class="pl-12 pr-3 pb-3 space-y-2 border-t border-zinc-100 dark:border-zinc-700 pt-2">
                                            @foreach($item->children as $child)
                                                <li class="flex items-center justify-between bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 p-2 rounded">
                                                    <div>
                                                        <span class="text-sm font-medium">{{ $child->title }}</span>
                                                        <span class="text-xs text-zinc-500 font-mono ml-2">{{ $child->url }}</span>
                                                    </div>
                                                    <div class="flex gap-1">
                                                        <x-ui.button data-page-click="editItem({{ $child->id }})" variant="ghost" size="sm" icon="pencil-square" class="h-6 w-6 text-zinc-500 p-0" />
                                                        <x-ui.button data-page-click="deleteItem({{ $child->id }})" data-page-confirm="Are you sure?" variant="ghost" size="sm" icon="trash" class="h-6 w-6 text-red-500 p-0" />
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </x-ui.card>
            @endif
        </div>
    </div>

    <!-- Add/Edit Item Modal -->
    <x-ui.modal data-page-model="showItemModal" class="md:w-[500px]">
        <div class="space-y-6">
            <div>
                <x-ui.heading size="lg">{{ $editingItemId ? 'Edit Menu Item' : 'Add Menu Item' }}</x-ui.heading>
            </div>

            <div class="space-y-4">
                <x-ui.input data-page-model="itemTitle" label="Link Title" placeholder="e.g. Home" required />

                <x-ui.input data-page-model="itemUrl" label="URL (Link)" placeholder="e.g. /job-solutions or https://google.com" />

                @if($this->activeMenu && $this->activeMenu->parentItems->count() > 0 && !$editingItemId)
                <x-ui.select data-page-model="itemParentId" label="Parent Item (Optional)">
                    <x-ui.select.option value="">-- No Parent (Top Level) --</x-ui.select.option>
                    @foreach($this->activeMenu->parentItems as $parent)
                        <x-ui.select.option value="{{ $parent->id }}">{{ $parent->title }}</x-ui.select.option>
                    @endforeach
                </x-ui.select>
                @endif

                <div class="grid grid-cols-2 gap-4">
                    <x-ui.input data-page-model="itemIcon" label="Icon Class (Optional)" placeholder="e.g. fas fa-home" />
                    <x-ui.input data-page-model="itemBadge" label="Badge Text (Optional)" placeholder="e.g. নতুন / New" />
                </div>
                <div>
                    <x-ui.select data-page-model="itemTarget" label="Open In">
                        <x-ui.select.option value="_self">Same Tab</x-ui.select.option>
                        <x-ui.select.option value="_blank">New Tab</x-ui.select.option>
                    </x-ui.select>
                </div>
            </div>

            <div class="flex justify-end gap-3">
                <x-ui.button data-page-click="$set('showItemModal', false)" variant="ghost">Cancel</x-ui.button>
                <x-ui.button data-page-click="saveItem" variant="primary">Save Item</x-ui.button>
            </div>
        </div>
    </x-ui.modal>
</div>
