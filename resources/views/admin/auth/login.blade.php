<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - NexShop</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-blue-900 via-purple-900 to-indigo-900 flex items-center justify-center p-4 font-sans">
    <div class="max-w-md w-full">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-white rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-2xl">
                <i class="fas fa-crown text-3xl text-blue-600"></i>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">Admin Dashboard</h1>
            <p class="text-blue-200">Sign in to manage your store</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 border border-white/20 shadow-2xl">
            <form action="{{ route('admin.login') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-white font-semibold mb-2">Email Address</label>
                    <div class="relative">
                        <input name="email" type="email" value="{{ old('email', 'ali@gmail.com') }}" required
                               class="w-full pl-12 pr-4 py-4 bg-white/20 border border-white/30 rounded-xl text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent backdrop-blur-sm"
                               placeholder="Enter your admin email">
                        <i class="fas fa-envelope absolute left-4 top-1/2 transform -translate-y-1/2 text-white/70"></i>
                    </div>
                    @error('email')
                        <p class="text-red-300 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-white font-semibold mb-2">Password</label>
                    <div class="relative">
                        <input name="password" type="password" value="password" required
                               class="w-full pl-12 pr-12 py-4 bg-white/20 border border-white/30 rounded-xl text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent backdrop-blur-sm"
                               placeholder="Enter your password">
                        <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-white/70"></i>
                        <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white/70 hover:text-white">
                            <i id="password-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 text-white py-4 px-6 rounded-xl font-bold text-lg hover:from-blue-700 hover:to-purple-700 focus:outline-none focus:ring-4 focus:ring-white/30 transition-all transform hover:scale-105 shadow-xl">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Sign In to Dashboard
                </button>
            </form>

            <!-- Demo Credentials -->
            <div class="mt-8 p-4 bg-white/10 rounded-xl border border-white/20">
                <h3 class="text-white font-semibold mb-2">Demo Credentials:</h3>
                <p class="text-blue-200 text-sm">Email: ali@gmail.com</p>
                <p class="text-blue-200 text-sm">Password: password</p>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.querySelector('input[name="password"]');
            const passwordIcon = document.getElementById('password-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                passwordIcon.className = 'fas fa-eye';
            }
        }
    </script>
</body>
</html>