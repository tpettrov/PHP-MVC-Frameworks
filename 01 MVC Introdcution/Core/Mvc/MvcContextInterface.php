<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 3/26/2017
 * Time: 19:30
 */

namespace Core\Mvc;


interface MvcContextInterface
{
    public  function getControllerName();
    public  function getActionName();
    public function getParams();
}