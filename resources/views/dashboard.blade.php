<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Custom CSS for CartKada Homepage -->
    <style>
        .cartkada-container * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .cartkada-container {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            overflow-x: hidden;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            margin: -3rem -1.5rem 0 -1.5rem; /* Removes default Laravel padding */
        }

        .ck-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Header Navigation - Integrated with Laravel */
        .ck-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .ck-logo {
            font-size: 2rem;
            font-weight: 800;
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .ck-nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
        }

        .ck-nav-links a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .ck-nav-links a:hover {
            color: #667eea;
        }

        .ck-nav-links a::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background: linear-gradient(45deg, #667eea, #764ba2);
            transition: width 0.3s ease;
        }

        .ck-nav-links a:hover::after {
            width: 100%;
        }

        .ck-cart-icon {
            position: relative;
            background: linear-gradient(45deg, #10b981, #059669);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
        }

        .ck-cart-icon:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.4);
        }

        .ck-cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ff4757;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            font-weight: bold;
        }

        /* Hero Section */
        .ck-hero {
            min-height: 80vh;
            display: flex;
            align-items: center;
            padding: 2rem 0;
            position: relative;
            overflow: hidden;
        }

        .ck-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><radialGradient id="grad" cx="50%" cy="50%" r="50%"><stop offset="0%" stop-color="rgba(255,255,255,0.1)"/><stop offset="100%" stop-color="rgba(255,255,255,0)"/></radialGradient></defs><circle cx="20" cy="20" r="2" fill="url(%23grad)"/><circle cx="80" cy="40" r="1" fill="url(%23grad)"/><circle cx="40" cy="80" r="1.5" fill="url(%23grad)"/></svg>') repeat;
            animation: ck-float 20s linear infinite;
        }

        @keyframes ck-float {
            0% { transform: translateY(0px); }
            100% { transform: translateY(-100px); }
        }

        .ck-hero-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .ck-hero-text h1 {
            font-size: 4rem;
            font-weight: 800;
            color: white;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            animation: ck-slideInLeft 1s ease-out;
        }

        .ck-hero-text p {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 2rem;
            animation: ck-slideInLeft 1s ease-out 0.2s both;
        }

        .ck-cta-buttons {
            display: flex;
            gap: 1rem;
            animation: ck-slideInLeft 1s ease-out 0.4s both;
        }

        .ck-btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .ck-btn-primary {
            background: linear-gradient(45deg, #10b981, #059669);
            color: white;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
        }

        .ck-btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(16, 185, 129, 0.4);
        }

        .ck-btn-secondary {
            background: transparent;
            color: white;
            border: 2px solid white;
        }

        .ck-btn-secondary:hover {
            background: linear-gradient(45deg, #10b981, #059669);
            color: white;
            transform: translateY(-3px);
            border-color: transparent;
        }

        .ck-hero-image {
            position: relative;
            animation: ck-slideInRight 1s ease-out;
        }

        .ck-hero-visual {
            width: 100%;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .ck-shopping-icons {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            padding: 2rem;
        }

        .ck-icon-item {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            transform: translateY(20px);
            animation: ck-bounceIn 0.6s ease-out forwards;
            transition: all 0.3s ease;
        }

        .ck-icon-item:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .ck-icon-item:nth-child(1) { animation-delay: 0.2s; }
        .ck-icon-item:nth-child(2) { animation-delay: 0.4s; }
        .ck-icon-item:nth-child(3) { animation-delay: 0.6s; }
        .ck-icon-item:nth-child(4) { animation-delay: 0.8s; }
        .ck-icon-item:nth-child(5) { animation-delay: 1s; }
        .ck-icon-item:nth-child(6) { animation-delay: 1.2s; }

        .ck-icon-item .emoji {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }

        .ck-icon-item .label {
            font-size: 0.9rem;
            font-weight: 600;
            color: #333;
        }

        /* Features Section */
        .ck-features {
            padding: 5rem 0;
            background: white;
        }

        .ck-features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 3rem;
            margin-top: 3rem;
        }

        .ck-feature-card {
            text-align: center;
            padding: 2rem;
            border-radius: 15px;
            transition: all 0.3s ease;
            background: white;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .ck-feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .ck-feature-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            background: linear-gradient(45deg, #10b981, #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .ck-section-title {
            text-align: center;
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .ck-section-subtitle {
            text-align: center;
            font-size: 1.2rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Animations */
        @keyframes ck-slideInLeft {
            from {
                transform: translateX(-100px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes ck-slideInRight {
            from {
                transform: translateX(100px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes ck-bounceIn {
            from {
                transform: translateY(50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .ck-nav-links {
                display: none;
            }

            .ck-hero-content {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 2rem;
            }

            .ck-hero-text h1 {
                font-size: 2.5rem;
            }

            .ck-cta-buttons {
                flex-direction: column;
                align-items: center;
            }

            .ck-shopping-icons {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
                padding: 1rem;
            }

            .ck-features-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }
        }

        /* Floating Action Button */
        .ck-fab {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            width: 60px;
            height: 60px;
            background: linear-gradient(45deg, #10b981, #059669);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            cursor: pointer;
            box-shadow: 0 5px 20px rgba(16, 185, 129, 0.4);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .ck-fab:hover {
            transform: scale(1.1);
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.6);
        }
    </style>

    <!-- CartKada Homepage Content -->
    <div class="cartkada-container">
        <!-- Navigation -->
        <nav class="ck-nav">
            <div class="ck-logo">CartKada</div>
            <ul class="ck-nav-links">
                <li><a href="#home">Home</a></li>
                <li><a href="#products">Products</a></li>
                <li><a href="#categories">Categories</a></li>
                <li><a href="#deals">Deals</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
            <button class="ck-cart-icon" onclick="toggleCart()">
                🛒 Cart
                <span class="ck-cart-count">3</span>
            </button>
        </nav>

        <!-- Hero Section -->
        <section class="ck-hero" id="home">
            <div class="ck-container">
                <div class="ck-hero-content">
                    <div class="ck-hero-text">
                        <h1>{{ __("Welcome CartKada!") }}</h1>
                        <p>Discover amazing products, unbeatable prices, and seamless shopping experience. Your one-stop destination for everything you need!</p>
                        <div class="ck-cta-buttons">
                            <a href="#products" class="ck-btn ck-btn-primary">Start Shopping</a>
                            <a href="#features" class="ck-btn ck-btn-secondary">Learn More</a>
                        </div>
                    </div>
                    <div class="ck-hero-image">
                        <div class="ck-hero-visual">
                            <div class="ck-shopping-icons">
                                <div class="ck-icon-item">
                                    <div class="emoji">📱</div>
                                    <div class="label">Electronics</div>
                                </div>
                                <div class="ck-icon-item">
                                    <div class="emoji">👕</div>
                                    <div class="label">Fashion</div>
                                </div>
                                <div class="ck-icon-item">
                                    <div class="emoji">🏠</div>
                                    <div class="label">Home</div>
                                </div>
                                <div class="ck-icon-item">
                                    <div class="emoji">📚</div>
                                    <div class="label">Books</div>
                                </div>
                                <div class="ck-icon-item">
                                    <div class="emoji">🎮</div>
                                    <div class="label">Gaming</div>
                                </div>
                                <div class="ck-icon-item">
                                    <div class="emoji">💄</div>
                                    <div class="label">Beauty</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="ck-features" id="features">
            <div class="ck-container">
                <h2 class="ck-section-title">Why Choose CartKada?</h2>
                <p class="ck-section-subtitle">Experience the future of online shopping with our cutting-edge features designed to make your life easier.</p>
                
                <div class="ck-features-grid">
                    <div class="ck-feature-card">
                        <div class="ck-feature-icon">🚀</div>
                        <h3>Fast Delivery</h3>
                        <p>Get your orders delivered within 24 hours with our express delivery service. Free shipping on orders above $50!</p>
                    </div>
                    <div class="ck-feature-card">
                        <div class="ck-feature-icon">🔒</div>
                        <h3>Secure Payments</h3>
                        <p>Shop with confidence using our encrypted payment system. Multiple payment options available for your convenience.</p>
                    </div>
                    <div class="ck-feature-card">
                        <div class="ck-feature-icon">💎</div>
                        <h3>Premium Quality</h3>
                        <p>All products are carefully curated and quality-checked to ensure you get only the best items.</p>
                    </div>
                    <div class="ck-feature-card">
                        <div class="ck-feature-icon">🎁</div>
                        <h3>Daily Deals</h3>
                        <p>Discover new deals every day with up to 70% off on selected items. Don't miss out on amazing offers!</p>
                    </div>
                    <div class="ck-feature-card">
                        <div class="ck-feature-icon">📞</div>
                        <h3>24/7 Support</h3>
                        <p>Our friendly customer support team is available round the clock to help you with any queries.</p>
                    </div>
                    <div class="ck-feature-card">
                        <div class="ck-feature-icon">↩️</div>
                        <h3>Easy Returns</h3>
                        <p>Not satisfied? No problem! Easy 30-day return policy with hassle-free refunds.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Floating Action Button -->
        <div class="ck-fab" onclick="scrollToTop()">↑</div>
    </div>

    <script>
        // Cart functionality
        function toggleCart() {
            alert('Cart functionality coming soon! You have 3 items in your cart.');
        }

        // Scroll to top
        function scrollToTop() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

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

        // Add scroll animation to feature cards
        function animateOnScroll() {
            const cards = document.querySelectorAll('.ck-feature-card');
            cards.forEach(card => {
                const cardTop = card.getBoundingClientRect().top;
                const cardVisible = 150;
                
                if (cardTop < window.innerHeight - cardVisible) {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }
            });
        }

        // Initialize feature cards as hidden
        document.querySelectorAll('.ck-feature-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(50px)';
            card.style.transition = 'all 0.6s ease';
        });

        window.addEventListener('scroll', animateOnScroll);
        animateOnScroll(); // Run once on load

        // Interactive cart count animation
        let cartCount = 3;
        setInterval(() => {
            const cartElement = document.querySelector('.ck-cart-count');
            if (cartElement) {
                cartElement.style.transform = 'scale(1.2)';
                setTimeout(() => {
                    cartElement.style.transform = 'scale(1)';
                }, 200);
            }
        }, 5000);
    </script>
</x-app-layout>