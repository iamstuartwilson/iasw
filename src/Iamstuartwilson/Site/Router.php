<?php

namespace Iamstuartwilson\Site;

use AltoRouter;

class Router
{
    /**
     * @var class AltoRouter
     */
    protected $router;

    /**
     * @var string
     */
    protected $baseUrl;

    function __construct($baseUrl)
    {
        $this->router = new AltoRouter();
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    /**
     * Returns a path relative to a base url
     *
     * @param  string $path
     *
     * @return string
     */
    protected function getPagePath($path)
    {
        $path = ltrim($path, '/');

        return $this->baseUrl . '/' . $path;
    }

    /**
     * Adds a route to AltoRouter
     *
     * @param string    $path
     * @param function  $callback
     * @param string    $method
     */
    public function addRoute($path, $callback, $method = 'GET')
    {
        return $this->router->map($method, $this->getPagePath($path), $callback);
    }

    /**
     * Serves matching route callable function, falling back to provided function
     *
     * @param function $fallback
     */
    public function match($fallback)
    {
        // Match route
        $match = $this->router->match();

        // Serve page
        if ($match && is_callable($match['target'])) {
            return call_user_func_array($match['target'], $match['params']);
        }

        return call_user_func($fallback);
    }
}
