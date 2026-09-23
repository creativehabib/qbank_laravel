<div class="max-w-7xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.index') }}" class="p-2 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                <x-ui.icon name="arrow-left" class="h-5 w-5 text-zinc-500" />
            </a>
            <div>
                <x-ui.heading size="xl">Email Settings</x-ui.heading>
                <x-ui.subheading>Configure SMTP settings for sending emails from the application.</x-ui.subheading>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <x-ui.button data-page-click="save" variant="primary" data-page-loading.attr="disabled" data-page-target="save">
                <span data-page-loading.remove data-page-target="save">Save changes</span>
                <span data-page-loading data-page-target="save">Saving...</span>
            </x-ui.button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 max-w-7xl">
        <!-- Settings Form (Left) -->
        <div class="lg:col-span-2 space-y-6">
            <x-ui.card>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <x-ui.select data-page-model="mail_mailer" label="Mail Driver" icon="server" required>
                        <option value="smtp">SMTP</option>
                        <option value="sendmail">Sendmail</option>
                        <option value="mailgun">Mailgun</option>
                        <option value="postmark">Postmark</option>
                        <option value="ses">Amazon SES</option>
                    </x-ui.select>

                    <x-ui.input data-page-model="mail_host" label="SMTP Host" icon="server" placeholder="e.g. smtp.mailtrap.io" required />

                    <x-ui.input data-page-model="mail_username" label="SMTP Username" icon="user" />

                    <x-ui.input data-page-model="mail_password" type="password" label="SMTP Password" icon="lock-closed" />

                    <x-ui.input data-page-model="mail_port" label="SMTP Port" icon="server" placeholder="e.g. 587 or 465" required />

                    <x-ui.select data-page-model="mail_encryption" label="Mail Encryption" icon="lock-closed">
                        <option value="tls">TLS</option>
                        <option value="ssl">SSL</option>
                        <option value="">None</option>
                    </x-ui.select>

                    <x-ui.input data-page-model="mail_from_address" label="From Address" icon="envelope" placeholder="e.g. hello@example.com" required />

                    <x-ui.input data-page-model="mail_from_name" label="From Name" icon="user" placeholder="e.g. Question Bank" required />
                </div>
            </x-ui.card>
        </div>

        <!-- Test Email Widget (Right) -->
        <div class="lg:col-span-1">
            <x-ui.card>
                <div class="flex items-center gap-2 mb-6">
                    <x-ui.icon name="paper-airplane" class="w-5 h-5 text-emerald-500" />
                    <x-ui.heading size="lg">Test Email Configuration</x-ui.heading>
                </div>

                <div class="space-y-4">
                    <x-ui.input data-page-model="test_email_to" label="Send Test To" placeholder="test@example.com" description="Enter an email address to send a test message" required />

                    <x-ui.button data-page-click="sendTestEmail" class="w-full bg-emerald-400 hover:bg-emerald-500 text-white border-emerald-400" icon="paper-airplane" data-page-loading.attr="disabled" data-page-target="sendTestEmail">
                        <span data-page-loading.remove data-page-target="sendTestEmail">Send Test Email</span>
                        <span data-page-loading data-page-target="sendTestEmail">Sending...</span>
                    </x-ui.button>
                </div>
            </x-ui.card>
        </div>
    </div>
</div>