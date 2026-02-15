# Arcade Gaming Website

A modern, responsive gaming community website with user authentication, posts, comments, likes, and a comprehensive admin panel.

![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)
![PHP](https://img.shields.io/badge/PHP-7.4+-purple.svg)
![MySQL](https://img.shields.io/badge/MySQL-5.7+-orange.svg)
![License](https://img.shields.io/badge/license-MIT-green.svg)

## ✨ Features

### Frontend
- 🎮 Modern gaming-themed design with gradient backgrounds
- 📱 Fully responsive (mobile, tablet, desktop)
- 🖼️ Image carousel/slider
- 👤 User registration and authentication
- 📝 Community posts with images
- ❤️ Like/unlike posts
- 💬 Comment system
- 🌙 Dark theme toggle
- 📧 Newsletter subscription
- ⚡ Smooth animations and transitions

### Admin Panel
- 📊 Dashboard with statistics overview
- 📝 **Posts CRUD** - Create, Read, Update, Delete posts
- 👥 User management
- 💬 Comment moderation
- 🖼️ Slider management
- 📧 Subscription management
- 📈 Engagement analytics
- 🎨 Modern, intuitive interface

## 🚀 Quick Start

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Modern web browser

### Installation (5 Minutes)

1. **Clone or download the project**
```bash
git clone https://github.com/yourusername/arcade-gaming.git
cd arcade-gaming
```

2. **Setup database**
```bash
mysql -u root -p < database_setup.sql
```

3. **Configure database connection**
Edit `include/db.php`:
```php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = 'your_password';
$db_name = 'arcade';
```

4. **Set permissions**
```bash
chmod 755 uploads/
chmod 755 uploads/profile/
```

5. **Access the website**
```
Frontend: http://localhost/arcade-gaming.php
Admin Panel: http://localhost/panel_admin/dashboard.php
```

### Default Login
- Username: `admin`
- Password: `admin123`

**⚠️ Change the default password immediately!**

## 📚 Documentation

- **[QUICKSTART.md](QUICKSTART.md)** - 5-minute setup guide
- **[FIXES_AND_SETUP.md](FIXES_AND_SETUP.md)** - Detailed technical documentation
- **[ADMIN_GUIDE.md](ADMIN_GUIDE.md)** - Complete admin panel guide
- **[database_setup.sql](database_setup.sql)** - Database schema

## 🎯 Key Features Explained

### Posts Management (Admin)
Create and manage community posts with:
- Rich text content
- Image uploads (auto-resize and optimize)
- Edit existing posts
- Delete posts (cascades to likes/comments)
- View engagement statistics

### User Authentication
- Secure registration with password hashing
- Profile picture upload
- Session management
- CSRF protection
- Input validation and sanitization

### Engagement System
- Like/unlike posts (toggle)
- Real-time comment posting
- Comment display with usernames
- Engagement statistics tracking

## 🗂️ Project Structure

```
arcade-gaming/
├── 📄 arcade-gaming.php       # Main homepage
├── 🎨 arcade-gaming.css       # Main stylesheet
├── 📁 include/
│   ├── db.php                 # Database connection
│   ├── header.php             # Navigation & modals
│   ├── footer.php             # Footer
│   └── main.php               # Main content
├── 📁 php_admin/
│   └── api/
│       ├── auth.php           # Authentication
│       ├── like.php           # Like system
│       ├── comment.php        # Comments
│       └── csrf.php           # Security
├── 📁 panel_admin/
│   ├── dashboard.php          # Admin dashboard ⭐
│   ├── posts.php              # Posts CRUD ⭐
│   ├── users.php              # User management
│   ├── comments.php           # Comment moderation
│   └── slidedr.php            # Slider management
├── 📁 uploads/                # User uploads
├── 📄 database_setup.sql      # Database schema
├── 📄 .htaccess               # Apache config
└── 📚 Documentation files
```

## 🛠️ Technology Stack

- **Frontend**: HTML5, CSS3, JavaScript (ES6+)
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Frameworks**: Bootstrap 5.3
- **Icons**: Font Awesome 6.0
- **Fonts**: Google Fonts (Orbitron, Poppins)

## 🔒 Security Features

- ✅ Password hashing (bcrypt)
- ✅ Prepared statements (SQL injection prevention)
- ✅ CSRF token protection
- ✅ Input validation and sanitization
- ✅ XSS protection
- ✅ Secure file uploads
- ✅ Session management
- ✅ HTTP security headers

## 📊 Database Schema

### Tables
- `users` - User accounts
- `posts` - Community posts
- `likes` - Post likes
- `comments` - Post comments
- `slider` - Homepage carousel

### Relationships
- Posts → Users (many-to-one)
- Likes → Posts, Users (many-to-many)
- Comments → Posts, Users (many-to-many)

## 🎨 Customization

### Change Colors
Edit `arcade-gaming.css`:
```css
/* Main gradient (line 11) */
background: linear-gradient(135deg, #YOUR_COLOR1, #YOUR_COLOR2);

/* Accent colors (line 47) */
background: linear-gradient(45deg, #YOUR_COLOR1, #YOUR_COLOR2);
```

### Add Slider Images
```sql
INSERT INTO slider (slider_img, slider_title, display_order) 
VALUES ('your-image.jpg', 'Your Title', 4);
```

### Modify Site Name
Edit `include/header.php` and `include/footer.php`:
```html
<span class="logo-text">Your Site Name</span>
```

## 🐛 Troubleshooting

### Database Connection Error
```bash
# Check MySQL is running
sudo service mysql status

# Verify credentials in include/db.php
```

### Upload Permission Error
```bash
chmod 755 uploads/
chmod 755 uploads/profile/
```

### 404 on API Calls
```bash
# Ensure .htaccess is enabled
sudo a2enmod rewrite
sudo service apache2 restart
```

## 📈 Performance Tips

1. Enable caching (already configured in .htaccess)
2. Optimize images before uploading
3. Use CDN for Bootstrap/FontAwesome in production
4. Enable GZIP compression (configured)
5. Minify CSS/JS for production

## 🔄 Updates

### Version 1.0.0 (Current)
- ✅ Complete posts CRUD in admin panel
- ✅ Modern admin dashboard
- ✅ User authentication system
- ✅ Like and comment functionality
- ✅ Responsive design
- ✅ Security improvements
- ✅ Comprehensive documentation

## 🤝 Contributing

Contributions are welcome! Please:
1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the LICENSE file for details.

## 👨‍💻 Author

Created for educational purposes.

## 🙏 Acknowledgments

- Bootstrap team for the amazing framework
- Font Awesome for the icons
- Google Fonts for typography
- The PHP and MySQL communities

## 📞 Support

For issues or questions:
1. Check the documentation files
2. Review the troubleshooting section
3. Check error logs
4. Open an issue on GitHub

## 🎯 Roadmap

### Upcoming Features
- [ ] Advanced search functionality
- [ ] User profiles with statistics
- [ ] Private messaging system
- [ ] Game library integration
- [ ] Tournament system
- [ ] Achievement badges
- [ ] Email notifications
- [ ] Social media integration
- [ ] API for mobile apps
- [ ] Multi-language support

## 📸 Screenshots

### Homepage
Modern gaming-themed design with carousel and posts

### Admin Dashboard
Comprehensive statistics and management tools

### Posts Management
Full CRUD operations with image upload

---

**Made with ❤️ for the gaming community**

⭐ Star this repo if you find it helpful!
