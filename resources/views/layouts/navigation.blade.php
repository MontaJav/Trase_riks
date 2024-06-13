<nav x-data="{ open: false }">
    <!-- Primary Navigation Menu -->
    <div class="flex">
        <!-- Navigation Links -->
        <div class="space-x-8 sm:-my-px sm:ml-6 underline sm:flex">
            <x-nav-link :href="route('projekti')" :active="request()->routeIs('projekti')">
                Projekti
            </x-nav-link>
        </div>
        @if (request()->user()->projVaditajs)
            <div class="space-x-8 sm:-my-px sm:ml-6 underline sm:flex">
                <x-nav-link :href="route('lietotaji')" :active="request()->routeIs('lietotaji')">
                    Lietotaji
                </x-nav-link>
            </div>
        @endif
        <div class="space-x-8 sm:-my-px sm:ml-6 underline sm:flex">
            <x-nav-link :href="route('laikauzskaite')" :active="request()->routeIs('laikauzskaite')">
                Laika uzskaite
            </x-nav-link>
        </div>
        <div class="space-x-8 sm:-my-px sm:ml-6 underline sm:flex">
            <x-nav-link :href="route('kalendars')" :active="request()->routeIs('kalendars')">
                Kalendars
            </x-nav-link>
        </div>
        <div class="space-x-8 sm:-my-px sm:ml-6 underline sm:flex">
            <x-nav-link :href="route('uzdevumi')" :active="request()->routeIs('uzdevumi')">
                Uzdevumi
            </x-nav-link>
        </div>
    </div>

    <!-- Logo -->
    <div class="shrink-0 flex items-center">
        <a href="{{ route('projekti') }}">
            <h1>RIKS</h1>
        </a>
    </div>

    <!-- Settings Dropdown -->
    <div class="sm:flex sm:items-center sm:ml-6">
        <div class="space-x-8 sm:-my-px sm:ml-6 sm:flex">
            <x-nav-link :class="'profile underline'" :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                Mans profils
            </x-nav-link>
            <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                </svg>
            </x-nav-link>
            <x-nav-link :href="route('logout')" :class="'button'">
                Iziet
            </x-nav-link>
        </div>
    </div>
</nav>
