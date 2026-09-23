<div class="max-w-7xl mx-auto space-y-6 pb-12">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.index') }}" class="p-2 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                <flux:icon name="arrow-left" class="h-5 w-5 text-zinc-500" />
            </a>
            <div>
                <flux:heading size="xl">Frontend Footer</flux:heading>
                <flux:subheading>Manage website footer content, social links, and column menus.</flux:subheading>
            </div>
        </div>
        <flux:button wire:click="save" variant="primary" wire:loading.attr="disabled" wire:target="save">
            <span wire:loading.remove wire:target="save">Save Changes</span>
            <span wire:loading wire:target="save">Saving...</span>
        </flux:button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="space-y-6">
            <flux:card>
                <flux:heading size="lg" class="mb-4">Brand Information</flux:heading>
                <div class="space-y-4">
                    <flux:textarea wire:model="about_text" label="About Us Text (Short)" rows="3" />
                    <flux:input wire:model="copyright_text" label="Copyright Text" />
                </div>
            </flux:card>

            <flux:card>
                <flux:heading size="lg" class="mb-4">Social Media Links</flux:heading>
                <div class="space-y-4">
                    <flux:input wire:model="facebook_url" label="Facebook URL" placeholder="https://facebook.com/..." />
                    <flux:input wire:model="youtube_url" label="YouTube URL" placeholder="https://youtube.com/..." />
                    <flux:input wire:model="twitter_url" label="Twitter (X) URL" placeholder="https://twitter.com/..." />
                    <flux:input wire:model="linkedin_url" label="LinkedIn URL" placeholder="https://linkedin.com/..." />
                </div>
            </flux:card>
        </div>

        <div class="space-y-6">
            <flux:card>
                <div class="flex items-center justify-between mb-4">
                    <flux:heading size="lg">Footer Columns (Menus)</flux:heading>
                    <div class="text-xs text-zinc-500 bg-zinc-100 dark:bg-zinc-800 px-2 py-1 rounded">Format: URL | Label</div>
                </div>
                
                <div class="space-y-6">
                    <div class="p-4 bg-zinc-50 dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 space-y-3">
                        <flux:input wire:model="column1_title" label="Column 1 Title" />
                        <flux:textarea wire:model="column1_links" label="Column 1 Links" rows="4" placeholder="/job-solutions|জব সল্যুশন" />
                    </div>

                    <div class="p-4 bg-zinc-50 dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 space-y-3">
                        <flux:input wire:model="column2_title" label="Column 2 Title" />
                        <flux:textarea wire:model="column2_links" label="Column 2 Links" rows="4" placeholder="/ssc|এসএসসি" />
                    </div>

                    <div class="p-4 bg-zinc-50 dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 space-y-3">
                        <flux:input wire:model="column3_title" label="Column 3 Title" />
                        <flux:textarea wire:model="column3_links" label="Column 3 Links" rows="4" />
                    </div>

                    <div class="p-4 bg-zinc-50 dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 space-y-3">
                        <flux:input wire:model="column4_title" label="Column 4 Title" />
                        <flux:textarea wire:model="column4_links" label="Column 4 Links" rows="4" />
                    </div>
                </div>
            </flux:card>
        </div>
    </div>
</div>
