<?php

class Router
{
    // Tableau qui stocke les routes, rangées par méthode HTTP (GET ou POST)
    // Exemple:
    // $routes['GET']['/produits'] = [ControllerClass, 'method']
    private array $routes = [
        'GET' => [],
        'POST' => [],
    ];

    // Enregistre une route GET
    public function get(string $path, callable $handler): void
    {
        // On associe un chemin (ex: "/") à une action (une fonction)
        $this->routes['GET'][$path] = $handler;
    }

    // Enregistre une route POST
    public function post(string $path, callable $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    // Cherche la route qui correspond à l'URL et la méthode, puis l'exécute
    public function dispatch(string $uri, string $method): void
    {
        // On nettoie l'URL pour enlever les paramètres GET
        // Exemple: "/test?id=42" devient "/test"
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';

        // On met la méthode en majuscules au cas où
        $method = strtoupper($method);

        // Si la méthode n'existe pas dans notre tableau, c'est pas géré
        if (!isset($this->routes[$method])) {
            http_response_code(405);
            echo "Methode non supportee";
            return;
        }

        // Si on a une route exacte qui correspond
        if (isset($this->routes[$method][$path])) {
            // On récupère la fonction associée à la route
            $handler = $this->routes[$method][$path];

            // On exécute la fonction
            $handler();
            return;
        }

        // Sinon, route introuvable
        http_response_code(404);
        echo "404 - Page non trouvee";
    }
}
