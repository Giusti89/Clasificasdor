<div>
    <div>
        <div class="contenedor">
            <link rel="stylesheet" href="./css/usuarios.css">
            <div class="botones">
                <div>
                    <x-layouts.btnconfirmar contenido="Nueva solicitud" enlace="docentes.pedidos.index">
                    </x-layouts.btnconfirmar>
                </div>
                <div>
                    <label for="filtro">Filtrar por mes: </label>
                    <input type="month" wire:model="searchMonth">
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
                            @if (Auth::user()->rol_id == 1)
                                <th>carrera</th>
                            @endif
                            <th>Descripcion</th>
                            <th>Estado</th>
                            <th>Registro</th>
                            <th>Modificación</th>
                            <th>Acción</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requerimientos as $requerimiento)
                            <tr>
                                @if (Auth::user()->rol_id == 1)
                                    <td> {{ $requerimiento->carrera->nombre }}</td>
                                @endif
                                <td class="filas-tabla">
                                    {{ $requerimiento->descripcion }}
                                </td>
                                <td class="filas-tabla">
                                    {{ $requerimiento->estado }}
                                </td>
                                <td class="filas-tabla">
                                    {{ $requerimiento->created_at->format('d-m-Y') }}
                                </td>
                                <td class="filas-tabla">
                                    <div>
                                        @php
                                            $encryptedId = Crypt::encrypt($requerimiento->id);
                                        @endphp
                                        <x-layouts.btnenviodat rutaEnvio="editSolicitud" dato="{{  $encryptedId }}"
                                            nombre="Modificar">
                                        </x-layouts.btnenviodat>
                                    </div>
                                </td>
                                @if ($requerimiento->estado == 'pendiente')
                                    <td>
                                        @php
                                            $encryptedId = Crypt::encrypt($requerimiento->id);
                                        @endphp
                                        <a href="{{ route('editSolicitud', $encryptedId) }}">
                                            <button type="button" class="asigna">
                                                Llenar
                                            </button>
                                        </a>
                                    </td>
                                @endif


                                <td class="filas-tabla">
                                    <div>
                                        <form class="eli" action="{{ route('destroySolicitud', Crypt::encrypt($requerimiento->id)) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <x-layouts.btnelim contenido="Eliminar"></x-layouts.btnelim>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $requerimientos->links() }}
            </div>
        </div>
        @section('js')
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $('.eli').submit(function(e) {
                    e.preventDefault()

                    Swal.fire({
                        title: "¿Estas seguro de eliminar este usuario?",
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
</div>
