<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
        <div class="w-full max-w-xl bg-white rounded-2xl shadow-lg p-10">

            <!-- Title -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-indigo-600 tracking-wide">
                    KampusGO
                </h1>
                <p class="text-sm text-gray-500 mt-1">
                    Daftar akun baru untuk mulai menggunakan sistem
                </p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Role -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">
                        Daftar Sebagai
                    </label>
                    <select
                        name="role"
                        class="w-full mt-1 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option value="customer">Customer</option>
                        <option value="mitra">Mitra</option>
                    </select>
                </div>

                <!-- Name -->
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Nama Lengkap')" />
                    <x-text-input
                        id="name"
                        class="block mt-1 w-full"
                        type="text"
                        name="name"
                        :value="old('name')"
                        required
                        autofocus
                    />
                    <x-input-error :messages="$errors->get('name')" class="mt-1" />
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input
                        id="email"
                        class="block mt-1 w-full"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input
                        id="password"
                        class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required
                    />
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-6">
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                    <x-text-input
                        id="password_confirmation"
                        class="block mt-1 w-full"
                        type="password"
                        name="password_confirmation"
                        required
                    />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>

                <!-- Button -->
                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-indigo-600 to-emerald-500 hover:from-indigo-700 hover:to-emerald-600 text-white font-semibold py-2.5 rounded-lg transition">
                    Daftar Sekarang
                </button>

                <!-- Login Link -->
                <div class="text-center mt-6">
                    <p class="text-sm text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline">
                            Masuk di sini
                        </a>
                    </p>
                </div>

            </form>
        </div>
    </div>
</x-guest-layout>
