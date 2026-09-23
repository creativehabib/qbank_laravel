<div class="mx-auto w-full max-w-3xl space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">প্রতিষ্ঠানের তথ্য</h1>
        <p class="text-sm text-zinc-600 dark:text-zinc-400">শিক্ষক প্রোফাইলের জন্য প্রতিষ্ঠানের তথ্য আপডেট করুন।</p>
    </div>

    @if (session('success'))
        <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-emerald-700 dark:border-emerald-800 dark:bg-emerald-900/40 dark:text-emerald-300">
            {{ session('success') }}
        </div>
    @endif

    <form data-page-submit="save" class="space-y-4 rounded-xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-900">
        <x-ui.input data-page-model.live.blur="organizationName" label="প্রতিষ্ঠানের নাম" placeholder="যেমন: ঢাকা কলেজ" />
        <x-ui.input data-page-model.live.blur="organizationType" label="প্রতিষ্ঠানের ধরন" placeholder="যেমন: কলেজ / স্কুল / মাদ্রাসা" />
        <x-ui.textarea data-page-model.live.blur="organizationAddress" label="প্রতিষ্ঠানের ঠিকানা" rows="4" />

        <div class="flex justify-end">
            <x-ui.button type="submit" variant="primary">আপডেট করুন</x-ui.button>
        </div>
    </form>
</div>
