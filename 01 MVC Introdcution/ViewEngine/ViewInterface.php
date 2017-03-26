<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 3/26/2017
 * Time: 19:53
 */

namespace ViewEngine;


interface ViewInterface
{

    public function render($model = null, $viewName = null);

}