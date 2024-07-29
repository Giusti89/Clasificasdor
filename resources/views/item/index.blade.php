<x-guest-layout>
    <div class="contenido">
        <link rel="stylesheet" href="../css/item.css">
        <div class="terminar">
            <form action="POST">
                @csrf
                <div class="mb-4">
                    @php
                        $encryptedId = Crypt::encrypt($id);
                    @endphp
                    @if ($reque->estado == 'pendiente')
                        <x-layouts.btnswett rutaEnvio="listoLlenar" dato="{{ $encryptedId }}" nombre="Listo"
                            cl="btn-listo" />
                    @elseif ($reque->estado == 'listo')
                        <x-layouts.btnenviodat rutaEnvio="aprobarLlenar" dato="{{ $encryptedId }}" nombre="Aprobar">
                        </x-layouts.btnenviodat>
                    @elseif ($reque->estado == 'aprovado')
                        <x-layouts.btnenviodat rutaEnvio="listoLlenar" dato="{{ $encryptedId }}" nombre="Clasificar">
                        </x-layouts.btnenviodat>
                    @elseif ($reque->estado == 'clasificado')
                        <x-layouts.btnenviodat rutaEnvio="listoLlenar" dato="{{ $encryptedId }}" nombre="Ver">
                        </x-layouts.btnenviodat>
                    @endif

                </div>
            </form>
        </div>
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

                        <th>Eliminar</th>


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

                            <td class="filas-tabla">
                                <form class="eli" action="{{ route('destroyLlenar', Crypt::encrypt($item->id)) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-layouts.btnelim contenido="Eliminar"></x-layouts.btnelim>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $items->links() }}
        </div>
        @if (Auth::user()->rol_id != 4)
            <div class="conteform">
                <div class="formulario">
                    <div class="titulo">
                        <h1> <b>Registra un item y/o servicio a la solicitud</b></h1>
                    </div>

                    <form method="POST" action="{{ route('storeLlenar', Crypt::encrypt($id)) }}"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="mt-4">
                            <x-input-label for="cantidad" :value="__('Cantidad')" />
                            <x-text-input id="cantidad" class="block mt-1 w-full" type="number" name="cantidad"
                                :value="old('cantidad')" required autofocus autocomplete="cantidad" />
                            <x-input-error :messages="$errors->get('cantidad')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="name" :value="__('Descripcion del insumo/servicio')" />
                            <textarea name="descripcion" id="descripcion" cols="30" rows="10" class="w-full">{{ old('descripcion') }}</textarea>
                            <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <label for="">Cotización del insumo</label><br>
                            <input type="file" name="file" class="w-full">
                        </div>

                        <div class="flex items-center  mt-4">
                            <x-primary-button class="mb-4">
                                {{ __('Register') }}
                            </x-primary-button>

                            <a class="underline text-sm text-red-600 ml-4 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                href="{{ route('publicoIndex') }}">
                                {{ __('Regresar') }}
                            </a>
                        </div>
                    </form>



                </div>

            </div>
        @endif
        @if (Auth::user()->rol_id == 4)
            <a class="underline text-sm text-red-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                href="{{ route('publicoIndex') }}">
                {{ __('Regresar') }}
            </a>
        @endif
    </div>

    @section('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $('.eli').submit(function(e) {
                e.preventDefault();

                Swal.fire({
                    title: "¿Quieres eliminar este articulo?",
                    text: "¡No podrás revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, eliminar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });

            $('button.modificar').click(function(e) {
                e.preventDefault();
                let url = $(this).data('url');

                Swal.fire({
                    title: "¿Estás seguro que quieres dar de alta esta solicitud?",
                    text: "¡No podrás agregar mas itmes a la solicitud!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, confirmar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        </script>
    @endsection
</x-guest-layout>
