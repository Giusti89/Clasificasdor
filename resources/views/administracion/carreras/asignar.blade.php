<x-guest-layout>
    <div class="contenido">
        <link rel="stylesheet" href="../css/asignar.css">
        <div class="titulo">
            <h1><b> Asignar Docentes a la Carrera: {{ $carrera->nombre }}</b></h1>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Docente</th>
                        <th>Cargo</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuariosAsignados as $usuario)
                        <tr>
                            <td class="filas-tabla">{{ $usuario->name }}</td>
                            <td class="filas-tabla">{{ $usuario->rol->nombre }}</td>
                            <td class="filas-tabla">
                                <form class="eli" action="{{ route('eliminarUsuarioCarrera', [$carrera->id, $usuario->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-layouts.btnelim contenido="Eliminar"></x-layouts.btnelim>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $usuariosAsignados->links() }}
        </div>

        <div class="formulario">
            <div class="titulo">
                <h1><b> Asignar Docentes</b></h1>
            </div>
           
            <form action="{{ route('asignarUsuarioCarrera', $carrera->id) }}" method="POST">
                @csrf
                <div class="mt-4">
                    <x-input-label for="user-select" :value="__('Docente')" />
                    <select id="user-select" name="user_id" required>
                        <option value="">Seleccione un docente</option>
                        @foreach ($usuariosDisponibles as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                </div>
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-4">{{ __('Asignar') }}</x-primary-button>
                </div>
            </form>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-red-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
               href="{{ route('adminCarrera') }}">
                {{ __('Regresar') }}
            </a>
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
