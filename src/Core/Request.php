<?php

namespace Src\Core;

class Request
{
    public string $uri;

    public function __construct(string $uri)
    {
        $this->uri = trim(urldecode($uri), '/');
    }

    public function getReqMethod(): string
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    public function isGet(): bool
    {
        return $this->getReqMethod() == 'GET';
    }

    public function isPost(): bool
    {
        return $this->getReqMethod() == 'POST';
    }

    public function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    public function get($name, $default = null): ?string
    {
        return $_GET[$name] ?? $default;
    }

    public function getPath()
    {
        return $this->removeQueryString();
    }

    protected function removeQueryString()
    {
        if ($this->uri) {
            $params = explode('?', $this->uri);
            return trim($params[0], '/');
        } else {
            return "";
        }
    }
}