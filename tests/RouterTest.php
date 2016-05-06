<?php

use Stark\Router\Router;

class RouterTest extends PHPUnit_Framework_TestCase
{
    public function testCanRoute()
    {
        $router = new Router();

        $truth = $router->route();

        $this->assertTrue($truth);
    }
}
