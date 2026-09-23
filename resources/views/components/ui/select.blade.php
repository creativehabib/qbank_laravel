@props(['label' => null, 'name' => null])
@php($fieldName = $name ?: $attributes->get('data-page-model') ?: $attributes->get('data-page-model.live'))
<label class="block space-y-1">@if($label)<span class="block text-sm font-medium">{{ $label }}</span>@endif<select name="{{ $fieldName }}" {{ $attributes->except(['data-page-model', 'data-page-model.live', 'label'])->merge(['class' => 'w-full rounded-lg border border-zinc-300 bg-white px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900']) }}>{{ $slot }}</select></label>
