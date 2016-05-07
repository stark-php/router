<?php namespace Stark\Router;

use Stark\Contracts\Router\RouterInterface as RouterContract;
use Stark\Router\Exceptions\{BadTypeException, RouteNotFoundException};

/**
 * Router class
 */
class Router implements RouterContract
{
    /**
     * Holds all the routes that can be processed by the application
     * @var array
     */
    protected $routes = [];

    protected $allowed_types = ['GET', 'POST', 'PUT', 'DELETE'];

    public function processRoute(string $request_type, string $request_url)
    {
        $this->checkRequestTypeIsValid($request_type);

        if (isset($this->routes[$request_url])) {
            return $this->routes[$request_url]();
        } else {
            throw new RouteNotFoundException("No function was found for the route {$request_url}");
        }
    }

    public function storeRoute(string $request_type, string $request_url, $function_to_process_route)
    {
        $this->checkRequestTypeIsValid($request_type);

        $request_url = $this->normaliseUrl($request_url);

        $this->routes[$request_url] = $function_to_process_route;
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }

    protected function normaliseUrl($url)
    {
        // Making it so urls always start with a slash
        return '/' . ltrim($url, '/');
    }

    public function checkRequestTypeIsValid($request_type)
    {
        if (!in_array($request_type, $this->allowed_types)) {
            throw new BadTypeException("The type {$request_type} is not permitted");
        }
    }
}
