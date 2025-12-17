<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Professional Signup - Pharm-Assist</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        // Professional Theme Colors (Matching Login/Forgot Password)
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

<body class="pos-background font-sans flex items-center justify-center min-h-screen py-10">
    
    <div class="w-full max-w-4xl p-8 sm:p-12 bg-pos-card rounded-2xl shadow-2xl-pos transition duration-300 transform hover:shadow-3xl">
        
        <div class="flex flex-col items-center mb-8">
            <div class="p-4 bg-pos-primary/10 rounded-full mb-4">
                <i class="fas fa-user-plus text-4xl text-pos-primary"></i>
            </div>
            <h2 class="text-3xl font-extrabold text-pos-text-main text-center">Create Your Professional Account</h2>
            <p class="text-center text-gray-500 mt-2">
                Join our platform to streamline your club's event management.
            </p>
        </div>

        <form id="signupForm" method="POST" action="{{ route('register') }}" class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">
            @csrf
            
            <div>
                <label for="name" class="block text-sm font-semibold text-pos-text-main mb-2">
                    <i class="fas fa-user mr-2 text-pos-primary/80"></i> Full Name
                </label>
                <div class="relative">
                    <input type="text" id="name" name="name" placeholder="John Doe" value="{{ old('name') }}" required 
                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-pos-secondary input-focus transition duration-200" />
                    <i class="fas fa-id-card absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                @error('name')<p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-pos-text-main mb-2">
                    <i class="fas fa-envelope mr-2 text-pos-primary/80"></i> Email Address
                </label>
                <div class="relative">
                    <input type="email" id="email" name="email" placeholder="you@example.com" value="{{ old('email') }}" required 
                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-pos-secondary input-focus transition duration-200" />
                    <i class="fas fa-at absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                @error('email')<p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="club" class="block text-sm font-semibold text-pos-text-main mb-2">
                    <i class="fas fa-building mr-2 text-pos-primary/80"></i> Club/Company Name
                </label>
                <div class="relative">
                    <input type="text" id="club" name="club" placeholder="The Social Club" value="{{ old('club') }}"
                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-pos-secondary input-focus transition duration-200" />
                    <i class="fas fa-users absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                @error('club')<p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="location" class="block text-sm font-semibold text-pos-text-main mb-2">
                    <i class="fas fa-map-marker-alt mr-2 text-pos-primary/80"></i> Location (City, Country)
                </label>
                <div class="relative">
                    <input type="text" id="location" name="location" placeholder="London, UK" value="{{ old('location') }}"
                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-pos-secondary input-focus transition duration-200" />
                    <i class="fas fa-globe absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                @error('location')<p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-pos-text-main mb-2">
                    <i class="fas fa-lock mr-2 text-pos-primary/80"></i> Password
                </label>
                <div class="relative">
                    <input type="password" id="password" name="password" placeholder="Minimum 6 characters" required 
                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-pos-secondary input-focus transition duration-200" />
                    <i class="fas fa-key absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                @error('password')<p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-pos-text-main mb-2">
                    <i class="fas fa-lock mr-2 text-pos-primary/80"></i> Confirm Password
                </label>
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Re-enter your password" required 
                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-pos-secondary input-focus transition duration-200" />
                    <i class="fas fa-check-double absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
            </div>

            <div class="col-span-full mt-3">
                <label class="block text-sm font-semibold text-pos-text-main mb-3">
                    <i class="fas fa-hand-holding-heart mr-2 text-pos-primary/80"></i> Services of Interest (Select all that apply)
                </label>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                    
                    <label class="flex items-center text-sm text-gray-600 cursor-pointer p-3 bg-gray-50 rounded-xl border border-gray-200 hover:bg-pos-primary/10 transition">
                        <input id="service_promo" name="services[]" type="checkbox" value="Event Promotions" class="h-4 w-4 text-pos-primary focus:ring-pos-primary border-gray-300 rounded-md">
                        <span class="ml-3 font-medium">Event Promotions</span>
                    </label>
                    
                    <label class="flex items-center text-sm text-gray-600 cursor-pointer p-3 bg-gray-50 rounded-xl border border-gray-200 hover:bg-pos-primary/10 transition">
                        <input id="service_content" name="services[]" type="checkbox" value="Content Creation & Reels" class="h-4 w-4 text-pos-primary focus:ring-pos-primary border-gray-300 rounded-md">
                        <span class="ml-3 font-medium">Content & Reels</span>
                    </label>
                    
                    <label class="flex items-center text-sm text-gray-600 cursor-pointer p-3 bg-gray-50 rounded-xl border border-gray-200 hover:bg-pos-primary/10 transition">
                        <input id="service_ticketing" name="services[]" type="checkbox" value="Ticketing & Guestlist Management" class="h-4 w-4 text-pos-primary focus:ring-pos-primary border-gray-300 rounded-md">
                        <span class="ml-3 font-medium">Ticketing & Guestlist</span>
                    </label>
                    
                    <label class="flex items-center text-sm text-gray-600 cursor-pointer p-3 bg-gray-50 rounded-xl border border-gray-200 hover:bg-pos-primary/10 transition">
                        <input id="service_collabs" name="services[]" type="checkbox" value="Artist & Influencer Collaborations" class="h-4 w-4 text-pos-primary focus:ring-pos-primary border-gray-300 rounded-md">
                        <span class="ml-3 font-medium">Artist Collabs</span>
                    </label>
                    
                    <label class="flex items-center text-sm text-gray-600 cursor-pointer p-3 bg-gray-50 rounded-xl border border-gray-200 hover:bg-pos-primary/10 transition">
                        <input id="service_strategy" name="services[]" type="checkbox" value="Event Strategy & Planning" class="h-4 w-4 text-pos-primary focus:ring-pos-primary border-gray-300 rounded-md">
                        <span class="ml-3 font-medium">Event Strategy</span>
                    </label>
                </div>
                @error('services')<p class="mt-2 text-sm text-red-600 font-medium">{{ $message }}</p>@enderror
            </div>
            
            <div class="col-span-full mt-4 space-y-3">
                <label class="flex items-start text-sm text-gray-600 cursor-pointer">
                    <input type="checkbox" id="terms" name="terms" required class="mt-1 mr-3 rounded text-pos-primary focus:ring-pos-primary border-gray-300" />
                    <span>I agree to the <a href="#" class="text-pos-secondary hover:text-pos-primary font-bold">Terms & Conditions</a>.</span>
                </label>
                @error('terms') <p class="mt-1 ml-6 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror

                <label class="flex items-start text-sm text-gray-600 cursor-pointer">
                    <input type="checkbox" id="privacy" name="privacy" required class="mt-1 mr-3 rounded text-pos-primary focus:ring-pos-primary border-gray-300" />
                    <span>I accept the <a href="#" class="text-pos-secondary hover:text-pos-primary font-bold">Privacy Policy</a>.</span>
                </label>
                @error('privacy') <p class="mt-1 ml-6 text-sm text-red-600 font-medium">{{ $message }}</p> @enderror

                <label class="flex items-center text-sm text-gray-600 cursor-pointer">
                    <input type="checkbox" id="newsletter" name="newsletter" class="mr-3 rounded text-pos-primary focus:ring-pos-primary border-gray-300" />
                    <span>Subscribe to our <a href="#" class="text-pos-secondary hover:text-pos-primary font-bold">newsletter</a> for updates.</span>
                </label>
            </div>

            <div class="col-span-full mt-6">
                <button type="submit" 
                    class="w-full bg-pos-primary hover:bg-pos-primary/90 text-white font-extrabold text-lg py-3 rounded-lg shadow-xl transition duration-300 ease-in-out transform hover:scale-[1.005] active:scale-[0.99] flex items-center justify-center">
                    <i class="fas fa-sign-in-alt mr-3"></i> Sign Up and Start Managing
                </button>
            </div>

            <p class="col-span-full text-center text-sm text-gray-600 mt-6">
                Already have an account?
                <a href="{{ route('login') }}" class="text-pos-secondary hover:text-pos-primary font-bold transition duration-200">Log In here</a>
            </p>
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