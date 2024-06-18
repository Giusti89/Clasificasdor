<x-guest-layout>
    <link rel="stylesheet" href="../css/loginn.css">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <section>
        <div class="contenedor">
            <div class="login">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="titulo">
                        <h1>Inicio</h1>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <label for="">Email</label>
                        <input type="email" required id="email" name="email" :value="old('email')" required
                            autofocus autocomplete="username">                        
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="inputbox">
                        <label for="">Contraseña</label>

                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="password" required id="password" name="password" autocomplete="current-password">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="forget">
                        <a href="{{ route('password.request') }}">Olvide la contraseña</a>
                    </div>
                    <button>
                        <p>Iniciar</p>
                    </button>
                </form>

            </div>
            <div class="bienvenida">
                <div class="titulo">
                    <h1>Instituto Tecnológico Ayacucho</h1>
                   
                </div>
                <p>
                    Sistema administrativo para la solicitud de insumos o servicios institucionales
                </p>
            </div>

        </div>

    </section>

</x-guest-layout>
