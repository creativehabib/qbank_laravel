@props(['label' => null, 'name' => null, 'checked' => false])
@php($fieldName = $name ?: $attributes->get('data-page-model') ?: $attributes->get('data-page-model.live'))
<label class="inline-flex items-center gap-2"><input type="checkbox" name="{{ $fieldName }}" @checked($checked) {{ $attributes->except(['data-page-model', 'data-page-model.live', 'label'])->merge(['class' => 'rounded border-zinc-300']) }}>@if($label)<span>{{ $label }}</span>@else {{ $slot }}@endif</label>
