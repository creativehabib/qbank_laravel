<x-layouts.app :title="__('Profile settings')">
<section class="w-full">
    @include('partials.settings-heading')
    <x-pages.settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <form method="POST" action="{{ route('profile.update') }}" class="my-6 w-full space-y-6">
            @csrf @method('PATCH')
            <x-ui.input name="name" :value="old('name', $user->name)" :label="__('Name')" required autofocus autocomplete="name" />
            <x-ui.input name="email" :value="old('email', $user->email)" :label="__('Email')" type="email" required autocomplete="email" />
            <x-ui.button variant="primary" type="submit">{{ __('Save') }}</x-ui.button>
            @if(session('status') === 'profile-updated')<span class="text-sm text-green-600">{{ __('Saved.') }}</span>@endif
        </form>
        <form method="POST" action="{{ route('profile.destroy') }}" class="space-y-4 border-t pt-6" onsubmit="return confirm('{{ __('Are you sure you want to delete your account?') }}')">
            @csrf @method('DELETE')
            <x-ui.heading>{{ __('Delete account') }}</x-ui.heading>
            <x-ui.input name="password" type="password" :label="__('Password')" required />
            <x-ui.button type="submit" variant="danger">{{ __('Delete account') }}</x-ui.button>
        </form>
    </x-pages.settings.layout>
</section>
</x-layouts.app>
