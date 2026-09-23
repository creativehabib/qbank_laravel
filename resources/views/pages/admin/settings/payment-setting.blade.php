<div>
    <div class="mb-6">
        <x-ui.heading size="xl">Payment Gateways</x-ui.heading>
        <x-ui.subheading>Configure API keys and credentials for payment gateways like bKash and SSLCommerz.</x-ui.subheading>
    </div>

    <form data-page-submit="save" class="space-y-6">

        <!-- SSLCommerz Settings -->
        <x-ui.card>
            <div class="flex items-center gap-4 mb-4 border-b border-zinc-100 pb-4 dark:border-zinc-800">
                <img src="{{ asset('images/sslcommerz_logo.png') }}" alt="SSLCommerz" class="h-8 object-contain">
                <div>
                    <h3 class="text-lg font-bold text-zinc-800 dark:text-zinc-100">SSLCommerz Settings</h3>
                    <p class="text-sm text-zinc-500">Enable and configure SSLCommerz integration.</p>
                </div>
            </div>

            <div class="space-y-6">
                <x-ui.switch data-page-model.live="sslcommerz_active" label="Enable SSLCommerz" description="Allow students to pay using Cards, Mobile Banking via SSLCommerz." />

                <div x-show="$page.sslcommerz_active" class="space-y-6 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-ui.input data-page-model="sslcommerz_store_id" label="Store ID" placeholder="Enter your Store ID" />
                        <x-ui.input data-page-model="sslcommerz_store_password" label="Store Password" type="password" placeholder="Enter your Store Password" viewable />
                    </div>

                    <x-ui.switch data-page-model="sslcommerz_sandbox" label="Sandbox Mode (Test Environment)" description="Enable test mode for local development. Turn off for production." />
                </div>
            </div>
        </x-ui.card>

        <!-- bKash Settings -->
        <x-ui.card>
            <div class="flex items-center gap-4 mb-4 border-b border-zinc-100 pb-4 dark:border-zinc-800">
                <img src="{{ asset('images/bkash_logo.svg') }}" alt="bKash" class="h-10 object-contain">
                <div>
                    <h3 class="text-lg font-bold text-zinc-800 dark:text-zinc-100">bKash Payment Gateway</h3>
                    <p class="text-sm text-zinc-500">Enable and configure bKash PGW API.</p>
                </div>
            </div>

            <div class="space-y-6">
                <x-ui.switch data-page-model.live="bkash_active" label="Enable bKash" description="Allow students to pay directly via bKash." />

                <div x-show="$page.bkash_active" class="space-y-6 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-ui.input data-page-model="bkash_app_key" label="App Key" placeholder="Enter App Key" />
                        <x-ui.input data-page-model="bkash_app_secret" label="App Secret" type="password" placeholder="Enter App Secret" viewable />
                        <x-ui.input data-page-model="bkash_username" label="Username" placeholder="Enter Username" />
                        <x-ui.input data-page-model="bkash_password" label="Password" type="password" placeholder="Enter Password" viewable />
                    </div>

                    <x-ui.switch data-page-model="bkash_sandbox" label="Sandbox Mode (Test Environment)" description="Enable bKash sandbox API. Turn off for production." />
                </div>
            </div>
        </x-ui.card>

                <!-- Nagad Settings -->
        <x-ui.card>
            <div class="flex items-center gap-4 mb-4 border-b border-zinc-100 pb-4 dark:border-zinc-800">
                <img src="{{ asset('images/nagad_logo.svg') }}" alt="Nagad" class="h-10 object-contain">
                <div>
                    <h3 class="text-lg font-bold text-zinc-800 dark:text-zinc-100">Nagad Payment Gateway</h3>
                    <p class="text-sm text-zinc-500">Enable and configure Nagad PGW API.</p>
                </div>
            </div>

            <div class="space-y-6">
                <x-ui.switch data-page-model.live="nagad_active" label="Enable Nagad" description="Allow users to pay directly via Nagad API." />

                <div x-show="$page.nagad_active" class="space-y-6 pt-4 border-t border-zinc-100 dark:border-zinc-800">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-ui.input data-page-model="nagad_merchant_id" label="Merchant ID" placeholder="Enter Merchant ID" />
                        <x-ui.input data-page-model="nagad_merchant_number" label="Merchant Number" placeholder="Enter Merchant Number" />
                        <x-ui.input data-page-model="nagad_public_key" label="Public Key" placeholder="Enter Public Key" />
                        <x-ui.input data-page-model="nagad_private_key" label="Private Key" type="password" placeholder="Enter Private Key" viewable />
                    </div>

                    <x-ui.switch data-page-model="nagad_sandbox" label="Sandbox Mode (Test Environment)" description="Enable Nagad sandbox API. Turn off for production." />
                </div>
            </div>
        </x-ui.card>

        <div class="flex items-center gap-4">
            <x-ui.button type="submit" variant="primary">Save Changes</x-ui.button>

            <div data-page-loading data-page-target="save" class="text-sm text-zinc-500 flex items-center gap-2">
                <x-ui.icon.arrow-path class="size-4 animate-spin" /> Saving...
            </div>
        </div>

    </form>
</div>
