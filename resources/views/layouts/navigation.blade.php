<nav x-data="{ open: false }"
     class="bg-gradient-to-r from-blue-600 to-emerald-500 shadow-md">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Left -->
            <div class="flex items-center gap-8">

                <!-- Brand -->
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-2 text-white font-bold text-lg">
                    <span>KampusGO</span>
                </a>

                <!-- Navigation Links -->
                <!-- <div class="hidden sm:flex gap-6">
                    <a href="{{ route('dashboard') }}"
                       class="text-white/90 hover:text-white font-medium transition">
                        Dashboard
                    </a>
                </div> -->

            </div>

            <!-- Right -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="flex items-center gap-2 text-white hover:text-gray-100 transition">
                            <span class="font-medium">
                                {{ Auth::user()->name }}
                            </span>
                            <svg class="h-4 w-4 fill-current"
                                 xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                      clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            👤 Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                🚪 Logout
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open"
                        class="text-white p-2 rounded hover:bg-white/20">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              :class="{ 'hidden': open }"
                              d="M4 6h16M4 12h16M4 18h16" />
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              :class="{ 'hidden': !open }"
                              d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" class="sm:hidden bg-white shadow-md">
        <div class="px-4 py-3 space-y-2">
            <a href="{{ route('dashboard') }}"
               class="block font-medium text-gray-700 hover:text-blue-600">
                Dashboard
            </a>
        </div>

        <div class="border-t px-4 py-3">
            <p class="font-semibold text-gray-800">{{ Auth::user()->name }}</p>
            <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>

            <div class="mt-3 space-y-2">
                <a href="{{ route('profile.edit') }}"
                   class="block text-gray-700 hover:text-blue-600">
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="text-left w-full text-red-600 hover:underline">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
