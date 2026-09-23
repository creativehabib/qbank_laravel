<div class="max-w-7xl mx-auto space-y-6 pb-12">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.index') }}" class="p-2 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                <x-ui.icon name="arrow-left" class="h-5 w-5 text-zinc-500" />
            </a>
            <div>
                <x-ui.heading size="xl">Global SEO Settings</x-ui.heading>
                <x-ui.subheading>Manage default Meta tags, Open Graph images, and global SEO fallbacks.</x-ui.subheading>
            </div>
        </div>
        <x-ui.button data-page-click="save" variant="primary" data-page-loading.attr="disabled" data-page-target="save">
            <span data-page-loading.remove data-page-target="save">Save Changes</span>
            <span data-page-loading data-page-target="save">Saving...</span>
        </x-ui.button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 space-y-6">
            <x-ui.card>
                <div class="space-y-4">
                    <x-ui.heading size="lg" class="mb-4">Meta Information</x-ui.heading>

                    <div class="space-y-1">
                        <x-ui.input data-page-model="meta_title" label="Default Meta Title" placeholder="e.g. QBank BD - Best Question Archive" />
                        <p class="text-xs text-zinc-500">নির্দেশনা: গুগল সার্চে ভালো দেখানোর জন্য টাইটেলটি <strong>৫০-৬০ ক্যারেক্টারের</strong> মধ্যে রাখার চেষ্টা করুন।</p>
                    </div>

                    <div class="space-y-1">
                        <x-ui.textarea data-page-model="meta_description" label="Default Meta Description" placeholder="Describe your website for search engines..." rows="3" />
                        <p class="text-xs text-zinc-500">নির্দেশনা: ওয়েবসাইটের সুন্দর একটি সারাংশ দিন। এটি <strong>১৫০-১৬০ ক্যারেক্টারের</strong> মধ্যে হলে এসইও (SEO)-তে সবচেয়ে ভালো ফলাফল পাওয়া যায়।</p>
                    </div>

                    <div class="space-y-1">
                        <x-ui.input data-page-model="meta_keywords" label="Meta Keywords (Comma separated)" placeholder="e.g. BCS, admission, question bank, model test" />
                        <p class="text-xs text-zinc-500">নির্দেশনা: কমা (,) দিয়ে ৫-১০টি গুরুত্বপূর্ণ কিওয়ার্ড লিখুন। (যেমন: job preparation, bcs question, admission test)</p>
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card>
                <div class="space-y-4">
                    <x-ui.heading size="lg" class="mb-4">Social Media & Open Graph</x-ui.heading>

                    <x-ui.input data-page-model="twitter_handle" label="Twitter Handle" placeholder="@qerobi" />

                    <div class="mt-4">
                        <x-ui.label>Default OG Image (Social Share Image)</x-ui.label>
                        <x-ui.text class="text-xs mb-2">This image will appear when users share your website on Facebook, Twitter, WhatsApp, etc. <br><span class="text-emerald-600 dark:text-emerald-500 font-medium">নির্দেশনা: ছবিটি ১২০০ x ৬৩০ (1200x630 pixels) সাইজের হলে সবচেয়ে সুন্দরভাবে শো করবে।</span></x-ui.text>

                        <div class="flex items-center gap-4 mt-2">
                            @if($og_image)
                                <img src="{{ $og_image->temporaryUrl() }}" class="h-24 w-auto object-cover rounded border border-zinc-200 dark:border-zinc-700">
                            @elseif($existing_og_image)
                                <img src="{{ Storage::url($existing_og_image) }}" class="h-24 w-auto object-cover rounded border border-zinc-200 dark:border-zinc-700">
                            @else
                                <div class="h-24 w-40 bg-zinc-100 dark:bg-zinc-800 rounded border border-dashed border-zinc-300 dark:border-zinc-700 flex items-center justify-center text-zinc-400">
                                    <x-ui.icon name="photo" class="w-8 h-8" />
                                </div>
                            @endif

                            <div>
                                <input type="file" data-page-model="og_image" id="og_image" class="block w-full text-sm text-zinc-500
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-md file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-emerald-50 file:text-emerald-700
                                  hover:file:bg-emerald-100
                                  dark:file:bg-emerald-500/10 dark:file:text-emerald-400 dark:hover:file:bg-emerald-500/20
                                "/>
                                <div data-page-loading data-page-target="og_image" class="text-xs mt-1 text-emerald-600">Uploading...</div>
                                @error('og_image') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <div class="space-y-6">
            <x-ui.card class="bg-blue-50/50 dark:bg-blue-900/10 border-blue-100 dark:border-blue-900/30">
                <div class="flex gap-3">
                    <x-ui.icon name="information-circle" class="w-5 h-5 text-blue-600 dark:text-blue-400 shrink-0" />
                    <div>
                        <h4 class="text-sm font-semibold text-blue-800 dark:text-blue-300">Why SEO is Important</h4>
                        <p class="text-xs text-blue-700 dark:text-blue-400 mt-1 leading-relaxed">
                            These settings act as the global fallback for your application. If a specific question or page doesn't have its own meta description or social image, these defaults will be used by search engines (Google/Bing) and social media platforms.
                        </p>
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card>
                <x-ui.heading size="md" class="mb-2">Other SEO Tools</x-ui.heading>
                <div class="space-y-2 mt-4">
                    <a href="{{ route('superadmin.settings.sitemap') }}" class="flex items-center justify-between p-2 rounded hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors border border-transparent hover:border-zinc-200 dark:hover:border-zinc-700">
                        <div class="flex items-center gap-2">
                            <x-ui.icon name="map" class="w-4 h-4 text-emerald-500" />
                            <span class="text-sm font-medium">XML Sitemap</span>
                        </div>
                        <x-ui.icon name="chevron-right" class="w-4 h-4 text-zinc-400" />
                    </a>

                    <a href="{{ route('superadmin.settings.robots-txt') }}" class="flex items-center justify-between p-2 rounded hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors border border-transparent hover:border-zinc-200 dark:hover:border-zinc-700">
                        <div class="flex items-center gap-2">
                            <x-ui.icon name="document-text" class="w-4 h-4 text-purple-500" />
                            <span class="text-sm font-medium">Robots.txt</span>
                        </div>
                        <x-ui.icon name="chevron-right" class="w-4 h-4 text-zinc-400" />
                    </a>

                    <a href="{{ route('admin.settings.tracking') }}" class="flex items-center justify-between p-2 rounded hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors border border-transparent hover:border-zinc-200 dark:hover:border-zinc-700">
                        <div class="flex items-center gap-2">
                            <x-ui.icon name="chart-bar" class="w-4 h-4 text-blue-500" />
                            <span class="text-sm font-medium">Analytics & Tracking</span>
                        </div>
                        <x-ui.icon name="chevron-right" class="w-4 h-4 text-zinc-400" />
                    </a>
                </div>
            </x-ui.card>
        </div>
    </div>
</div>
