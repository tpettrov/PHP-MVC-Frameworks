<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 3/26/2017
 * Time: 18:17
 */

/** @var Core\Mvc\MvcContextInterface */

namespace Core;


use Core\Mvc\MvcContextInterface;

class Application
{
    private $mvcContext;


    private $dependencies = [];
    private $resolvedDependencies = [];



    public function __construct (MvcContextInterface $mvcContext){

        $this->mvcContext = $mvcContext;
        $this->dependencies[MvcContextInterface::class] = get_class($mvcContext);
        $this->resolvedDependencies[get_class($mvcContext)] = $mvcContext;
    }



    public function registerDependency (string $abstraction, string $implementation) {

        $this->dependencies[$abstraction] = $implementation;

    }

    private function resolve($className) {

        if (array_key_exists($className, $this->resolvedDependencies)) {

            return $this->resolvedDependencies[$className];

        }

        $refClass = new \ReflectionClass($className);
        $constructor = $refClass->getConstructor();

        if ($constructor === null) {

            $object = new $className;
            $this->resolvedDependencies[$className] = $object;

            return $object;

        }

        $parameters = $constructor->getParameters();

        $arguments = [];

        foreach ($parameters as $parameter){

            $dependencyInterface = $parameter->getClass();
            $dependencyClass = $this->dependencies[$dependencyInterface->getName()];
                $arguments[] = $this->resolve($dependencyClass);

        }

        $object = $refClass->newInstanceArgs($arguments);
        $this->resolvedDependencies[$className] = $object;

        return $object;


    }


    public function start()
    {

        $params = $this->mvcContext->getParams();
        $controllerFullQualifiedName = "Controllers\\" . ucfirst($this->mvcContext->getControllerName());
        $controller = $this->resolve($controllerFullQualifiedName);

        $refMethod = new \ReflectionMethod($controller, $this->mvcContext->getActionName());
        $refParams = $refMethod->getParameters();
        $count = count($this->mvcContext->getParams());

        for ($i = $count; $i<count($refParams); $i++){

            $argument = $refParams[$i];
            $argumentInterface =  $argument->getClass();
            $argumentClass = $this->dependencies[$argumentInterface->getName()];
            $params[] = $this->resolve($argumentClass);

        }


        call_user_func_array([$controller, $this->mvcContext->getActionName()], $params);

    }









}