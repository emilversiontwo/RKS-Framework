<?php

namespace Src\Core;

class View
{
    public string $layout;

    public string $content = '';

    public function __construct(string $layout)
    {
        $this->layout = $layout;
    }

    public function render(string $view, $data = [], $layout = ''): string
    {
        extract($data);
        $view_file = VIEWS . '/' . $view . '.php';
        if (file_exists($view_file)) {
            ob_start();
            require $view_file;
            $this->content = ob_get_clean();
        } else {
            abort("View {$view_file} not found", 500);
        }

        if (false === $layout) {
            return $this->content;
        }

        $layout_file = $layout ?: $this->layout;
        $layout_file = VIEWS . '/layouts/' . $layout_file . '.php';
        if (file_exists($layout_file)) {
            ob_start();
            require_once $layout_file;
            return ob_get_clean();
        } else {
            abort("Layout {$layout_file} not found", 500);
        }
        return '';
    }
}