<div>
    <div class="contenedor">
        <link rel="stylesheet" href="./css/usuarios.css">
        <div class="botones">
            <div>
                <x-layouts.btnconfirmar contenido="Crear Usuario" enlace="register">
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
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>

                        <th>Modificación</th>
                        <th>Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $usuario)
                        @if ($usuario->rol->nombre != 'Dir Administrativo')
                            <tr>

                                <td class="filas-tabla">
                                    {{ $usuario->name }}
                                </td>

                                <td class="filas-tabla">
                                    {{ $usuario->email }}
                                </td>

                                <td class="filas-tabla">
                                    {{ $usuario->rol->nombre }}
                                </td>

                                <td class="filas-tabla">
                                    <div>
                                        @php
                                            $encryptedId = Crypt::encrypt($usuario->id);
                                        @endphp
                                        <x-layouts.btnenviodat rutaEnvio="adminedi" dato="{{ $encryptedId }}"
                                            nombre="Modificar">
                                        </x-layouts.btnenviodat>

                                    </div>
                                </td>
                                <td class="filas-tabla">
                                    <div>
                                        <form class="eli" action="{{ route('admineli', $usuario->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <x-layouts.btnelim contenido="Eliminar">
                                            </x-layouts.btnelim>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
            {{ $users->links() }}
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
