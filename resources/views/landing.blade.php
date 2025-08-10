<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PowerFit Gym - Transform Your Life</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .feature-card:hover {
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }
        .animate-fade-in {
            animation: fadeIn 1s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-2xl font-bold text-purple-600">
                            <i class="fas fa-dumbbell mr-2"></i>PowerFit
                        </h1>
                    </div>
                </div>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="text-gray-700 hover:text-purple-600 transition">Home</a>
                    <a href="#about" class="text-gray-700 hover:text-purple-600 transition">About</a>
                    <a href="#services" class="text-gray-700 hover:text-purple-600 transition">Services</a>
                    <a href="#contact" class="text-gray-700 hover:text-purple-600 transition">Contact</a>
                    <button onclick="openLoginModal()" class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 transition">
                        Login
                    </button>
                    <button onclick="openRegisterModal()" class="bg-gray-800 text-white px-6 py-2 rounded-lg hover:bg-gray-900 transition">
                        Join Now
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-gradient min-h-screen flex items-center justify-center relative overflow-hidden">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative z-10 text-center text-white px-4">
            <h1 class="text-5xl md:text-7xl font-bold mb-6 animate-fade-in">
                Transform Your Life
            </h1>
            <p class="text-xl md:text-2xl mb-8 max-w-3xl mx-auto animate-fade-in">
                Join the ultimate fitness experience with state-of-the-art equipment, expert trainers, and a supportive community.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in">
                <button onclick="openRegisterModal()" class="bg-white text-purple-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-gray-100 transition">
                    Start Your Journey
                </button>
                <button onclick="openLoginModal()" class="border-2 border-white text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-white hover:text-purple-600 transition">
                    Member Login
                </button>
            </div>
        </div>
        <div class="absolute bottom-10 left-1/2 transform -translate-x-1/2">
            <i class="fas fa-chevron-down text-white text-2xl animate-bounce"></i>
        </div>
    </section>

    <!-- Features Section -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Why Choose PowerFit?</h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    We provide everything you need to achieve your fitness goals in a supportive and motivating environment.
                </p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="feature-card bg-white p-8 rounded-xl shadow-lg text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-dumbbell text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4">Modern Equipment</h3>
                    <p class="text-gray-600">Access to the latest fitness equipment and technology to maximize your workout efficiency.</p>
                </div>
                <div class="feature-card bg-white p-8 rounded-xl shadow-lg text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-users text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4">Expert Trainers</h3>
                    <p class="text-gray-600">Certified personal trainers dedicated to helping you reach your fitness goals safely and effectively.</p>
                </div>
                <div class="feature-card bg-white p-8 rounded-xl shadow-lg text-center">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-heart text-2xl text-purple-600"></i>
                    </div>
                    <h3 class="text-2xl font-semibold mb-4">Supportive Community</h3>
                    <p class="text-gray-600">Join a community of like-minded individuals who will motivate and inspire you on your fitness journey.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Services</h2>
                <p class="text-xl text-gray-600">Comprehensive fitness solutions tailored to your needs</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <i class="fas fa-running text-3xl text-purple-600 mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Group Classes</h3>
                    <p class="text-gray-600">High-energy group workouts for all fitness levels</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <i class="fas fa-user-friends text-3xl text-purple-600 mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Personal Training</h3>
                    <p class="text-gray-600">One-on-one sessions with certified trainers</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <i class="fas fa-apple-alt text-3xl text-purple-600 mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Nutrition Planning</h3>
                    <p class="text-gray-600">Customized meal plans and nutrition guidance</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md text-center">
                    <i class="fas fa-chart-line text-3xl text-purple-600 mb-4"></i>
                    <h3 class="text-xl font-semibold mb-2">Progress Tracking</h3>
                    <p class="text-gray-600">Monitor your fitness journey with detailed analytics</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Get In Touch</h2>
                <p class="text-xl text-gray-600">Ready to start your fitness journey? Contact us today!</p>
            </div>
            <div class="grid md:grid-cols-2 gap-12">
                <div>
                    <h3 class="text-2xl font-semibold mb-6">Contact Information</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-purple-600 mr-4 text-xl"></i>
                            <div>
                                <p class="font-semibold">Address</p>
                                <p class="text-gray-600">123 Fitness Street, Gym City, GC 12345</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-phone text-purple-600 mr-4 text-xl"></i>
                            <div>
                                <p class="font-semibold">Phone</p>
                                <p class="text-gray-600">(555) 123-4567</p>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-envelope text-purple-600 mr-4 text-xl"></i>
                            <div>
                                <p class="font-semibold">Email</p>
                                <p class="text-gray-600">info@powerfitgym.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <h3 class="text-2xl font-semibold mb-6">Hours of Operation</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span>Monday - Friday</span>
                            <span>5:00 AM - 11:00 PM</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Saturday</span>
                            <span>6:00 AM - 10:00 PM</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Sunday</span>
                            <span>7:00 AM - 9:00 PM</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Login Modal -->
    <div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Login</h2>
                <button onclick="closeLoginModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="mr-2">
                        <span class="text-sm text-gray-600">Remember me</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-sm text-purple-600 hover:text-purple-500">Forgot password?</a>
                </div>
                <button type="submit" class="w-full bg-purple-600 text-white py-2 px-4 rounded-md hover:bg-purple-700 transition">
                    Login
                </button>
            </form>
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">Don't have an account? 
                    <button onclick="switchToRegister()" class="text-purple-600 hover:text-purple-500">Register here</button>
                </p>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div id="registerModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg p-8 max-w-md w-full mx-4 max-h-screen overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900">Join PowerFit</h2>
                <button onclick="closeRegisterModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <select name="role_id" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="">Select your role</option>
                        <option value="2">Member</option>
                        <option value="3">Trainer</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                    <select name="gender" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="">Select gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                    <input type="date" name="dob" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <button type="submit" class="w-full bg-purple-600 text-white py-2 px-4 rounded-md hover:bg-purple-700 transition">
                    Create Account
                </button>
            </form>
            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">Already have an account? 
                    <button onclick="switchToLogin()" class="text-purple-600 hover:text-purple-500">Login here</button>
                </p>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4">PowerFit</h3>
                    <p class="text-gray-400">Transform your life with the ultimate fitness experience.</p>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#home" class="text-gray-400 hover:text-white">Home</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white">About</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white">Services</a></li>
                        <li><a href="#contact" class="text-gray-400 hover:text-white">Contact</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Services</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Personal Training</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Group Classes</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Nutrition Planning</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Equipment</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-lg font-semibold mb-4">Connect</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram text-xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-youtube text-xl"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400">&copy; 2024 PowerFit Gym. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        function openLoginModal() {
            document.getElementById('loginModal').classList.remove('hidden');
        }

        function closeLoginModal() {
            document.getElementById('loginModal').classList.add('hidden');
        }

        function openRegisterModal() {
            document.getElementById('registerModal').classList.remove('hidden');
        }

        function closeRegisterModal() {
            document.getElementById('registerModal').classList.add('hidden');
        }

        function switchToRegister() {
            closeLoginModal();
            openRegisterModal();
        }

        function switchToLogin() {
            closeRegisterModal();
            openLoginModal();
        }

        // Close modals when clicking outside
        document.getElementById('loginModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeLoginModal();
            }
        });

        document.getElementById('registerModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRegisterModal();
            }
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
