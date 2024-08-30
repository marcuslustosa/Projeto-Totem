<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <img class="img-fluid for-light" src="{{asset('assets/images/logo/login.png')}}" alt="loginpage">
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" value="Nome" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" value="Email" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>
            <div class="row">
                <div class="mb-3 col-lg-6 col-12">
                    <label class="col-form-label">Nome</label>
                    <input class="form-control input-air-primary" type="text" placeholder="nome" id="name" name="name" value="{{ $lead->name }}">
                </div>
                <div class="mb-3 col-lg-6 col-12">
                    <label class="col-form-label">Email</label>
                    <input class="form-control input-air-primary" type="email" placeholder="email" id="email" name="email" value="{{ $lead->email }}">
                </div>
            </div>
            
            <div class="mt-4">
                <x-label for="cnpj" value="CNPJ" />
                <x-input id="cnpj" class="block mt-1 w-full" type="text" name="cnpj" :value="old('cnpj')" required />
            </div>
            <div class="mt-4">
                <x-label for="trade-name" value="Razão Social" />
                <x-input id="trade_name" class="block mt-1 w-full" type="text" name="trade_name" :value="old('trade_name')" required />
            </div>
            <div class="mt-4">
                <x-label for="phone" value="Telefone" />
                <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
            </div>
            <div class="mt-4">
                <x-label for="whatsapp" value="WhatsApp" />
                <x-input id="whatsapp" class="block mt-1 w-full" type="text" name="whatsapp" :value="old('whatsapp')" required />
            </div>
            <div class="mt-4">
                <x-label for="logo_color" value="Logo Colorido" />                
                <x-input id="logo_color" class="block mt-1 w-full" id="logo_color" name="logo_color" :value="old('logo_color')" required type="file" accept="image/png,image/jpg, image/jpeg"/>
            </div>
            <div class="mt-4">
                <x-label for="logo_light" value="Logo Branco" />
                <x-input id="logo_light" class="block mt-1 w-full" id="logo_light" name="logo_light" :value="old('logo_light')" required type="file" accept="image/png,image/jpg, image/jpeg"/>
            </div>
            <div class="mt-4">
                <x-label for="logo_dark" value="Logo Preto" />
                <x-input id="logo_dark" class="block mt-1 w-full" id="logo_dark" name="logo_dark" :value="old('logo_dark')" required type="file" accept="image/png,image/jpg, image/jpeg"/>
            </div>
            <div class="mt-4">
                <x-label for="slug" value="Slug" />
                <x-input id="slug" class="block mt-1 w-full" type="text" name="slug" :value="old('slug')" required />
            </div>
            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" value="Senha" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" value="Confirmar Senha" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    Já tem cadastro?
                </a>

                <x-button class="ml-4">
                    Cadastrar
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
