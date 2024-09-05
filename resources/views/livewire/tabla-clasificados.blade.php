<div>
    <div>
        <div>
            <div class="contenedor">
                <link rel="stylesheet" href="./css/usuarios.css">
                <div class="botones">

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
                                @if (Auth::user()->rol_id == 1 || Auth::user()->rol_id == 2)
                                    <th>Carrera</th>
                                @endif
                                <th>Descripcion</th>
                                <th>Registro</th>
                                <th>Verificar</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($requerimientos as $requerimiento)
                                <tr>
                                    @if (Auth::user()->rol_id == 1 || Auth::user()->rol_id == 2)
                                        <td> {{ $requerimiento->carrera->nombre }}</td>
                                    @endif

                                    <td class="filas-tabla">
                                        {{ $requerimiento->descripcion }}
                                    </td>

                                    <td class="filas-tabla">
                                        {{ $requerimiento->created_at->format('d-m-Y') }}
                                    </td>

                                    <td>
                                        @php
                                            $encryptedId = Crypt::encrypt($requerimiento->id);
                                        @endphp
                                        <a href="{{ route('verIndex', $encryptedId) }}">
                                            <button type="button" class="asigna">
                                                Ver
                                            </button>
                                        </a>
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
                            title: "¿Estas seguro de eliminar esta solicitud?",
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
</div>
