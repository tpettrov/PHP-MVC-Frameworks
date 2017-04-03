<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 3/26/2017
 * Time: 16:53
 */

namespace Controllers;


use DTO\ProfileEditViewModel;
use DTO\UserViewModel;
use ViewEngine\ViewInterface;
use DTO\ProfileEditBindingModel;

class Users
{

    public function hello(string $firstName, string $lastName, ViewInterface $view)
    {

        $viewModel = new UserViewModel($firstName, $lastName);
        $view->render($viewModel);


    }

    public function edit($id, ProfileEditBindingModel $model, ViewInterface $view){

        $viewModel = new ProfileEditViewModel(
            $id,
            $model->getUsername(),
            $model->getPassword(),
            $model->getEmail(),
            $model->getBirthday()


        );

        $view->render($viewModel);

    }


}