<div class="max-w-7xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.index') }}" class="p-2 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                <x-ui.icon name="arrow-left" class="h-5 w-5 text-zinc-500" />
            </a>
            <div>
                <x-ui.heading size="xl">General Settings</x-ui.heading>
                <x-ui.subheading>Manage your system's core information, contact details, and basic configuration.</x-ui.subheading>
            </div>
        </div>
        <x-ui.button data-page-click="save" variant="primary" data-page-loading.attr="disabled" data-page-target="save">
            <span data-page-loading.remove data-page-target="save">Save changes</span>
            <span data-page-loading data-page-target="save">Saving...</span>
        </x-ui.button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 max-w-7xl items-start">
        <x-ui.card>
            <div class="mb-6">
                <x-ui.heading size="lg">System Settings</x-ui.heading>
                <x-ui.text class="!text-sm">Configure system-wide settings for your application</x-ui.text>
            </div>

            <div class="space-y-6">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <x-ui.select data-page-model="default_language" label="Default Language" icon="language">
                        <option value="en">🇬🇧 English</option>
                        <option value="bn">🇧🇩 Bengali</option>
                    </x-ui.select>

                    <x-ui.select data-page-model="date_format" label="Date Format" icon="calendar">
                        <option value="M j, Y">M j, Y (Jan 1, 2025)</option>
                        <option value="d-m-Y">d-m-Y (01-01-2025)</option>
                        <option value="m-d-Y">m-d-Y (01-01-2025)</option>
                        <option value="Y-m-d">Y-m-d (2025-01-01)</option>
                        <option value="d M, Y">d M, Y (01 Jan, 2025)</option>
                        <option value="d F, Y">d F, Y (01 January, 2025)</option>
                        <option value="F j, Y">F j, Y (January 1, 2025)</option>
                        <option value="j F Y">j F Y (1 January 2025)</option>
                        <option value="D, M j, Y">D, M j, Y (Thu, Jan 1, 2025)</option>
                        <option value="l, F j, Y">l, F j, Y (Thursday, January 1, 2025)</option>
                        <option value="d/m/Y">d/m/Y (01/01/2025)</option>
                        <option value="m/d/Y">m/d/Y (01/01/2025)</option>
                    </x-ui.select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <x-ui.select data-page-model="time_format" label="Time Format" icon="clock">
                        <option value="H:i">H:i (13:30)</option>
                        <option value="h:i A">h:i A (01:30 PM)</option>
                    </x-ui.select>

                    <x-ui.select data-page-model="calendar_start_day" label="Calendar Start Day" icon="calendar-days">
                        <option value="Sunday">Sunday</option>
                        <option value="Monday">Monday</option>
                        <option value="Saturday">Saturday</option>
                    </x-ui.select>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <x-ui.select data-page-model="default_timezone" label="Default Timezone" icon="globe-alt" searchable placeholder="Search timezones...">
                        @foreach($this->timezones as $tzValue => $tzLabel)
                            <option value="{{ $tzValue }}">{{ $tzLabel }}</option>
                        @endforeach
                    </x-ui.select>
                </div>

                <x-ui.separator variant="subtle" />

                <x-ui.switch data-page-model="email_verification" label="Email Verification" description="Require users to verify their email addresses" />

                <x-ui.switch data-page-model="landing_page" label="Landing Page" description="Enable or disable the public landing page" />

                <x-ui.switch data-page-model="user_registration" label="User Registration" description="Allow new users to create accounts on your platform" />

                <div class="pt-2">
                    <x-ui.input data-page-model="terms_conditions_url" label="Terms and Conditions URL" icon="link" placeholder="https://example.com/terms" description="Enter the URL for your Terms and Conditions page that will be linked in the registration form" />
                </div>
            </div>
        </x-ui.card>

        <x-ui.card>
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <div>
                    <x-ui.heading size="lg">Basic Information</x-ui.heading>
                    <x-ui.text class="!text-sm">These details might be displayed on the frontend to the users.</x-ui.text>
                </div>
            </div>

            <div class="space-y-6">

                <x-ui.textarea data-page-model="site_description" label="Site Description (SEO)" placeholder="Briefly describe what this platform is about..." rows="3" description="Used for SEO meta descriptions on the public site." />

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <x-ui.input data-page-model="support_email" type="email" label="Support Email" icon="envelope" placeholder="support@example.com" />

                    <x-ui.input data-page-model="support_phone" label="Support Phone" icon="phone" placeholder="+8801XXXXXXXXX" />
                </div>

                <x-ui.textarea data-page-model="company_address" label="Company Address" placeholder="123 Main Street, City, Country" rows="2" />

                <div class="grid grid-cols-1 gap-6">
                    <x-ui.select data-page-model="system_currency" label="System Currency" icon="currency-dollar" required>
                        <option value="BDT">BDT (৳)</option>
                        <option value="USD">USD ($)</option>
                        <option value="EUR">EUR (€)</option>
                        <option value="INR">INR (₹)</option>
                    </x-ui.select>
                </div>

                <x-ui.separator variant="subtle" />

                <x-ui.heading size="lg">Social Media Links</x-ui.heading>
                <div class="space-y-4">
                    <x-ui.input data-page-model="facebook_url" type="url" label="Facebook URL" icon="link" placeholder="https://facebook.com/yourpage" />
                    <x-ui.input data-page-model="youtube_url" type="url" label="YouTube URL" icon="link" placeholder="https://youtube.com/c/yourchannel" />
                    <x-ui.input data-page-model="linkedin_url" type="url" label="LinkedIn URL" icon="link" placeholder="https://linkedin.com/company/yourcompany" />
                </div>
            </div>
        </x-ui.card>
    </div>
</div>