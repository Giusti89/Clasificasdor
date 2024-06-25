<x-guest-layout>

    <div>
        <a href="/">
           <img style="width: 250px;" src="../img/ita_logo.png" alt="">
        </a>
    </div>

    <form method="post" action="{{ route('adminedi.update', $user->id) }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')
        <div>
            <h1 style="color: red"> <b>Modificar datos del Usuario</b> </h1>
        </div>
        <div>
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required
                autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)"
                required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />
        </div>

        <div class="mt-4">
            <x-input-label for="rol" :value="__('Rol')" />
            <select id="rol" name="rol" class="selector w-full" autofocus autocomplete="rol">
                <option value=""></option>
                @foreach ($rol as $nombre => $id)
                    <option value="{{ $id }}" {{ $user->rol_id == $id ? 'selected' : '' }}>{{ $nombre }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Nuevo Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" 
                autocomplete="password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <!-- Foto de perfil -->
        <div class="mt-4">
            <img style="width:190px;height:auto ;" src="../avatar/{{ $user->image_url }}" alt="foto perfil">
        </div>
        <div class="mt-4">
            <input type="file" name="file" placeholder="file">
        </div>


        <div class="flex items-center gap-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
            href="{{ route('adminIndex') }}">
            {{ __('Regresar') }}
        </a>
            <x-primary-button>{{ __('Guardar') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>

        
    </form>


</x-guest-layout>
