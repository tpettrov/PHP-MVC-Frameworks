<?php
/**
 * Created by PhpStorm.
 * User: Toni
 * Date: 3/27/2017
 * Time: 21:22
 */

/** @var \DTO\ProfileEditViewModel $model  */

?>

<div><?= $model->getId();?></div>
<div><?= $model->getUsername();?></div>
<div><?= $model->getPassword(); ?></div>
<div><?= $model->getEmail(); ?></div>
<div><?= $model->getBirthday(); ?></div>

