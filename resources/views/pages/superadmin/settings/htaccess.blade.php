<form data-page-submit.prevent="save" class="max-w-7xl mx-auto space-y-6 pb-12">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.index') }}" class="p-2 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                <x-ui.icon name="arrow-left" class="h-5 w-5 text-zinc-500" />
            </a>
            <div>
                <x-ui.heading size="xl">.htaccess Editor</x-ui.heading>
                <x-ui.subheading>Edit server configuration files for root and public directories.</x-ui.subheading>
            </div>
        </div>
        <x-ui.button type="submit" variant="primary" data-page-loading.attr="disabled" data-page-target="save">
            <span data-page-loading.remove data-page-target="save">Save Changes</span>
            <span data-page-loading data-page-target="save">Saving...</span>
        </x-ui.button>
    </div>

    <x-ui.card>
        <!-- Custom Tabs Navigation -->
        <div class="flex gap-6 border-b border-zinc-200 dark:border-zinc-800 mb-6">
            <button
                type="button"
                data-page-click="$set('activeTab', 'root')"
                class="pb-3 px-1 font-medium text-sm transition-colors border-b-2 {{ $activeTab === 'root' ? 'border-accent text-zinc-900 dark:text-white' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300' }}"
            >
                <div class="flex items-center gap-2">
                    <x-ui.icon name="folder" class="w-4 h-4" />
                    Root Directory
                </div>
            </button>
            <button
                type="button"
                data-page-click="$set('activeTab', 'public')"
                class="pb-3 px-1 font-medium text-sm transition-colors border-b-2 {{ $activeTab === 'public' ? 'border-accent text-zinc-900 dark:text-white' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300' }}"
            >
                <div class="flex items-center gap-2">
                    <x-ui.icon name="globe-alt" class="w-4 h-4" />
                    Public Directory
                </div>
            </button>
        </div>

        <!-- Tab Contents -->
        <div>
            @if($activeTab === 'root')
                <div class="space-y-4 animate-in fade-in slide-in-from-bottom-2 duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <x-ui.heading size="lg">Root <code>.htaccess</code></x-ui.heading>
                            <x-ui.text class="text-sm text-zinc-500">
                                This file is located at <code>{{ base_path('.htaccess') }}</code>. It usually handles redirecting traffic to the public folder.
                            </x-ui.text>
                        </div>
                    </div>

                    <x-ui.textarea
                        data-page-model="rootContent"
                        rows="15"
                        class="font-mono text-sm leading-relaxed"
                        placeholder="RewriteEngine On..."
                    />
                </div>
            @endif

            @if($activeTab === 'public')
                <div class="space-y-4 animate-in fade-in slide-in-from-bottom-2 duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <x-ui.heading size="lg">Public <code>.htaccess</code></x-ui.heading>
                            <x-ui.text class="text-sm text-zinc-500">
                                This file is located at <code>{{ public_path('.htaccess') }}</code>. It handles Laravel's front controller pattern and asset caching.
                            </x-ui.text>
                        </div>
                    </div>

                    <x-ui.textarea
                        data-page-model="publicContent"
                        rows="15"
                        class="font-mono text-sm leading-relaxed"
                        placeholder="RewriteEngine On..."
                    />
                </div>
            @endif
        </div>

        <div class="mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-800 flex items-start gap-3 text-amber-600 dark:text-amber-500 bg-amber-50 dark:bg-amber-500/10 p-4 rounded-lg">
            <x-ui.icon name="exclamation-triangle" class="w-5 h-5 shrink-0 mt-0.5" />
            <div class="text-sm font-medium">
                <strong>Warning:</strong> Incorrect configuration in these files can break your website (Internal Server Error 500). Please be careful and only make changes if you know exactly what you are doing.
            </div>
        </div>
    </x-ui.card>
</form>
