<div class="max-w-7xl mx-auto space-y-6 pb-12">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.index') }}" class="p-2 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                <x-ui.icon name="arrow-left" class="h-5 w-5 text-zinc-500" />
            </a>
            <div>
                <x-ui.heading size="xl">XML Sitemap</x-ui.heading>
                <x-ui.subheading>Generate and manage the sitemap to help search engines crawl your site.</x-ui.subheading>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="md:col-span-2 space-y-6">
            <x-ui.card>
                <div class="flex items-start gap-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-500">
                        <x-ui.icon name="map" variant="outline" class="h-6 w-6" />
                    </div>
                    <div class="flex-1">
                        <x-ui.heading size="lg">Sitemap Generator</x-ui.heading>
                        <x-ui.text class="mt-1">
                            Clicking the generate button will build an updated <code>sitemap.xml</code> file in the public directory containing all organizations, past exams, job solutions, and available questions.<br><br><strong>Note:</strong> The sitemap is now configured to automatically update every day at midnight (Daily Auto Update) to ensure search engines always get your latest questions.
                        </x-ui.text>

                        <div class="mt-6 flex flex-wrap gap-4">
                            <x-ui.button data-page-click="generateSitemap" variant="primary" icon="arrow-path" data-page-loading.attr="disabled">
                                <span data-page-loading.remove data-page-target="generateSitemap">Generate Sitemap Now</span>
                                <span data-page-loading data-page-target="generateSitemap">Generating... please wait</span>
                            </x-ui.button>

                            @if($sitemapExists)
                                <x-ui.button href="{{ url('sitemap.xml') }}" target="_blank" variant="outline" icon="arrow-top-right-on-square">
                                    View Sitemap
                                </x-ui.button>
                            @endif
                        </div>
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card>
                <div class="flex flex-col gap-4">
                    <div class="flex items-center gap-2">
                        <x-ui.icon name="information-circle" class="w-6 h-6 text-accent" />
                        <x-ui.heading size="lg">কীভাবে সাইটম্যাপটি ব্যবহার করবেন? (Instructions)</x-ui.heading>
                    </div>
                    <div class="text-sm text-zinc-600 dark:text-zinc-400 space-y-4">
                        <p>XML Sitemap মূলত গুগল (Google) বা বিং (Bing)-এর মতো সার্চ ইঞ্জিনগুলোকে আপনার ওয়েবসাইটের সব পেইজ সহজে খুঁজে পেতে সাহায্য করে। এটি আপনার ওয়েবসাইটের এসইও (SEO) র‍্যাংকিং দ্রুত বাড়াতে কার্যকর ভূমিকা রাখে।</p>

                        <div>
                            <h4 class="text-zinc-800 dark:text-zinc-200 font-semibold mb-2">গুগল সার্চ কনসোলে (Google Search Console) কীভাবে যুক্ত করবেন?</h4>
                            <ol class="list-decimal pl-5 space-y-2">
                                <li>প্রথমে <a href="https://search.google.com/search-console" target="_blank" class="text-accent hover:underline">Google Search Console</a> এ লগইন করুন।</li>
                                <li>বামের মেনু থেকে <strong>Sitemaps</strong> অপশনে ক্লিক করুন।</li>
                                <li>"Add a new sitemap" বক্সে শুধুমাত্র <code>sitemap.xml</code> লিখে <strong>Submit</strong> বাটনে ক্লিক করুন।</li>
                                <li>গুগল কয়েক ঘণ্টার মধ্যে আপনার সাইটম্যাপটি প্রসেস করে নিবে এবং ডাটাবেজের সকল প্রশ্ন গুগলে ইনডেক্সিং শুরু করবে।</li>
                            </ol>
                        </div>

                        <div class="pt-2">
                            <h4 class="text-zinc-800 dark:text-zinc-200 font-semibold mb-2">আপনার robots.txt ফাইলে যুক্ত করুন</h4>
                            <p>সার্চ ইঞ্জিন যেন সহজেই আপনার সাইটম্যাপটি খুঁজে পায়, তার জন্য আপনার <code>robots.txt</code> ফাইলের একেবারে নিচে নিচের লাইনটি যুক্ত করে দিন (আপনি চাইলে সেটিংসের Robots.txt মেনু থেকে সরাসরি এটি করতে পারেন):</p>

                            <!-- Copy Box 1 -->
                            <div x-data="{
                                text: 'Sitemap: {{ url('sitemap.xml') }}',
                                copied: false,
                                copy() {
                                    navigator.clipboard.writeText(this.text);
                                    this.copied = true;
                                    setTimeout(() => this.copied = false, 2000);
                                    if (typeof window.AppUI !== 'undefined') {
                                        window.AppUI.toast({ variant: 'success', text: 'Copied to clipboard!' });
                                    }
                                }
                            }" class="mt-3 flex items-center justify-between bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 p-2 rounded-md font-mono text-xs text-zinc-800 dark:text-zinc-200 overflow-hidden">
                                <span class="select-all block overflow-x-auto whitespace-nowrap pr-4" style="-ms-overflow-style:none;scrollbar-width:none;" x-text="text"></span>
                                <button @click="copy()" type="button" class="shrink-0 p-1.5 rounded hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300 focus:outline-none" title="Copy">
                                    <div x-show="!copied"><x-ui.icon name="clipboard-document" class="w-4 h-4" /></div>
                                    <div x-show="copied" x-cloak><x-ui.icon name="check" class="w-4 h-4 text-emerald-500" /></div>
                                </button>
                            </div>
                        </div>

                        <div class="pt-2 border-t border-zinc-100 dark:border-zinc-800 mt-2">
                            <h4 class="text-zinc-800 dark:text-zinc-200 font-semibold mb-2">সার্ভারে Cron Job সেটআপ (অটো-আপডেটের জন্য)</h4>
                            <p class="mb-2">প্রতিদিন অটোমেটিক সাইটম্যাপ আপডেট চালু রাখতে আপনার cPanel বা VPS সার্ভারের Cron Job সেকশনে নিচের কমান্ডটি যুক্ত করে দিন (প্রতি মিনিটে রান করার জন্য <code>* * * * *</code> সেট করবেন):</p>

                            <!-- Copy Box 2 -->
                            <div x-data="{
                                text: '* * * * * cd {{ base_path() }} && php artisan schedule:run >> /dev/null 2>&1',
                                copied: false,
                                copy() {
                                    navigator.clipboard.writeText(this.text);
                                    this.copied = true;
                                    setTimeout(() => this.copied = false, 2000);
                                    if (typeof window.AppUI !== 'undefined') {
                                        window.AppUI.toast({ variant: 'success', text: 'Copied to clipboard!' });
                                    }
                                }
                            }" class="flex items-center justify-between bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 p-2 rounded-md font-mono text-xs text-zinc-800 dark:text-zinc-200 overflow-hidden">
                                <span class="select-all block overflow-x-auto whitespace-nowrap pr-4" style="-ms-overflow-style:none;scrollbar-width:none;" x-text="text"></span>
                                <button @click="copy()" type="button" class="shrink-0 p-1.5 rounded hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300 focus:outline-none" title="Copy">
                                    <div x-show="!copied"><x-ui.icon name="clipboard-document" class="w-4 h-4" /></div>
                                    <div x-show="copied" x-cloak><x-ui.icon name="check" class="w-4 h-4 text-emerald-500" /></div>
                                </button>
                            </div>

                            <p class="text-xs text-zinc-500 mt-2">নোট: এই কমান্ডটি সেট করা থাকলে শুধুমাত্র সাইটম্যাপ নয়, সিস্টেমের অন্যান্য ব্যাকগ্রাউন্ড কাজগুলোও (যেমন: ডাটাবেজ ব্যাকআপ) ঠিকমতো অটোমেটিক রান করবে।</p>
                        </div>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <div class="space-y-6">
            <x-ui.card>
                <x-ui.heading size="md" class="mb-4">Sitemap Status</x-ui.heading>

                @if($sitemapExists)
                    <div class="space-y-4">
                        <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-2">
                            <span class="text-sm text-zinc-500">Status</span>
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400 text-xs font-medium">
                                <div class="size-1.5 rounded-full bg-emerald-500"></div>
                                Available
                            </span>
                        </div>
                        <div class="flex items-center justify-between border-b border-zinc-100 dark:border-zinc-800 pb-2">
                            <span class="text-sm text-zinc-500">Last Generated</span>
                            <span class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $lastModified }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-zinc-500">File Size</span>
                            <span class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $fileSize }}</span>
                        </div>
                    </div>
                @else
                    <div class="py-6 text-center text-zinc-500 flex flex-col items-center justify-center">
                        <x-ui.icon name="document-magnifying-glass" class="h-8 w-8 mb-2 opacity-50" />
                        <p class="text-sm">No sitemap found.</p>
                        <p class="text-xs mt-1">Please generate one to see details.</p>
                    </div>
                @endif
            </x-ui.card>

            <x-ui.card>
                <x-ui.heading size="md" class="mb-2">Search Engines</x-ui.heading>
                <x-ui.text class="text-sm text-zinc-500 mb-4">
                    Once generated, your sitemap can be submitted to Google Search Console or Bing Webmaster Tools using this URL:
                </x-ui.text>

                <!-- Copy Box 3 -->
                <div x-data="{
                    text: '{{ url('sitemap.xml') }}',
                    copied: false,
                    copy() {
                        navigator.clipboard.writeText(this.text);
                        this.copied = true;
                        setTimeout(() => this.copied = false, 2000);
                                    if (typeof window.AppUI !== 'undefined') {
                                        window.AppUI.toast({ variant: 'success', text: 'Copied to clipboard!' });
                                    }
                    }
                }" class="flex items-center justify-between bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 p-2 rounded-md font-mono text-xs text-zinc-800 dark:text-zinc-200 overflow-hidden">
                    <span class="select-all block overflow-x-auto whitespace-nowrap pr-4" style="-ms-overflow-style:none;scrollbar-width:none;" x-text="text"></span>
                    <button @click="copy()" type="button" class="shrink-0 p-1.5 rounded hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-colors text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300 focus:outline-none" title="Copy">
                        <div x-show="!copied"><x-ui.icon name="clipboard-document" class="w-4 h-4" /></div>
                        <div x-show="copied" x-cloak><x-ui.icon name="check" class="w-4 h-4 text-emerald-500" /></div>
                    </button>
                </div>
            </x-ui.card>
        </div>
    </div>
</div>
