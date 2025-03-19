@extends('layouts.dash')

@section('content')
<!-- 
    Main container: a header at the top, a sidebar on the left, and the dashboard content on the right.
    We'll replicate the screenshot structure as closely as possible using your existing card styles.
-->

<div class="flex flex-col min-h-screen">

    

    <!-- MAIN CONTENT AREA -->
    <div class="">

        

        <!-- MAIN DASHBOARD -->
        <div class="">
            <!-- Title / Greeting -->
            <h1 class="dashboard-title mb-4">Welcome to Your Supplier Dashboard</h1>
            <p class="dashboard-subtitle mb-8">
                You have successfully logged in! Explore your dashboard:
            </p>

            <!-- Infolets / Cards (grid) -->
            <!-- 3-column layout for the top row, plus a full-width row for Supplier News -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

<!-- 1) RECENT ACTIVITY (Last 30 Days) -->
<div class="card card-gray relative">
    <h2 class="text-lg font-semibold text-gray-700 mb-2">
        Recent Activity <span class="text-sm text-gray-500">(Last 30 Days)</span>
    </h2>
    <!-- Subtext -->
    <p class="text-blue-600 mb-6">
        Agreements changed or canceled
    </p>
    <!-- “1” in the bottom-right corner -->
    <span class="absolute bottom-2 right-2 text-xl text-gray-500">
        1
    </span>
</div>

<!-- 2) REQUIRING ATTENTION (Donut Chart) -->
<div class="card relative">
    <h2 class="text-lg font-semibold text-gray-700 mb-2">
        Requiring Attention
    </h2>
    <!-- Donut Chart (multi-segment) -->
    <div class="flex items-center justify-center mt-4">
        <div class="relative">
            <!-- Outer circle / base -->
            <svg class="w-28 h-28" viewBox="0 0 36 36">
                <!-- Gray background circle -->
                <path
                    class="text-gray-200"
                    stroke-width="4"
                    stroke="currentColor"
                    fill="none"
                    d="M18 2.0845
                       a 15.9155 15.9155 0 0 1 0 31.831
                       a 15.9155 15.9155 0 0 1 0 -31.831"
                />
                <!-- Segment 1: Blue (Agreements) -->
                <path
                    class="text-blue-500"
                    stroke-dasharray="25, 100"
                    stroke-dashoffset="25"
                    stroke-linecap="round"
                    stroke-width="4"
                    stroke="currentColor"
                    fill="none"
                    d="M18 2.0845
                       a 15.9155 15.9155 0 0 1 0 31.831
                       a 15.9155 15.9155 0 0 1 0 -31.831"
                    transform="rotate(-90 18 18)"
                />
                <!-- Segment 2: Green (Orders) -->
                <path
                    class="text-green-500"
                    stroke-dasharray="20, 100"
                    stroke-dashoffset="5"
                    stroke-linecap="round"
                    stroke-width="4"
                    stroke="currentColor"
                    fill="none"
                    d="M18 2.0845
                       a 15.9155 15.9155 0 0 1 0 31.831
                       a 15.9155 15.9155 0 0 1 0 -31.831"
                    transform="rotate(-90 18 18)"
                />
                <!-- Segment 3: Orange (Schedules) -->
                <path
                    class="text-orange-400"
                    stroke-dasharray="15, 100"
                    stroke-dashoffset="-15"
                    stroke-linecap="round"
                    stroke-width="4"
                    stroke="currentColor"
                    fill="none"
                    d="M18 2.0845
                       a 15.9155 15.9155 0 0 1 0 31.831
                       a 15.9155 15.9155 0 0 1 0 -31.831"
                    transform="rotate(-90 18 18)"
                />
                <!-- Segment 4: Red (Invoices) -->
                <path
                    class="text-red-500"
                    stroke-dasharray="10, 100"
                    stroke-dashoffset="-30"
                    stroke-linecap="round"
                    stroke-width="4"
                    stroke="currentColor"
                    fill="none"
                    d="M18 2.0845
                       a 15.9155 15.9155 0 0 1 0 31.831
                       a 15.9155 15.9155 0 0 1 0 -31.831"
                    transform="rotate(-90 18 18)"
                />
            </svg>
            <!-- Center Count -->
            <div
                class="absolute inset-0 flex items-center 
                       justify-center font-bold text-2xl"
            >
                346
            </div>
        </div>
    </div>
    <!-- Legend -->
    <ul class="mt-4 space-y-1 text-sm text-gray-700">
        <li class="flex items-center space-x-2">
            <span class="inline-block w-3 h-3 bg-blue-500 rounded-full"></span>
            <span>Agreements to Acknowledge</span>
        </li>
        <li class="flex items-center space-x-2">
            <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>
            <span>Orders to Acknowledge</span>
        </li>
        <li class="flex items-center space-x-2">
            <span class="inline-block w-3 h-3 bg-orange-400 rounded-full"></span>
            <span>Schedules Overdue or Due Today</span>
        </li>
        <li class="flex items-center space-x-2">
            <span class="inline-block w-3 h-3 bg-red-500 rounded-full"></span>
            <span>Invoices Overdue</span>
        </li>
    </ul>
</div>

<!-- 3) TRANSACTION REPORTS (Last 30 Days) -->
<div class="card card-gray">
    <h2 class="text-lg font-semibold text-gray-700 mb-2">
        Transaction Reports <span class="text-sm text-gray-500">(Last 30 Days)</span>
    </h2>
    <div class="flex flex-col items-center mt-6">
        <!-- Lightning Bolt SVG -->
        
        <svg viewBox="0 0 1024 1024" class="icon w-20 h-20" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M704 469.333333h-200.533333L640 106.666667H405.333333l-128 448h183.466667L362.666667 960z" fill="#FFC107"></path></g></svg>

        <!-- <svg viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M704 469.333333h-200.533333L640 106.666667H405.333333l-128 448h183.466667L362.666667 960z" fill="#FFC107"></path></g></svg> -->
        <p class="text-gray-600">No data available</p>
    </div>
</div>

<!-- SUPPLIER NEWS (spans all 3 columns at the bottom) -->
<div class="card col-span-1 md:col-span-3 mt-2">
    <h2 class="text-lg font-semibold text-gray-700 mb-2">
        Supplier News / Respond Public Negotiations
    </h2>
    <ul class="list-disc list-inside text-gray-700 mt-2 space-y-2">
        <li>
            To respond: Click <strong>'View Active Negotiations'</strong> on the left side pane; it navigates to all open and active negotiations.
        </li>
        <li>
            Click the <strong>negotiation number</strong> to open it and review requirements, line items, and details.
        </li>
        <li>
            If interested, please submit your bid via your supplier portal account.
        </li>
    </ul>
</div>
</div>

        </div>
    </div>
</div>
@endsection

<style>
/* Reuse your existing styles + some new utility classes to mimic the screenshot's feel */

/* Basic card style from your snippet */
.card {
  background: #fff;
  padding: 1.5rem;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  border-left: 4px solid #2c3e50;
}

/* “Gray” card variant for “No data” cards */
.card-gray {
  background-color: #f4f6f9;
  border-left: 4px solid #7f8c8d;
}

/* Title & subtitle from your snippet */
.dashboard-title {
  font-size: 1.75rem;
  font-weight: 700;
  color: #2c3e50;
}
.dashboard-subtitle {
  font-size: 1rem;
  color: #7f8c8d;
}

/* Example .no-data styling */
.no-data-icon {
  opacity: 0.7;
}

/* Adjust for smaller screens */
@media (max-width: 1024px) {
  .dashboard-content {
    grid-template-columns: 1fr;
  }
}
</style>
