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
                <x-label for="name" value="Nome do Titular" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="cardNumber" value="Número do Cartão" />
                <x-input id="cardNumber" class="block mt-1 w-full" type="text" name="cardNumber" :value="old('cardNumber')" required />
            </div>
            
            
            <div class="flex items-center justify-end mt-4">
                <div class="mr-1">
                    <x-label for="expirationDate" value="Data de Vencimento" />
                    <x-input id="expirationDate" class="block mt-1 w-full" type="text" name="expirationDate" :value="old('expirationDate')" required />
                </div>
                <div class="ml-1">
                    <x-label for="ccv" value="Código" />
                    <x-input id="ccv" class="block mt-1 w-full" type="text" name="ccv" :value="old('ccv')" required />
                </div>
            </div>           
            
            

            <div class="flex items-center justify-end mt-4 w-full">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    Cancelar
                </a>

                <x-button-success class="ml-4 btn-success">
                    Fazer Assinatura
                </x-button-success>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
