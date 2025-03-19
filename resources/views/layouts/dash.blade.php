<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    
<head>
    <meta charset="utf-8">
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="Home">
    <meta name="description"
        content="UNDP works to eradicate poverty and reduce inequalities through the sustainable development of nations, in more than 170 countries and territories.">
    <meta name="twitter:site" content="@undp">
    <meta name="twitter:card" content="summary_large_image">
    <meta property="og:site_name" content="UNDP">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://www.undp.org/home">
    <meta property="og:title" content="Home">
    <meta property="og:description"
        content="UNDP works to eradicate poverty and reduce inequalities through the sustainable development of nations, in more than 170 countries and territories.">
    <meta property="og:image"
        content="https://www.undp.org/sites/g/files/zskgke326/files/styles/scaled_image_large/public/2021-09/undp-homepage-meta.jpeg?itok=8mazW-tZ">
    <link rel="icon" href="https://www.undp.org/sites/g/files/zskgke326/files/favicon.ico"
        type="image/vnd.microsoft.icon"> 
    <!-- Include Tailwind CSS (assuming it's added via CDN or installed in your project) -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- <script src="//unpkg.com/alpinejs" defer></script> -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])


    
</head>

<body class="bg-gray-100 h-screen">

    <div class="flex flex-1 min-h-screen">
        <!-- SIDEBAR (fixed width, fixed position) -->
        <aside class="w-64 bg-gray-800 text-white p-4 fixed h-full overflow-y-auto">
            @include('layouts.partials._sidebar')
        </aside>

        <!-- RIGHT SIDE: Header + Main (offset by sidebar width) -->
        <div class="flex-1 ml-64">
            <!-- HEADER (fixed at top, spanning full width except sidebar) -->
            <header class="fixed top-0 left-64 right-0 h-16  px-4   ">
                @include('layouts.partials._header')
            </header>

            <!-- MAIN CONTENT, padded down so it appears below the header -->
            <main class="flex-1 pt-16 p-8">
                <div class="container mx-auto">

                    @if (!auth()->user()->email_verified_at)
                        <div class="p-4 mb-6 rounded bg-yellow-100 text-yellow-800 border border-yellow-200">
                            <strong>Warning!</strong> Your email is not verified. 
                            Please check your inbox and verify your email to access all features.
                            <a href="{{ route('resend.verification') }}" class="text-yellow-900 underline">
                                Resend Verification Email
                            </a>
                        </div>
                    @endif

                    @yield('content')
                    @livewireScripts
                </div>
            </main>
        </div>
    </div>

</body>
</html>