<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services - Hotelbase</title>
    <style>
        :root{ --brown:#8B4513;--light-brown:#8B6F47;--muted:#f4f4f6;--card:#fff; --radius:8px;font-family:Arial,Helvetica,sans-serif;color:#333; }
        *{box-sizing:border-box}
        body{margin:0;background:var(--muted);padding:0}
        header{ background:var(--brown); padding:0; margin:0; box-shadow:0 4px 8px rgba(0,0,0,0.1); }
        .nav-indicator{display:none}
        .topbar{ background:var(--brown); padding:14px 0; }
        .topbar .nav-inner{ max-width:1100px; margin:0 auto; display:flex; align-items:center; gap:20px; padding:0 16px; }
        .topbar .brand{ font-weight:700; color:#fff; display:flex; align-items:center; gap:8px; font-size:16px; }
        .top-links{ margin-left:auto; display:flex; gap:20px; align-items:center; }
        .top-links a{ color:#fff; text-decoration:none; font-size:15px; transition:opacity 0.3s; }
        .top-links a:hover{ opacity:0.8; }
        .hero { position: relative; background: url("/Service.png") center/cover no-repeat; color: white; text-align: center; padding: 120px 20px; }
        .hero::before { content: ""; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(139, 69, 19, 0.5); z-index: 1; filter: blur(5px); }
        .hero h1, .hero p{ position: relative; z-index: 2; }
        .services { padding: 60px 20px; background-color: #ffffff; }
        .services h2 { font-size: 36px; text-align: center; margin-bottom: 50px; color: #333; }
        .rooms-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; max-width: 1200px; margin: 0 auto; }
        .room-card { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: transform 0.3s, box-shadow 0.3s; }
        .room-card:hover { transform: translateY(-8px); box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
        .room-image { width: 100%; height: 200px; background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; color: white; font-size: 14px; text-align: center; padding: 20px; position: relative; }
        .room-badge { position: absolute; top: 10px; right: 10px; background-color: #8B4513; color: white; padding: 5px 10px; border-radius: 20px; font-size: 12px; }
        .room-info { padding: 25px; }
        .room-info h3 { font-size: 22px; color: #333; margin-bottom: 12px; }
        .room-info p { font-size: 14px; color: #666; line-height: 1.6; margin-bottom: 15px; }
        .room-amenities { display: flex; gap: 15px; margin: 15px 0; flex-wrap: wrap; }
        .amenity { font-size: 12px; background-color: #f0f0f0; padding: 6px 12px; border-radius: 4px; color: #666; }
        .room-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 20px; border-top: 1px solid #e0e0e0; padding-top: 15px; }
        .room-price { font-size: 24px; color: #8B4513; font-weight: bold; }
        .room-btn { background-color: #8B4513; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; transition: background-color 0.3s; }
        .room-btn:hover { background-color: #6b3410; }
        footer { background-color: #8B6F47; color: white; padding: 40px 20px; text-align: center; }
        .footer-content { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; text-align: left; }
        .footer-section h4 { margin-bottom: 15px; font-size: 16px; }
        .footer-section p, .footer-section a { font-size: 14px; color: #f0f0f0; text-decoration: none; display: block; margin: 8px 0; }
        .footer-section a:hover { color: #FFD700; }
        .social-icons { display: flex; gap: 15px; margin-top: 15px; }
        .social-icons a { display: inline-block; width: 30px; height: 30px; background-color: #6b5a42; border-radius: 50%; text-align: center; line-height: 30px; }
        .footer-bottom { margin-top: 30px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.2); text-align: center; font-size: 12px; }
        @media (max-width: 768px) { .page-header h1 { font-size: 32px; } nav a { margin: 0 10px; font-size: 12px; } .services h2 { font-size: 28px; } .rooms-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <header>
    <div class="nav-indicator" aria-hidden></div>
    <div class="topbar">
        <div class="nav-inner">
        <a href="{{ route('home') }}" style="text-decoration: none;"><div class="brand">🏨 HotelEase</div></a>
        <nav class="top-links" aria-label="Main">
            <a href="{{ route('home') }}">Home</a>
            <a href="{{ route('book') }}">Booking</a>
        </nav>
        </div>
    </div>
    </header>

    <div class="hero" id="home">
        <h1>Our Room Services</h1>
        <p>Choose from our variety of luxurious room options</p>
    </div>

    <section class="services">
        <h2>Available Rooms</h2>
        <div class="rooms-grid">
            <div class="room-card">
                <div class="room-image" style="background-image: url('/StandardRoom.png')">
                    <span class="room-badge">MOST POPULAR</span>
                    Standard Room 🛏️
                </div>
                <div class="room-info">
                    <h3>Standard Room</h3>
                    <p>Comfortable room perfect for individual travelers or couples. Features modern amenities and a cozy atmosphere.</p>
                    <div class="room-amenities">
                        <span class="amenity">📺 LED TV</span>
                        <span class="amenity">❄️ AC</span>
                        <span class="amenity">📶 WiFi</span>
                        <span class="amenity">🛁 Bathroom</span>
                    </div>
                    <div class="room-footer">
                        <span class="room-price">₱1500/night</span>
                        <a href="{{ route('book') }}?room=Standard%20Room"><button class="room-btn">Book Now</button></a>
                    </div>
                </div>
            </div>

            <div class="room-card">
                <div class="room-image" style="background-image: url('/Delux.png')">
                    <span class="room-badge">DELUXE</span>
                    Deluxe Room 🌟
                </div>
                <div class="room-info">
                    <h3>Deluxe Room</h3>
                    <p>Spacious room with premium furnishings and stunning city views. Perfect for business travelers or leisure guests.</p>
                    <div class="room-amenities">
                        <span class="amenity">📺 Smart TV</span>
                        <span class="amenity">❄️ Climate Control</span>
                        <span class="amenity">📶 High-Speed WiFi</span>
                        <span class="amenity">🛁 Luxury Bath</span>
                    </div>
                    <div class="room-footer">
                        <span class="room-price">₱1760/night</span>
                        <a href="{{ route('book') }}?room=Deluxe%20Room"><button class="room-btn">Book Now</button></a>
                    </div>
                </div>
            </div>

            <div class="room-card">
                <div class="room-image" style="background-image: url('/Executive.png')">
                    <span class="room-badge">EXECUTIVE</span>
                    Executive Suite 👑
                </div>
                <div class="room-info">
                    <h3>Executive Suite</h3>
                    <p>Luxurious suite with separate living area and premium amenities. Ideal for executives and special occasions.</p>
                    <div class="room-amenities">
                        <span class="amenity">📺 Cinema System</span>
                        <span class="amenity">❄️ Smart Climate</span>
                        <span class="amenity">📶 Ultra WiFi</span>
                        <span class="amenity">🛁 Spa Bath</span>
                    </div>
                    <div class="room-footer">
                        <span class="room-price">₱6000/night</span>
                        <a href="{{ route('book') }}?room=Executive%20Suite"><button class="room-btn">Book Now</button></a>
                    </div>
                </div>
            </div>

            <div class="room-card">
                <div class="room-image" style="background-image: url('/Premium.png')">
                    <span class="room-badge">PREMIUM</span>
                    Premium Suite 💎
                </div>
                <div class="room-info">
                    <h3>Premium Suite</h3>
                    <p>Our most luxurious offering with panoramic views and exclusive services. An unforgettable experience awaits.</p>
                    <div class="room-amenities">
                        <span class="amenity">📺 4K Display</span>
                        <span class="amenity">❄️ Automated Climate</span>
                        <span class="amenity">📶 Private WiFi</span>
                        <span class="amenity">🛁 Jacuzzi Tub</span>
                    </div>
                    <div class="room-footer">
                        <span class="room-price">₱3700/night</span>
                        <a href="{{ route('book') }}?room=Premium%20Suite"><button class="room-btn">Book Now</button></a>
                    </div>
                </div>
            </div>

            <div class="room-card">
                <div class="room-image" style="background-image: url('/Family.png')">
                    <span class="room-badge">FAMILY</span>
                    Family Room 👨‍👩‍👧‍👦
                </div>
                <div class="room-info">
                    <h3>Family Room</h3>
                    <p>Spacious rooms designed for families with multiple beds and a comfortable living area for everyone.</p>
                    <div class="room-amenities">
                        <span class="amenity">📺 Multiple TVs</span>
                        <span class="amenity">❄️ AC</span>
                        <span class="amenity">📶 WiFi</span>
                        <span class="amenity">🛁 Large Bath</span>
                    </div>
                    <div class="room-footer">
                        <span class="room-price">₱1100/night</span>
                        <a href="{{ route('book') }}?room=Family%20Room"><button class="room-btn">Book Now</button></a>
                    </div>
                </div>
            </div>

            <div class="room-card">
                <div class="room-image" style="background-image: url('/Penthouse.png')">
                    <span class="room-badge">PENTHOUSE</span>
                    Penthouse Suite 🏰
                </div>
                <div class="room-info">
                    <h3>Penthouse Suite</h3>
                    <p>Top-floor luxury with breathtaking views, exclusive amenities, and personalized concierge service available.</p>
                    <div class="room-amenities">
                        <span class="amenity">📺 Home Theater</span>
                        <span class="amenity">❄️ Smart Control</span>
                        <span class="amenity">📶 Fiber WiFi</span>
                        <span class="amenity">🛁 Steam Room</span>
                    </div>
                    <div class="room-footer">
                        <span class="room-price">₱9800/night</span>
                        <a href="{{ route('book') }}?room=Penthouse%20Suite"><button class="room-btn">Book Now</button></a>
                    </div>
                </div>
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

