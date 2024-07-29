<div>
    <link rel="stylesheet" href="../css/clasificador.css">
   
    <form action=" {{ route('itemEjecutar') }}" method="POST">
        @csrf
        <div class="formulario">

            <div class="mt-4">
                <x-input-label for="partida-select" :value="__('Partida económica')" />
                <select id="partida-select" name="partida_id" required wire:model.live="partidaId">
                    <option value="">Seleccione una partida económica</option>
                    @foreach ($partidas as $partida)
                        <option value="{{ $partida->id }}">{{$partida->npartida}} {{ $partida->nombre }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('partida_id')" class="mt-2" />
            </div>
    
            <div class="mt-4">
                <x-input-label for="subpartida-select" :value="__('Sub partida económica')" />
                <select id="subpartida-select" name="subpartida_id" wire:model="subpartidaId" required>
                    @if ($subpartidas->count() == 0)
                        <option value="">Debe seleccionar una partida económica antes</option>
                    @endif
                    @foreach ($subpartidas as $sub)
                        <option value="{{ $sub->id }}">{{ $sub->npartida }} {{ $sub->nombre }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('subpartida_id')" class="mt-2" />
            </div>
            <input type="hidden" name="item_id" value="{{ $idItem }}">
    
            <div class="mt-4">
                <x-input-label for="cantidad" :value="__('Costo Total')" />
                <x-text-input id="precio" class="block mt-1 " type="number" name="precio"
                    :value="old('precio')" required autofocus autocomplete="precio" step="0.01" />
                <x-input-error :messages="$errors->get('precio')" class="mt-2" />
            </div>
    
            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-red-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('calsificarReque', $identificador) }}">
                    {{ __('Regresar') }}
                </a>
    
                <x-primary-button class="ms-4">
                    {{ __('Actualizar') }}
                </x-primary-button>
            </div>     
        </div>
           
    </form>
</div>
