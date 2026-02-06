<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Dinasti Sushi - Cita Rasa Autentik Jepang</title>
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet" />
  </head>
  <body>
    <!-- Header -->
    <header class="header">
      <div class="container">
        <div class="nav-wrapper">
          <div class="logo">
            <span class="logo-icon">🍣</span>
          </div>
          <nav class="nav">
            <ul class="nav-links">
              <li><a href="#home">Home</a></li>
              <li><a href="#menu">Menu</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#gallery">Gallery</a></li>
              <li><a href="#contact">Contact</a></li>
            </ul>
          </nav>
          <div class="nav-right">
            <span class="location">📍 Bogor, Indonesia</span>
            <a href="{{ route('login') }}" class="btn-reservation-nav">Menu Order</a>
          </div>
          <button class="mobile-menu-btn">
            <span></span>
            <span></span>
            <span></span>
          </button>
        </div>
      </div>
    </header>

    <!-- Hero Section -->
    <section id="home" class="hero">
      <div class="hero-bg">
        <img src="https://images.unsplash.com/photo-1579871494447-9811cf80d66c?w=1920&q=80" alt="Sushi Background" />
        <div class="hero-overlay"></div>
      </div>
      <div class="container">
        <div class="hero-content">
          <h1 class="hero-title">
            Cita Rasa<br />
            Autentik<br />
            Jepang
          </h1>
          <p class="hero-subtitle">Nikmati kelezatan sushi premium dengan bahan-bahan segar pilihan langsung dari Jepang</p>
          <div class="hero-buttons">
            <a href="#menu" class="btn btn-primary">Explore menu</a>
            <button class="btn-play">
              <span class="play-icon">▶</span>
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Menu Section -->
    <section id="menu" class="menu-section">
      <div class="container">
        <div class="section-header">
          <h2 class="section-title">Koleksi Sushi<br />Kami</h2>
        </div>
        <div class="menu-grid">
          <div class="menu-card">
            <div class="menu-image">
              <img src="https://images.unsplash.com/photo-1579584425555-c3ce17fd4351?w=400&q=80" alt="Salmon Nigiri Set" />
            </div>
            <div class="menu-info">
              <h3>Salmon Nigiri Set</h3>
              <p class="menu-price">Rp 185.000</p>
            </div>
          </div>
          <div class="menu-card">
            <div class="menu-image">
              <img src="https://images.unsplash.com/photo-1617196034796-73dfa7b1fd56?w=400&q=80" alt="Tuna Sashimi Deluxe" />
            </div>
            <div class="menu-info">
              <h3>Tuna Sashimi Deluxe</h3>
              <p class="menu-price">Rp 225.000</p>
            </div>
          </div>
          <div class="menu-card">
            <div class="menu-image">
              <img src="https://images.unsplash.com/photo-1553621042-f6e147245754?w=400&q=80" alt="Dragon Roll Special" />
            </div>
            <div class="menu-info">
              <h3>Dragon Roll Special</h3>
              <p class="menu-price">Rp 165.000</p>
            </div>
          </div>
          <div class="menu-card">
            <div class="menu-image">
              <img src="https://images.unsplash.com/photo-1611143669185-af224c5e3252?w=400&q=80" alt="Omakase Premium" />
            </div>
            <div class="menu-info">
              <h3>Omakase Premium</h3>
              <p class="menu-price">Rp 450.000</p>
            </div>
          </div>
          <div class="menu-card">
            <div class="menu-image">
              <img src="https://images.unsplash.com/photo-1534482421-64566f976cfa?w=400&q=80" alt="Spicy Tuna Roll" />
            </div>
            <div class="menu-info">
              <h3>Spicy Tuna Roll</h3>
              <p class="menu-price">Rp 145.000</p>
            </div>
          </div>
          <div class="menu-card">
            <div class="menu-image">
              <img src="https://images.unsplash.com/photo-1580822184713-fc5400e7fe10?w=400&q=80" alt="Chirashi Bowl" />
            </div>
            <div class="menu-info">
              <h3>Chirashi Bowl</h3>
              <p class="menu-price">Rp 275.000</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
      <div class="about-wrapper">
        <div class="about-image">
          <img src="https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=800&q=80" alt="Restaurant Interior" />
        </div>
        <div class="about-content">
          <span class="about-tag">Our Story</span>
          <h2 class="about-title">Warisan Kuliner<br />Jepang Sejak 2010</h2>
          <p class="about-text">Dinasti Sushi hadir untuk membawa pengalaman kuliner Jepang autentik ke Indonesia. Dengan chef berpengalaman langsung dari Tokyo, kami menyajikan sushi dengan kualitas terbaik.</p>
          <p class="about-text">
            Setiap hidangan dibuat dengan penuh dedikasi, menggunakan bahan-bahan premium yang diimpor langsung dari pasar ikan Tsukiji. Kami percaya bahwa makanan adalah seni, dan setiap piring adalah karya masterpiece.
          </p>
          <blockquote class="about-quote">"Setiap potongan sashimi adalah perjalanan ke Jepang, tanpa harus meninggalkan Indonesia"</blockquote>
          <a href="#gallery" class="btn btn-outline">Lihat Gallery</a>
        </div>
      </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="gallery-section">
      <div class="container">
        <h2 class="section-title-center">Momen Istimewa di Dinasti Sushi 🍣</h2>
        <div class="gallery-grid">
          <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?w=400&q=80" alt="Sushi Preparation" />
          </div>
          <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1540648639573-8c848de23f0a?w=400&q=80" alt="Sushi Platter" />
          </div>
          <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1583623025817-d180a2221d0a?w=400&q=80" alt="Restaurant Ambiance" />
          </div>
          <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1579027989536-b7b1f875659b?w=400&q=80" alt="Nigiri Selection" />
          </div>
          <div class="gallery-item">
            <img src="https://images.unsplash.com/photo-1617196034183-421b4917c92d?w=400&q=80" alt="Sashimi Fresh" />
          </div>
        </div>
      </div>
    </section>

    <!-- Reservation Section -->
    <section id="contact" class="reservation-section">
      <div class="reservation-bg">
        <img src="https://images.unsplash.com/photo-1514190051997-0f6f39ca5cde?w=1920&q=80" alt="Restaurant Background" />
        <div class="reservation-overlay"></div>
      </div>
      <div class="container">
        <div class="reservation-content">
          <h2 class="reservation-title">menu<br />order</h2>
          <p class="reservation-subtitle">Pesan menu favorit Anda sekarang dan nikmati kelezatan sushi autentik</p>
          <div class="reservation-buttons">
            <a href="{{ route('login') }}" class="btn btn-primary">Menu Order</a>
            <button class="btn-play-light">
              <span class="play-icon">▶</span>
            </button>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
      <div class="container">
        <div class="footer-grid">
          <div class="footer-col">
            <h4>Menu</h4>
            <ul>
              <li><a href="#">Sushi</a></li>
              <li><a href="#">Sashimi</a></li>
              <li><a href="#">Ramen</a></li>
              <li><a href="#">Donburi</a></li>
            </ul>
          </div>
          <div class="footer-col">
            <h4>Lokasi</h4>
            <ul>
              <li><a href="#">Jakarta Selatan</a></li>
              <li><a href="#">Jakarta Pusat</a></li>
              <li><a href="#">Bandung</a></li>
              <li><a href="#">Surabaya</a></li>
            </ul>
          </div>
          <div class="footer-col">
            <h4>Layanan</h4>
            <ul>
              <li><a href="#">Dine-in</a></li>
              <li><a href="#">Delivery</a></li>
              <li><a href="#">Catering</a></li>
              <li><a href="#">Private Event</a></li>
            </ul>
          </div>
          <div class="footer-col">
            <h4>Ikuti Kami</h4>
            <div class="social-links">
              <a href="#" class="social-link">Instagram</a>
              <a href="#" class="social-link">Facebook</a>
              <a href="#" class="social-link">TikTok</a>
            </div>
          </div>
        </div>
        <div class="footer-bottom">
          <p>&copy; {{ date('Y') }} Dinasti Sushi. All rights reserved.</p>
        </div>
      </div>
    </footer>

    <script src="{{ asset('js/landing.js') }}"></script>
  </body>
</html>
