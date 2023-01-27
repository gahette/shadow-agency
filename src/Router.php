<?php

namespace App;

use AltoRouter;
use Exception;

/**
 * @method generate(string $string, array $array)
 */
class Router
{

    private string $viewpath;
    private AltoRouter $router;

    public function __construct(string $viewPath)
    {
        $this->viewpath = $viewPath;
        $this->router = new AltoRouter();
    }

    /**
     * @throws Exception
     */
    public function get(string $url, string $view, ?string $name = null): self
    {
        $this->router->map('GET', $url, $view, $name);
        return $this;
    }

    public function url(string $name, array $params = [])
    {
    return $this->router->generate($name, $params);
    }

    public function run():self
    {
        $match = $this->router->match();
        $view = $match['target'];
        $router = $this;
        ob_start();
        require $this->viewpath . DIRECTORY_SEPARATOR . $view . '.php';
        $content = ob_get_clean();
        require $this->viewpath . DIRECTORY_SEPARATOR . 'layouts/default.php';

        return $this;
    }
}
