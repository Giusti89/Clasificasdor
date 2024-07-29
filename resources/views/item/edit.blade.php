<x-guest-layout>
    <div class="contenido">
        <link rel="stylesheet" href="../css/item.css">
        <div class="conteform">
            <div class="formulario">
                <div class="titulo">
                    <h1> <b>Registra un item y/o servicio a la solicitud</b></h1>
                </div>
                
                <form method="POST" action="{{ route('updateItem', $encryptedId) }}" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <div class="mt-4">
                        <x-input-label for="cantidad" :value="__('Cantidad')" />
                        <x-text-input id="cantidad" class="block mt-1 w-full" type="number" name="cantidad"
                            value="{{ $item->cantidad }}" required autofocus autocomplete="cantidad" />
                        <x-input-error :messages="$errors->get('cantidad')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="name" :value="__('Descripcion del insumo/servicio')" />
                        <textarea name="descripcion" id="descripcion" cols="30" rows="10" class="w-full">{{ $item->descripcion }}</textarea>
                        <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <a href="../cotizacion/{{ $item->image_url }}" target="_blank">
                            <img style="width:400px;height:auto ;" src="../cotizacion/{{ $item->image_url }}"alt="">
                        </a>
                    </div>

                    <div class="mt-4">
                        <label for="">Remplazar cotización del insumo</label><br>
                        <input type="file" name="file" class="w-full">
                    </div>

                    <div class="flex items-center  mt-4">
                        <x-primary-button class="mb-4">
                            {{ __('Register') }}
                        </x-primary-button>

                        <a class="underline text-sm text-red-600 ml-4 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            href="{{ route('vistacorreccion', Crypt::encrypt($item->requerimiento_id)) }}">
                            {{ __('Regresar') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-guest-layout>
