@props(['href' => '#'])<a href="{{ $href }}" {{ $attributes->except(['icon', 'current'])->merge(['class' => 'inline-flex items-center gap-2']) }}>{{ $slot }}</a>
