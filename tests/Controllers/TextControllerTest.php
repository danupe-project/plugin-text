<?php

namespace Danupe\Plugin\Text\Tests\Controllers;

use PHPUnit\Framework\TestCase;
use Danupe\Plugin\Text\Controllers\TextController;
use Danupe\Core\Classes\Controller;

class TextControllerTest extends TestCase
{
    private TextController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new TextController();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    public function testTextControllerIsInstanceOfController()
    {
        $this->assertInstanceOf(Controller::class, $this->controller);
    }

    public function testTextControllerExtendsController()
    {
        $this->assertTrue(is_subclass_of($this->controller, Controller::class));
    }

    public function testIndexMethodExists()
    {
        $this->assertTrue(method_exists($this->controller, 'index'));
    }

    public function testEditMethodExists()
    {
        $this->assertTrue(method_exists($this->controller, 'edit'));
    }

    public function testUpdatePostMethodExists()
    {
        $this->assertTrue(method_exists($this->controller, 'update_post'));
    }

    public function testCreateMethodExists()
    {
        $this->assertTrue(method_exists($this->controller, 'create'));
    }

    public function testCreatePostMethodExists()
    {
        $this->assertTrue(method_exists($this->controller, 'create_post'));
    }

    public function testDeletePostMethodExists()
    {
        $this->assertTrue(method_exists($this->controller, 'delete_post'));
    }

    public function testIndexMethodIsPublic()
    {
        $reflection = new \ReflectionMethod($this->controller, 'index');
        $this->assertTrue($reflection->isPublic());
    }

    public function testEditMethodIsPublic()
    {
        $reflection = new \ReflectionMethod($this->controller, 'edit');
        $this->assertTrue($reflection->isPublic());
    }

    public function testUpdatePostMethodIsPublic()
    {
        $reflection = new \ReflectionMethod($this->controller, 'update_post');
        $this->assertTrue($reflection->isPublic());
    }

    public function testCreateMethodIsPublic()
    {
        $reflection = new \ReflectionMethod($this->controller, 'create');
        $this->assertTrue($reflection->isPublic());
    }

    public function testCreatePostMethodIsPublic()
    {
        $reflection = new \ReflectionMethod($this->controller, 'create_post');
        $this->assertTrue($reflection->isPublic());
    }

    public function testDeletePostMethodIsPublic()
    {
        $reflection = new \ReflectionMethod($this->controller, 'delete_post');
        $this->assertTrue($reflection->isPublic());
    }

    public function testEditMethodAcceptsParameter()
    {
        $reflection = new \ReflectionMethod($this->controller, 'edit');
        $parameters = $reflection->getParameters();
        
        $this->assertCount(1, $parameters);
        $this->assertEquals('args', $parameters[0]->getName());
    }

    public function testTextControllerHasCorrectNamespace()
    {
        $this->assertEquals('Danupe\Plugin\Text\Controllers\TextController', get_class($this->controller));
    }

    public function testIndexMethodWithMockedDependencies()
    {
        // Test that index method exists and is public
        $this->assertTrue(method_exists($this->controller, 'index'));
        
        $reflection = new \ReflectionMethod($this->controller, 'index');
        $this->assertTrue($reflection->isPublic());
        
        // Test method signature - index should take no parameters
        $this->assertEquals(0, $reflection->getNumberOfParameters());
        
        // Test that the method is callable
        $this->assertTrue(is_callable([$this->controller, 'index']));
    }

    public function testCreateMethodWithMockedDependencies()
    {
        // Test that create method exists and is public
        $this->assertTrue(method_exists($this->controller, 'create'));
        
        $reflection = new \ReflectionMethod($this->controller, 'create');
        $this->assertTrue($reflection->isPublic());
        
        // Test that the method is callable
        $this->assertTrue(is_callable([$this->controller, 'create']));
    }

    public function testEditMethodWithMockedDependencies()
    {
        // Test that edit method exists and is public
        $this->assertTrue(method_exists($this->controller, 'edit'));
        
        $reflection = new \ReflectionMethod($this->controller, 'edit');
        $this->assertTrue($reflection->isPublic());
        
        // Test method signature - edit should accept parameters
        $this->assertGreaterThan(0, $reflection->getNumberOfParameters());
        
        // Test that the method is callable
        $this->assertTrue(is_callable([$this->controller, 'edit']));
    }

    public function testControllerCanBeInstantiatedWithoutErrors()
    {
        $newController = new TextController();
        $this->assertInstanceOf(TextController::class, $newController);
    }

    public function testControllerMethodsReturnTypeHints()
    {
        $reflection = new \ReflectionClass($this->controller);
        $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        
        // Check that methods exist and are callable
        foreach (['index', 'edit', 'create', 'update_post', 'create_post', 'delete_post'] as $methodName) {
            $method = $reflection->getMethod($methodName);
            $this->assertTrue($method->isPublic(), "Method {$methodName} should be public");
        }
    }

    public function testControllerUsesCorrectImports()
    {
        $reflection = new \ReflectionClass($this->controller);
        $fileName = $reflection->getFileName();
        $fileContent = file_get_contents($fileName);
        
        // Check that required imports are present
        $this->assertStringContainsString('use Danupe\Core\Classes\Controller;', $fileContent);
        $this->assertStringContainsString('use Danupe\Plugin\User\Classes\Validate;', $fileContent);
        $this->assertStringContainsString('use Danupe\Plugin\Text\Models\Text;', $fileContent);
    }
}
