<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title> @yield('titulo') </title>
    @livewireStyles
</head>

<body>

    <!-- mensajes de confirmacion -->
    @if (session('msj') == 'ok')
        <script>
            Swal.fire({
                title: "Eliminado",
                text: "Su archivo ha sido eliminado.",
                icon: "success"
            });
        </script>
    @endif

    @if (session('msj') == 'cambio')
        <script>
            Swal.fire({
                title: "Correcto",
                text: "Su solicitud a sido ejecutada.",
                icon: "success"
            });
        </script>
    @endif

    @if (session('msj') == 'prohibido')
        <script>
            Swal.fire({
                title: "NO TIENES LOS PERMISOS",
                text: "Su solicitud no puede ser ejecutada.",
                icon: "warning"
            });
        </script>
    @endif

    @if (session('msj') == 'error')
        <script>
            Swal.fire({
                title: "OPERACION NO PERMITIDA",
                text: "Su solicitud no puede ser ejecutada.",
                icon: "warning"
            });
        </script>
    @endif

    <!-- mensajes de confirmacion -->
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                @yield('nombre')
            </h2>
        </x-slot>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                       
                        @yield('contenido')

                    </div>
                </div>
            </div>
        </div>

        @livewireScripts
    </x-app-layout>
</body>

</html>