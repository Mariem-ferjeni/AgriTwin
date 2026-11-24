<?php
/** Fonctions utilitaires globales. */

/* ---------- Compatibilité : si l'extension mbstring est absente (elle est activée par défaut dans XAMPP) ---------- */
if (!function_exists('mb_strlen')) {
    function mb_internal_encoding($e = null) { return true; }
    function mb_strlen($s, $e = null) { return preg_match_all('/./su', (string) $s); }
    function mb_substr($s, $start, $len = null, $e = null) { $a = preg_split('//u', (string) $s, -1, PREG_SPLIT_NO_EMPTY); return implode('', array_slice($a, $start, $len)); }
    function mb_strtoupper($s, $e = null) { return strtoupper((string) $s); }
    function mb_strimwidth($s, $start, $width, $trim = '', $e = null) {
        $a = preg_split('//u', (string) $s, -1, PREG_SPLIT_NO_EMPTY);
        return count($a) <= $width ? implode('', $a) : implode('', array_slice($a, 0, max(0, $width - mb_strlen($trim)))) . $trim;
    }
}

function e($v): string
{
    return htmlspecialchars((string) ($v ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Chemin web du dossier du projet (ex. /AgriTwin_Final), calculé automatiquement. */
function base_url(): string
{
    static $base = null;
    if ($base !== null) {
        return $base;
    }
    $doc  = str_replace('\\', '/', (string) realpath($_SERVER['DOCUMENT_ROOT'] ?? ''));
    $root = str_replace('\\', '/', (string) realpath(ROOT_PATH));
    if ($doc !== '' && stripos($root, $doc) === 0) {
        $base = rtrim(substr($root, strlen($doc)), '/');
    } else {
        $dir  = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
        $base = rtrim(preg_replace('#/(admin|database)$#', '', $dir), '/');
    }
    return $base;
}

function url(string $route = 'home/index', array $params = []): string
{
    // La route garde ses « / » lisibles (index.php?r=exploitations/show&id=2)
    return base_url() . '/index.php?r=' . $route . ($params ? '&' . http_build_query($params) : '');
}

function asset(string $path): string
{
    return base_url() . '/assets/' . ltrim($path, '/');
}

function admin_url(string $page = 'dashboard.php'): string
{
    return base_url() . '/admin/' . ltrim($page, '/');
}

function redirect(string $to): void
{
    header('Location: ' . $to);
    exit;
}

function is_post(): bool
{
    return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
}

/* ---------- Messages flash (affichés une seule fois) ---------- */
function flash(string $type, string $message): void
{
    $_SESSION['_flash'][] = ['type' => $type, 'msg' => $message];
}

function flash_pull(): array
{
    $f = $_SESSION['_flash'] ?? [];
    unset($_SESSION['_flash']);
    return $f;
}

function format_date(?string $date): string
{
    if (!$date || $date === '0000-00-00') {
        return '—';
    }
    $t = strtotime($date);
    return $t ? date('d/m/Y', $t) : e($date);
}

function truncate(string $text, int $len = 140): string
{
    return mb_strimwidth(trim(strip_tags($text)), 0, $len, '…', 'UTF-8');
}

/** Pagination : renvoie page courante, nombre de pages et décalage SQL. */
function paginate(int $total, int $perPage, int $page): array
{
    $pages = max(1, (int) ceil($total / $perPage));
    $page  = min(max(1, $page), $pages);
    return ['total' => $total, 'per' => $perPage, 'page' => $page, 'pages' => $pages, 'offset' => ($page - 1) * $perPage];
}

/** Lien vers la page courante en conservant les filtres GET. */
function self_url(array $override = []): string
{
    $q = array_merge($_GET, $override);
    foreach ($q as $k => $v) {
        if ($v === '' || $v === null) {
            unset($q[$k]);
        }
    }
    return base_url() . '/index.php?' . str_replace('%2F', '/', http_build_query($q));
}

function partial(string $name, array $vars = []): void
{
    extract($vars, EXTR_SKIP);
    require ROOT_PATH . '/app/views/partials/' . $name . '.php';
}

/* ---------- Aides d'affichage ---------- */
function culture_icon(?string $type): string
{
    $map = ['Agrume' => '🍊', 'Arbre fruitier' => '🌳', 'Légume' => '🥬', 'Céréale' => '🌾'];
    return $map[$type ?? ''] ?? '🌱';
}

function culture_class(?string $type): string
{
    $map = ['Agrume' => 'agrume', 'Arbre fruitier' => 'arbre', 'Légume' => 'legume', 'Céréale' => 'cereale'];
    return 'type-' . ($map[$type ?? ''] ?? 'autre');
}

function etat_badge(string $etat): string
{
    $label = Parcelle::ETATS[$etat] ?? $etat;
    return '<span class="badge etat-' . e($etat) . '">' . e($label) . '</span>';
}

/** Courbe SVG simple (sparkline) à partir d'une liste de nombres. */
function sparkline(array $values, int $w = 260, int $h = 60): string
{
    $values = array_values(array_filter($values, fn($v) => $v !== null));
    if (count($values) < 2) {
        return '';
    }
    $min = min($values); $max = max($values); $range = max(0.0001, $max - $min);
    $pts = [];
    foreach ($values as $i => $v) {
        $x = 4 + $i * (($w - 8) / (count($values) - 1));
        $y = 4 + ($h - 8) * (1 - (($v - $min) / $range));
        $pts[] = round($x, 1) . ',' . round($y, 1);
    }
    return '<svg class="spark" viewBox="0 0 ' . $w . ' ' . $h . '" role="img" aria-label="Évolution de l\'humidité"><polyline fill="none" stroke="currentColor" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round" points="' . implode(' ', $pts) . '"/></svg>';
}
