<?php

namespace App;

class Router
{

    private string $viewpath;
    private \AltoRouter $router;

    public function __construct(string $viewPath)
    {
        $this->viewpath = $viewPath;
        $this->router = new \AltoRouter();
    }

    public function get(string $url, string $view, ?string $name = null): self
    {
        $this->router->map('GET', $url, $view, $name);
        return $this;
    }

    public function run()
    {
        $match = $this->router->match();
        $view = $match['target'];
        ob_start();
        require $this->viewpath . DIRECTORY_SEPARATOR . $view . '.php';
        $content = ob_get_clean();
        require $this->viewpath . DIRECTORY_SEPARATOR . 'layouts/default.php';

        return $this;
    }
}
