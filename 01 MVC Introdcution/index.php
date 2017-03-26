<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 3/24/2017
 * Time: 18:01
 */

spl_autoload_register(function($className){

    include $className . '.php';

});

$uri = $_SERVER['REDIRECT_URL'];

$self = explode ('/', $_SERVER['PHP_SELF']);
array_pop($self);
$replace = implode('/', $self);
$uri = str_replace($replace.'/', '', $uri);


$params = explode('/', $uri);
$controllerName = array_shift($params);
$actionName = array_shift($params);

$mvcContext = new \Core\Mvc\MvcContext($controllerName, $actionName, $params);
$app = new \Core\Application($mvcContext);
$app->registerDependency(\ViewEngine\ViewInterface::class, \ViewEngine\View::class);
$app->start();





?>

