 
 

<!-- TOP HEADER / NAVBAR -->
<div class="container bg-gray-100 h-16 flex items-center px-4 justify-between">
       

        <!-- Middle Section: Search -->
        <div class="hidden md:flex space-x-2">
            <select
                name="searchCategory"
                class="border border-gray-300 text-gray-700 text-sm rounded px-3 py-1 
                       focus:outline-none focus:ring-1 focus:ring-blue-400">

                <option value="" class="mt-2">Search Agreements</option>
                <option value="agreements">Agreements</option>
                <option value="orders">Orders</option>
                <!-- etc. -->
            </select>
            <input
                type="text"
                name="agreementNumber"
                placeholder="Agreement Number"
                class="border border-gray-300 text-gray-700 text-sm rounded px-3 py-1
                       focus:outline-none focus:ring-1 focus:ring-blue-400 w-48"
            />
            <button
                class="bg-blue-600 text-white text-sm px-3 py-1 rounded
                       hover:bg-blue-700 focus:outline-none focus:ring-2
                       focus:ring-blue-400"
            >
                Search
            </button>
        </div>

        <!-- Right Section: Icons (Home, Notifications, User) -->
        <div class="flex items-center space-x-6">
            <!-- Home Button -->
            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-blue-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 
                             1 0 001 1h3m10-11l2 2m-2-2v10a1 1 
                             0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 
                             1 0 011-1h2a1 1 0 011 1v4a1 1 0 
                             001 1m-6 0h6">
                    </path>
                </svg>
            </a>

             <!-- NOTIFICATIONS: Hover Dropdown -->
        <div
            x-data="{ open: false, searchQuery: '' }"
            class="relative"
            @mouseover="open = true"
            @mouseleave="open = false"
        >
            <!-- Bell Icon with Count Badge -->
            <button class="text-gray-800 hover:text-blue-800 relative">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path 
                        stroke-linecap="round" 
                        stroke-linejoin="round" 
                        stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 
                           0 0118 14.158V11a6 6 0 00-12 0v3.159c0 
                           .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 
                           3 0 01-6 0v-1m6 0H9">
                    </path>
                </svg>

                <!-- Badge showing number of unread notifications -->
                @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                    <span 
                        class="absolute top-0 right-0 inline-flex items-center 
                               justify-center px-1 py-0.5 text-xs font-bold 
                               leading-none text-white bg-red-600 rounded-full">
                        {{ auth()->user()->unreadNotifications->count() }}
                    </span>
                @endif
            </button>

            <!-- DROPDOWN PANEL -->
            <div
                x-show="open"
                @click.away="open = false"
                class="absolute right-0 mt-2 w-80 bg-white border border-gray-200 
                       rounded-lg shadow-xl z-50"
                style="display: none;"
            >
                <!-- Header: Title, “Show All” Button -->
                <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-800">Notifications</h2>
                    <a 
                        href="{{ route('notifications.index') }}"
                        class="text-sm text-blue-500 hover:text-blue-700"
                    >
                        Show All
                    </a>
                </div>

                <!-- Search Bar -->
                <div class="px-4 py-2 border-b border-gray-200">
                    <div class="relative">
                        <svg 
                            class="absolute w-4 h-4 text-gray-400 left-2 top-1/2 
                                   transform -translate-y-1/2" 
                            fill="none" stroke="currentColor" 
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M8 16l-4.35 4.35a1.252 
                                     1.252 0 101.77 1.77L9.77 
                                     17.77A6 6 0 108 16z">
                            </path>
                        </svg>
                        <input
                            x-model="searchQuery"
                            type="text"
                            placeholder="Search"
                            class="pl-8 pr-2 py-1 w-full rounded border 
                                   border-gray-300 focus:outline-none focus:border-blue-400"
                        />
                    </div>
                </div>

               
                <!-- Footer: “Load More” + Count (Optional) -->
                @if(auth()->user()->unreadNotifications->count() > 5)
                    <div class="px-4 py-2 border-t border-gray-200 text-center text-sm">
                        <a href="#" class="text-blue-500 hover:text-blue-600">
                            Load More Items (1-5 of {{ auth()->user()->unreadNotifications->count() }})
                        </a>
                    </div>
                @endif
            </div>
        </div>

            
                <!-- User Icon / Initials -->
            <div class="flex items-center">
                <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center ml-4">
                    <span class="text-sm font-bold text-gray-800">
                        {{ $initials ?? 'U' }}
                    </span>
                </div>
            </div>
        </div>
    </div>