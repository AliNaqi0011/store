<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - NexShop</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-900 text-white flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-crown text-white"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold">NexShop</h1>
                        <p class="text-xs text-gray-400">Admin Panel</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-chart-line w-5"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('admin.products.index') }}" 
                   class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.products.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-box w-5"></i>
                    <span>Products</span>
                </a>
                
                <a href="{{ route('admin.categories.index') }}" 
                   class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.categories.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-folder w-5"></i>
                    <span>Categories</span>
                </a>
                
                <a href="{{ route('admin.brands.index') }}" 
                   class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.brands.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-copyright w-5"></i>
                    <span>Brands</span>
                </a>

                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.orders.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-shopping-cart w-5"></i>
                    <span>Orders</span>
                </a>
                
                <a href="{{ route('admin.customers.index') }}" 
                   class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.customers.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-users w-5"></i>
                    <span>Customers</span>
                </a>
                
                <a href="{{ route('admin.coupons.index') }}" 
                   class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.coupons.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-ticket-alt w-5"></i>
                    <span>Coupons</span>
                </a>
                
                <a href="{{ route('admin.deals.index') }}" 
                   class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.deals.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-tags w-5"></i>
                    <span>Deals</span>
                </a>
                
                <a href="{{ route('admin.reviews.index') }}" 
                   class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.reviews.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-star w-5"></i>
                    <span>Reviews</span>
                </a>
                
                <a href="{{ route('admin.contacts.index') }}" 
                   class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.contacts.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-envelope w-5"></i>
                    <span>Messages</span>
                </a>
                
                <a href="{{ route('admin.analytics.index') }}" 
                   class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.analytics.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-chart-bar w-5"></i>
                    <span>Analytics</span>
                </a>
                
                <!-- Marketing Section -->
                <div class="pt-3 pb-1">
                    <div class="px-4 py-1">
                        <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold">Marketing</p>
                    </div>
                </div>
                
                <a href="{{ route('admin.marketing.newsletter') }}" 
                   class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.marketing.newsletter') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-envelope-open w-5"></i>
                    <span>Newsletter</span>
                </a>
                
                <a href="{{ route('admin.marketing.seo') }}" 
                   class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.marketing.seo') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-search w-5"></i>
                    <span>SEO</span>
                </a>
                
                <a href="{{ route('admin.marketing.social-media') }}" 
                   class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.marketing.social-media') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-share-alt w-5"></i>
                    <span>Social Media</span>
                </a>

                <a href="{{ route('admin.settings.index') }}" 
                   class="flex items-center space-x-3 px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors {{ request()->routeIs('admin.settings.*') ? 'bg-gray-800 border-l-4 border-blue-500' : '' }}">
                    <i class="fas fa-cog w-5"></i>
                    <span>Settings</span>
                </a>
            </nav>

            <!-- User Menu -->
            <div class="p-4 border-t border-gray-700">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold">{{ substr(auth('admin')->user()->name, 0, 1) }}</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold">{{ auth('admin')->user()->name }}</p>
                        <p class="text-xs text-gray-400">{{ auth('admin')->user()->role }}</p>
                    </div>
                </div>
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center space-x-3 px-4 py-2 text-red-400 hover:bg-red-500/10 rounded-lg transition-colors">
                        <i class="fas fa-sign-out-alt w-5"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">@yield('page-title', 'Dashboard')</h2>
                        <p class="text-gray-600">@yield('page-description', 'Manage your e-commerce store')</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="relative p-2 text-gray-600 hover:text-gray-900">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                        </button>
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-semibold">{{ substr(auth('admin')->user()->name, 0, 1) }}</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>