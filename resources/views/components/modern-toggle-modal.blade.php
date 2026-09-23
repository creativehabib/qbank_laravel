@props([
    'name' => 'toggle-confirm',
])

<x-ui.modal name="{{ $name }}" data-page-model="showToggleModal" class="md:w-96">
    <div class="flex gap-4">
        <div class="shrink-0">
            <div class="flex size-10 items-center justify-center rounded-xl bg-amber-50 dark:bg-amber-500/10 border border-amber-200/50 dark:border-amber-500/20 text-amber-600 dark:text-amber-500">
                <x-ui.icon icon="exclamation-triangle" class="size-6" variant="outline" />
            </div>
        </div>
        <div class="flex-1">
            <x-ui.heading size="lg" class="!font-semibold">
                {{ $this->toggleTargetState ? 'Activate' : 'Deactivate' }} "{{ $this->toggleTargetName }}"?
            </x-ui.heading>

            <x-ui.text class="mt-1 !text-sm">
                Are you sure you want to {{ $this->toggleTargetState ? 'activate' : 'deactivate' }} this item?
            </x-ui.text>

            <div class="mt-6 flex justify-end gap-2">
                <x-ui.modal.close>
                    <x-ui.button variant="ghost" size="sm">Cancel</x-ui.button>
                </x-ui.modal.close>
                <x-ui.button data-page-click="performToggle" variant="primary" size="sm" class="{{ !$this->toggleTargetState ? '!bg-orange-500 hover:!bg-orange-600 !text-white !border-orange-500' : '' }}">
                    <span data-page-loading.remove data-page-target="performToggle">
                        {{ $this->toggleTargetState ? 'Activate' : 'Deactivate' }}
                    </span>
                    <span data-page-loading data-page-target="performToggle">Wait...</span>
                </x-ui.button>
            </div>
        </div>
    </div>
</x-ui.modal>
