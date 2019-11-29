<?php
declare(strict_types=1);

require_once __DIR__ . "/../vendor/autoload.php";

use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();

if (substr($request->getPathInfo(), 0, 6) === "/post/") {

    $slug = substr($request->getPathInfo(), 6);

    $files = scandir(__DIR__ . "/../content");

    $contentPath = null;

    foreach ($files as $file) {
        if (substr($file, 11) === "{$slug}.html") {
            $contentPath = __DIR__ . "/../content/{$file}";
        }
    }

    if (is_null($contentPath)) {
        throw new Exception("Content not found");
    }

    ob_start();

    include $contentPath;

    $content = ob_get_contents();

    ob_end_clean();

    include __DIR__ . "/../src/Templates/article.php";
} else {
    include __DIR__ . "/../src/Templates/index.php";
}
