<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pharm-Assist POS Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Updated Professional Pharmacy Theme Colors
                        'pos-primary': '#1d4ed8', // Stronger Emerald Green (teal-600)
                        'pos-secondary': '#1d4ed8', // Royal Blue (blue-700)
                        'pos-bg': '#f9fafb', // Very Light Gray/Off-White Background
                        'pos-card': '#ffffff', // White Card
                        'pos-text-main': '#1f2937', // Darker text for readability
                    },
                    boxShadow: {
                        // Custom shadow for the main container
                        '3xl': '0 20px 50px rgba(0, 0, 0, 0.15)',
                    }
                }
            }
        }
    </script>
    <style>
        /* Modern Background Pattern */
       .pos-background {
            background-color: theme('colors.pos-bg');
            background-image: linear-gradient(to right, #f4f4f4 1px, transparent 1px),
                              linear-gradient(to bottom, #f4f4f4 1px, transparent 1px);
            background-size: 20px 20px;
        }
        
        /* Floating WhatsApp Button Animation - Slightly refined */
        @keyframes pulsing {
            0% { box-shadow: 0 0 0 0 rgba(5, 150, 105, 0.7); }
            70% { box-shadow: 0 0 0 15px rgba(5, 150, 105, 0); }
            100% { box-shadow: 0 0 0 0 rgba(5, 150, 105, 0); }
        }
        .whatsapp-pulse {
            animation: pulsing 1.5s infinite;
        }

        /* Focus state for inputs */
        .input-focus:focus {
             box-shadow: 0 0 0 3px theme('colors.pos-primary');
        }

        /* Gradient for the sidebar - FIXED */
        .sidebar-gradient {
            /* Fallback color for browsers that don't support gradient fully */
            background-color: theme('colors.pos-primary'); 
            background: linear-gradient(135deg, theme('colors.pos-primary') 0%, theme('colors.pos-primary') 50%, theme('colors.pos-secondary') 100%);
        }

    </style>
</head>

<body class="pos-background min-h-screen flex items-center justify-center font-sans p-4">

    <div class="flex flex-col md:flex-row w-full max-w-6xl bg-pos-card rounded-2xl shadow-3xl overflow-hidden transform hover:shadow-2xl transition duration-500">
        
        <div class="hidden md:flex md:w-5/12 bg-pos-primary sidebar-gradient p-12 flex-col items-center justify-center text-white text-center">
            
            <div class="flex items-center mb-6">
                <i class="fas fa-prescription-bottle-alt text-7xl text-white mr-4 animate-bounce"></i>
                <h1 class="text-5xl font-extrabold tracking-tight">Pharm-Assist</h1>
            </div>

            <p class="text-xl font-light mb-8 opacity-90">
                Your trusted partner for modern pharmacy management.
            </p>
            
            <div class="w-full mt-4 space-y-4 text-left">
                <div class="flex items-start">
                    <i class="fas fa-chart-line text-2xl text-white mr-4 mt-1"></i>
                    <div>
                        <span class="text-lg font-semibold block">Inventory Optimization</span>
                        <span class="text-sm opacity-80">Track stock and expiry in real-time.</span>
                    </div>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-user-shield text-2xl text-white mr-4 mt-1"></i>
                    <div>
                        <span class="text-lg font-semibold block">HIPAA Compliant Security</span>
                        <span class="text-sm opacity-80">Protect patient data with robust encryption.</span>
                    </div>
                </div>
                <div class="flex items-start">
                    <i class="fas fa-cash-register text-2xl text-white mr-4 mt-1"></i>
                    <div>
                        <span class="text-lg font-semibold block">Lightning-Fast POS</span>
                        <span class="text-sm opacity-80">Process sales quickly and accurately.</span>
                    </div>
                </div>
            </div>
            
            <a href="#" class="mt-10 inline-block bg-white text-pos-primary font-bold py-3 px-8 rounded-full shadow-lg hover:bg-gray-100 transition duration-300 transform hover:scale-105">
                Learn More
            </a>

        </div>

        <div class="w-full md:w-7/12 p-8 sm:p-14 lg:p-20 flex flex-col justify-center">
            
            <div class="flex items-center justify-center md:hidden mb-8">
               <i class="fas fa-prescription-bottle-alt text-4xl text-pos-primary mr-3"></i>
               <h1 class="text-3xl font-bold text-pos-text-main">Pharm-Assist</h1>
            </div>

            <h2 class="text-4xl font-extrabold text-pos-text-main mb-3 text-center md:text-left">
                System Access
            </h2>
            <p class="text-center md:text-left text-gray-500 mb-10">
                Please log in with your authorized staff credentials.
            </p>

            <form id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="mb-6">
                    <label for="email" class="block text-sm font-semibold text-pos-text-main mb-2">
                        <i class="fas fa-user-circle mr-2 text-pos-primary"></i> Staff ID / Email
                    </label>
                    <div class="relative">
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="staff.id@pharmacy.com"
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-pos-secondary input-focus transition duration-200"
                            required
                            value="{{ old('email') }}"
                        />
                         <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('email')
                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-semibold text-pos-text-main mb-2">
                        <i class="fas fa-lock mr-2 text-pos-primary"></i> Password
                    </label>
                    <div class="relative">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••••••"
                            class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-pos-secondary input-focus transition duration-200"
                            required
                        />
                        <i class="fas fa-key absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                    @error('password')
                    <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between mb-8">
                    <label class="flex items-center text-sm text-gray-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="mr-2 rounded text-pos-primary focus:ring-pos-primary border-gray-300" />
                        Keep me logged in
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm font-medium text-pos-secondary hover:text-pos-primary transition duration-200">
                        Forgot Password?
                    </a>
                </div>

                @if(session('error'))
                <div class="my-4 p-4 bg-red-50 text-sm text-center text-red-700 rounded-lg border border-red-200" role="alert">
                    <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
                </div>
                @endif
                @if(session('success'))
                <div class="my-4 p-4 bg-green-50 text-sm text-center text-green-700 rounded-lg border border-green-200" role="alert">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
                @endif

                <button type="submit" class="w-full bg-pos-primary hover:bg-pos-primary/90 text-white font-extrabold text-lg py-3 rounded-lg shadow-xl hover:shadow-2xl transition duration-300 ease-in-out transform hover:scale-[1.005] active:scale-[0.99] flex items-center justify-center">
                    <i class="fas fa-sign-in-alt mr-3"></i> Secure Login
                </button>

                <p class="text-center text-sm text-gray-500 mt-10">
                    Having trouble accessing the system? 
                    <a href="#" class="text-pos-secondary hover:text-pos-primary font-bold transition duration-200">
                        Contact IT Support
                    </a>
                </p>
            </form>
        </div>
    </div>

    <div class="fixed bottom-6 right-6 z-1000">
        <a target="_blank" href="https://wa.me/917845667204" title="Contact us on WhatsApp" class="block">
            <div class="bg-pos-primary text-white w-16 h-16 text-3xl rounded-full flex items-center justify-center shadow-2xl whatsapp-pulse transition duration-300 hover:scale-110 hover:bg-pos-secondary">
                <i class="fab fa-whatsapp"></i>
            </div>
        </a>
        <p class="text-pos-text-main text-center text-xs mt-2 font-medium drop-shadow-sm">Need help?</p>
    </div>

</body>
</html>