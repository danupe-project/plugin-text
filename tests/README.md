# Plugin Text Tests

This directory contains comprehensive tests for the plugin-text module.

## Test Structure

- `Models/TextTest.php` - Tests for the Text model class
- `Controllers/TextControllerTest.php` - Tests for the TextController class
- `IntegrationTest.php` - Integration tests for model and controller interaction
- `FunctionalTest.php` - Functional tests for business logic and code structure
- `EdgeCaseTest.php` - Tests for edge cases and error conditions

## Running Tests

### Using Docker Compose (Recommended)

```bash
# Run all plugin-text tests
docker-compose run --rm phpunit www/danupe/plugin-text/tests/

# Run specific test class
docker-compose run --rm phpunit www/danupe/plugin-text/tests/Models/TextTest.php

# Run with coverage (if configured)
docker-compose run --rm phpunit --coverage-html coverage www/danupe/plugin-text/tests/
```

### Using PHPUnit directly (within plugin directory)

```bash
cd www/danupe/plugin-text
../../../vendor/bin/phpunit tests/
```

## Test Coverage

The tests cover:

### Text Model (`Text.php`)
- ✅ Model inheritance and structure
- ✅ Table configuration
- ✅ Attribute management
- ✅ `getByLanguageAsArray()` method
- ✅ Multilingual support

### TextController (`TextController.php`)
- ✅ Controller inheritance and structure
- ✅ CRUD methods (index, create, edit, update, delete)
- ✅ Method visibility and parameters
- ✅ Business logic validation
- ✅ Form validation logic

### Integration
- ✅ Model-Controller interaction
- ✅ Namespace and autoloading
- ✅ Method signatures and compatibility

### Edge Cases
- ✅ Null and invalid inputs
- ✅ Property visibility
- ✅ Method error handling
- ✅ Attribute immutability

## Test Environment Considerations

Some tests are designed to be environment-aware:
- Database connection tests will skip if `danupe()` function is not available
- Controller method tests will handle missing dependencies gracefully
- View rendering tests account for template engine limitations in test environments

## Contributing

When adding new features to plugin-text:
1. Write tests first (TDD approach)
2. Ensure all existing tests pass
3. Add tests for new functionality
4. Update this README if adding new test files
