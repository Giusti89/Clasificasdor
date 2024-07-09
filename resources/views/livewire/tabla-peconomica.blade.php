<div>

    <div class="contenedor">
        <link rel="stylesheet" href="../../css/usuarios.css">
        <div class="botones">
            <div>
                <x-layouts.btnconfirmar contenido="Nueva Partida" enlace="administracion.peconomica.nuevo">
                </x-layouts.btnconfirmar>
            </div>
            <div>
                <label for="filtro">Filtrar por nombre: </label>
                <input type="text" wire:model.live="search">
            </div>
            <div>
                <label for="filtro">Paginas: </label>
                <input type="number" wire:model.live="paginate" min="1">
            </div>
        </div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>

                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Presupuesto</th>
                        <th>Agregar subpartidas</th>
                        <th>Modificar</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($teco as $teconomica)
                        <tr>

                            <td class="filas-tabla">
                                {{ $teconomica->npartida }}
                            </td>

                            <td class="filas-tabla">
                                {{ $teconomica->nombre }}
                            </td>
                            <td class="filas-tabla">
                                {{ $teconomica->descripcion }}
                            </td>
                            <td class="filas-tabla">
                                {{ $teconomica->presupuesto }}
                            </td>

                            <td class="filas-tabla">
                                <div>
                                    @php
                                        $encryptedId = Crypt::encrypt($teconomica->id);
                                    @endphp
                                    <a href="{{ route('subparIndex', $encryptedId) }}">
                                        <button type="button" class="asigna">
                                            Asignar Partidas
                                        </button>
                                    </a>
                                </div>
                            </td>
                            <td class="filas-tabla">
                                <div>
                                    @php
                                        $encryptedId = Crypt::encrypt($teconomica->id);
                                    @endphp
                                    <x-layouts.btnenviodat rutaEnvio="editTeco" dato="{{ $encryptedId }}"
                                        nombre="Modificar datos">
                                    </x-layouts.btnenviodat>
                                </div>
                            </td>
                            <td class="filas-tabla">
                                <div>
                                    <form class="eli" action="{{ route('eliTeco', $teconomica->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <x-layouts.btnelim contenido="Eliminar">
                                        </x-layouts.btnelim>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $teco->links() }}
        </div>
    </div>
    @section('js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $('.eli').submit(function(e) {
                e.preventDefault()

                Swal.fire({
                    title: "¿Estas seguro de eliminar esta carrera?",
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
</div>
