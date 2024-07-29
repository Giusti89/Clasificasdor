<x-guest-layout>
    <div class="contenido">
        <link rel="stylesheet" href="../css/nuevopedi.css">
        <!-- Name -->
        <div class="titulo">
            <h1> <b>Observaciones de los requeriminetos</b></h1>

        </div>
        
        <form method="POST" action="{{ route('storeobservacion', $encryptedId) }}">
            @csrf
            <div class="conteform">
                <div>
                    <h2>Por favor introduzca las observaciones de la solicitud para ser corregidas.</h2>
                </div>
                
                <div class="mt-4">
                    <textarea required name="observacion" id="observacion" cols="35" rows="10">
                    </textarea>
                    <x-input-error :messages="$errors->get('observacion')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    @php
                        $encryptedId = Crypt::encrypt($item->id);
                    @endphp
                    <a class="underline text-sm text-red-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('vistallenarSol',$encryptedId) }}">
                        {{ __('Regresar') }}
                    </a>

                    <x-primary-button class="ms-4">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </div>
        </form>

    </div>
</x-guest-layout>
