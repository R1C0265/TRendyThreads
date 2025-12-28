# Project Structure - Trendy Threads

## Directory Organization

### Root Level Structure
```
trendy_threads/
├── admin/              # Administrative interface
├── assets/             # Public assets (CSS, JS, images)
├── config/             # Configuration files
├── controller/         # Business logic controllers
├── employee/           # Employee dashboard interface
├── forms/              # Form handling scripts
├── general/            # General purpose components
├── model/              # Data access layer
├── partials/           # Reusable UI components
├── sql/                # Database schemas and migrations
└── *.php               # Main application pages
```

### Core Components

#### `/config/` - Configuration Layer
- `main.php`: Core application configuration, autoloader, utility functions
- `database.php`: Database connection settings
- `paychangu.php`: Payment gateway configuration

#### `/controller/` - Business Logic
- `Database.php`: Database abstraction layer
- `Essential.php`: Core application utilities
- `Article.php`: Content management
- `Meta.php`: Metadata handling
- `home.php`: Homepage logic

#### `/model/` - Data Access Layer
- **User Management**: `addUser.php`, `deluser.php`, `login.php`
- **Product Management**: `addBail.php`, `updateBail.php`, `delBail.php`
- **Sales Operations**: `addSale.php`, `updateSale.php`, `delSale.php`
- **Image Handling**: `uploadBailImages.php`, `getBailImages.php`, `setPrimaryImage.php`
- **Payment Processing**: `processOrder.php`, `processPayChanguOrder.php`, `checkPaymentStatus.php`
- **Notifications**: `notificationHelper.php`, `markNotificationRead.php`
- **Database Setup**: `createTables.php`, `createSimpleTables.php`

#### `/employee/` - Employee Interface
- Material Dashboard-based admin interface
- **Assets**: Bootstrap, Material Design components, charts
- **Pages**: Dashboard, billing, notifications, profile management
- **Core Files**: `index.php`, `bails.php`, `sales.php`, `notifications.php`

#### `/assets/` - Frontend Resources
- **CSS**: `main.css` for styling
- **JavaScript**: jQuery, form handling, contact forms
- **Images**: Product images, UI assets, uploaded content
- **Vendor**: Bootstrap, AOS, Swiper, Isotope libraries

### Architectural Patterns

#### MVC Architecture
- **Models**: Data access in `/model/` directory
- **Views**: PHP templates with embedded HTML
- **Controllers**: Business logic in `/controller/` directory

#### Component Structure
- **Partials**: Reusable header/footer components
- **Forms**: Dedicated form processing scripts
- **Assets**: Organized by type (CSS, JS, images)

#### Database Layer
- Custom Database class with query abstraction
- Prepared statements for security
- Automated table creation scripts
- Migration support through SQL files

#### File Organization
- **Separation of Concerns**: Clear separation between frontend, backend, and data layers
- **Modular Design**: Independent components for different features
- **Asset Management**: Organized static resources with vendor libraries
- **Configuration Management**: Centralized configuration with environment-specific settings

## Key Relationships
- Controllers use Database class for data access
- Models handle specific business operations
- Views include partials for consistent UI
- Employee interface uses Material Dashboard framework
- Payment system integrates with external PayChangu service
- Notification system spans across all user interfaces