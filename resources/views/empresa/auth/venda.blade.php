<x-empresa-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('empresa.venda') }}">
            @csrf
            <h1 class="center">Digite o Valor da Venda</h1>
            <!-- Name -->
            <div>                

                <x-input id="valor" class="block mt-1 w-full" type="number"  min="1" step="0.01" name="valor" :value="old('valor')" autofocus />
            </div>
            
            <div class="flex items-center justify-end mt-4">
                <a class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 border border-red-700 rounded"
                 href="{{ route('empresa.dashboard') }}">
                    {{ __('Cancelar') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Confirmar') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-empresa-guest-layout>

