<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 3/26/2017
 * Time: 19:34
 */

namespace Core\Mvc;


class MvcContext implements MvcContextInterface
{

    private $controllerName;
    private $actionName;
    private $params = [];


    public function __construct(string $controllerName, string $actionName, array $params)
    {

        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
        $this->params = $params;


    }




    public function getControllerName(){

        return $this->controllerName;
    }

    public function getActionName()
    {
        return $this->actionName;
    }

    public function getParams()
    {
        return $this->params;
    }



}