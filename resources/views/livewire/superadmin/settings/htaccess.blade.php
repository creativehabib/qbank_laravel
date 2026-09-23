<form wire:submit.prevent="save" class="max-w-7xl mx-auto space-y-6 pb-12">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.index') }}" class="p-2 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                <flux:icon name="arrow-left" class="h-5 w-5 text-zinc-500" />
            </a>
            <div>
                <flux:heading size="xl">.htaccess Editor</flux:heading>
                <flux:subheading>Edit server configuration files for root and public directories.</flux:subheading>
            </div>
        </div>
        <flux:button type="submit" variant="primary" wire:loading.attr="disabled" wire:target="save">
            <span wire:loading.remove wire:target="save">Save Changes</span>
            <span wire:loading wire:target="save">Saving...</span>
        </flux:button>
    </div>

    <flux:card>
        <!-- Custom Tabs Navigation -->
        <div class="flex gap-6 border-b border-zinc-200 dark:border-zinc-800 mb-6">
            <button 
                type="button"
                wire:click="$set('activeTab', 'root')" 
                class="pb-3 px-1 font-medium text-sm transition-colors border-b-2 {{ $activeTab === 'root' ? 'border-accent text-zinc-900 dark:text-white' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300' }}"
            >
                <div class="flex items-center gap-2">
                    <flux:icon name="folder" class="w-4 h-4" />
                    Root Directory
                </div>
            </button>
            <button 
                type="button"
                wire:click="$set('activeTab', 'public')" 
                class="pb-3 px-1 font-medium text-sm transition-colors border-b-2 {{ $activeTab === 'public' ? 'border-accent text-zinc-900 dark:text-white' : 'border-transparent text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300' }}"
            >
                <div class="flex items-center gap-2">
                    <flux:icon name="globe-alt" class="w-4 h-4" />
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
                            <flux:heading size="lg">Root <code>.htaccess</code></flux:heading>
                            <flux:text class="text-sm text-zinc-500">
                                This file is located at <code>{{ base_path('.htaccess') }}</code>. It usually handles redirecting traffic to the public folder.
                            </flux:text>
                        </div>
                    </div>
                    
                    <flux:textarea 
                        wire:model="rootContent" 
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
                            <flux:heading size="lg">Public <code>.htaccess</code></flux:heading>
                            <flux:text class="text-sm text-zinc-500">
                                This file is located at <code>{{ public_path('.htaccess') }}</code>. It handles Laravel's front controller pattern and asset caching.
                            </flux:text>
                        </div>
                    </div>
                    
                    <flux:textarea 
                        wire:model="publicContent" 
                        rows="15" 
                        class="font-mono text-sm leading-relaxed" 
                        placeholder="RewriteEngine On..." 
                    />
                </div>
            @endif
        </div>
        
        <div class="mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-800 flex items-start gap-3 text-amber-600 dark:text-amber-500 bg-amber-50 dark:bg-amber-500/10 p-4 rounded-lg">
            <flux:icon name="exclamation-triangle" class="w-5 h-5 shrink-0 mt-0.5" />
            <div class="text-sm font-medium">
                <strong>Warning:</strong> Incorrect configuration in these files can break your website (Internal Server Error 500). Please be careful and only make changes if you know exactly what you are doing.
            </div>
        </div>
    </flux:card>
</form>
