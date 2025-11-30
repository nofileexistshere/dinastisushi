# 🍣 Dinasti Sushi - AI-Powered Sushi Recommendation System

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/TailwindCSS-3-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="TailwindCSS">
  <img src="https://img.shields.io/badge/Alpine.js-3-8BC0D0?style=for-the-badge&logo=alpine.js&logoColor=white" alt="Alpine.js">
  <img src="https://img.shields.io/badge/SQLite-3-003B57?style=for-the-badge&logo=sqlite&logoColor=white" alt="SQLite">
</p>

A modern web application for sushi restaurant recommendations powered by collaborative filtering AI algorithm. Built with Laravel 12, featuring personalized menu suggestions based on user preferences and ratings.

## ✨ Features

### 🔐 Authentication System
- **User Registration** - Create new accounts with email/password
- **Secure Login** - Email and password authentication
- **Demo Accounts** - Quick access with pre-configured users:
  - 🍱 Budi Santoso (budi@example.com) - Suka Salmon & Pedas
  - 🥗 Siti Nurhaliza (siti@example.com) - Vegetarian
  - 💎 Ahmad Rizki (ahmad@example.com) - Premium Menu

### 🤖 AI-Powered Recommendations
- **Collaborative Filtering Algorithm** using Cosine Similarity
- **Personalized Suggestions** based on user rating history
- **Similar User Analysis** to find matching preferences
- **Content-Based Filtering** considering ingredients, category, and price
- **Weighted Scoring System** combining multiple factors

### 📱 User Interface
- **Responsive Design** - Mobile, Tablet, Desktop optimized
- **Modern UI/UX** with TailwindCSS
- **Interactive Components** using Alpine.js
- **Smooth Animations** and transitions
- **Beautiful Gradients** (Pink to Orange theme)

### 📊 Dashboard
- **Welcome Banner** with personalized greeting
- **User Statistics** - Total orders and recommendations count
- **Algorithm Explanation** - Expandable details about collaborative filtering
- **Top Recommendations** - AI-suggested menu items with scores
- **Quick Actions** - Navigate to menu and history

### 🍱 Menu System
- **Category Filtering** - Nigiri, Maki, Sashimi, Special
- **Search Functionality** - Find dishes by name or description
- **Detailed Menu Cards** - Image, description, price, ratings
- **Order Placement** - Direct ordering with quantity selection
- **Rating System** - 5-star rating after ordering

### 📜 Order History
- **Purchase Tracking** - View all past orders
- **Statistics Dashboard** - Total orders, spending, average rating
- **Sort Options** - By date or rating
- **Rating Management** - View and update your ratings
- **Detailed Order Cards** - Full information with images

## 🛠️ Tech Stack

- **Backend**: Laravel 12 (PHP 8.3+)
- **Database**: SQLite
- **Frontend**: Blade Templates, TailwindCSS 3, Alpine.js 3
- **Build Tool**: Vite
- **CSS Framework**: TailwindCSS with custom gradient theme
- **JavaScript**: Alpine.js for reactive components

## 📋 Prerequisites

- PHP >= 8.3
- Composer
- Node.js & NPM
- SQLite extension enabled

## 🚀 Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/nofileexistshere/dinastisushi.git
   cd dinastisushi
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Database setup**
   ```bash
   touch database/database.sqlite
   php artisan migrate:fresh
   php artisan db:seed
   ```

6. **Build assets**
   ```bash
   npm run build
   ```

7. **Start development server**
   ```bash
   php artisan serve
   ```

8. **Access the application**
   
   Open your browser and visit: `http://127.0.0.1:8000`

## 👥 Demo Accounts

Try the application with these pre-seeded accounts:

| Name | Email | Password | Preferences |
|------|-------|----------|-------------|
| Budi Santoso | budi@example.com | password | Salmon & Spicy |
| Siti Nurhaliza | siti@example.com | password | Vegetarian |
| Ahmad Rizki | ahmad@example.com | password | Premium Menu |

## 📁 Project Structure

```
dinastisushi/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php      # Authentication & Registration
│   │   ├── DashboardController.php # Main dashboard
│   │   ├── MenuController.php      # Menu listing & details
│   │   ├── HistoryController.php   # Order history
│   │   └── OrderController.php     # Order & rating management
│   ├── Models/
│   │   ├── User.php               # User model
│   │   ├── MenuItem.php           # Menu item model
│   │   ├── Order.php              # Order model
│   │   └── Rating.php             # Rating model
│   └── Services/
│       └── RecommendationService.php # AI Collaborative Filtering
├── database/
│   ├── migrations/                # Database schema
│   └── seeders/
│       └── DatabaseSeeder.php     # Demo data seeder
├── resources/
│   ├── css/
│   │   └── app.css               # TailwindCSS configuration
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php     # Base layout
│       ├── auth/
│       │   └── login.blade.php   # Login/Register page
│       ├── dashboard.blade.php   # Dashboard view
│       ├── menu/
│       │   ├── index.blade.php   # Menu listing
│       │   └── show.blade.php    # Menu details
│       └── history/
│           └── index.blade.php   # Order history
├── routes/
│   └── web.php                   # Application routes
├── tailwind.config.js            # TailwindCSS configuration
└── vite.config.js               # Vite build configuration
```

## 🎨 Features in Detail

### Collaborative Filtering Algorithm

The recommendation system uses a custom-built collaborative filtering algorithm:

1. **User Rating Analysis** - Analyzes your rating history
2. **Similarity Calculation** - Finds users with similar preferences using Cosine Similarity
3. **Rating Prediction** - Predicts ratings for items you haven't tried
4. **Content Analysis** - Considers ingredients, category, and price
5. **Weighted Scoring** - Combines all factors for final recommendations

### Responsive Design Breakpoints

- **Mobile**: < 640px (sm)
- **Tablet**: 640px - 1024px (md, lg)
- **Desktop**: > 1024px (xl, 2xl)

## 🧪 Testing

1. **Login** with demo account or create new account
2. **Browse Menu** and filter by category
3. **Place Orders** and rate menu items
4. **View Dashboard** to see personalized recommendations
5. **Check History** to review past orders

## 📸 Screenshots

_Add your application screenshots here_

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 👨‍💻 Author

**Your Name**

- GitHub: [@nofileexistshere](https://github.com/nofileexistshere)

## 🙏 Acknowledgments

- Laravel Framework
- TailwindCSS
- Alpine.js
- Unsplash for sushi images

---

<p align="center">Made with ❤️ using Laravel 12</p>
