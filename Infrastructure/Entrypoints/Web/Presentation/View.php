<?php
// Infrastructure/Entrypoints/Web/Presentation/View.php

class View {
    public static function render(string $template, array $data = []): void {
        $viewFile = dirname(__DIR__, 4) . '/Presentation/Views/' . $template . '.php';
        if (!file_exists($viewFile)) {
            throw new RuntimeException('Vista no encontrada: ' . $template . ' en la ruta ' . $viewFile);
        }
        $layout = dirname(__DIR__, 4) . '/Presentation/Views/layouts/main.php';
        
        extract($data, EXTR_SKIP);
        require $layout;
    }

    public static function redirect(string $route, array $params = []): void {
        $url = '?route=' . urlencode($route);
        foreach ($params as $key => $value) {
            $url .= '&' . urlencode($key) . '=' . urlencode((string)$value);
        }
        header('Location: ' . $url);
        exit;
    }
}
