<?php

namespace Src\Core;

class Response
{
    public function setResponseCode(int $code): void
    {
        http_response_code($code);
    }

    public function redirect(string $path): void
    {

    }
}