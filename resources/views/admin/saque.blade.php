<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('admin.saque') }}">
            @csrf
            <h1 class="center">Número da Conta</h1>
            <!-- Name -->
            <div>                
                <x-input id="num_conta" class="block mt-1 w-full" type="number"  min="1" name="num_conta" :value="old('num_conta')" autofocus />
            </div>

            <h1 class="center">Valor do Saque</h1>
            <!-- Name -->
            <div>                
                <x-input id="valor" class="block mt-1 w-full" type="number"  step="0.01" name="valor" :value="old('valor')" autofocus />
            </div>
            
            <div class="flex items-center justify-end mt-4">
                <a class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 border border-red-700 rounded"
                 href="{{ route('dashboard') }}">
                    {{ __('Cancelar') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Confirmar') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>

