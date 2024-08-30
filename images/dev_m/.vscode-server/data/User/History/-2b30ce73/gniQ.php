<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <img class="img-fluid for-light" src="{{asset('assets/images/logo/login.png')}}" alt="loginpage">
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('subscription') }}" enctype="multipart/form-data">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" value="Nome no Cartão" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" value="Número do Cartão" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>
            <div class="mt-4">

                <div>
                    <x-label for="cnpj" value="CNPJ" />
                    <x-input id="cnpj" class="block mt-1 w-full" type="text" name="cnpj" :value="old('cnpj')" required />
                </div>
                <div>
                    <x-label for="trade-name" value="Razão Social" />
                    <x-input id="trade_name" class="block mt-1 w-full" type="text" name="trade_name" :value="old('trade_name')" required />
                </div>
            </div>    
            
            <div class="mt-4">
                <x-label for="phone" value="Telefone" />
                <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
            </div>
            <div class="mt-4">
                <x-label for="whatsapp" value="WhatsApp" />
                <x-input id="whatsapp" class="block mt-1 w-full" type="text" name="whatsapp" :value="old('whatsapp')" required />
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
