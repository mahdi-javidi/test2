# Quick Start Guide - Arcade Gaming Website

## Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache/Nginx web server
- Web browser (Chrome, Firefox, Safari, Edge)

## Installation (5 Minutes)

### Step 1: Database Setup
```bash
# Login to MySQL
mysql -u root -p

# Run the setup file
source database_setup.sql

# Or import via phpMyAdmin
```

### Step 2: Configure Database Connection
Open `include/db.php` and verify settings:
```php
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';  // Your MySQL password
$db_name = 'arcade';
```

### Step 3: Set Permissions
```bash
chmod 755 uploads/
chmod 755 uploads/profile/
```

### Step 4: Access the Website
Open your browser and navigate to:
```
http://localhost/arcade-gaming.php
```

## Test the Features

### 1. Test Registration
- Click "Sign Up" button
- Fill in the form:
  - Username: testuser
  - Email: test@example.com
  - Password: test123
- Click "Sign Up"

### 2. Test Login
- Click "Login" button
- Use credentials:
  - Username: admin
  - Password: admin123
- Click "Login"

### 3. Test Posts
- Scroll to "Community Posts" section
- Click the heart icon to like a post
- Type a comment and click "Submit"

### 4. Test Admin Panel (NEW)
- Navigate to: `http://localhost/panel_admin/dashboard.php`
- View dashboard statistics
- Click "Posts" in sidebar
- Create a new post:
  - Add title and content
  - Upload an image
  - Click "Create Post"
- Edit or delete existing posts

### 5. Test Slider
- The carousel at the top should auto-rotate
- Click arrows to navigate manually

## Troubleshooting

### Database Connection Error
```
Error: Database connection failed
Solution: Check MySQL is running and credentials in include/db.php
```

### Upload Directory Error
```
Error: Failed to upload profile picture
Solution: chmod 755 uploads/profile/
```

### 404 Errors on API Calls
```
Error: 404 on php_admin/api/
Solution: Ensure php_admin folder exists with API files
```

### JavaScript Errors
```
Error: Cannot read property of null
Solution: Clear browser cache and reload (Ctrl+F5)
```

## File Checklist

Make sure these files exist:
- ✅ arcade-gaming.php
- ✅ arcade-gaming.css
- ✅ include/db.php
- ✅ include/header.php
- ✅ include/footer.php
- ✅ include/main.php
- ✅ postinsta.php
- ✅ php_admin/api/auth.php
- ✅ php_admin/api/csrf.php
- ✅ php_admin/api/like.php
- ✅ php_admin/api/comment.php
- ✅ panel_admin/dashboard.php (NEW)
- ✅ panel_admin/posts.php (NEW)
- ✅ database_setup.sql

## Default Accounts

### Admin Account
- Username: `admin`
- Password: `admin123`
- Email: admin@arcade.com

### Test Data
- 3 sample posts
- 3 slider images
- Ready to test immediately

## Next Steps

1. Change admin password
2. Add your own slider images
3. Create new posts
4. Customize colors in CSS
5. Add more games/content

## Support

Check these files for detailed information:
- `FIXES_AND_SETUP.md` - Complete documentation
- `database_setup.sql` - Database schema
- `.htaccess` - Server configuration

## Common Customizations

### Change Colors
Edit `arcade-gaming.css`:
```css
/* Line 11-12: Main gradient */
background: linear-gradient(135deg, #YOUR_COLOR1, #YOUR_COLOR2);

/* Line 47: Accent colors */
background: linear-gradient(45deg, #YOUR_COLOR1, #YOUR_COLOR2);
```

### Add Slider Images
1. Upload image to root folder
2. Run SQL:
```sql
INSERT INTO slider (slider_img, slider_title, display_order) 
VALUES ('your-image.jpg', 'Your Title', 4);
```

### Change Site Name
Edit `include/header.php` and `include/footer.php`:
```html
<!-- Change "Arcade" to your name -->
<span class="logo-text">Your Name</span>
```

## Performance Tips

1. Enable caching in `.htaccess` (already configured)
2. Optimize images before uploading
3. Use CDN for Bootstrap/FontAwesome in production
4. Enable GZIP compression (already configured)
5. Minify CSS/JS for production

## Security Checklist

- [ ] Change default admin password
- [ ] Enable HTTPS in production
- [ ] Update database credentials
- [ ] Set proper file permissions
- [ ] Enable error logging (not display)
- [ ] Add rate limiting for login
- [ ] Regular backups

## Success!

If you can see the homepage with the slider and can register/login, you're all set! 🎮

Enjoy your gaming website!
