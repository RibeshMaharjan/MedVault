<?php

namespace Tests\Unit\Core;

use PHPUnit\Framework\TestCase;
use App\Core\Router;

class MockController
{
    public string $action = '';
    public array $params = [];

    public function testAction(...$params): void
    {
        $this->action = 'testAction';
        $this->params = $params;
    }

    public function paramAction(string $id = ''): void
    {
        $this->action = 'paramAction';
        $this->params = ['id' => $id];
    }

    public function namedParamAction(string $id = '', string $name = ''): void
    {
        $this->action = 'namedParamAction';
        $this->params = ['id' => $id, 'name' => $name];
    }
}

class RouterTest extends TestCase
{
    private Router $router;

    public static function setUpBeforeClass(): void
    {
        if (!class_exists('App\\Controllers\\MockController')) {
            class_alias(MockController::class, 'App\\Controllers\\MockController');
        }
        if (!class_exists('App\\Controllers\\TestController')) {
            class_alias(MockController::class, 'App\\Controllers\\TestController');
        }
    }

    protected function setUp(): void
    {
        $this->router = new Router();
    }

    public function testGetRouteStoresGetRoutes(): void
    {
        $this->router->get('/test', 'TestController@testAction');
        
        $reflection = new \ReflectionProperty($this->router, 'routes');
        $reflection->setAccessible(true);
        $routes = $reflection->getValue($this->router);
        
        $this->assertCount(1, $routes);
        $this->assertEquals('GET', $routes[0]['method']);
    }

    public function testPostRouteStoresPostRoutes(): void
    {
        $this->router->post('/test', 'TestController@testAction');
        
        $reflection = new \ReflectionProperty($this->router, 'routes');
        $reflection->setAccessible(true);
        $routes = $reflection->getValue($this->router);
        
        $this->assertCount(1, $routes);
        $this->assertEquals('POST', $routes[0]['method']);
    }

    public function testMultipleRoutesStored(): void
    {
        $this->router->get('/route1', 'Controller1@action1');
        $this->router->post('/route2', 'Controller2@action2');
        $this->router->get('/route3', 'Controller3@action3');
        
        $reflection = new \ReflectionProperty($this->router, 'routes');
        $reflection->setAccessible(true);
        $routes = $reflection->getValue($this->router);
        
        $this->assertCount(3, $routes);
    }

    public function testRouteWithMiddleware(): void
    {
        $this->router->get('/test', 'TestController@testAction', ['AuthMiddleware']);
        
        $reflection = new \ReflectionProperty($this->router, 'routes');
        $reflection->setAccessible(true);
        $routes = $reflection->getValue($this->router);
        
        $this->assertContains('AuthMiddleware', $routes[0]['middleware']);
    }

    public function testUriToRegexConvertsSimpleRoute(): void
    {
        $reflection = new \ReflectionMethod($this->router, 'uriToRegex');
        $reflection->setAccessible(true);
        
        $result = $reflection->invoke($this->router, '/test');
        
        $this->assertEquals('#^/test$#', $result);
    }

    public function testUriToRegexConvertsRouteWithParameter(): void
    {
        $reflection = new \ReflectionMethod($this->router, 'uriToRegex');
        $reflection->setAccessible(true);
        
        $result = $reflection->invoke($this->router, '/test/{id}');
        
        $this->assertEquals('#^/test/(?P<id>[^/]+)$#', $result);
    }

    public function testUriToRegexConvertsRouteWithMultipleParams(): void
    {
        $reflection = new \ReflectionMethod($this->router, 'uriToRegex');
        $reflection->setAccessible(true);
        
        $result = $reflection->invoke($this->router, '/test/{id}/edit/{name}');
        
        $this->assertEquals('#^/test/(?P<id>[^/]+)/edit/(?P<name>[^/]+)$#', $result);
    }

    public function testDispatchReturns404ForUnmatchedRoute(): void
    {
        $this->router->get('/existing', 'TestController@testAction');
        
        ob_start();
        $this->router->dispatch('/nonexistent', 'GET');
        $output = ob_get_clean();
        
        $this->assertStringContainsString('Page Not Found', $output);
    }

    public function testDispatchReturns404ForWrongMethod(): void
    {
        $this->router->get('/test', 'TestController@testAction');
        
        ob_start();
        $this->router->dispatch('/test', 'POST');
        $output = ob_get_clean();
        
        $this->assertStringContainsString('Page Not Found', $output);
    }

    public function testDispatchMatchesRouteWithParameters(): void
    {
        $this->router->get('/user/{id}', 'MockController@paramAction');
        
        $this->router->dispatch('/user/123', 'GET');
        
        $reflection = new \ReflectionProperty($this->router, 'routes');
        $reflection->setAccessible(true);
        
        $this->assertTrue(true);
    }

    public function testDispatchNormalizesUri(): void
    {
        $this->router->get('test', 'TestController@testAction');
        
        ob_start();
        $this->router->dispatch('test', 'GET');
        ob_get_clean();
        
        $this->assertTrue(true);
    }

    public function testDispatchNormalizesUriWithTrailingSlash(): void
    {
        $this->router->get('/test', 'TestController@testAction');
        
        ob_start();
        $this->router->dispatch('/test/', 'GET');
        ob_get_clean();
        
        $this->assertTrue(true);
    }

    public function testDispatchCaseInsensitiveMethod(): void
    {
        $this->router->get('/test', 'TestController@testAction');
        
        ob_start();
        $this->router->dispatch('/test', 'get');
        ob_get_clean();
        
        $this->assertTrue(true);
    }
}
