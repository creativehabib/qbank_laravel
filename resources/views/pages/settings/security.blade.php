<x-layouts.app :title="__('Security settings')">
<section class="w-full">
    @include('partials.settings-heading')
    <x-pages.settings.layout :heading="__('Security')" :subheading="__('Update your password and two-factor authentication')">
        <form method="POST" action="{{ route('security.password.update') }}" class="mt-6 space-y-6">
            @csrf @method('PUT')
            <x-ui.input name="current_password" type="password" :label="__('Current password')" required autocomplete="current-password" />
            <x-ui.input name="password" type="password" :label="__('New password')" required autocomplete="new-password" />
            <x-ui.input name="password_confirmation" type="password" :label="__('Confirm password')" required autocomplete="new-password" />
            <x-ui.button type="submit" variant="primary">{{ __('Save') }}</x-ui.button>
            @if(session('status') === 'password-updated')<span class="text-sm text-green-600">{{ __('Saved.') }}</span>@endif
        </form>
    </x-pages.settings.layout>
</section>
</x-layouts.app>
