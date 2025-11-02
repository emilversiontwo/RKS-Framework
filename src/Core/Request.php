<?php

namespace Src\Core;

use RequestParseBodyException;

class Request
{
    public string $uri;

    public array $params;

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

    /**
     * @throws RequestParseBodyException
     */
    public function handleBodyRequest(): Request
    {
        if (str_contains($this->uri, '?')) {
            $parametrs = explode('?', $this->uri);
            $parametrs = $parametrs[1];
            $parametrs = explode('&', $parametrs);

            $regexp = '/^([^=]+)=(.*)$/u';

            foreach ($parametrs as $parametr) {
                if (preg_match($regexp, $parametr, $m)) {
                    $key = $m[1];
                    $value = $m[2];
                    $this->params[$key] = $value;
                }
            }

            return $this;
        }

        if (!empty($_POST)) {
            foreach ($_POST as $name => $value) {
                $this->params[htmlspecialchars($name)] = htmlspecialchars($value);
            }
        }

        return $this;
    }
}