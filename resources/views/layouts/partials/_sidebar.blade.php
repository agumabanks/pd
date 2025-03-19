<aside class="fixed top-0 left-0 h-full w-64 bg-gray-50 shadow-md flex flex-col">
 <!-- Sidebar Title (Optional) -->
 <div class="p-4 border-b border-gray-200">
    <a href="{{ route('dashboard') }}">
    <img src="{{ asset('storage/documents/Logo_Colour.png') }}" alt="QUANTUM Logo" class="h-8 mr-2">

    <h3 class="text-lg font-light ext-base pt-2 pl-2.5 text-gray-500">Supplier Portal Tasks</h3>

    </a>    
    
    </div>

    <!-- Define a quick helper inline to set active link classes -->
    @php
        /**
         * setActiveClass checks if the current route matches the given pattern.
         * If yes, returns classes that highlight the link; otherwise returns the normal link classes.
         */
        function setActiveClass(string $routePattern) {
            // If you want partial matches for all routes under "orders.*", use request()->routeIs('orders.*')
            // If you only want exact route name matches, do request()->routeIs($routePattern)
            return request()->routeIs($routePattern)
                ? 'bg-blue-50 text-blue-800 font-semibold'
                : 'text-blue-500 hover:bg-gray-200 hover:text-[#009edb]';
        }
    @endphp

    <!-- Sidebar Content -->
    <nav class="flex-grow overflow-y-auto px-2 pt-4">

        <!-- Orders Section -->
        <div class="mb-6 text-sm">
            <h4 class="text-md font-bold text-gray-700 mb-2 px-2">Orders</h4>
            <ul class="space-y-2">
                <!-- Manage Orders -->
                <li>
                    <a href="{{ route('orders.index') }}"
                       class="block text-sm  py-2 px-4 rounded transition duration-150 {{ setActiveClass('orders.index') }}">
                        Manage Orders
                    </a>
                </li>

                <!-- Manage Schedules -->
                <li>
                    <a href="{{ route('schedules.index') }}"
                       class="block text-sm   py-2 px-4 rounded transition duration-150 {{ setActiveClass('schedules.index') }}">
                        Manage Schedules
                    </a>
                </li>

                <!-- Acknowledge Schedules in Spreadsheet -->
                <!-- <li>
                    <a href="{{ route('orders.acknowledge_spreadsheet') }}"
                       class="block py-2 text-sm   px-4 rounded transition duration-150 {{ setActiveClass('orders.acknowledge_spreadsheet') }}">
                        Acknowledge Schedules in Spreadsheet
                    </a>
                </li> -->

                <!-- View Order Lifecycle -->
                <li>
                    <a href="{{ route('orders.lifecycle') }}"
                       class="block py-2 text-sm   px-4 rounded transition duration-150 {{ setActiveClass('orders.lifecycle') }}">
                        View Order Lifecycle
                    </a>
                </li>
            </ul>
        </div>

        

        <!-- Agreements Section -->
<div class="mb-6">
    <h4 class="text-md font-bold text-gray-700 mb-2 px-2">Agreements</h4>
    <ul class="list-disc list-outside ml-5 space-y-2">
    <li>
        <a href="{{ route('agreements.index') }}"
           class="block text-sm px-4 py-2 rounded transition duration-150 {{ setActiveClass('agreements.index') }}">
            Manage Agreements
        </a>
    </li>
</ul>
</div>
    

        <!-- Channel Programs Section -->
        <div class="mb-6">
            <h4 class="text-md font-bold text-gray-700 mb-2 px-2">Channel Programs</h4>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('channel_programs.index') }}"
                       class="block py-2 text-sm  px-4 rounded transition duration-150 {{ setActiveClass('channel_programs.index') }}">
                        Manage Programs
                    </a>
                </li>
            </ul>
        </div>

        <!-- Shipments Section -->
        <div class="mb-6">
            <h4 class="text-md font-bold text-gray-700 mb-2 px-2">Shipments</h4>
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('shipments.index') }}"
                       class="block py-2   text-sm        px-4 rounded transition duration-150 {{ setActiveClass('shipments.index') }}">
                        Manage Shipments
                    </a>
                </li>
                <li>
                    <a href="{{ route('shipments.create_asn') }}"
                       class="block py-2  text-sm px-4 rounded transition duration-150 {{ setActiveClass('shipments.create_asn') }}">
                        Create ASN
                    </a>
                </li>
                <li>
                    <a href="{{ route('shipments.create_asbn') }}"
                       class="block py-2 text-sm  px-4 rounded transition duration-150 {{ setActiveClass('shipments.create_asbn') }}">
                        Create ASBN
                    </a>
                </li>
                <li>
                    <a href="{{ route('shipments.upload_asn_asbn') }}"
                       class="block py-2 text-sm  px-4 rounded transition duration-150 {{ setActiveClass('shipments.upload_asn_asbn') }}">
                        Upload ASN or ASBN
                    </a>
                </li>
                <li>
                    <a href="{{ route('shipments.view_receipts') }}"
                       class="block py-2 text-sm  px-4 rounded transition duration-150 {{ setActiveClass('shipments.view_receipts') }}">
                        View Receipts
                    </a>
                </li>
                <li>
                    <a href="{{ route('shipments.view_returns') }}"
                       class="block py-2 text-sm  px-4 rounded transition duration-150 {{ setActiveClass('shipments.view_returns') }}">
                        View Returns
                    </a>
                </li>
            </ul>
        </div>

        <!-- Contracts Section -->
        <div class="mb-6">
            <h4 class="text-md font-bold text-gray-700 mb-2 px-2">Contracts</h4>
            <ul class="space-y-2">
                <li>
                    <a href="/contracts"
                       class="block py-2 text-sm  px-4 rounded transition duration-150 
                              hover:bg-gray-200 hover:text-[#009edb] text-blue-500">
                        Manage Deliverables
                    </a>
                </li>
            </ul>
        </div>

        <!-- Invoices and Payments Section -->
        <div class="mb-6">
            <h4 class="text-md font-bold text-gray-700 mb-2 px-2">Invoices and Payments</h4>
            <ul class="space-y-2">
                <!-- Manage Invoices -->
                <li>
                    @if(Route::has('invoices.index'))
                        <a href="{{ route('invoices.index') }}"
                           class="block py-2 text-sm  px-4 rounded transition duration-150 {{ setActiveClass('invoices.index') }}">
                            Manage Invoices
                        </a>
                    @else
                        <a href="#"
                           class="block py-2 text-sm  px-4 rounded transition duration-150 text-blue-500 hover:bg-gray-200 hover:text-[#009edb]">
                            Manage Invoices (Not Implemented)
                        </a>
                    @endif
                </li>

                <!-- Create Invoices -->
                <li>
                    @if(Route::has('invoices.create'))
                        <a href="{{ route('invoices.create') }}"
                           class="block py-2 text-sm  px-4 rounded transition duration-150 {{ setActiveClass('invoices.create') }}">
                            Create Invoices
                        </a>
                    @else
                        <a href="#"
                           class="block py-2 text-sm  px-4 rounded transition duration-150 text-blue-500 hover:bg-gray-200 hover:text-[#009edb]">
                            Create Invoices (Not Implemented)
                        </a>
                    @endif
                </li>

                <!-- Create Invoice Without PO -->
                <li>
                    @if(Route::has('invoices.create_without_po'))
                        <a href="{{ route('invoices.create_without_po') }}"
                           class="block py-2 px-4 rounded transition duration-150 {{ setActiveClass('invoices.create_without_po') }}">
                            Create Invoice Without PO
                        </a>
                    @else
                        <a href="#"
                           class="block py-2 text-sm  px-4 rounded transition duration-150 text-blue-500 hover:bg-gray-200 hover:text-[#009edb]">
                            Create Invoice Without PO (Not Implemented)
                        </a>
                    @endif
                </li>

                <!-- Manage Payments -->
                <li>
                    @if(Route::has('payments.index'))
                        <a href="{{ route('payments.index') }}"
                           class="block py-2  text-sm px-4 rounded transition duration-150 {{ setActiveClass('payments.index') }}">
                            Manage Payments
                        </a>
                    @else
                        <a href="#"
                           class="block py-2 text-sm  px-4 rounded transition duration-150 text-blue-500 hover:bg-gray-200 hover:text-[#009edb]">
                            Manage Payments (Not Implemented)
                        </a>
                    @endif
                </li>
            </ul>
        </div>
    </nav>

    <!-- Logout Section at the Bottom (Optional) -->
    <div class="p-4 border-t border-gray-200">
        <a href="{{ route('logout') }}"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
           class="block text-blue-500 hover:bg-gray-200 hover:text-[#009edb] rounded py-2 px-4 transition duration-150">
            Logout
        </a>
    </div>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

</aside>
