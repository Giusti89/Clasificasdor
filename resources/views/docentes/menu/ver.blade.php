<x-guest-layout>
    <div class="contenido">
        <link rel="stylesheet" href="../css/item.css">
        <div class="titulo">
            <h1><b> SOLICITUD DE MATERIALES Y/O CONTRATACION DE SERVICIOS </b></h1>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Descripción</th>

                        @if (Auth::user()->rol_id == 1)
                            <th>Costo</th>
                        @endif

                        <th>Cantidad</th>

                        <th>Cotización</th>

                        @if (Auth::user()->rol_id == 1)
                            <th>P/Unitario</th>
                        @endif

                        @if (Auth::user()->rol_id == 1)
                            <th>Partida economica</th>
                        @endif

                        @if (Auth::user()->rol_id == 1)
                            <th>Acciónnn</th>
                        @endif

                        <th>Modificar</th>



                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td class="filas-tabla">
                                {{ $item->descripcion }}
                            </td>

                            @if (Auth::user()->rol_id == 1)
                                <td class="filas-tabla">

                                </td>
                            @endif

                            <td class="filas-tabla">
                                {{ $item->cantidad }}
                            </td>

                            <td class="filas-tabla">
                                <a href="../cotizacion/{{ $item->image_url }}" target="_blank">
                                    <img style="width:80px;height:auto ;"
                                        src="../cotizacion/{{ $item->image_url }}"alt="">
                                </a>
                            </td>

                            @if (Auth::user()->rol_id == 1)
                                <td class="filas-tabla">
                                    "precio unitario"
                                </td>
                            @endif
                            @if (Auth::user()->rol_id == 1)
                                <td class="filas-tabla">
                                    "partida economica"
                                </td>
                            @endif
                            @if (Auth::user()->rol_id == 1)
                                <td class="filas-tabla">
                                    "accion"
                                </td>
                            @endif


                            <td class="filas-tabla">
                                "modificar"
                            </td>



                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $items->links() }}
        </div>
        <div class="mt-4">
            <a class="underline text-sm text-red-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('publicoIndex') }}">
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
