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
