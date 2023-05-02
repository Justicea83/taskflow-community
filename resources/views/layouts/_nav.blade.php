<nav class="{{ isset($hasShadow) ? 'shadow mb-1' : '' }}">
    <div class="container mx-auto text-gray-800 lg:block lg:py-8" x-data="navConfig()" @click.outside="nav = false">
        <div class="block bg-white 2xl:-mx-10">
            <div class="lg:px-4 lg:flex">
                <div class="block lg:flex lg:items-center lg:shrink-0">
                    <div class="flex justify-between items-center p-4 lg:p-0">
                        <a href="{{ route('home') }}" class="mr-4">
                            <img loading="lazy" class="h-6 w-auto lg:h-8" src="{{ asset('images/logo.svg') }}" width="330" height="78" alt="{{ config('app.name') }}" />
                        </a>

                        <div class="flex lg:hidden">
                            <button @click="showSearch($event)">
                                <x-heroicon-o-magnifying-glass class="w-6 h-6 mr-4" />
                            </button>

                            <button @click="nav = !nav">
                                <x-heroicon-o-bars-3-center-left x-show="!nav" class="w-6 h-6" />
                            </button>

                            <button @click="nav = !nav" x-cloak>
                                <x-heroicon-o-x-mark x-show="nav" class="w-6 h-6" />
                            </button>
                        </div>
                    </div>

                    <div class="mt-2 border-b lg:block lg:mt-0 lg:border-0" x-cloak :class="{ 'block': nav, 'hidden': !nav }">
                        <ul class="flex flex-col px-4 mb-2 gap-y-2 lg:flex-row lg:mb-0 lg:gap-6">
                            <li class="rounded lg:mb-0 lg:hover:bg-gray-100 @if(is_active(['forum', 'threads*', 'thread'])) bg-gray-100 @endif">
                                <a href="{{ route('forum') }}" class="inline-block w-full px-2 py-1">
                                    Forum
                                </a>
                            </li>

                            <li class="rounded lg:mb-0 lg:hover:bg-gray-100 @if(is_active(['articles', 'articles*'])) bg-gray-100 @endif">
                                <a href="{{ route('articles') }}" class="inline-block w-full px-2 py-1">
                                    Articles
                                </a>
                            </li>

                        </ul>
                    </div>
                </div>

                <div class="w-full block gap-x-4 lg:flex lg:items-center lg:justify-end">
                    <div class="flex items-center">
                        <button @click="showSearch($event)" @keyup.window.slash="showSearch($event)" class="hover:text-lio-500">
                            <x-heroicon-o-magnifying-glass class="h-5 w-5 hidden lg:block" />
                        </button>
                        @include('_partials._search')
                    </div>

                    <ul class="block lg:flex lg:items-center gap-x-8" x-cloak :class="{ 'block': nav, 'hidden': !nav }">
                        @if (Auth::guest())
                            <li class="w-full rounded text-center lg:hover:bg-gray-100">
                                <a href="https://hr.taskflowhr.com/web/index.php/auth/register" class="inline-block w-full  p-2.5">
                                    Register
                                </a>
                            </li>

                            <li>
                                <div class="hidden lg:block">
                                    <x-buttons.secondary-cta class="flex items-center" href="{{ route('login') }}">
                                        <span class="flex items-center">
                                            <x-heroicon-o-user class="w-5 h-5 mr-1" />
                                            Login
                                        </span>
                                    </x-buttons.secondary-cta>
                                </div>

                                <a href="{{ route('login') }}" class="block w-full text-center bg-lio-500 text-white p-2.5 lg:hidden">
                                    Login
                                </a>
                            </li>
                        @else
                            <li class="relative p-4 lg:p-0">
                                <div class="flex items-center justify-center">
                                    <a href="{{ route('notifications') }}" class="hidden shrink-0 rounded-full lg:block">
                                        <span class="block relative">
                                            <x-heroicon-o-bell  class="h-5 w-5 hover:fill-current hover:text-lio-500"/>

                                            <livewire:notification-indicator/>
                                        </span>
                                    </a>

                                    <x-avatar :user="Auth::user()" class="h-8 w-8 ml-5" />

                                    <div class="ml-2" @click.outside="settings = false">
                                        <button @click="settings = !settings" class="flex items-center">
                                            {{ Auth::user()->username() }}
                                            <x-heroicon-s-chevron-down x-show="!settings" class="w-4 h-4 ml-1"/>
                                            <x-heroicon-s-chevron-left x-show="settings" class="w-4 h-4 ml-1"/>
                                        </button>
                                    </div>
                                </div>

                                <div x-show="settings" x-cloak class="mt-4 lg:mt-0">
                                    <ul class="flex flex-col items-center lg:absolute lg:items-stretch lg:ml-0 lg:mt-2 lg:w-36 lg:rounded-md lg:shadow-lg lg:z-50 lg:bg-white">
                                         <li class="mb-4 lg:hover:bg-gray-100 lg:mb-0">
                                             <a href="{{ route('profile') }}" class="inline-block w-full lg:px-4 lg:py-3">
                                                Your Profile
                                            </a>
                                        </li>

                                        <li class="mb-4 lg:hover:bg-gray-100 lg:mb-0">
                                            <a href="{{ route('user.articles') }}" class="inline-block w-full lg:px-4 lg:py-3">
                                                Your Articles
                                            </a>
                                        </li>

                                        <li class="mb-4 lg:hover:bg-gray-100 lg:mb-0">
                                            <a href="{{ route('settings.profile') }}" class="inline-block w-full lg:px-4 lg:py-3">
                                                Settings
                                            </a>
                                        </li>

                                        @can(App\Policies\UserPolicy::ADMIN, App\Models\User::class)
                                            <li class="mb-4 lg:hover:bg-gray-100 lg:mb-0 lg:border-t lg:border-b">
                                                <a href="{{ route('admin') }}" class="inline-block w-full lg:px-4 lg:py-3">
                                                    Admin
                                                </a>
                                            </li>
                                        @endcan

                                        <li class="mb-4 lg:hover:bg-gray-100 lg:mb-0">
                                            <x-buk-logout class="inline-block w-full text-left lg:px-4 lg:py-3">
                                                Sign out
                                            </x-buk-logout>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @yield('subnav')
</nav>
