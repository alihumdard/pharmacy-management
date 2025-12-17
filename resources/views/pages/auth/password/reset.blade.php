<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Set New Password - Pharm-Assist</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Professional Theme Colors (Matching previous pages)
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
                <i class="fas fa-key text-4xl text-pos-primary"></i>
            </div>
            <h2 class="text-3xl font-extrabold text-pos-text-main text-center">Set New Password</h2>
            <p class="text-center text-gray-500 mt-2">
                Your identity is verified. Please choose a strong, new password.
            </p>
        </div>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            
            <input type="hidden" name="email" value="{{ $email }}">
            <input type="hidden" name="token" value="{{ $otp }}"> <div class="mb-5">
                <label for="password" class="block text-sm font-semibold text-pos-text-main mb-2">
                    <i class="fas fa-lock mr-2 text-pos-primary/80"></i> New Password
                </label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        placeholder="••••••••••••"
                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-pos-secondary input-focus transition duration-200" 
                        required
                    >
                    <i class="fas fa-key absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                @error('password')
                <p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-sm font-semibold text-pos-text-main mb-2">
                    <i class="fas fa-lock mr-2 text-pos-primary/80"></i> Confirm New Password
                </label>
                <div class="relative">
                    <input 
                        type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        placeholder="••••••••••••"
                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-pos-secondary input-focus transition duration-200" 
                        required
                    >
                    <i class="fas fa-check-double absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            <button type="submit" 
                class="w-full bg-pos-primary hover:bg-pos-primary/90 text-white font-extrabold text-lg py-3 rounded-lg shadow-xl transition duration-300 ease-in-out transform hover:scale-[1.005] active:scale-[0.99] flex items-center justify-center">
                <i class="fas fa-redo-alt mr-3"></i> Finalize Reset
            </button>
        </form>
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