<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Nome')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" autofocus />
            </div>

            <!-- Surname -->
            <div>
                <x-label for="surname" :value="__('Sobrenome')" />

                <x-input id="surname" class="block mt-1 w-full" type="text" name="surname" :value="old('surname')" autofocus />
            </div>

            <!-- CPF -->
            <div>
                <x-label for="cpf" :value="__('CPF')" />

                <x-input id="cpf" class="block mt-1 w-full" type="text" name="cpf" :value="old('cpf')" autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" autofocus/>
            </div>

            <!-- Confirm Email Address -->
            <div class="mt-4">
                <x-label for="email_confirmation" :value="__('Confirmar Email')" />

                <x-input id="email_confirmation" class="block mt-1 w-full" type="email" name="email_confirmation" autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Senha')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirmar Senha')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" />
            </div>

            <div class="flex items-center justify-end mt-4">                
                <x-button class="ml-4">
                    {{ __('Registrar') }}
                </x-button>
            </div>
        </form>       
    </x-auth-card>
</x-guest-layout>
