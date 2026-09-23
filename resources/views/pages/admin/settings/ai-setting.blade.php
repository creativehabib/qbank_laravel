<div class="max-w-7xl mx-auto pb-12">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.settings.index') }}" class="p-2 rounded-full hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors">
                <x-ui.icon name="arrow-left" class="h-5 w-5 text-zinc-500" />
            </a>
            <div>
                <x-ui.heading size="xl">AI Settings</x-ui.heading>
                <x-ui.subheading>Configure Artificial Intelligence providers and API keys used across the platform.</x-ui.subheading>
            </div>
        </div>
        <x-ui.button data-page-click="save" variant="primary" data-page-loading.attr="disabled" data-page-target="save">
            <span data-page-loading.remove data-page-target="save">Save changes</span>
            <span data-page-loading data-page-target="save">Saving...</span>
        </x-ui.button>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 max-w-7xl items-start">
        <!-- AI Provider Selection (Left Column) -->
        <div class="lg:col-span-1 space-y-6">
            <x-ui.card>
                <x-ui.heading size="lg">Select AI Provider</x-ui.heading>
                <x-ui.text class="!text-sm mb-4">Choose which artificial intelligence provider you want to use as the default for the system.</x-ui.text>

                <x-ui.radio.group data-page-model.live="ai_provider">
                    <x-ui.radio value="openai" label="Chat GPT (OpenAI)" description="Use OpenAI's GPT models" />
                    <x-ui.radio value="gemini" label="Google Gemini" description="Use Google's Gemini AI models (Recommended)" />
                </x-ui.radio.group>
            </x-ui.card>
        </div>

        <!-- Provider Specific Settings (Right Column) -->
        <div class="lg:col-span-2 space-y-6">
            @if($ai_provider === 'openai')
                <x-ui.card>
                    <div class="mb-6">
                        <x-ui.heading size="lg">Chat GPT Settings</x-ui.heading>
                        <x-ui.text class="!text-sm">Configure Chat GPT integration settings for AI-powered features</x-ui.text>
                    </div>

                    <div class="space-y-6">
                        <x-ui.input type="password" data-page-model="openai_api_key" label="Chat GPT Key" icon="key" placeholder="Enter your OpenAI API key" required />

                        <x-ui.select data-page-model="openai_model" label="Chat GPT Model Name" icon="cpu-chip" required>
                            <option value="gpt-3.5-turbo">GPT-3.5 Turbo</option>
                            <option value="gpt-4">GPT-4</option>
                            <option value="gpt-4o">GPT-4o</option>
                            <option value="gpt-4o-mini">GPT-4o Mini</option>
                            <option value="gpt-4-turbo">GPT-4 Turbo</option>
                        </x-ui.select>
                    </div>
                </x-ui.card>
            @endif

            @if($ai_provider === 'gemini')
                <x-ui.card>
                    <div class="mb-6">
                        <x-ui.heading size="lg">Google Gemini Settings</x-ui.heading>
                        <x-ui.text class="!text-sm">Configure Google Gemini integration settings for AI-powered features</x-ui.text>
                    </div>

                    <div class="space-y-6">
                        <x-ui.input type="password" data-page-model="gemini_api_key" label="Gemini API Key" icon="key" placeholder="Enter your Gemini API key" required />

                        <x-ui.select data-page-model="gemini_model" label="Primary Gemini Model" icon="cpu-chip" required>
                            <option value="gemini-2.5-flash-lite">Gemini 2.5 Flash-Lite (Fastest & most lightweight)</option>
                            <option value="gemini-2.5-flash">Gemini 2.5 Flash (Fast & Cost-effective)</option>
                            <option value="gemini-2.5-pro">Gemini 2.5 Pro (Complex reasoning)</option>
                            <option value="gemini-3.5-flash-lite">Gemini 3.5 Flash-Lite (Next generation lightweight)</option>
                            <option value="gemini-3.5-flash">Gemini 3.5 Flash (Next generation fast)</option>
                            <option value="gemini-1.5-flash">Gemini 1.5 Flash (Legacy)</option>
                            <option value="gemini-1.5-pro">Gemini 1.5 Pro (Legacy)</option>
                        </x-ui.select>

                        <x-ui.separator variant="subtle" />

                        <x-ui.switch data-page-model.live="enable_gemini_fallback" label="Enable Dynamic Model Fallback" description="If the primary model reaches its limit or fails, automatically switch to a fallback model." />

                        @if($enable_gemini_fallback)
                            <x-ui.select data-page-model="gemini_fallback_model" label="Fallback Model" icon="cpu-chip" required>
                                <option value="gemini-2.5-flash-lite">Gemini 2.5 Flash-Lite (Fastest & most lightweight)</option>
                            <option value="gemini-2.5-flash">Gemini 2.5 Flash (Fast & Cost-effective)</option>
                            <option value="gemini-2.5-pro">Gemini 2.5 Pro (Complex reasoning)</option>
                            <option value="gemini-3.5-flash-lite">Gemini 3.5 Flash-Lite (Next generation lightweight)</option>
                            <option value="gemini-3.5-flash">Gemini 3.5 Flash (Next generation fast)</option>
                            <option value="gemini-1.5-flash">Gemini 1.5 Flash (Legacy)</option>
                            <option value="gemini-1.5-pro">Gemini 1.5 Pro (Legacy)</option>
                            </x-ui.select>
                        @endif
                    </div>
                </x-ui.card>
            @endif

            <x-ui.card>
                <div class="mb-6">
                    <x-ui.heading size="lg">Google Vision OCR Settings</x-ui.heading>
                    <x-ui.text class="!text-sm">Enter your Google Cloud Vision Service Account JSON credentials for Optical Character Recognition (OCR).</x-ui.text>
                </div>

                <div class="space-y-4">
                    <x-ui.textarea rows="10" data-page-model="google_vision_credentials" label="Google Vision Credentials (JSON)" placeholder='{
  "type": "service_account",
  "project_id": "your-project-id",
  "private_key_id": "...",
  ...
}' />
                    <div class="space-y-2 text-sm text-zinc-500">
                        <p>Paste the raw JSON content from your Google Cloud Service Account key file. When you save, it will automatically generate the credentials file and update your .env configuration.</p>

                        <div class="mt-3 p-3 bg-blue-50 dark:bg-blue-900/30 rounded-lg border border-blue-100 dark:border-blue-800">
                            <p class="font-medium text-blue-800 dark:text-blue-300 mb-1 flex items-center gap-1.5">
                                <x-ui.icon.information-circle class="w-4 h-4" />
                                How to get Google Vision Credentials?
                            </p>
                            <ol class="list-decimal ml-5 space-y-1 text-blue-700/90 dark:text-blue-300/80">
                                <li>Go to <a href="https://console.cloud.google.com/" target="_blank" class="underline font-medium hover:text-blue-900 dark:hover:text-blue-200">Google Cloud Console</a> and create a project.</li>
                                <li>Enable the <a href="https://console.cloud.google.com/apis/library/vision.googleapis.com" target="_blank" class="underline font-medium hover:text-blue-900 dark:hover:text-blue-200">Cloud Vision API</a> for your project.</li>
                                <li>Go to <strong>IAM & Admin > Service Accounts</strong>, create a new service account.</li>
                                <li>Create a new <strong>JSON Key</strong> for that service account, download it, and paste its entire content here.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </x-ui.card>

        </div>
    </div>
</div>