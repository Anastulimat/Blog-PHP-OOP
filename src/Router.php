<?php


namespace App;


use AltoRouter;
use Exception;

class Router
{

    /**
     * @var string
     */
    private $viewPath;

    /**
     * @var AltoRouter
     */
    private $router;

    /**
     * Router constructor.
     *
     * @param string $viewPath
     */
    public function __construct(string $viewPath)
    {
        $this->viewPath = $viewPath;
        $this->router = new AltoRouter();
    }

    /**
     * Enregistrer une route
     *
     * @param string      $url
     * @param string      $view
     * @param string|null $name
     *
     * @return Router
     * @throws Exception
     */
    public function get(string $url, string $view, ?string  $name = null): self
    {
        $this->router->map('GET', $url, $view, $name);
        return $this;
    }

    /**
     * Permet de génére un url et lui donner un nom
     *
     * @param string $name
     * @param array  $params
     *
     * @return string|null
     */
    public function url(string $name, array $params = [])
    {
        try {
            return $this->router->generate($name, $params);
        } catch(Exception $e) {
            return null;
        }
    }

    /**
     * Vérifier s'il y a une correspondance entre la route demandée et une route enregistrée
     * Si oui charger la vue correspondance
     *
     * @return $this
     */
    public function run()
    {
        $match = $this->router->match();
        $view = $match['target'];
        $params = $match['params'];
        $router = $this;
        ob_start();
        require $this->viewPath . DIRECTORY_SEPARATOR . $view . '.php';
        $content = ob_get_clean();
        require $this->viewPath . DIRECTORY_SEPARATOR . 'layouts/default.php';

        return $this;
    }

}