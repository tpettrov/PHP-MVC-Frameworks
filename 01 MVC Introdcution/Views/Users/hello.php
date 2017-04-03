<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 3/26/2017
 * Time: 18:52
 */

/** @var \DTO\UserViewModel $model */

?>

<h1> Hello <?= $model->getFirstName(); ?> <?=$model->getLastName(); ?></h1>


<form action="/PHP MVC Frameworks/01 MVC Introdcution/users/edit/4">

    <input type="text" name="id">
    <input type="text" name="username">
    <input type="text" name="password">
    <input type="text" name="email">
    <input type="text" name="birthday">

    <input type="submit">


</form>