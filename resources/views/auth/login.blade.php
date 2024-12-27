<x-guest-layout>
    <head>
        <!-- Styles -->
    </head>
    <body class="login-background min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white bg-opacity-90 p-6 rounded-lg shadow-lg">
            <!-- Title -->
            <h1 class="text-2xl font-bold text-center text-green-700 mb-4">Login to Farmer Management System</h1>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input id="email" 
                        class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autofocus 
                        autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input id="password" 
                        class="block mt-1 w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" 
                        type="password" 
                        name="password" 
                        required 
                        autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center mb-4">
                    <input id="remember_me" 
                        type="checkbox" 
                        class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500" 
                        name="remember">
                    <label for="remember_me" class="ml-2 text-sm text-gray-700">Remember me</label>
                </div>

                <!-- Forgot Password & Submit -->
                <div class="flex items-center justify-between">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-green-600 hover:text-green-700">
                            Forgot your password?
                        </a>
                    @endif

                    <button type="submit" 
                        class="inline-block px-6 py-2 text-white bg-green-600 hover:bg-green-700 rounded-lg shadow-md focus:ring-2 focus:ring-green-500">
                        Log in
                    </button>
                </div>
            </form>
        </div>
    </body>
</x-guest-layout>
