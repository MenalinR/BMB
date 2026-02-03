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
            gap: 10px;
            font-size: 24px;
            font-weight: 800;
        }

        .logo i {
            font-size: 32px;
            color: #000;
        }

        .logo-text {
            display: flex;
            flex-direction: column;
            line-height: 1;
        }

        .logo-text .online {
            color: #000;
            font-size: 18px;
            font-weight: 800;
        }

        .logo-text .store {
            color: #d4956b;
            font-size: 20px;
            font-style: italic;
            font-weight: 700;
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
            font-size: 13px;
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
        }

        .call-number {
            color: #000;
            font-size: 20px;
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
            height: calc(100vh - 140px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 60px;
            position: relative;
        }

        /* Left Section */
        .left-section {
            flex: 1;
            z-index: 2;
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
            font-size: 60px;
            color: #d4956b;
            font-style: italic;
            font-weight: 700;
        }

        .left-section p {
            font-size: 14px;
            color: #999;
            margin-top: 20px;
        }

        /* Center Section - Image */
        .center-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            z-index: 1;
        }

        .image-circle {
            width: 450px;
            height: 450px;
            border-radius: 50%;
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
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            justify-content: center;
            z-index: 2;
        }

        .right-section h3 {
            font-size: 16px;
            color: #000;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-bottom: 10px;
        }

        .discount-section {
            text-align: right;
        }

        .discount-section .discount-percent {
            font-size: 80px;
            color: #d4956b;
            font-weight: 800;
            line-height: 0.9;
        }

        .discount-section .discount-label {
            font-size: 20px;
            color: #d4956b;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .underline {
            width: 80px;
            height: 3px;
            background: #000;
            margin: 20px auto 0;
        }

        /* Decorative Circle */
        .decorative-circle {
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: #d4956b;
            opacity: 0.3;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            z-index: 0;
        }

        /* Footer */
        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 25px 60px;
            background-color: #f5ede4;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 14px;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .footer-left {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #d4956b;
        }

        .footer-left i {
            font-size: 24px;
        }

        .footer-left span {
            font-weight: 600;
            color: #000;
        }

        .footer-right {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .social-icons {
            display: flex;
            gap: 15px;
        }

        .social-icons a {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #d4956b;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 18px;
            transition: all 0.3s;
        }

        .social-icons a:hover {
            background: #000;
            transform: scale(1.1);
        }

        .copyright {
            color: #666;
            font-size: 11px;
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
            <i class="fas fa-shopping-cart"></i>
            <div class="logo-text">
                <span class="store">Blessing</span>
                <span class="store">Multi</span>
                <span class="store">Business</span>
            </div>
        </div>

        <nav>
            <a href="#home">HOME</a>
            <a href="#products">PRODUCTS</a>
            <a href="#about">ABOUT</a>
            <a href="#contact">CONTACT</a>
        </nav>

        <div class="call-section">
            <span class="call-label">CALL NOW</span>
            <span class="call-number">1800 888 555</span>
        </div>

        <a href="{{ route('login') }}" class="login-btn">Login</a>
    </header>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Left Section -->
        <div class="left-section">
            <h2>NEW ARRIVALS</h2>
            <h1>JUST FOR</h1>
            <div class="highlight">you</div>
            <p>Discover our latest collection of premium products designed exclusively for you.</p>
        </div>

        <!-- Center Section - Image -->
        <div class="center-section">
            <div class="image-circle">
                <img src="{{ asset('images/banner.png') }}" alt="BMB Products - Instruments, Clothes, Nuts & Services">
                <div class="image-overlay"></div>
            </div>
        </div>

        <!-- Right Section -->
        <div class="right-section">
            <h3>FOR<br>ONLINE<br>ORDER</h3>
            <div class="discount-section">
                <div class="discount-percent">30%</div>
                <div class="discount-label">OFF</div>
                <div class="underline"></div>
            </div>
        </div>

        <!-- Decorative Circle -->
        <div class="decorative-circle"></div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-left">
            <i class="fas fa-map-marker-alt"></i>
            <span>BUILDING NAME<br>MAIN ROAD, COUNTRY, 45612</span>
        </div>

        <div class="footer-right">
            <div class="social-icons">
                <a href="#" title="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" title="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" title="Twitter"><i class="fab fa-twitter"></i></a>
                <a href="#" title="WhatsApp"><i class="fab fa-whatsapp"></i></a>
            </div>
            <span class="copyright">© Company Name 2026. All rights reserved.</span>
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
