# Test File Organization Rule

## Test File Location
All test, debug, and temporary files must be placed in the `/test/` directory, never in the project root or other directories.

### Examples:
- ✅ `test/debug_login.php`
- ✅ `test/test_registration.php` 
- ✅ `test/fix_database.php`
- ❌ `debug_login.php` (root directory)
- ❌ `model/test_something.php` (wrong directory)

### Cleanup
Always clean up test files after use unless they serve ongoing debugging purposes.
