<?php
/** Classe de base des contrôleurs : rendu des vues, redirections, erreurs. */
abstract class Controller
{
    protected function view(string $view, array $data = [], string $layout = 'main'): void
    {
        $data['authUser'] = Auth::user();
        $data['flashes']  = flash_pull();
        $data['title']    = $data['title'] ?? APP_NAME;
        extract($data, EXTR_SKIP);

        ob_start();
        require ROOT_PATH . '/app/views/' . $view . '.php';
        $content = ob_get_clean();
        require ROOT_PATH . '/app/views/layouts/' . $layout . '.php';
    }

    protected function redirect(string $route, array $params = []): void
    {
        redirect(url($route, $params));
    }

    /** Les actions qui modifient des données exigent POST + jeton CSRF. */
    protected function requirePost(): void
    {
        if (!is_post()) {
            http_response_code(405);
            $this->abort(405, 'Méthode non autorisée.');
        }
        Csrf::check();
    }

    protected function abort(int $code = 404, string $message = ''): void
    {
        http_response_code($code);
        $this->view('errors/' . ($code === 403 ? '403' : '404'), [
            'title' => $code === 403 ? 'Accès refusé' : 'Page introuvable',
            'message' => $message,
        ]);
        exit;
    }

    protected function post(string $key, string $default = ''): string
    {
        $v = $_POST[$key] ?? $default;
        return is_string($v) ? trim($v) : $default;
    }

    protected function intParam(string $key): int
    {
        $v = $_GET[$key] ?? $_POST[$key] ?? '';
        return ctype_digit((string) $v) ? (int) $v : 0;
    }
}
