<x-guest-layout>

    <div class="contenido">
        <link rel="stylesheet" href="../css/nuevaCarrera.css">
        <!-- Name -->
        <div class="titulo">
            <h1> <b>Modificar datos carrera</b></h1>
        </div>

        <form method="POST" action="{{ route('updateSubeco', $peco->id) }}">
            @csrf
            @method('patch')

            <div class="mt-4">
                <x-input-label for="nombre" :value="__('Nombre de la partida económica')" />
                <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre', $peco->nombre)"
                    required autofocus autocomplete="nombre" />
                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="codigo" :value="__('Código de la partida económica')" />
                <x-text-input id="codigo" class="block mt-1 w-full" type="number" name="codigo" :value="old('codigo', $peco->npartida)"
                    required autofocus autocomplete="codigo" />
                <x-input-error :messages="$errors->get('codigo')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="presupuesto" :value="__('Presupuesto de la partida económica')" />
                <x-text-input id="presupuesto" class="block mt-1 w-full" type="number" name="presupuesto"
                    :value="old('presupuesto', $peco->monto)" autofocus autocomplete="presupuesto" readonly />
                <x-input-error :messages="$errors->get('presupuesto')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="agregar" :value="__('Agregar presupuseto a la partida económica')" />
                <x-text-input id="agregar" class="block mt-1 w-full" type="number" name="agregar" :value="old('agregar')"
                    autofocus autocomplete="agregar" />
                <x-input-error :messages="$errors->get('agregar')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="descripcion" :value="__('Descripción de la partida económica')" />
                <textarea name="descripcion" id="descripcion" cols="30" rows="10">{{ old('descripcion', $peco->descripcion) }}</textarea>
                <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                @php
                    $encryptedId = Crypt::encrypt($peco->teconomica_id);
                @endphp
                <a class="underline text-sm text-red-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('subparIndex', $encryptedId) }}">
                    {{ __('Regresar') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ __('Actualizar') }}
                </x-primary-button>
            </div>
        </form>


    </div>
    <script src="../../js/datosCarrera.js"></script>
</x-guest-layout>
