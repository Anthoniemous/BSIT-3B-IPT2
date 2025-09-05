<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }} | Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .fade-in {
            animation: fadeIn 0.4s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .minimal-shadow {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.03), 0 1px 2px 0 rgba(0, 0, 0, 0.02);
        }
        .hover-lift {
            transition: all 0.2s ease;
        }
        .hover-lift:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px 0 rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50">

    <div class="flex min-h-screen">
        <!-- Left side - Minimalist branding -->
        <div class="relative flex-col items-center justify-center hidden p-16 bg-white lg:flex lg:w-1/2">
           
            <div class="max-w-md text-center">
               <!-- Logo -->
                <div class="flex items-center justify-center mx-auto mb-6 max-w-[200px]">
                    <img src="{{ asset('img/LOGO.png') }}" 
                        alt="Logo" 
                        class="object-contain w-full h-auto">
                </div>

                <p class="mb-12 text-lg font-light leading-relaxed text-gray-500">
                    MAKE STYLES.<br/>
                    Latest Trends.
                </p>
                
                <!-- Clean product grid -->
                <div class="grid grid-cols-2 gap-6 mb-12">
                    <div class="group">
                        <div class="mb-3 overflow-hidden aspect-square rounded-2xl">
                            <img src="https://idcult.com/cdn/shop/files/ID6112-BLACK_2_1eb7e311-af57-45cb-9b6a-bfbebfb7025d_1800x1800.jpg?v=1738220890 w=300&h=300&fit=crop&crop=center" 
                                 alt="Product" class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-105">
                        </div>
                        <p class="text-sm font-medium text-gray-600">Casuals</p>
                    </div>
                    <div class="group">
                        <div class="mb-3 overflow-hidden aspect-square rounded-2xl">
                            <img src="https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=300&h=300&fit=crop&crop=center" 
                                 alt="Product" class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-105">
                        </div>
                        <p class="text-sm font-medium text-gray-600">Sports</p>
                    </div>
                </div>
                
                <!-- Simple stats -->
                <div class="flex justify-center space-x-8 text-center">
                    <div>
                        <div class="text-2xl font-light text-gray-900">10k+</div>
                        <div class="text-xs tracking-wide text-gray-500 uppercase">Products</div>
                    </div>
                    <div>
                        <div class="text-2xl font-light text-gray-900">50k+</div>
                        <div class="text-xs tracking-wide text-gray-500 uppercase">Customers</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right side - Clean auth form -->
        <div class="flex flex-col items-center justify-center w-full px-8 py-12 lg:w-1/2 bg-gray-50">
           <!-- Mobile Logo -->
            <div class="flex flex-col items-center mb-8 lg:hidden">
                <div class="flex items-center justify-center mx-auto mb-6 max-w-[200px]">
                    <img src="{{ asset('img/LOGO.png') }}" 
                        alt="Logo" 
                        class="object-contain w-full h-auto">
                </div>
            </div>


            <div class="w-full max-w-sm">
                <!-- Clean header -->
                <div class="mb-10 text-center">
                    <h2 class="mb-2 text-3xl font-light text-gray-900">Welcome</h2>
                    <p class="text-gray-500">Sign in to your account</p>
                </div>

                <!-- Minimal tabs -->
                <div class="flex p-1 mb-8 bg-white rounded-xl minimal-shadow">
                    <button id="loginTab" class="flex-1 py-3 text-sm font-medium text-white transition-all duration-300 bg-gray-900 rounded-lg">
                        Sign In
                    </button>
                    <button id="registerTab" class="flex-1 py-3 text-sm font-medium text-gray-600 transition-all duration-300 rounded-lg hover:text-gray-900">
                        Sign Up
                    </button>
                </div>

               <!-- Login Form -->
<form id="loginForm" method="POST" action="{{ route('login') }}" class="space-y-4">
    @csrf
    <div class="space-y-4">
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" required 
                   class="w-full px-3 py-2.5 text-gray-900 placeholder-gray-400 transition-colors bg-white border border-gray-200 rounded-lg focus:border-gray-400 focus:outline-none hover-lift">
        </div>
        
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" required 
                   class="w-full px-3 py-2.5 text-gray-900 placeholder-gray-400 transition-colors bg-white border border-gray-200 rounded-lg focus:border-gray-400 focus:outline-none hover-lift">
        </div>
    </div>
    
    <div class="flex items-center justify-between pt-1">
        <label class="flex items-center text-sm text-gray-600">
            <input type="checkbox" name="remember" class="w-4 h-4 mr-2 border border-gray-300 rounded focus:ring-0 focus:ring-offset-0">
            Remember me
        </label>
        <a href="#" class="text-sm text-gray-600 transition-colors hover:text-gray-900">
            Forgot password?
        </a>
    </div>
    
    <button type="submit" class="w-full py-2.5 font-medium text-white transition-colors bg-gray-900 rounded-lg hover:bg-gray-800 hover-lift">
        Sign In
    </button>
</form>

<!-- Register Form -->
<form id="registerForm" method="POST" action="{{ route('register') }}" class="hidden space-y-4">
    @csrf
    <div class="space-y-4">
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" required 
                   class="w-full px-3 py-2.5 text-gray-900 placeholder-gray-400 transition-colors bg-white border border-gray-200 rounded-lg focus:border-gray-400 focus:outline-none hover-lift">
        </div>
        
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" required 
                   class="w-full px-3 py-2.5 text-gray-900 placeholder-gray-400 transition-colors bg-white border border-gray-200 rounded-lg focus:border-gray-400 focus:outline-none hover-lift">
        </div>
        
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" required 
                   class="w-full px-3 py-2.5 text-gray-900 placeholder-gray-400 transition-colors bg-white border border-gray-200 rounded-lg focus:border-gray-400 focus:outline-none hover-lift">
        </div>
        
        <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" name="password_confirmation" required 
                   class="w-full px-3 py-2.5 text-gray-900 placeholder-gray-400 transition-colors bg-white border border-gray-200 rounded-lg focus:border-gray-400 focus:outline-none hover-lift">
        </div>
    </div>
    
    <div class="pt-1">
        <label class="flex items-start text-sm text-gray-600">
            <input type="checkbox" required class="w-4 h-4 mr-2 border border-gray-300 rounded focus:ring-0 focus:ring-offset-0">
            <span>I agree to the <a href="#" class="text-gray-900 hover:underline">Terms</a> and <a href="#" class="text-gray-900 hover:underline">Privacy Policy</a></span>
        </label>
    </div>
    
    <button type="submit" class="w-full py-2.5 font-medium text-white transition-colors bg-gray-900 rounded-lg hover:bg-gray-800 hover-lift">
        Create Account
    </button>
</form>


              
              

    <script>
        // Clean tab switching
        const loginTab = document.getElementById('loginTab');
        const registerTab = document.getElementById('registerTab');
        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');

        function switchToLogin() {
            loginForm.classList.remove('hidden');
            loginForm.classList.add('fade-in');
            registerForm.classList.add('hidden');
            registerForm.classList.remove('fade-in');
            
            loginTab.classList.add('bg-gray-900', 'text-white');
            loginTab.classList.remove('text-gray-600');
            registerTab.classList.add('text-gray-600');
            registerTab.classList.remove('bg-gray-900', 'text-white');
        }

        function switchToRegister() {
            registerForm.classList.remove('hidden');
            registerForm.classList.add('fade-in');
            loginForm.classList.add('hidden');
            loginForm.classList.remove('fade-in');
            
            registerTab.classList.add('bg-gray-900', 'text-white');
            registerTab.classList.remove('text-gray-600');
            loginTab.classList.add('text-gray-600');
            loginTab.classList.remove('bg-gray-900', 'text-white');
        }

        loginTab.addEventListener('click', switchToLogin);
        registerTab.addEventListener('click', switchToRegister);
    </script>

</body>
</html>