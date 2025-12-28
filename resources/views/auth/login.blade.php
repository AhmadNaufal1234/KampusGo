<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
        <div class="w-full max-w-lg bg-white rounded-2xl shadow-xl p-10">
            <!-- Title -->
            <div class="text-center mb-10">
                <h1 class="text-4xl font-bold text-indigo-600 tracking-wide">
                    KampusGO
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Sistem Informasi Kampus
                </p>

                <h2 class="text-lg font-bold text-gray-700 mt-2 tracking-wide">
                    LOGIN
                </h2>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-6" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-5">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input
                        id="email"
                        class="block mt-2 w-full"
                        type="email"
                        name="email"
                        :value="old('email')"
                        required
                        autofocus
                    />
                    <x-input-error
                        :messages="$errors->get('email')"
                        class="mt-1"
                    />
                </div>

                <!-- Password -->
                <div class="mb-6">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input
                        id="password"
                        class="block mt-2 w-full"
                        type="password"
                        name="password"
                        required
                    />
                    <x-input-error
                        :messages="$errors->get('password')"
                        class="mt-1"
                    />
                </div>

                <button
                    type="submit"
                    x-data="{ loading: false }"
                    @click="setTimeout(() => loading = true, 100)"
                    :disabled="loading"
                    class="w-full py-3 rounded-lg text-white font-semibold bg-gradient-to-r from-indigo-600 to-emerald-500 hover:from-indigo-700 hover:to-emerald-600 transition flex items-center justify-center gap-2"
                >
                    <svg
                        x-show="loading"
                        class="animate-spin h-5 w-5 text-white"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle
                            class="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            stroke-width="4"
                        ></circle>
                        <path
                            class="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"
                        ></path>
                    </svg>

                    <span x-show="!loading">Masuk</span>
                    <span x-show="loading">Memproses...</span>
                </button>
            </form>

            <!-- Register Link -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600">
                    Belum punya akun?
                    <a
                        href="{{ route('register') }}"
                        class="text-indigo-600 font-semibold hover:underline"
                    >
                        Daftar sekarang
                    </a>
                </p>
            </div>
        </div>
    </div>
</x-guest-layout>
