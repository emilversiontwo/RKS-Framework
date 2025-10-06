<?php

namespace Src\App\Controller;

class SomeController
{
    public function index()
    {
        return view('test', ['name' => 'John Doe']);
    }
}