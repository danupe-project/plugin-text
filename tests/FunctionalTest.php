<?php

namespace Danupe\Plugin\Text\Tests;

use PHPUnit\Framework\TestCase;
use Danupe\Plugin\Text\Models\Text;
use Danupe\Plugin\Text\Controllers\TextController;

class FunctionalTest extends TestCase
{
    public function testTextModelStructureForMultilingualSupport()
    {
        $text = new Text();
        
        // Test that the model can handle multilingual attributes
        $text->setAttribute('language', 'en');
        $text->setAttribute('key', 'greeting');
        $text->setAttribute('text', 'Hello World');
        
        $this->assertEquals('en', $text->getAttribute('language'), 'Model should support language attribute for multilingual texts');
        $this->assertEquals('greeting', $text->getAttribute('key'), 'Model should have key attribute for text identification');
        $this->assertEquals('Hello World', $text->getAttribute('text'), 'Model should have text attribute for the actual content');
    }

    public function testTextModelGetByLanguageAsArrayImplementation()
    {
        $text = new Text();
        $method = new \ReflectionMethod($text, 'getByLanguageAsArray');
        
        // Check method signature
        $this->assertTrue($method->isPublic());
        
        $parameters = $method->getParameters();
        $this->assertCount(1, $parameters);
        
        $languageParam = $parameters[0];
        $this->assertEquals('language', $languageParam->getName());
        $this->assertTrue($languageParam->hasType());
        $this->assertEquals('string', $languageParam->getType()->getName());
        $this->assertEquals('', $languageParam->getDefaultValue());
    }

    public function testControllerCrudOperationsStructure()
    {
        $controller = new TextController();
        $reflection = new \ReflectionClass($controller);
        
        // Test CREATE operations
        $this->assertTrue($reflection->hasMethod('create'), 'Should have create method for showing form');
        $this->assertTrue($reflection->hasMethod('create_post'), 'Should have create_post method for processing form');
        
        // Test READ operations
        $this->assertTrue($reflection->hasMethod('index'), 'Should have index method for listing texts');
        $this->assertTrue($reflection->hasMethod('edit'), 'Should have edit method for showing single text');
        
        // Test UPDATE operations
        $this->assertTrue($reflection->hasMethod('update_post'), 'Should have update_post method for updating text');
        
        // Test DELETE operations
        $this->assertTrue($reflection->hasMethod('delete_post'), 'Should have delete_post method for deleting text');
    }

    public function testControllerIndexMethodLogic()
    {
        $controller = new TextController();
        
        // Read the actual method content to verify business logic
        $reflection = new \ReflectionMethod($controller, 'index');
        $fileName = $reflection->getFileName();
        $startLine = $reflection->getStartLine();
        $endLine = $reflection->getEndLine();
        
        $file = file($fileName);
        $methodContent = implode('', array_slice($file, $startLine - 1, $endLine - $startLine + 1));
        
        // Check that the method includes text truncation logic
        $this->assertStringContainsString('strlen($text) > 50', $methodContent, 'Should truncate long texts to 50 characters');
        $this->assertStringContainsString('substr($text, 0, 50)', $methodContent, 'Should use substr for truncation');
        $this->assertStringContainsString('...', $methodContent, 'Should append ellipsis to truncated text');
        
        // Check that it orders by ID
        $this->assertStringContainsString('orderBy', $methodContent, 'Should order results');
        $this->assertStringContainsString('id', $methodContent, 'Should order by ID');
        
        // Check that it renders the correct view
        $this->assertStringContainsString('texts/index', $methodContent, 'Should render texts/index view');
    }

    public function testControllerEditMethodLogic()
    {
        $controller = new TextController();
        
        $reflection = new \ReflectionMethod($controller, 'edit');
        $fileName = $reflection->getFileName();
        $startLine = $reflection->getStartLine();
        $endLine = $reflection->getEndLine();
        
        $file = file($fileName);
        $methodContent = implode('', array_slice($file, $startLine - 1, $endLine - $startLine + 1));
        
        // Check that it finds a text by ID
        $this->assertStringContainsString('first', $methodContent, 'Should find first text by ID');
        $this->assertStringContainsString('texts/edit', $methodContent, 'Should render texts/edit view');
    }

    public function testControllerValidationLogic()
    {
        $controller = new TextController();
        
        // Check create_post method for validation
        $reflection = new \ReflectionMethod($controller, 'create_post');
        $fileName = $reflection->getFileName();
        $startLine = $reflection->getStartLine();
        $endLine = $reflection->getEndLine();
        
        $file = file($fileName);
        $methodContent = implode('', array_slice($file, $startLine - 1, $endLine - $startLine + 1));
        
        $this->assertStringContainsString('Validate', $methodContent, 'Should use validation');
        $this->assertStringContainsString('validate', $methodContent, 'Should call validate method');
        $this->assertStringContainsString('redirectWithSuccess', $methodContent, 'Should redirect with success on valid data');
        $this->assertStringContainsString('redirectWithErrors', $methodContent, 'Should redirect with errors on invalid data');
    }

    public function testControllerUpdateValidationLogic()
    {
        $controller = new TextController();
        
        $reflection = new \ReflectionMethod($controller, 'update_post');
        $fileName = $reflection->getFileName();
        $startLine = $reflection->getStartLine();
        $endLine = $reflection->getEndLine();
        
        $file = file($fileName);
        $methodContent = implode('', array_slice($file, $startLine - 1, $endLine - $startLine + 1));
        
        // Check for required validation
        $this->assertStringContainsString('required', $methodContent, 'Should have required validation for text');
        $this->assertStringContainsString('string', $methodContent, 'Should validate that text is a string');
        
        // Check for proper data handling
        $this->assertStringContainsString('only', $methodContent, 'Should only use specific input fields');
        $this->assertStringContainsString('update', $methodContent, 'Should call update method');
    }

    public function testControllerDeleteValidationLogic()
    {
        $controller = new TextController();
        
        $reflection = new \ReflectionMethod($controller, 'delete_post');
        $fileName = $reflection->getFileName();
        $startLine = $reflection->getStartLine();
        $endLine = $reflection->getEndLine();
        
        $file = file($fileName);
        $methodContent = implode('', array_slice($file, $startLine - 1, $endLine - $startLine + 1));
        
        // Check for ID validation
        $this->assertStringContainsString('required', $methodContent, 'Should require ID for deletion');
        $this->assertStringContainsString('integer', $methodContent, 'Should validate ID as integer');
        $this->assertStringContainsString('delete', $methodContent, 'Should call delete method');
    }

    public function testTextModelTableNameMatchesDatabaseConvention()
    {
        $text = new Text();
        $reflection = new \ReflectionClass($text);
        $property = $reflection->getProperty('table');
        $property->setAccessible(true);
        
        $tableName = $property->getValue($text);
        
        // Check that table name follows convention (plural form)
        $this->assertEquals('texts', $tableName);
        $this->assertStringEndsWith('s', $tableName, 'Table name should be plural');
    }

    public function testModelAttributesMatchExpectedDatabaseSchema()
    {
        $text = new Text();
        
        // Test that the model can handle all expected database fields
        $expectedFields = [
            'id' => 1,
            'key' => 'test_key', 
            'text' => 'test_content',
            'language' => 'en'
        ];
        
        foreach ($expectedFields as $field => $testValue) {
            $text->setAttribute($field, $testValue);
            $this->assertEquals($testValue, $text->getAttribute($field), "Field '{$field}' should be supported by the model");
        }
    }
}
