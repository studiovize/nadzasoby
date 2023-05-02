<nav class="bg-white border-b border-gray-100 border-b-2 border-red-500 z-30">
    <x-container>
        <div class="flex justify-between items-center lg:items-stretch h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center text-red-500">
                    <x-logo :link="true" :text="true"/>
                </div>

                <div class="hidden gap-6 lg:gap-8 lg:-my-px lg:ml-12 lg:flex">
                    <x-nav-link :href="route('listings.index')" :active="request()->routeIs('listings.index')">
                        Nabídka zboží
                    </x-nav-link>

                    <x-nav-link :href="route('about')" :active="request()->routeIs('about')">
                        O nás
                    </x-nav-link>

                    <x-nav-link :href="route('listings.search')" :active="request()->routeIs('listings.search')">
                        Vyhledávání
                    </x-nav-link>

                    <x-nav-link :href="route('listings.create')" :active="request()->routeIs('listings.create')">
                        Přidat inzerát
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden lg:flex items-center ml-6">
                @auth
                    <a href="{{ route('credits.index') }}"
                       class="text-xs text-gray-500 mr-4 border border-gray-300 rounded-2xl py-1 px-4 hover:bg-gray-300">{{ auth()->user()->credit_amount }}
                        kreditů</a>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                @role('admin')
                                <span
                                    class="text-xs bg-green-400 p-1 rounded font-bold text-white uppercase">Admin</span>
                                @endrole

                                @if(auth()->user()->newThreadsCount() > 0)
                                    <span
                                        class="w-2 h-2 bg-red-500 rounded-full -top-px relative pointer-events-none"></span>
                                @endif


                                <div>
                                    {{ auth()->user()->name }}
                                </div>

                                @role('admin')
                                @if(getToApproveCount() > 0)
                                    <x-badge theme="red" :rounded="false">{{ getToApproveCount() }}</x-badge>
                                @endif
                                @endrole

                                <div>
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('dashboard')">
                                Přehled
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('listings.my')">
                                Moje inzeráty
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('messages.index')">
                                Zprávy @if(auth()->user()->newThreadsCount() > 0)<span
                                    class="inline-block w-2 h-2 bg-red-500 rounded-full ml-1 -top-px relative"></span>@endif
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('credits.index')">
                                Přidat kredity
                            </x-dropdown-link>

                            @can('approve listings')
                                <hr>

                                <x-dropdown-link :href="route('listings.approve')"
                                                 class="flex items-center gap-3">
                                    Schvalování inzerátů
                                    @if(getToApproveCount() > 0)
                                        <x-badge theme="red" :rounded="false">{{ getToApproveCount() }}</x-badge>
                                    @endif
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('listings.removed')">
                                    Zamítnuté inzeráty
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('admin.stats')">
                                    Statistiky
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('admin.users')">
                                    Uživatelé
                                </x-dropdown-link>

                            @endcan

                            <hr>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                                 onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    Odhlásit
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}"
                       class="text-sm text-gray-700 underline hover:no-underline">Přihlášení</a>

                    <a href="{{ route('register') }}"
                       class="ml-4 text-sm text-gray-700 underline hover:no-underline">Registrace</a>
                @endauth
            </div>

            <div class="flex lg:hidden items-center gap-3">
                @if(getToApproveCount() > 0)
                    <div class="text-0">
                        <x-badge theme="red" :rounded="false">{{ getToApproveCount() }}</x-badge>
                    </div>
                @endif

                <div class="-mr-2 flex items-center lg:hidden">
                    <button data-burger-trigger
                            class="relative inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        @auth
                            @if(auth()->user()->newThreadsCount() > 0)
                                <span
                                    class="w-2 h-2 bg-red-500 rounded-full absolute top-2 left-1 pointer-events-none"></span>
                            @endif
                        @endauth
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path data-burger-path-a :class="{'hidden': open, 'inline-flex': ! open }"
                                  class="inline-flex"
                                  stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16"/>
                            <path data-burger-path-b :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                                  stroke-linecap="round"
                                  stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </x-container>

    <!-- Responsive Navigation Menu -->
    <div data-burger-elem class="hidden relative">
        <!-- Responsive Settings Options -->
        <div class="py-4 @auth pb-1 @endauth border-t border-gray-200">
            @auth
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ auth()->user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ auth()->user()->email }}</div>
                    @role('admin')
                    <span class="text-xs bg-green-400 p-1 rounded font-bold text-white uppercase">Admin</span>
                    @endrole
                </div>
            @endauth

            {{--            <hr>--}}
            <x-responsive-nav-link :href="route('about')">
                O nás
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('listings.search')">
                Vyhledávání
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('listings.create')">
                Přidat inzerát
            </x-responsive-nav-link>
            <hr>

            @auth
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('dashboard')">
                        Přehled
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('listings.my')">
                        Moje inzeráty
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('messages.index')" class="relative">
                        <span class="relative">
                        Zprávy
                            @auth
                                @if(auth()->user()->newThreadsCount() > 0)
                                    <span
                                        class="w-2 h-2 bg-red-500 rounded-full absolute top-0 -right-3 pointer-events-none"></span>
                                @endif
                            @endauth
                        </span>
                    </x-responsive-nav-link>

                    <x-responsive-nav-link :href="route('credits.index')">
                        Přidat kredity
                    </x-responsive-nav-link>


                    @can('approve listings')
                        <hr>

                        <x-responsive-nav-link :href="route('listings.approve')" class="inline-flex items-center gap-3">
                            Schvalování inzerátů
                            @if(getToApproveCount() > 0)
                                <x-badge theme="red" :rounded="false">{{ getToApproveCount() }}</x-badge>
                            @endif
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('listings.removed')">
                            Zamítnuté inzeráty
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('admin.stats')">
                            Statistiky
                        </x-responsive-nav-link>

                        <x-responsive-nav-link :href="route('admin.users')">
                            Uživatelé
                        </x-responsive-nav-link>
                @endcan

                <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                                               onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            Odhlásit
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <x-responsive-nav-link :href="route('login')">
                    Přihlášení
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('register')">
                    Registrace
                </x-responsive-nav-link>
            @endauth
        </div>
    </div>
</nav>
