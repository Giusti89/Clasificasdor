<x-guest-layout>
    <div class="contenido">
        <link rel="stylesheet" href="./css/nuevaCarrera.css">
        <!-- Name -->
        
        <h1> <b>Registro Nueva carrera</b></h1>
        <form method="POST" action="{{ route('storeCarrera') }}" >
            @csrf
            <div class="mt-4">
                <x-input-label for="name" :value="__('Nombre de la carrera')" />
                <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')"
                    required autofocus autocomplete="nombre" />
                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="name" :value="__('Presupuesto de la carrera')" />
                <input type="number" name="monto" id="monto" :value="old('monto')">
                <x-input-error :messages="$errors->get('monto')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-red-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('adminCarrera') }}">
                    {{ __('Regresar') }}
                </a>
    
                <x-primary-button class="ms-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>

        </form>

    </div>
</x-guest-layout>
