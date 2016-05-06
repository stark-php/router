<?php

use Stark\Router\Router;
use Stark\Router\Exceptions\{BadTypeException, RouteNotFoundException};

class RouterTest extends PHPUnit_Framework_TestCase
{
    public function testWeCannotPassThroughABadType()
    {
        $this->expectException(BadTypeException::class);
        $router = new Router();

        $router->storeRoute('foobar', '/home', function() {});
    }

    public function testWeCanStoreARoute()
    {
        $router = new Router();
        $closure = function() {};

        $router->storeRoute('GET', '/home', $closure);

        $this->assertEquals(['/home' => $closure], $router->getRoutes());
    }

    public function testWeCannotProcessARouteThatHasntBeenStored()
    {
        $this->expectException(RouteNotFoundException::class);
        $router = new Router();

        $router->processRoute('GET', '/home');
    }

    public function testWeCanProcessARoute()
    {
        $router = new Router;
        $closure = function() {
            return 'A Response';
        };
        $router->storeRoute('GET', '/home', $closure);

        $response = $router->processRoute('GET', '/home');

        $this->assertEquals('A Response', $response);
    }
}
