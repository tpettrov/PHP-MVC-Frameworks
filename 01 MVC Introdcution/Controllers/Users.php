<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 3/26/2017
 * Time: 16:53
 */

namespace Controllers;


use DTO\UserViewModel;
use ViewEngine\ViewInterface;

class Users
{

    public function hello(string $firstName, string $lastName, ViewInterface $view)
    {

        $viewModel = new UserViewModel($firstName, $lastName);
        $view->render($viewModel);


    }


}