<x-layouts.auth :title="__('Register')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf
            <!-- Name -->
            <x-ui.input
                name="name"
                :label="__('Name')"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Full name')"
            />

            <!-- Email Address -->
            <x-ui.input
                name="email"
                :label="__('Email address')"
                :value="old('email')"
                type="email"
                required
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <x-ui.input
                name="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Password')"
                viewable
            />


            <div x-data="{ registrationRole: '{{ old('registration_role', 'job_seeker') }}' }" class="space-y-4">
                <x-ui.select name="registration_role" x-model="registrationRole" :label="__('I want to register as')">
                    <option value="job_seeker">{{ __('Job Seeker') }}</option>
                    <option value="student">{{ __('Student') }}</option>
                    <option value="teacher">{{ __('Teacher') }}</option>
                </x-ui.select>

                @php
                    $academicClasses = \App\Models\AcademicClass::whereNotIn('name', ['Jobs', 'BCS'])->get();
                    $deptClasses = $academicClasses->filter(function($c) {
                        return in_array($c->name, ['Class 9', 'Class 10', 'এসএসসি', 'এইচ এস সি', 'Admission']);
                    })->pluck('id')->toArray();
                @endphp

                <div x-data="{ selectedClass: '{{ old('academic_class_id', '') }}', deptClasses: {{ json_encode($deptClasses) }} }" x-show="registrationRole === 'student'" x-cloak class="space-y-4 rounded-lg border border-zinc-200 p-4 dark:border-zinc-700">
                    <x-ui.select name="academic_class_id" x-model="selectedClass" :label="__('Select Class')">
                        <option value="">{{ __('Select your class') }}</option>
                        @foreach($academicClasses as $class)
                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </x-ui.select>

                    <div x-show="deptClasses.includes(parseInt(selectedClass))" x-cloak>
                       <x-ui.select name="department" :label="__('Department')">
                            <option value="">{{ __('Select Department') }}</option>
                            <option value="Science">{{ __('Science') }}</option>
                            <option value="Arts">{{ __('Arts') }}</option>
                            <option value="Commerce">{{ __('Commerce') }}</option>
                       </x-ui.select>
                    </div>
                </div>

                <div x-show="registrationRole === 'teacher'" x-cloak class="space-y-4 rounded-lg border border-zinc-200 p-4 dark:border-zinc-700">
                    <x-ui.input name="organization_name" :label="__('Organization name')" :value="old('organization_name')" type="text" :placeholder="__('Organization name')" />
                    <x-ui.input name="organization_type" :label="__('Organization type')" :value="old('organization_type')" type="text" :placeholder="__('School / College / Madrasa')" />
                    <x-ui.textarea name="organization_address" :label="__('Organization address')">{{ old('organization_address') }}</x-ui.textarea>
                </div>
            </div>

            <!-- Confirm Password -->
            <x-ui.input
                name="password_confirmation"
                :label="__('Confirm password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Confirm password')"
                viewable
            />

            <div class="flex items-center justify-end">
                <x-ui.button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                    {{ __('Create account') }}
                </x-ui.button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Already have an account?') }}</span>
            <x-ui.link :href="route('login')" data-page-navigate>{{ __('Log in') }}</x-ui.link>
        </div>
    </div>
</x-layouts.auth>
