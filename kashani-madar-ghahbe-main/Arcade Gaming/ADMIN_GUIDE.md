# Admin Panel Guide - Arcade Gaming Website

## Accessing the Admin Panel

### URL
```
http://localhost/panel_admin/dashboard.php
```

### Default Credentials
- Username: `admin`
- Password: `admin123`

**Important**: Change the default password immediately after first login!

## Dashboard Overview

The admin dashboard provides:
- Total posts count
- Total users count
- Total comments count
- Total likes count
- Recent posts list
- Quick action buttons

## Posts Management (CRUD)

### Accessing Posts Management
Click "Posts" in the sidebar navigation.

### Creating a New Post

1. Fill in the form at the top:
   - **Post Title** (required): Enter a catchy title
   - **Content** (required): Write your post content (100-500 characters recommended)
   - **Post Image** (optional): Upload an image (recommended: 1200x675px, 16:9 ratio)

2. Click "Create Post" button

3. The post will appear in the posts list and on the main website

### Editing a Post

1. Find the post in the list
2. Click the yellow "Edit" button (pencil icon)
3. The form will populate with existing data
4. Make your changes
5. Click "Update Post"
6. Click "Cancel" to discard changes

### Deleting a Post

1. Find the post in the list
2. Click the red "Delete" button (trash icon)
3. Confirm the deletion
4. **Warning**: This will also delete all associated likes and comments

### Post Statistics

Each post shows:
- **Likes**: Number of users who liked the post
- **Comments**: Number of comments on the post
- **Author**: Username of the post creator
- **Created Date**: When the post was created

### Image Management

- **Supported formats**: JPEG, PNG, GIF, WebP
- **Recommended size**: 1200x675px (16:9 aspect ratio)
- **Maximum file size**: 5MB (configurable in .htaccess)
- **Storage location**: `uploads/` folder
- Old images are automatically deleted when updating posts

## User Management

### Creating a New User

1. Navigate to "Users" section
2. Fill in the registration form:
   - Username (required)
   - Email (required)
   - Password (required, min 6 characters)
   - Status (Active/Inactive)
3. Click "Create User"

### Managing Users

- **Activate/Deactivate**: Toggle user status
- **Delete**: Remove user from system
- **View**: See user details and statistics

**Note**: You cannot modify your own account status or delete yourself.

## Slider Management

### Adding Slider Images

1. Navigate to "Slider" section
2. Upload images for the homepage carousel
3. Set display order
4. Enable/disable slides

### Best Practices
- Use high-quality images (1920x1080px recommended)
- Keep 3-5 slides for optimal performance
- Update regularly to keep content fresh

## Comments Management

### Moderating Comments

1. Navigate to "Comments" section
2. View all comments across all posts
3. Delete inappropriate comments
4. Monitor user engagement

### Comment Features
- See which post the comment belongs to
- View commenter username
- See comment timestamp
- Delete spam or inappropriate content

## Statistics Dashboard

### Available Metrics

1. **Total Posts**: Number of published posts
2. **Total Likes**: Aggregate likes across all posts
3. **Total Comments**: Total comments on all posts
4. **Average Engagement**: (Likes + Comments) / Posts

### Recent Activity
- View latest 5 posts
- Quick access to post statistics
- Monitor engagement trends

## Best Practices

### Content Management

1. **Post Regularly**: Keep your community engaged with fresh content
2. **Use Quality Images**: High-resolution images improve engagement
3. **Write Engaging Titles**: Clear, catchy titles attract more readers
4. **Moderate Comments**: Remove spam and inappropriate content promptly

### Security

1. **Change Default Password**: Use a strong, unique password
2. **Regular Backups**: Backup database and uploads folder regularly
3. **Monitor Activity**: Check for suspicious user activity
4. **Update Software**: Keep PHP and MySQL updated

### Performance

1. **Optimize Images**: Compress images before uploading
2. **Clean Old Data**: Remove unused posts and images periodically
3. **Monitor Database**: Check database size and optimize tables
4. **Cache Management**: Clear browser cache after major updates

## Troubleshooting

### Cannot Upload Images

**Problem**: Image upload fails
**Solutions**:
- Check `uploads/` folder permissions (755)
- Verify file size is under 5MB
- Ensure file format is supported (JPEG, PNG, GIF, WebP)
- Check PHP upload settings in .htaccess

### Posts Not Appearing

**Problem**: Created posts don't show on website
**Solutions**:
- Clear browser cache (Ctrl+F5)
- Check database connection
- Verify post was saved (check posts list)
- Refresh the main website page

### Cannot Delete Post

**Problem**: Delete button doesn't work
**Solutions**:
- Check database connection
- Verify you have admin permissions
- Check browser console for JavaScript errors
- Try refreshing the page

### Statistics Not Updating

**Problem**: Dashboard stats are incorrect
**Solutions**:
- Refresh the dashboard page
- Check database connection
- Verify tables exist (posts, likes, comments)
- Run database integrity check

## Keyboard Shortcuts

- **Ctrl+S**: Save form (when focused)
- **Esc**: Close modals
- **Enter**: Submit comment (in comment input)

## Mobile Access

The admin panel is responsive and works on:
- Desktop computers
- Tablets
- Mobile phones (limited functionality)

**Recommendation**: Use desktop for best experience.

## API Endpoints

The admin panel uses these API endpoints:

- `php_admin/api/auth.php` - User authentication
- `php_admin/api/like.php` - Like/unlike posts
- `php_admin/api/comment.php` - Add comments
- `php_admin/api/csrf.php` - Security tokens

## Database Tables

Posts management interacts with:

- `posts` - Post data
- `likes` - Post likes
- `comments` - Post comments
- `users` - User information

## File Permissions

Required permissions:
```bash
chmod 755 panel_admin/
chmod 755 uploads/
chmod 755 uploads/profile/
chmod 644 panel_admin/*.php
```

## Backup Procedure

### Database Backup
```bash
mysqldump -u root -p arcade > backup_$(date +%Y%m%d).sql
```

### Files Backup
```bash
tar -czf uploads_backup_$(date +%Y%m%d).tar.gz uploads/
```

### Automated Backup (Cron)
```bash
# Add to crontab (daily at 2 AM)
0 2 * * * /path/to/backup_script.sh
```

## Support

### Common Issues

1. **Database Connection Failed**
   - Check MySQL is running
   - Verify credentials in `include/db.php`
   - Test connection: `mysql -u root -p`

2. **Permission Denied**
   - Check file permissions
   - Verify web server user (www-data, apache)
   - Run: `chown -R www-data:www-data uploads/`

3. **Session Errors**
   - Check PHP session configuration
   - Verify session directory is writable
   - Clear browser cookies

### Getting Help

1. Check error logs: `/var/log/apache2/error.log`
2. Enable PHP error display (development only)
3. Check browser console for JavaScript errors
4. Review database logs

## Updates and Maintenance

### Regular Tasks

**Daily**:
- Monitor new posts and comments
- Check for spam
- Review user registrations

**Weekly**:
- Backup database
- Review statistics
- Update slider images

**Monthly**:
- Clean old uploads
- Optimize database
- Review security logs
- Update passwords

## Advanced Features

### Bulk Operations (Coming Soon)
- Bulk delete posts
- Bulk approve comments
- Export data to CSV

### Analytics (Coming Soon)
- Post performance metrics
- User engagement tracking
- Traffic statistics

### Notifications (Coming Soon)
- Email alerts for new comments
- Daily summary reports
- Spam detection alerts

## Conclusion

The admin panel provides comprehensive tools for managing your gaming website. Regular maintenance and monitoring will ensure optimal performance and user experience.

For technical support or feature requests, refer to the main documentation files:
- `FIXES_AND_SETUP.md` - Technical details
- `QUICKSTART.md` - Quick setup guide
- `database_setup.sql` - Database schema
