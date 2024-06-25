<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- sweet alerrt --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- sweet alerrt --}}
    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <div class="contenido mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg ">
            <!-- mensajes de confirmacion -->
            @if (session('msj') == 'ok')
                <script>
                    Swal.fire({
                        title: "Eliminado",
                        text: "Eliminación exitosa.",
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
            {{ $slot }}
        </div>
    </div>
    {{-- sweet alerrt --}}
    @yield('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    {{-- sweet alerrt --}}
</body>

</html>
