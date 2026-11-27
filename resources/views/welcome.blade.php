<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Store - BMB</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5ede4;
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header */
        header {
            background-color: #f5ede4;
            padding: 15px 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 24px;
            font-weight: 800;
        }

        .logo i {
            font-size: 32px;
            color: #000;
        }

        .logo img {
            width: 100px;
            height: 100px;
            object-fit: contain;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1;
            gap: 12px;
        }

        .logo-text .online {
            color: #000;
            font-size: 18px;
            font-weight: 800;
        }

        .logo-text .store {
            color: #d4956b;
            font-size: 16px;
            font-style: normal;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .logo-text .store:first-child {
            color: #333;
        }

        nav {
            display: flex;
            gap: 40px;
            flex: 1;
            justify-content: center;
        }

        nav a {
            text-decoration: none;
            color: #000;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #d4956b;
        }

        .call-section {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            font-size: 13px;
        }

        .call-label {
            color: #000;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 16px;
        }

        .call-number {
            color: #000;
            font-size: 15px;
            font-weight: 800;
        }

        .login-btn {
            background: #d4956b;
            color: white;
            padding: 12px 30px;
            border: none;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            cursor: pointer;
            transition: all 0.3s;
            border-radius: 3px;
            text-decoration: none;
            display: inline-block;
            margin-left: 30px;
        }

        .login-btn:hover {
            background: #000;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Main Container */
        .main-container {
            margin-top: 70px;
            height: calc(100vh - 420px);
            display: flex;
            align-items: center;
            
            padding: 20px 90px 20px 60px;
            position: relative;
            gap: 100px;
            flex: 1;
        }

        /* Left Section */
        .left-section {
            flex: 0 0 600px;
            z-index: 2;
            text-align: left;
            padding-right: 10px;
            align-self: center;
        }

        .left-section h2 {
            font-size: 14px;
            color: #666;
            font-weight: 500;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 15px;
        }

        .left-section h1 {
            font-size: 72px;
            font-weight: 900;
            line-height: 0.9;
            margin-bottom: 10px;
            color: #000;
        }

        .left-section .highlight {
            font-size: 64px;
            color: #2c3e50;
            font-weight: 900;
            line-height: 1;
            margin-bottom: 25px;
            letter-spacing: -2px;
        }

        .left-section p {
            font-size: 15px;
            color: #555;
            margin-top: 20px;
            line-height: 1.8;
            max-width: 600px;
            font-weight: 400;
            letter-spacing: 0.3px;
            margin-bottom: 30px;
        }

        .shop-btn {
            display: inline-block;
            padding: 12px 35px;
            background: #2c3e50;
            color: white;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 1px;
            text-transform: lowercase;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        .shop-btn:hover {
            background: #1a252f;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        /* Center Section - Image */
        .center-section {
            flex: 0 0 420px;
            display: flex;
            justify-content: flex-start;
            align-items: center;
            position: relative;
            z-index: 1;
            margin-left: 20px;
        }

        .image-circle {
            width: 1100px;
            height: 650px;
            border-radius: 16px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            position: relative;
            filter: brightness(0.65);
        }

        .image-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-grid {
            width: 100%;
            height: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            grid-template-rows: 1fr 1fr;
            gap: 0;
        }

        .image-grid img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(212, 149, 107, 0.05), rgba(0, 0, 0, 0.05));
            pointer-events: none;
        }

        /* Right Section */
        .right-section {
            flex: 0.8;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            z-index: 2;
            padding-left: 20px;
        }

        .right-section h3 {
            font-size: 28px;
            color: #000;
            font-weight: 700;
            text-transform: capitalize;
            letter-spacing: 1px;
            margin-bottom: 25px;
            text-align: center;
        }

        .services-list {
            display: flex;
            flex-direction: column;
            gap: 18px;
            text-align: left;
        }

        .services-list p {
            font-size: 16px;
            color: #333;
            line-height: 1.6;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 12px;
            margin: 0;
        }

        .services-list p strong {
            color: #000;
            font-weight: 600;
        }

        /* Footer */
        footer {
            position: relative;
            bottom: auto;
            left: auto;
            right: auto;
            padding: 30px 60px;
            background-color: #f5ede4;
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1.2fr;
            gap: 30px;
            font-size: 12px;
            border-top: 1px solid rgba(0, 0, 0, 0.06);
            margin-top: auto;
        }

        .footer-section {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .footer-section h3 {
            font-size: 14px;
            font-weight: 700;
            color: #000;
            margin-bottom: 8px;
        }

        .footer-section p {
            font-size: 13px;
            color: #333;
            line-height: 1.6;
        }

        .footer-links {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .footer-links a {
            color: #000;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .footer-links a:hover {
            color: #d4956b;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
            font-size: 18px;
            font-weight: 800;
        }

        .footer-logo i {
            font-size: 28px;
            color: #ff8c00;
        }

        .footer-logo img {
            width: 45px;
            height: 45px;
            object-fit: contain;
        }

        .footer-contact {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .contact-info {
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }

        .contact-info i {
            font-size: 18px;
            color: #ff8c00;
            margin-top: 2px;
        }

        .social-icons {
            display: flex;
            gap: 12px;
            margin-top: 10px;
        }

        .social-icons a {
            width: 36px;
            height: 36px;
            border-radius: 4px;
            background: #000;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 16px;
            transition: all 0.3s;
        }

        .social-icons a:hover {
            background: #d4956b;
        }

        .app-buttons {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-top: 15px;
        }

        .app-button {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            background: #000;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .app-button:hover {
            background: #d4956b;
        }

        .app-button i {
            font-size: 18px;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            header {
                padding: 15px 40px;
            }

            .main-container {
                padding: 0 40px;
                padding-bottom: 100px;
                flex-direction: column;
                height: auto;
                min-height: 100vh;
            }

            nav {
                gap: 30px;
            }

            .left-section h1 {
                font-size: 60px;
            }

            .left-section .highlight {
                font-size: 50px;
            }

            .image-circle {
                width: 300px;
                height: 300px;
            }

            .right-section {
                margin-top: 40px;
                align-items: center;
            }

            footer {
                padding: 20px 40px;
                font-size: 12px;
            }
        }

        @media (max-width: 768px) {
            header {
                padding: 15px 20px;
                flex-wrap: wrap;
                gap: 10px;
            }

            nav {
                gap: 15px;
                font-size: 11px;
            }

            .main-container {
                padding: 20px;
                padding-bottom: 120px;
            }

            .left-section h1 {
                font-size: 42px;
            }

            .left-section .highlight {
                font-size: 36px;
            }

            .image-circle {
                width: 250px;
                height: 250px;
            }

            .right-section .discount-percent {
                font-size: 72px;
            }

            .decorative-circle {
                width: 200px;
                height: 200px;
            }

            footer {
                padding: 15px 20px;
                font-size: 11px;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <div class="logo">
            <img src="{{ asset('images/bmb.png') }}" alt="BMB Logo">
            <div class="logo-text">
                <span class="store">Blessing</span>
                <span class="store">Multi Business</span>

            </div>
        </div>

        <nav>
            <a href="#home">HOME</a>
            <a href="#products">PRODUCTS</a>
            <a href="#about">ABOUT</a>
            <a href="#contact">CONTACT</a>
            <a href="#contact">SERVICES</a>
        </nav>

        <div class="call-section">
            <span class="call-label">CALL NOW</span>
            <span class="call-number">+94 779 090 517</span>
        </div>

        <a href="{{ route('login') }}" class="login-btn">Login</a>
    </header>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Left Section -->
        <div class="left-section">
            <div class="highlight">Built for Your Lifestyle</div>
            <p>We are a multi-business platform designed to make your life easier. From quality musical instruments and stylish clothing to fresh nuts and trusted services, we bring everything together in one convenient place. Our focus is on quality, reliability, and customer satisfaction.</p>
            <a href="#shop" class="shop-btn">shop now</a>
        </div>

        <!-- Center Section - Image -->
        <div class="center-section">
            <div class="image-circle">
                <img src="{{ asset('images/banner.png') }}" alt="BMB Products - Instruments, Clothes, Nuts & Services">
                <div class="image-overlay"></div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <!-- Left Section: Logo & Description -->
        <div class="footer-section">
            <div class="footer-logo">
                <img src="{{ asset('images/bmb.png') }}" alt="BMB Logo">
                <span>BMB</span>
            </div>
            <p>Welcome to BMB! Discover our range of quality products. Whether you're looking for music instruments, fashion, healthy nuts, or services, we've got you covered. Stay connected via social media for the latest news and offers. Thanks for choosing us!</p>
        </div>

        <!-- Middle Left: Important Links -->
        <div class="footer-section">
            <h3>Important Links</h3>
            <div class="footer-links">
                <a href="#introduction">Introduction</a>
                <a href="#products">Our Products</a>
                <a href="#advertisement">Advertisement</a>
                <a href="#testimonials">Testimonials</a>
            </div>
        </div>

        <!-- Middle Right: Information -->
        <div class="footer-section">
            <h3>Information</h3>
            <div class="footer-links">
                <a href="#about">About Us</a>
                <a href="#terms">Terms & Conditions</a>
                <a href="#privacy">Privacy policy</a>
                <a href="#contact">Contact</a>
            </div>
        </div>

        <!-- Right Section: Contact & Social -->
        <div class="footer-section">
            <h3>Contact & Follow</h3>
            <div class="footer-contact">
                <div class="contact-info">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Savatkaddu, Mannar</span>
                </div>
                <div class="contact-info">
                    <i class="fas fa-phone"></i>
                    <span>+94 779090517</span>
                </div>
                <div class="social-icons">
                    <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" title="TikTok"><i class="fab fa-tiktok"></i></a>
                    <a href="#" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    <a href="#" title="YouTube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Smooth scroll for navigation links
        document.querySelectorAll('nav a').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const section = document.querySelector(this.getAttribute('href'));
                if (section) {
                    section.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>
