# Development Guidelines - Trendy Threads

## Code Quality Standards

### PHP Coding Standards
- **File Structure**: All PHP files start with `<?php` opening tag without closing tag at end
- **Class Naming**: PascalCase for class names (e.g., `Database`, `Essential`)
- **Method Naming**: camelCase for method names (e.g., `fetchAll()`, `lastInsertID()`)
- **Variable Naming**: snake_case for database fields, camelCase for PHP variables
- **Constants**: UPPERCASE with underscores (e.g., `ROOT`, `CONTROLLER`)

### Database Interaction Patterns
- **Prepared Statements**: Always use prepared statements for SQL queries
- **Parameter Binding**: Automatic type detection with `_gettype()` method
- **Error Handling**: Custom error handling with `show_errors` flag
- **Connection Management**: Single database connection per request lifecycle

### Frontend Standards
- **Bootstrap Integration**: Material Dashboard 3 framework for admin interface
- **jQuery Usage**: Consistent use of jQuery for AJAX and DOM manipulation
- **Modal Patterns**: Bootstrap modals for forms and detail views
- **Form Validation**: Client-side validation with server-side verification

## Architectural Patterns

### MVC Implementation
- **Models**: Located in `/model/` directory for data operations
- **Views**: PHP templates with embedded HTML in main directories
- **Controllers**: Business logic in `/controller/` directory
- **Configuration**: Centralized in `/config/` directory

### File Organization
```
/config/           # Configuration files
/controller/       # Business logic classes
/model/           # Data access operations
/assets/          # Static resources
/employee/        # Admin interface
/partials/        # Reusable components
```

### Database Design Patterns
- **Naming Convention**: Tables use singular names (e.g., `bails`, `customers`)
- **Primary Keys**: Auto-increment integer IDs with consistent naming (`b_id`, `c_id`)
- **Foreign Keys**: Descriptive names linking to parent tables
- **Status Fields**: Enum-like varchar fields for entity states

## Common Implementation Patterns

### AJAX Form Handling
```javascript
$("#formId").submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: "../model/action.php",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        beforeSend: function() {
            $("#btnSubmit").prop("disabled", true).html("Processing...");
        },
        success: function(data) {
            // Handle response
        }
    });
});
```

### Database Query Pattern
```php
// With parameters
$result = $db->query("SELECT * FROM table WHERE field = ?", $value)->fetchAll();

// Without parameters  
$result = $db->query("SELECT * FROM table")->fetchAll();
```

### Modal Management
- Use Bootstrap 5 modal components
- Consistent header styling with `bg-gradient-dark`
- Form validation before submission
- Success/error notifications after operations

### Image Upload Handling
- Multiple file upload support with validation
- File type restrictions (jpg, jpeg, png, gif)
- Automatic filename generation with timestamps
- Directory structure: `assets/img/{category}/`

## Security Practices

### Input Validation
- **HTML Escaping**: Use `htmlspecialchars()` for output
- **SQL Injection Prevention**: Prepared statements only
- **File Upload Security**: Type and size validation
- **XSS Protection**: Escape all user input in templates

### Authentication Patterns
- Session-based authentication
- Password hashing (implementation varies)
- Role-based access control
- Secure session management

## Error Handling

### PHP Error Management
- Custom error handling in Database class
- Graceful degradation for missing data
- Logging for debugging purposes
- User-friendly error messages

### JavaScript Error Handling
- Try-catch blocks for AJAX operations
- Console logging for debugging
- User notifications for errors
- Fallback behaviors for failed operations

## Performance Considerations

### Database Optimization
- Efficient query design with proper JOINs
- Pagination for large datasets
- Index usage for frequently queried fields
- Connection pooling through single instance

### Frontend Optimization
- Minified CSS/JS libraries
- Image optimization and compression
- Lazy loading for large datasets
- Efficient DOM manipulation

## Development Workflow

### File Modification Process
1. Read existing code structure
2. Follow established patterns
3. Test functionality thoroughly
4. Validate security implications
5. Document changes appropriately

### Testing Standards
- Test all CRUD operations
- Validate form submissions
- Check error handling paths
- Verify security measures
- Cross-browser compatibility

## Code Documentation

### Inline Comments
- Explain complex business logic
- Document security considerations
- Note performance implications
- Clarify non-obvious code sections

### Function Documentation
- Parameter descriptions
- Return value specifications
- Usage examples where helpful
- Error conditions and handling