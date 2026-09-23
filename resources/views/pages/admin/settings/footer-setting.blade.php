<div class="max-w-7xl mx-auto space-y-6 pb-12">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.index') }}" class="p-2 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                <x-ui.icon name="arrow-left" class="h-5 w-5 text-zinc-500" />
            </a>
            <div>
                <x-ui.heading size="xl">Frontend Footer</x-ui.heading>
                <x-ui.subheading>Manage website footer content, social links, and column menus.</x-ui.subheading>
            </div>
        </div>
        <x-ui.button data-page-click="save" variant="primary" data-page-loading.attr="disabled" data-page-target="save">
            <span data-page-loading.remove data-page-target="save">Save Changes</span>
            <span data-page-loading data-page-target="save">Saving...</span>
        </x-ui.button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="space-y-6">
            <x-ui.card>
                <x-ui.heading size="lg" class="mb-4">Brand Information</x-ui.heading>
                <div class="space-y-4">
                    <x-ui.textarea data-page-model="about_text" label="About Us Text (Short)" rows="3" />
                    <x-ui.input data-page-model="copyright_text" label="Copyright Text" />
                </div>
            </x-ui.card>

            <x-ui.card>
                <x-ui.heading size="lg" class="mb-4">Social Media Links</x-ui.heading>
                <div class="space-y-4">
                    <x-ui.input data-page-model="facebook_url" label="Facebook URL" placeholder="https://facebook.com/..." />
                    <x-ui.input data-page-model="youtube_url" label="YouTube URL" placeholder="https://youtube.com/..." />
                    <x-ui.input data-page-model="twitter_url" label="Twitter (X) URL" placeholder="https://twitter.com/..." />
                    <x-ui.input data-page-model="linkedin_url" label="LinkedIn URL" placeholder="https://linkedin.com/..." />
                </div>
            </x-ui.card>
        </div>

        <div class="space-y-6">
            <x-ui.card>
                <div class="flex items-center justify-between mb-4">
                    <x-ui.heading size="lg">Footer Columns (Menus)</x-ui.heading>
                    <div class="text-xs text-zinc-500 bg-zinc-100 dark:bg-zinc-800 px-2 py-1 rounded">Format: URL | Label</div>
                </div>

                <div class="space-y-6">
                    <div class="p-4 bg-zinc-50 dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 space-y-3">
                        <x-ui.input data-page-model="column1_title" label="Column 1 Title" />
                        <x-ui.textarea data-page-model="column1_links" label="Column 1 Links" rows="4" placeholder="/job-solutions|জব সল্যুশন" />
                    </div>

                    <div class="p-4 bg-zinc-50 dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 space-y-3">
                        <x-ui.input data-page-model="column2_title" label="Column 2 Title" />
                        <x-ui.textarea data-page-model="column2_links" label="Column 2 Links" rows="4" placeholder="/ssc|এসএসসি" />
                    </div>

                    <div class="p-4 bg-zinc-50 dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 space-y-3">
                        <x-ui.input data-page-model="column3_title" label="Column 3 Title" />
                        <x-ui.textarea data-page-model="column3_links" label="Column 3 Links" rows="4" />
                    </div>

                    <div class="p-4 bg-zinc-50 dark:bg-zinc-900 rounded-lg border border-zinc-200 dark:border-zinc-700 space-y-3">
                        <x-ui.input data-page-model="column4_title" label="Column 4 Title" />
                        <x-ui.textarea data-page-model="column4_links" label="Column 4 Links" rows="4" />
                    </div>
                </div>
            </x-ui.card>
        </div>
    </div>
</div>
