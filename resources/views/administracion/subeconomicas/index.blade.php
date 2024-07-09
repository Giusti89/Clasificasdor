<x-guest-layout>
    <div class="contenido">
        <link rel="stylesheet" href="../css/nuevaSub.css">
        <!-- Name -->
        <div class="titulo">
            <h1><b> Asignar sub partidas económicas:{{ $sub->nombre }}, <br> codigo: {{ $sub->npartida }} </b></h1>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Codigo</th>
                        <th>Descripción</th>
                        <th>Presupuseto</th>
                        <th>Modificar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subpartidas as $partidas)
                        <tr>
                            <td class="filas-tabla">{{ $partidas->nombre }}</td>
                            <td class="filas-tabla">{{ $partidas->npartida }}</td>
                            <td class="filas-tabla" id="des">{{ $partidas->descripcion }}</td>
                            <td class="filas-tabla">{{ $partidas->monto }}</td>
                            <td class="filas-tabla">
                                <div>
                                    @php
                                        $encryptedId = Crypt::encrypt($partidas->id);
                                    @endphp
                                    <x-layouts.btnenviodat rutaEnvio="editSubeco" dato="{{ $encryptedId }}"
                                        nombre="Modificar datos">
                                    </x-layouts.btnenviodat>
                                </div>
                            </td>
                            <td class="filas-tabla">
                                <form class="eli" action="{{ route('eliSubeco', $partidas->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-layouts.btnelim contenido="Eliminar"></x-layouts.btnelim>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $subpartidas->links() }}
        </div>
        <div class="conteform">
            <div class="formulario">
                <div class="titulo">
                    <h1> <b>Registro sub Partida Económica</b></h1>
                </div>

                <form action="{{ route('storeSubecono', $id) }}" method="POST">
                    @csrf
                    <div class="mt-4">
                        <x-input-label for="nombre" :value="__('Nombre de la partida económica')" />
                        <x-text-input id="nombre" class="block mt-1 w-14" type="text" name="nombre"
                            :value="old('nombre')" required autofocus autocomplete="nombre" />
                        <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="codigo" :value="__('Código de la partida económica')" />
                        <x-text-input id="codigo" class="block mt-1 w-14" type="number" name="codigo"
                            :value="old('codigo')" required autofocus autocomplete="codigo" />
                        <x-input-error :messages="$errors->get('codigo')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="monto" :value="__('Presupuesto de la partida económica')" />
                        <input type="number" name="monto" id="monto" :value="old('monto')">
                        <x-input-error :messages="$errors->get('monto')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="descripcion" :value="__('Descripción de la partida económica')" />
                        <textarea name="descripcion" class="descripcion" id="descripcion" cols="30" rows="10">
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
        </div>

    </div>
    @section('js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $('.eli').submit(function(e) {
                e.preventDefault()

                Swal.fire({
                    title: "¿Quieres elimiar al docente?",
                    text: "¡No podrás revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, eliminar"
                }).then((result) => {
                    if (result.value) {
                        this.submit();
                    }
                });
            });
        </script>
    @endsection
</x-guest-layout>
