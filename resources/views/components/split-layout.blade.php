@props([
    'header' => null,
])

<div class="space-y-6">
    @if($header)
        {{ $header }}
    @endif
    <div class="flex flex-col lg:flex-row gap-6 items-start">
        <!-- Left Side: Table/List (flex-1) -->
        <div class="w-full lg:flex-[2]">
            <x-ui.card class="p-0! overflow-hidden">
                {{ $table }}
            </x-ui.card>
        </div>

        <!-- Right Side: Form/Panel (w-96) -->
        <div class="w-full lg:w-[400px] shrink-0 sticky top-6">
            <x-ui.card class="shadow-sm">
                {{ $form }}
            </x-ui.card>
        </div>
    </div>

    {{ $slot ?? '' }}
</div>
