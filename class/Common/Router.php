<?php

namespace FS\Common;

class Router
{
    private $groupPattern;
    private $routes = [];

    public function get($pattern, $callback)
    {
        $this->route($pattern, 'GET', $callback);
    }

    public function post($pattern, $callback)
    {
        $this->route($pattern, 'POST', $callback);
    }

    public function put($pattern, $callback)
    {
        $this->route($pattern, 'PUT', $callback);
    }

    public function route($pattern, $method, $callback)
    {
        if (!empty($this->groupPattern)) {
            $pattern = $this->groupPattern . $pattern;
        }

        $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';

        if (is_array($method)) {
            foreach ($method as $m) {
                $this->routes[$pattern][$m] = $callback;
            }
        } else if (is_string($method)) {
            $this->routes[$pattern][$method] = $callback;
        }
    }

    public function group($groupPattern, $callback)
    {
        $this->groupPattern = $groupPattern;

        ($callback->bindTo($this, '\FS\Common\Router'))();

        $this->groupPattern = '';
    }

    public function execute()
    {
        $url    = $_SERVER['PATH_INFO'] ?? $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        foreach ($this->routes as $pattern => $methods) {
            if (preg_match($pattern, $url, $params)) {
                if (isset($methods[$method])) {
                    array_shift($params);

                    try {
                        $response = call_user_func_array($methods[$method], array_values($params));

                        if (isset($response)) {
                            if (is_array($response) || is_object($response)) {
                                // convert array to json string
                                header('content-type: application/json');
                                $response = json_encode(IO::formatResponseArray($response), JSON_HEX_TAG);

                                if (json_last_error() === JSON_ERROR_UTF8) {
                                    throw new \Exception('Unexpected UTF8 error when encode json');
                                }
                            }

                            exit($response);
                        }
                        // Not Found
                        http_response_code(404);
                        exit();
                    } catch (\Exception $e) {
                        // Internal Server Error
                        $result = IO::initResponseArray();

                        $result['status'] = 'error';
                        $result['message']   = $e->getMessage();

                        $result = json_encode(IO::formatResponseArray($result));

                        header('content-type: application/json');
                        http_response_code(500);
                        exit($result);
                    }
                } else {
                    // Method Not Allowed
                    http_response_code(405);
                    exit();
                }
            }
        }
        // Bad Request, no matching path found
        http_response_code(400);
        exit();
    }
}
