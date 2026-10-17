<?php

declare(strict_types=1);

class View
{
    public static function render(
        string $view,
        array $data = [],
        string $layout = 'layouts/public'
    ): void {
        extract($data, EXTR_SKIP);

        ob_start();
        require BASE_PATH . '/resources/views/' . $view . '.php';
        $content = ob_get_clean();

        require BASE_PATH . '/resources/views/' . $layout . '.php';
    }
}