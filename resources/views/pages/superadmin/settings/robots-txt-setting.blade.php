<form data-page-submit.prevent="save" class="max-w-7xl mx-auto space-y-6 pb-12">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.index') }}" class="p-2 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                <x-ui.icon name="arrow-left" class="h-5 w-5 text-zinc-500" />
            </a>
            <div>
                <x-ui.heading size="xl">Robots.txt Setting</x-ui.heading>
                <x-ui.subheading>Manage search engine crawling rules directly from the admin panel.</x-ui.subheading>
            </div>
        </div>
        <x-ui.button type="submit" variant="primary" data-page-loading.attr="disabled" data-page-target="save">
            <span data-page-loading.remove data-page-target="save">Save changes</span>
            <span data-page-loading data-page-target="save">Saving...</span>
        </x-ui.button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <x-ui.card>
                <div class="space-y-4">
                    <x-ui.heading size="lg">Edit robots.txt</x-ui.heading>
                    <x-ui.text class="text-sm text-zinc-500">
                        This file tells search engine crawlers which URLs the crawler can access on your site.
                        Be careful with your syntax to avoid accidentally blocking important pages.
                    </x-ui.text>

                    <x-ui.textarea
                        data-page-model="content"
                        rows="12"
                        class="font-mono text-sm"
                        placeholder="User-agent: *&#10;Disallow:"
                    />
                    <x-ui.error name="content" />
                </div>
            </x-ui.card>
        </div>

        <div class="space-y-6">
            <x-ui.card>
                <x-ui.heading size="md" class="mb-4">Common Examples</x-ui.heading>

                <div class="space-y-4">
                    <div>
                        <span class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 block mb-1">Allow all bots:</span>
                        <div class="bg-zinc-50 dark:bg-zinc-900 p-2 rounded border border-zinc-200 dark:border-zinc-700 font-mono text-xs text-zinc-600 dark:text-zinc-400">
User-agent: *<br>
Disallow:
                        </div>
                    </div>

                    <div>
                        <span class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 block mb-1">Block all bots:</span>
                        <div class="bg-zinc-50 dark:bg-zinc-900 p-2 rounded border border-zinc-200 dark:border-zinc-700 font-mono text-xs text-zinc-600 dark:text-zinc-400">
User-agent: *<br>
Disallow: /
                        </div>
                    </div>

                    <div>
                        <span class="text-xs font-semibold text-zinc-900 dark:text-zinc-100 block mb-1">Block specific bot:</span>
                        <div class="bg-zinc-50 dark:bg-zinc-900 p-2 rounded border border-zinc-200 dark:border-zinc-700 font-mono text-xs text-zinc-600 dark:text-zinc-400">
User-agent: BadBot<br>
Disallow: /
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                        <x-ui.text class="text-xs text-zinc-500">
                            <strong>Note:</strong> Always include the link to your sitemap at the bottom of your robots.txt file to help search engines discover your pages faster.
                        </x-ui.text>
                    </div>
                </div>
            </x-ui.card>
        </div>
    </div>
</form>
