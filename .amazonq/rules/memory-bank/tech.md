# Technology Stack - Trendy Threads

## Programming Languages
- **PHP**: Server-side logic and business operations
- **JavaScript**: Client-side interactivity and form handling
- **HTML5**: Markup and structure
- **CSS3/SCSS**: Styling and responsive design
- **SQL**: Database queries and schema management

## Backend Technologies

### PHP Framework & Libraries
- **PHP 7.4+**: Core server-side language
- **Custom MVC Framework**: Built-in application structure
- **MySQLi**: Database connectivity and operations
- **Session Management**: Built-in PHP session handling
- **File Upload Handling**: Native PHP file processing

### Database
- **MySQL**: Primary database system
- **Custom Database Class**: Query abstraction layer with automatic prepared statements
- **Database Pattern**: Use `$db->query("SQL", $param1, $param2)` - this IS prepared statements via custom class
- **Parameter Binding**: Automatic type detection with `_gettype()` method
- **Auto-increment IDs**: Primary key management

## Frontend Technologies

### CSS Frameworks & Libraries
- **Bootstrap 5**: Responsive grid system and components
- **Material Design**: Google's design system implementation
- **Custom CSS**: Application-specific styling
- **SCSS**: CSS preprocessing (development)

### JavaScript Libraries
- **jQuery 3.7.1**: DOM manipulation and AJAX
- **Bootstrap JS**: Interactive components
- **AOS (Animate On Scroll)**: Scroll animations
- **Swiper**: Touch slider functionality
- **Isotope**: Filtering and sorting layouts
- **GLightbox**: Lightbox gallery functionality
- **PureCounter**: Number counting animations
- **Imagesloaded**: Image loading detection

### UI Components
- **Material Dashboard 3**: Admin interface framework
- **Bootstrap Icons**: Icon library
- **Custom Forms**: Contact and registration forms
- **Responsive Navigation**: Mobile-friendly menus

## Development Tools

### Build System
- **Gulp**: Task automation (employee interface)
- **npm**: Package management
- **Composer**: PHP dependency management (employee interface)

### Asset Management
- **Vendor Libraries**: Organized in `/assets/vendor/`
- **Custom Assets**: Application-specific CSS/JS
- **Image Processing**: PHP GD library for image manipulation
- **File Organization**: Structured asset directories

## Payment Integration
- **PayChangu**: Payment gateway service
- **Webhook Support**: Real-time payment notifications
- **Order Processing**: Secure transaction handling

## Development Commands

### Employee Interface (Material Dashboard)
```bash
# Install dependencies
npm install
composer install

# Build assets
gulp build

# Development server
gulp serve
```

### Main Application
- **No build process required**: Direct PHP execution
- **Asset serving**: Static file serving through web server
- **Database setup**: Run SQL scripts in `/sql/` directory

## Configuration Requirements

### Server Requirements
- **PHP 7.4+** with extensions:
  - MySQLi
  - GD (image processing)
  - Session support
  - File upload support
- **MySQL 5.7+**
- **Web server**: Apache/Nginx with PHP support

### Environment Setup
- **Document root**: Point to project root directory
- **Database**: Configure connection in `/config/database.php`
- **File permissions**: Write access for upload directories
- **Session configuration**: PHP session settings

### Security Considerations
- **Database Security**: Custom Database class provides prepared statement protection automatically
- **Query Pattern**: Always use `$db->query("SQL WITH ?", $params)` for parameterized queries
- **File upload validation**: Image type and size restrictions
- **Session management**: Secure session handling
- **Input sanitization**: XSS protection
- **HTTPS recommended**: Secure data transmission

## External Dependencies
- **PayChangu API**: Payment processing service
- **Bootstrap CDN**: CSS/JS framework delivery
- **Google Fonts**: Typography resources
- **Material Icons**: Icon resources