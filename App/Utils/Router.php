<?php

namespace App\Utils;

class Router
{
    private array $routes = [];

    public function add(string $method, string $uri, array $action): void
    {
        $pattern = preg_replace('/{([a-zA-Z0-9_]+)}/', '([^/]+)', $uri);
        $regex = "#^" . $pattern . "$#";

        $this->routes[$method][$regex] = [
            'action' => $action,
            'uri' => $uri
        ];
    }

    public function match(string $requestMethod, string $requestUri): ?array
    {
        if (!isset($this->routes[$requestMethod])) {
            return null;
        }

        foreach ($this->routes[$requestMethod] as $regex => $routeData) {
            if (preg_match($regex, $requestUri, $matches)) {
                array_shift($matches);
                preg_match_all('/{([a-zA-Z0-9_]+)}/', $routeData['uri'], $paramNames);
                $paramNames = $paramNames[1];

                $params = [];
                foreach ($paramNames as $index => $name) {
                    if (isset($matches[$index])) {
                        $params[$name] = $matches[$index];
                    }
                }

                return [
                    'action' => $routeData['action'],
                    'params' => $params
                ];
            }
        }

        return null;
    }
}
