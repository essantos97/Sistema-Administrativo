<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />
        @if (session('msg'))    
             <div class="font-medium text-red-600">
                 {{ __('Opa! algo deu errado.') }}
            </div>                                       
            <ul class="mt-3 list-disc list-inside text-sm text-red-600">                                    
                <li>{{session('msg')}}</li>                    
            </ul>                               
        @endif  
        <form method="POST" action="{{ route('empresa.register') }}">
            @csrf

             <!-- CNPJ -->
             <div>
                <x-label for="cnpj" :value="__('CNPJ')" />

                <x-input id="cnpj" class="block mt-1 w-full" type="text" name="cnpj" :value="old('cnpj')"  autofocus />
            </div>

            <!-- Razão social -->
            <div>
                <x-label for="razao" :value="__('Razão Social')" />

                <x-input id="razao" class="block mt-1 w-full" type="text" name="razao" :value="old('razao')"  autofocus />
            </div>            

            <!-- Nome Fantasia -->
            <div>
                <x-label for="nomeFantasia" :value="__('Nome Fantasia')" />

                <x-input id="nomeFantasia" class="block mt-1 w-full" type="text" name="nomeFantasia" :value="old('nomeFantasia')"  autofocus />
            </div>

            <!-- CPF -->
            <div>
                <x-label for="telefone" :value="__('Telefone')" />

                <x-input id="telefone" class="block mt-1 w-full" type="tel" pattern="^\d{(2)}-\d{5}-\d{4}$" name="telefone" :value="old('telefone')"  autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"  autofocus="new-email"/>
            </div>

            <!-- Confirm Email Address -->
            <div class="mt-4">
                <x-label for="email_confirmation" :value="__('Confirmar Email')" />

                <x-input id="email_confirmation" class="block mt-1 w-full" type="email" name="email_confirmation"  autofocus/>
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
                                name="password_confirmation"  />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('empresa.login') }}">
                    {{ __('Já Tenho Uma Conta') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Registrar') }}
                </x-button>
            </div>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
