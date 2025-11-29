<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotelbase - Experience Comfort</title>
    <style>
          :root{ --brown:#8B4513;--light-brown:#8B6F47;--muted:#f4f4f6;--card:#fff; --radius:8px;font-family:Arial,Helvetica,sans-serif;color:#333; }
        *{box-sizing:border-box}
        body{margin:0;background:var(--muted);padding:0}
        header{ background:var(--brown); padding:0; margin:0; box-shadow:0 4px 8px rgba(0,0,0,0.1); }
        .nav-indicator{display:none}
        .topbar{ background:var(--brown); padding:14px 0; }
        .topbar .nav-inner{ max-width:1100px; margin:0 auto; display:flex; align-items:center; gap:20px; padding:0 16px; }
        .topbar .brand{ font-weight:700; color:#fff; display:flex; align-items:center; gap:8px; font-size:16px; }
        .brand .logo{ width:22px; height:22px; object-fit:contain }
        .top-links{ margin-left:auto; display:flex; gap:50px; align-items:center; }
        .top-links a{ color:#fff; text-decoration:none; font-size:15px; transition:opacity 0.3s; }
        .top-links a:hover{ opacity:0.8; }
        main{ padding:36px 16px; }
        .hero { position: relative; background: url("/img.png") center/cover no-repeat; color: white; text-align: center; padding: 120px 20px; }
        .hero::before { content: ""; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(139, 69, 19, 0.5); z-index: 1; filter: blur(5px); }
        .hero h1, .hero p, .hero-btn { position: relative; z-index: 2; }
        .hero-btn { background-color: #8B4513; color: white; padding: 12px 30px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; transition: background-color 0.3s; }
        .hero-btn:hover { background-color: #6b3410; }
        .why-choose { padding: 60px 20px; text-align: center; background-color: #f9f9f9; }
        .why-choose h2 { font-size: 36px; margin-bottom: 50px; color: #333; }
        .features { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; max-width: 1200px; margin: 0 auto; }
        .feature-card { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: transform 0.3s; }
        .feature-card:hover { transform: translateY(-5px); }
        .feature-icon { width: 60px; height: 60px; background-color: #8B6F47; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px; font-size: 30px; color: white; }
        .feature-card h3 { font-size: 20px; margin-bottom: 10px; color: #333; }
        .feature-card p { font-size: 14px; color: #666; line-height: 1.6; }
        footer { background-color: #8B6F47; color: white; padding: 40px 20px; text-align: center; }
        .footer-content { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; text-align: left; }
        .footer-section h4 { margin-bottom: 15px; font-size: 16px; }
        .footer-section p, .footer-section a { font-size: 14px; color: #f0f0f0; text-decoration: none; display: block; margin: 8px 0; }
        .footer-section a:hover { color: #FFD700; }
        .social-icons { display: flex; gap: 15px; margin-top: 15px; }
        .social-icons a { display: inline-block; width: 30px; height: 30px; background-color: #6b5a42; border-radius: 50%; text-align: center; line-height: 30px; }
        .footer-bottom { margin-top: 30px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.2); text-align: center; font-size: 12px; }
        @media (max-width: 768px) { .hero h1 { font-size: 32px; } nav a { margin: 0 10px; font-size: 12px; } .why-choose h2 { font-size: 28px; } }
    </style>
    </head>
<body>
    <header>
    <div class="nav-indicator" aria-hidden></div>
    <div class="topbar">
        <div class="nav-inner">
        <a href="{{ route('home') }}" style="text-decoration: none;"><div class="brand"><img src="/logo.png" alt="Logo" class="logo"> HotelEase</div></a>
        <nav class="top-links" aria-label="Main">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('book') }}">Booking</a>
        </nav>
        </div>
    </div>
    </header>

    <div class="hero" id="home">
        <h1>Experience Comfort, Convenience, and Modern Hospitality</h1>
        <p>Your perfect stay awaits</p>
        <a href="{{ route('services') }}"><button class="hero-btn">Services</button></a>
    </div>

    <section class="why-choose" id="why-choose">
        <h2>Why Choose Hotelbase</h2>
        <div class="features">
            <div class="feature-card">
                <div class="feature-icon">🏨</div>
                <h3>Best Locations</h3>
                <p>Located in the heart of the city, close to all major attractions and transportation hubs.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⭐</div>
                <h3>Luxury Service</h3>
                <p>Experience world-class service with our dedicated and professional staff members.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💰</div>
                <h3>Affordable Rates</h3>
                <p>Get the best value for your money with our competitive and transparent pricing.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🛏️</div>
                <h3>Comfortable Rooms</h3>
                <p>Relax in our spacious and well-equipped rooms with modern amenities.</p>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h4>🏨 HotelEase</h4>
                <p>Experience comfort and convenience at Hotelbase.</p>
            </div>
             <div class="footer-section">
                <h4>Quick Links</h4>
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('services') }}">Services</a>
            </div>
            <div class="footer-section" id="Contact">
                <h4>Contact Info</h4>
                <p>📍 HotelEase, Cebu IT Park, Abad St, Brgy Apas, Cebu City, 6000 Cebu, Philippines.</p>
                <p>📞 +1 (555) 123-4567</p>
                <p>📧 info@hotelease.com</p>
            </div>
            <div class="footer-section">
                <h4>Follow Us</h4>
                <div class="social-icons">
                    <a href="#" title="Facebook">f</a>
                    <a href="#" title="Twitter">𝕏</a>
                    <a href="#" title="Instagram">📷</a>
                    <a href="#" title="LinkedIn">in</a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 HotelEase. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
