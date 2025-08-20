<?php

namespace Danupe\Plugin\Text\Tests;

use PHPUnit\Framework\TestCase;
use Danupe\Plugin\Text\Models\Text;
use Danupe\Plugin\Text\Controllers\TextController;

class IntegrationTest extends TestCase
{
    public function testTextModelAndControllerCanBeInstantiated()
    {
        $text = new Text();
        $controller = new TextController();
        
        $this->assertInstanceOf(Text::class, $text);
        $this->assertInstanceOf(TextController::class, $controller);
    }

    public function testTextModelHasRequiredAttributes()
    {
        $text = new Text();
        
        // Test that the model can handle the expected attributes
        $text->setAttribute('id', 1);
        $text->setAttribute('key', 'test_key');
        $text->setAttribute('text', 'test_text');
        $text->setAttribute('language', 'en');
        
        $this->assertEquals(1, $text->getAttribute('id'));
        $this->assertEquals('test_key', $text->getAttribute('key'));
        $this->assertEquals('test_text', $text->getAttribute('text'));
        $this->assertEquals('en', $text->getAttribute('language'));
    }

    public function testControllerHasAllCrudMethods()
    {
        $controller = new TextController();
        
        $expectedMethods = [
            'index',      // READ (list)
            'edit',       // READ (single)
            'create',     // CREATE (form)
            'create_post', // CREATE (process)
            'update_post', // UPDATE
            'delete_post'  // DELETE
        ];
        
        foreach ($expectedMethods as $method) {
            $this->assertTrue(
                method_exists($controller, $method),
                "Controller should have method '{$method}'"
            );
        }
    }

    public function testTextModelTableConfiguration()
    {
        $text = new Text();
        $reflection = new \ReflectionClass($text);
        $property = $reflection->getProperty('table');
        $property->setAccessible(true);
        
        $this->assertEquals('texts', $property->getValue($text));
    }

    public function testNamespacesAreCorrect()
    {
        $text = new Text();
        $controller = new TextController();
        
        $this->assertEquals('Danupe\Plugin\Text\Models\Text', get_class($text));
        $this->assertEquals('Danupe\Plugin\Text\Controllers\TextController', get_class($controller));
    }

    public function testClassesCanBeAutoloaded()
    {
        // Test that classes can be found and loaded
        $this->assertTrue(class_exists('Danupe\Plugin\Text\Models\Text'));
        $this->assertTrue(class_exists('Danupe\Plugin\Text\Controllers\TextController'));
    }

    public function testTextModelGetByLanguageAsArrayMethodSignature()
    {
        $text = new Text();
        $reflection = new \ReflectionMethod($text, 'getByLanguageAsArray');
        
        $this->assertTrue($reflection->isPublic());
        
        $parameters = $reflection->getParameters();
        $this->assertCount(1, $parameters);
        
        $parameter = $parameters[0];
        $this->assertEquals('language', $parameter->getName());
        $this->assertTrue($parameter->hasType());
        $this->assertEquals('string', $parameter->getType()->getName());
        $this->assertTrue($parameter->isDefaultValueAvailable());
        $this->assertEquals('', $parameter->getDefaultValue());
    }

    public function testControllerEditMethodSignature()
    {
        $controller = new TextController();
        $reflection = new \ReflectionMethod($controller, 'edit');
        
        $this->assertTrue($reflection->isPublic());
        
        $parameters = $reflection->getParameters();
        $this->assertCount(1, $parameters);
        
        $parameter = $parameters[0];
        $this->assertEquals('args', $parameter->getName());
    }
}
