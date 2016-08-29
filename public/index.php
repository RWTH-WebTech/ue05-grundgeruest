<?php
require_once(__DIR__.'/../src/Application/Application.php');
require_once(__DIR__.'/../src/Application/NavigationItem.php');
require_once(__DIR__.'/../src/Application/Page/Example.php');

$app = new \Application\Application();

$examplePage = new \Application\Page\Example();
$exampleNavigation = new \Application\NavigationItem('Example', 'example');

$app->addPage('example', $examplePage);
$app->addNavigationItem($exampleNavigation);

$app->run();