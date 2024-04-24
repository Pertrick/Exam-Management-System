<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')"
                    required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Phone -->
            <div>
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')"
                    required autofocus />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>


            <div class="mt-4">
                <div class="form-group">
                    <x-input-label for="programs" :value="__('Programs')" />
                    <select id="program-id" name="program" class="block mt-1 w-full rounded text-sm text-gray-700"
                        required>
                        <option value="" selected disabled>select options</option>
                        @foreach ($programs as $program)
                            <option value="{{ $program->id }}">{{ $program->name }}</option>
                        @endforeach
                    </select>
                </div>
                <x-input-error :messages="$errors->get('program')" class="mt-2" />
            </div>

            <div class="mt-4">
                <div class="form-group">
                    <x-input-label for="courses" :value="__('Courses')" />
                    <select id="course-id" name="course" class="block mt-1 w-full rounded text-sm text-gray-700"
                        required>
                        <option disabled> select a program first</option>

                    </select>
                    @error('course')
                        <div class="error text-danger text-xs">{{ $message }}</div>
                    @enderror
                </div>
                <x-input-error :messages="$errors->get('course')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ml-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>

<script>
    $('#program-id').on('change', async (event) => {
        const programId = $(event.currentTarget).val();

        try {
            const response = await $.get(`api/courses/programs/${programId}`);
            const courses = response || response; 

            $('#course-id').empty().append(
                courses.map((course) => `<option value="${course.id}">${course.name}</option>`)
            );
        } catch (error) {
            console.error('Error fetching courses:', error);
        }
    });
</script>
