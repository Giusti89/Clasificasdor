<x-guest-layout>

    <div class="contenido">
        <link rel="stylesheet" href="../../css/nuevaCarrera.css">
        <!-- Name -->
        <div class="titulo">
            <h1> <b>Modificar datos carrera</b></h1>
        </div>

        <form method="POST" action="{{ route('updateCarrera', $datos->id) }}">
            @csrf
            @method('patch')

            <div class="mt-4">
                <x-input-label for="name" :value="__('Nombre de la carrera')" id="txtname"  />
                <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre', $datos->nombre)"
                    required autofocus autocomplete="nombre" />
                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="monto" :value="__('Presupuesto actual de la carrera')" id="txtmonto" />

                <x-text-input id="monto" class="block mt-1 w-full" type="number" name="monto" :value="old('monto', $datos->presupuesto)"
                    required autofocus readonly autocomplete="monto" />
                <x-input-error :messages="$errors->get('monto')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="agregar" :value="__('Agregar presupuesto')" id="txtagregar"/>

                <x-text-input id="agregar" class="block mt-1 w-full" type="number" name="agregar" :value="old('agregar')"
                    autofocus autocomplete="agregar" />
                <x-input-error :messages="$errors->get('agregar')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="reducir" :value="__('Reducir presupuesto')" id="txtreducir" />
                <x-text-input id="reducir" class="block mt-1 w-full" type="number" name="reducir" :value="old('reducir')"
                    autofocus autocomplete="monto" />
                <x-input-error :messages="$errors->get('reducir')" class="mt-2" />
            </div>


            <div class="mt-4 titulo">
                <h1> <b>Transferencia de presupuestos </b></h1>
            </div>
        <input type="checkbox" id="transferir">
            {{-- transferir recursos economicos entre carreras  --}}
            <div class="transferencia" id="transferencia">
                <div class="mt-4">
                    <label for="carrera_id"> Seleccionar Carrera</label>
                    <select id="carrera_id" name="carrera_id" class="block mt-1 w-full">
                        <option value="">Selecciona una carrera</option>
                        @foreach ($carreras as $carrera)
                            <option value="{{ $carrera->id }}" data-presupuesto="{{ $carrera->monto }}">
                                {{ $carrera->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <label for="presupuesto">Presupuesto actual de la carrera</label>
                    <input id="presupuesto" class="block mt-1 w-full" type="number" name="presupuesto" readonly
                        autocomplete="presupuesto" />
                </div>

                <div class="mt-4">
                    <x-input-label for="name" :value="__('Transferir presupuesto')" />
                    <x-text-input id="trasnferir" class="block mt-1 w-full" type="number" name="trasnferir"
                        :value="old('trasnferir')" autofocus autocomplete="trasnferir" />
                    <x-input-error :messages="$errors->get('trasnferir')" class="mt-2" />
                </div>

                {{-- transferir recursos economicos entre carreras  --}}
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
    <script src="../../js/datosCarrera.js"></script>
</x-guest-layout>
