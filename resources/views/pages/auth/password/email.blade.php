<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Reset Password - Pharm-Assist</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Professional Pharmacy Theme Colors (Used from Login Page)
                        'pos-primary': '#1d4ed8', // Stronger Emerald Green (teal-600)
                        'pos-secondary': '#1d4ed8', // Royal Blue (blue-700)
                        'pos-bg': '#f9fafb', // Very Light Gray/Off-White Background
                        'pos-card': '#ffffff', // White Card
                        'pos-text-main': '#1f2937', // Darker text for readability
                    },
                    boxShadow: {
                        // Custom shadow for the main container
                        '2xl-pos': '0 15px 30px rgba(0, 0, 0, 0.1)',
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

        /* Focus state for inputs */
        .input-focus:focus {
             box-shadow: 0 0 0 3px theme('colors.pos-primary');
             border-color: transparent;
        }

        /* Floating WhatsApp Button Animation - Aligned with POS Primary */
        @keyframes pulsing {
            0% { box-shadow: 0 0 0 0 rgba(5, 150, 105, 0.7); }
            70% { box-shadow: 0 0 0 15px rgba(5, 150, 105, 0); }
            100% { box-shadow: 0 0 0 0 rgba(5, 150, 105, 0); }
        }
        .whatsapp-pulse {
            animation: pulsing 1.5s infinite;
        }

    </style>
</head>

<body class="pos-background min-h-screen flex items-center justify-center font-sans p-4">

    <div class="w-full max-w-md p-8 sm:p-10 bg-pos-card rounded-2xl shadow-2xl-pos transition duration-300 transform hover:shadow-3xl">
        
        <div class="flex flex-col items-center mb-8">
            <div class="p-4 bg-pos-primary/10 rounded-full mb-4">
                <i class="fas fa-redo-alt text-4xl text-pos-primary"></i>
            </div>
            <h2 class="text-3xl font-extrabold text-pos-text-main text-center">Forgot Your Password?</h2>
            <p class="text-center text-gray-500 mt-2">
                We'll send a secure link to your registered email address.
            </p>
        </div>

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            
            <div class="mb-6">
                <label for="email" class="block text-sm font-semibold text-pos-text-main mb-2">
                    <i class="fas fa-envelope mr-2 text-pos-primary/80"></i> Email Address
                </label>
                <div class="relative">
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="Enter your professional email"
                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-pos-secondary input-focus transition duration-200" 
                        required 
                        value="{{ old('email') }}"
                    >
                    <i class="fas fa-user-circle absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                @error('email')
                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            @if (session('status'))
                <div class="my-4 p-4 bg-green-50 text-sm text-center text-green-700 rounded-lg border border-green-200" role="alert">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('status') }}
                </div>
            @endif

            <button 
                type="submit" 
                class="w-full bg-pos-primary hover:bg-pos-primary/90 text-white font-extrabold text-lg py-3 rounded-lg shadow-xl transition duration-300 ease-in-out transform hover:scale-[1.005] active:scale-[0.99] flex items-center justify-center">
                <i class="fas fa-paper-plane mr-3"></i> Request Reset Link
            </button>
        </form>

        <p class="text-center text-sm text-gray-500 mt-8">
            Remember your password? 
            <a href="{{ route('login') }}" class="text-pos-secondary hover:text-pos-primary font-bold transition duration-200">
                Go back to Log In
            </a>
        </p>
    </div>

    <div class="fixed bottom-6 right-6 z-1000">
        <a target="_blank" href="https://wa.me/917845667204" title="Contact us on WhatsApp" class="block">
            <div class="bg-pos-primary text-white w-14 h-14 text-3xl rounded-full flex items-center justify-center shadow-2xl whatsapp-pulse transition duration-300 hover:scale-110 hover:bg-pos-secondary">
                <i class="fab fa-whatsapp"></i>
            </div>
        </a>
        <p class="text-pos-text-main text-center text-xs mt-2 font-medium drop-shadow-sm">Need help?</p>
    </div>

</body>
</html>