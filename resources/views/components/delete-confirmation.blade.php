<x-ui.modal name="delete-confirmation" class="w-full max-w-md">
    <div class="space-y-4">
        <div>
            <x-ui.heading size="lg">Delete this item?</x-ui.heading>
            <x-ui.text class="mt-2">This action cannot be undone.</x-ui.text>
        </div>

        <div class="flex justify-end gap-2">
            <x-ui.modal.close>
                <x-ui.button variant="ghost">Cancel</x-ui.button>
            </x-ui.modal.close>
            <x-ui.button variant="primary" icon="trash" x-on:click="window.confirmPendingDeletion()">Delete</x-ui.button>
        </div>
    </div>
</x-ui.modal>
