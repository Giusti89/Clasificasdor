<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Actualizar avatar de perfil') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Cambiar el avatar del perfil.') }}
        </p>
    </header>
    <div>
        <img style="width:500px;" src="./avatar/{{ Auth::user()->image_url }}" alt="">
    </div>
    <form method="post" action="{{ route('avatar.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Cargar Imagen')" />
            <input type="file" name="file" placeholder="file">
        </div>
       
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Guardar') }}</x-primary-button>

            
        </div>
    </form>
</section>
