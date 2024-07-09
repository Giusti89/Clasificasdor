<x-guest-layout>
    <div class="contenido">
        <link rel="stylesheet" href="../css/nuevopedi.css">
        <!-- Name -->
        <div class="titulo">
            <h1> <b>SOLICITUD DE MATERILES Y/O CONTRATACIÓN DE SERVICIOS</b></h1>
        </div>
        <form method="POST" action="{{ route('updateSolicitud', Crypt::encrypt($solicitud->id)) }}">
            @csrf
            @method('patch')
            
            <div class="conteform">
                <div>
                    <h2>Por favor introduzca una descripcion general de la solicitud a realizar (Justificacion del pedido)</h2>
                </div>
                <div class="mt-4">
                    <textarea required name="descripcion" id="descripcion" cols="35" rows="10">{{ $solicitud->descripcion }}</textarea>
                    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>
                @if ($rol == 'Jefe de carrera')
                    <div class="mt-4">
                        <x-input-label for="carrera" :value="__('Seleccione la carrera')" />
                        <select required id="carrera" name="carrera" class="selector w-full" autofocus autocomplete="carrera">
                            <option value=""></option>
                            @foreach ($prueba as $nombre => $id)
                                <option value="{{ $id }}" {{ $solicitud->carrera_id == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('carrera')" class="mt-2" />
                    </div>
                @else
                    <select style="display: none;" required id="carrera" name="carrera" class="selector w-full" autofocus autocomplete="carrera">
                        @foreach ($prueba as $nombre => $id)
                            <option value="{{ $id }}" {{ $solicitud->carrera_id == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                        @endforeach
                    </select>
                @endif

                <div class="flex items-center justify-end mt-4">
                    <a class="underline text-sm text-red-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('publicoIndex') }}">
                        {{ __('Regresar') }}
                    </a>
                    <x-primary-button class="ms-4">
                        {{ __('Actualizar') }}
                    </x-primary-button>
                </div>
            </div>
        </form>
    </div>
</x-guest-layout>