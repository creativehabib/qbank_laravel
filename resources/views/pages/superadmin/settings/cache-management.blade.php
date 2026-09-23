<div class="space-y-6">
    <div class="space-y-1 mb-2">
        <x-ui.heading size="xl">Cache Management</x-ui.heading>
        <x-ui.subheading size="lg">সিস্টেমের স্পিড এবং পারফরম্যান্স বাড়াতে ক্যাশ ফাইলগুলো নিয়মিত ক্লিয়ার করুন।</x-ui.subheading>
    </div>

    <!-- Cache Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <x-ui.card class="relative overflow-hidden group flex items-center gap-4">
            <div class="absolute -right-2 -top-2 size-16 text-zinc-100 dark:text-zinc-800 opacity-50 transition-transform group-hover:scale-110">
                <x-ui.icon.server class="size-16" />
            </div>
            <div class="z-10 w-12 h-12 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-600 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700">
                <x-ui.icon.server class="w-6 h-6" />
            </div>
            <div class="z-10">
                <p class="text-xs font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">Cache Driver</p>
                <p class="mt-1 text-2xl font-black text-zinc-900 dark:text-white uppercase">{{ $this->cacheInfo['driver'] }}</p>
            </div>
        </x-ui.card>

        <x-ui.card class="relative overflow-hidden group flex items-center gap-4">
            <div class="absolute -right-2 -top-2 size-16 text-zinc-100 dark:text-zinc-800 opacity-50 transition-transform group-hover:scale-110">
                <x-ui.icon.document-duplicate class="size-16" />
            </div>
            <div class="z-10 w-12 h-12 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-600 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700">
                <x-ui.icon.document-duplicate class="w-6 h-6" />
            </div>
            <div class="z-10">
                <p class="text-xs font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">File Cache Size</p>
                <p class="mt-1 text-2xl font-black text-zinc-900 dark:text-white">{{ $this->cacheInfo['file_cache_size'] }}</p>
            </div>
        </x-ui.card>

        <x-ui.card class="relative overflow-hidden group flex items-center gap-4">
            <div class="absolute -right-2 -top-2 size-16 text-zinc-100 dark:text-zinc-800 opacity-50 transition-transform group-hover:scale-110">
                <x-ui.icon.photo class="size-16" />
            </div>
            <div class="z-10 w-12 h-12 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-600 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700">
                <x-ui.icon.photo class="w-6 h-6" />
            </div>
            <div class="z-10">
                <p class="text-xs font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">Views Cache Size</p>
                <p class="mt-1 text-2xl font-black text-zinc-900 dark:text-white">{{ $this->cacheInfo['views_size'] }}</p>
            </div>
        </x-ui.card>
    </div>

    <!-- Clear Cache Options -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        <!-- App Cache -->
        <x-ui.card class="group hover:border-zinc-300 dark:hover:border-zinc-600 transition-colors">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                <div class="flex gap-3">
                    <div class="mt-1 text-zinc-400 group-hover:text-accent transition-colors">
                        <x-ui.icon.circle-stack class="size-6" />
                    </div>
                    <div>
                        <x-ui.heading size="md">Application Cache</x-ui.heading>
                        <x-ui.text class="mt-1 !text-sm">সিস্টেমের ডিফল্ট ক্যাশ। ডাটাবেজ কুয়েরি বা অন্যান্য স্ট্যাটিক ডাটা ক্যাশ ক্লিয়ার করতে এটি ব্যবহার করুন।</x-ui.text>
                    </div>
                </div>
                <x-ui.button data-page-click="clearApplicationCache" data-page-loading.attr="disabled" size="sm" variant="outline" class="shrink-0 w-full sm:w-auto">
                    <span data-page-loading.remove data-page-target="clearApplicationCache">Clear Cache</span>
                    <span data-page-loading data-page-target="clearApplicationCache">Clearing...</span>
                </x-ui.button>
            </div>
        </x-ui.card>

        <!-- Views Cache -->
        <x-ui.card class="group hover:border-zinc-300 dark:hover:border-zinc-600 transition-colors">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                <div class="flex gap-3">
                    <div class="mt-1 text-zinc-400 group-hover:text-accent transition-colors">
                        <x-ui.icon.window class="size-6" />
                    </div>
                    <div>
                        <x-ui.heading size="md">Views Cache</x-ui.heading>
                        <x-ui.text class="mt-1 !text-sm">ব্লেড ফাইলের কম্পাইলড ক্যাশ। ডিজাইনে কোনো পরিবর্তন করলে এবং সেটি শো না করলে এটি ক্লিয়ার করুন।</x-ui.text>
                    </div>
                </div>
                <x-ui.button data-page-click="clearViewCache" data-page-loading.attr="disabled" size="sm" variant="outline" class="shrink-0 w-full sm:w-auto">
                    <span data-page-loading.remove data-page-target="clearViewCache">Clear Views</span>
                    <span data-page-loading data-page-target="clearViewCache">Clearing...</span>
                </x-ui.button>
            </div>
        </x-ui.card>

        <!-- Config Cache -->
        <x-ui.card class="group hover:border-zinc-300 dark:hover:border-zinc-600 transition-colors">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                <div class="flex gap-3">
                    <div class="mt-1 text-zinc-400 group-hover:text-accent transition-colors">
                        <x-ui.icon.cog-6-tooth class="size-6" />
                    </div>
                    <div>
                        <x-ui.heading size="md">Configuration Cache</x-ui.heading>
                        <x-ui.text class="mt-1 !text-sm">.env ফাইল বা কনফিগারেশন ফাইলে কোনো পরিবর্তন আনলে এই ক্যাশটি ক্লিয়ার করতে হয়।</x-ui.text>
                    </div>
                </div>
                <x-ui.button data-page-click="clearConfigCache" data-page-loading.attr="disabled" size="sm" variant="outline" class="shrink-0 w-full sm:w-auto">
                    <span data-page-loading.remove data-page-target="clearConfigCache">Clear Config</span>
                    <span data-page-loading data-page-target="clearConfigCache">Clearing...</span>
                </x-ui.button>
            </div>
        </x-ui.card>

        <!-- Route Cache -->
        <x-ui.card class="group hover:border-zinc-300 dark:hover:border-zinc-600 transition-colors">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                <div class="flex gap-3">
                    <div class="mt-1 text-zinc-400 group-hover:text-accent transition-colors">
                        <x-ui.icon.map class="size-6" />
                    </div>
                    <div>
                        <x-ui.heading size="md">Route Cache</x-ui.heading>
                        <x-ui.text class="mt-1 !text-sm">নতুন কোনো রাউট বা URL তৈরি করলে এই ক্যাশটি ক্লিয়ার করা প্রয়োজন হয়।</x-ui.text>
                    </div>
                </div>
                <x-ui.button data-page-click="clearRouteCache" data-page-loading.attr="disabled" size="sm" variant="outline" class="shrink-0 w-full sm:w-auto">
                    <span data-page-loading.remove data-page-target="clearRouteCache">Clear Routes</span>
                    <span data-page-loading data-page-target="clearRouteCache">Clearing...</span>
                </x-ui.button>
            </div>
        </x-ui.card>

    </div>

    <!-- Optimize All -->
    <x-ui.card class="bg-zinc-50 dark:bg-zinc-900 border-zinc-200 dark:border-zinc-800 relative overflow-hidden group">
        <div class="absolute -right-2 -top-2 size-24 text-zinc-200 dark:text-zinc-800 opacity-50 transition-transform group-hover:scale-110">
            <x-ui.icon.bolt class="size-24" />
        </div>
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex gap-3">
                <div class="mt-1 text-accent">
                    <x-ui.icon.bolt class="size-8" />
                </div>
                <div>
                    <h3 class="text-lg font-black text-zinc-900 dark:text-white">
                        Optimize Clear (Clear All)
                    </h3>
                    <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400 font-medium">
                        সিস্টেমের সমস্ত ক্যাশ (Application, Views, Routes, Config, Compiled Services) এক ক্লিকে মুছে ফেলুন।
                    </p>
                </div>
            </div>

            <x-ui.button data-page-click="optimizeClear" data-page-loading.attr="disabled" variant="primary" class="shrink-0 w-full md:w-auto shadow-sm">
                <span data-page-loading.remove data-page-target="optimizeClear" class="flex items-center gap-2">
                    <x-ui.icon.trash class="size-4" />
                    Clear All Caches
                </span>
                <span data-page-loading data-page-target="optimizeClear">Processing...</span>
            </x-ui.button>
        </div>
    </x-ui.card>

</div>
