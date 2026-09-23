<x-layouts.app :title="__('Appearance settings')">
<section class="w-full">
    @include('partials.settings-heading')
    <x-pages.settings.layout :heading="__('Appearance')" :subheading="__('Choose your preferred color scheme')">
        <div x-data="{ mode: localStorage.getItem('appearance') || 'system' }" class="mt-6 flex gap-3">
            @foreach(['light' => __('Light'), 'dark' => __('Dark'), 'system' => __('System')] as $value => $label)
                <button type="button" x-on:click="mode='{{ $value }}'; localStorage.setItem('appearance', mode); applyAppearance(mode)" class="rounded-lg border px-4 py-2" x-bind:class="mode === '{{ $value }}' && 'border-accent'">{{ $label }}</button>
            @endforeach
        </div>
    </x-pages.settings.layout>
</section>
</x-layouts.app>
