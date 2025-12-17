<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pharmacy Management')</title>
    @include('includes.head')
    <style>
        /* Theme styles */
        @keyframes pulsing {
            to {
                box-shadow: 0 0 0 30px rgba(66, 219, 135, 0);
            }
        }

        /* --- 1. New Fading Circle Loader Style --- */
        .loader {
            margin: 0 auto;
            width: 70px;
            text-align: center;
        }

        .loader > div {
            width: 15px;
            height: 15px;
            background-color: #3498db; /* Loader Color */
            border-radius: 100%;
            display: inline-block;
            animation: sk-bouncedelay 1.4s infinite ease-in-out both;
        }

        .loader .bounce1 {
            animation-delay: -0.32s;
        }

        .loader .bounce2 {
            animation-delay: -0.16s;
        }

        .loader .bounce3 {
            animation-delay: 0s; /* Explicitly set for completeness */
        }

        @keyframes sk-bouncedelay {
            0%, 80%, 100% { 
                transform: scale(0);
            } 40% { 
                transform: scale(1.0);
            }
        }
        /* -------------------------------------- */
        
        /* --- 3. FIX: Hide content initially --- */
        .preloading {
            visibility: hidden;
        }
        /* -------------------------------------- */

        /* Important: Remove overflow-hidden from body if it was set elsewhere */
        body {
            overflow-y: auto !important; 
        }
    </style>
</head>

<body class="preloading"> <div id="preloader"
        class="fixed inset-0 z-50 flex items-center justify-center bg-white transition-opacity duration-500 opacity-100">
        
        <div class="loader">
            <div class="bounce1"></div>
            <div class="bounce2"></div>
            <div class="bounce3"></div>
        </div>
        
    </div>
    <div class="flex min-h-screen">
        
        @include('includes.sidebar')
        
        <div class="flex-1 flex flex-col">
            
            @include('includes.header')
            
            <main class="flex-grow">
                 @yield('content')
            </main>
            
            @include('includes.footer')
        </div>
    </div>
    
    <div
        style="position: fixed; bottom: 30px; right: 30px; width: 100px; height: 100px; display: flex; flex-direction: column; align-items: center; justify-content: center; z-index: 1000;">
        <a target="_blank" href="https://wa.me/917845667204" style="text-decoration: none;">
            <div
                style=" background-color: #42db87; color: #fff; width: 60px; height: 60px; font-size: 30px; border-radius: 50%; text-align: center; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 0 0 #42db87; animation: pulsing 1.25s infinite cubic-bezier(0.66, 0, 0, 1); transition: all 300ms ease-in-out;">
                <i class="fab fa-whatsapp"></i>
            </div>
        </a>
        <p style="margin-top: 8px; color: #ffff; font-size: 13px;">Talk to us?</p>
    </div>
    
    @include('includes.script')
    @stack('scripts')

    <script>
        // Note: The toggleSidebar function is ONLY for mobile view now.
        function toggleSidebar() {
            document.getElementById("sidebar").classList.toggle("-translate-x-full");
            // Overlay is no longer used in this new structure for simplicity
        }

        // --- UPDATED PRELOADER JAVASCRIPT LOGIC ---
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            
            // 1. Content ko visible karein 'preloading' class remove karke
            document.body.classList.remove('preloading'); 
            
            // 2. Preloader ko fade out karein
            preloader.style.opacity = '0';
            
            // 3. Preloader element ko DOM se hata dein
            setTimeout(function() {
                preloader.remove();
            }, 500); 
        });
        // -----------------------------------------
    </script>

</body>
</html>