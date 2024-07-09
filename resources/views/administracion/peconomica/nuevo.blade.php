<x-guest-layout>
    <div class="contenido">
        <link rel="stylesheet" href="./css/nuevaCarrera.css">
        <!-- Name -->

        <h1> <b>Registro Nueva Partida Económica</b></h1>
        <form method="POST" action="{{ route('storeTecono') }}">
            @csrf

            <div class="mt-4">
                <x-input-label for="nombre" :value="__('Nombre de la partida económica')" />
                <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')"
                    required autofocus autocomplete="nombre" />
                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="codigo" :value="__('Código de la partida económica')" />
                <x-text-input id="codigo" class="block mt-1 w-full" type="number" name="codigo" :value="old('codigo')"
                    required autofocus autocomplete="codigo" />
                <x-input-error :messages="$errors->get('codigo')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="presupuesto" :value="__('Presupuesto de la partida económica')" />
                <input type="number" name="presupuesto" id="presupuesto" :value="old('presupuesto')">
                <x-input-error :messages="$errors->get('presupuesto')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="descripcion" :value="__('Descripción de la partida económica')" />
                <textarea name="descripcion" id="descripcion" cols="30" rows="10">
                </textarea>                
                <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-red-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('teconomicaCarrera') }}">
                    {{ __('Regresar') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>

        </form>

    </div>
</x-guest-layout>
