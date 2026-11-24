<?php
/**
 * Contrôleur frontal (routeur) du Front Office.
 * URL de la forme : index.php?r=controleur/action&id=...   (ex. index.php?r=cultures/show&id=2)
 */
require_once __DIR__ . '/app/bootstrap.php';

$route = $_GET['r'] ?? 'home/index';
$notFound = function () {
    (new ErrorController())->notFound();
    exit;
};

if (!is_string($route) || !preg_match('#^[a-z]+(/[a-zA-Z]+)?$#', $route)) {
    $notFound();
}
[$name, $action] = array_pad(explode('/', $route, 2), 2, 'index');
$class = ucfirst($name) . 'Controller';

if (!class_exists($class) || !is_subclass_of($class, 'Controller') || !method_exists($class, $action)) {
    $notFound();
}
$method = new ReflectionMethod($class, $action);
// Seules les actions publiques déclarées dans le contrôleur lui-même sont accessibles
if (!$method->isPublic() || $method->isStatic() || $method->getDeclaringClass()->getName() !== $class) {
    $notFound();
}
(new $class())->$action();
