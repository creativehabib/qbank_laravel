<div class="max-w-7xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.index') }}" class="p-2 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                <x-ui.icon name="arrow-left" class="h-5 w-5 text-zinc-500" />
            </a>
            <div>
                <x-ui.heading size="xl">Website Tracking</x-ui.heading>
                <x-ui.subheading>Manage Google Analytics, Facebook Pixel, and custom tracking scripts.</x-ui.subheading>
            </div>
        </div>
        <x-ui.button data-page-click="save" variant="primary" data-page-loading.attr="disabled" data-page-target="save">
            <span data-page-loading.remove data-page-target="save">Save changes</span>
            <span data-page-loading data-page-target="save">Saving...</span>
        </x-ui.button>
    </div>

    <div class="space-y-6 max-w-4xl">
        <x-ui.card>
            <div class="space-y-6">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <x-ui.input data-page-model="google_analytics_id" label="Google Analytics ID" placeholder="e.g. G-XXXXXXX" />

                    <x-ui.input data-page-model="facebook_pixel_id" label="Facebook Pixel ID" placeholder="e.g. 1234567890" />
                </div>

                <x-ui.separator variant="subtle" />

                <x-ui.heading size="lg">Custom Scripts</x-ui.heading>
                <x-ui.text class="!text-sm">These scripts will be injected into the website. Be careful with what you add here.</x-ui.text>

                <div class="grid grid-cols-1 gap-6">
                    <x-ui.textarea data-page-model="custom_header_script" label="Header Script" placeholder="<script>...</script>" rows="4" description="Inserted just before the closing </head> tag." />

                    <x-ui.textarea data-page-model="custom_footer_script" label="Footer Script" placeholder="<script>...</script>" rows="4" description="Inserted just before the closing </body> tag." />
                </div>
            </div>
        </x-ui.card>
    </div>
</div>