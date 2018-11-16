<?php

use yii\helpers\Html;
use common\constant\Config;
/* @var $this yii\web\View */
/* @var $model common\models\ReaderControl */

$this->title = 'Create Reader Control';
$this->params['breadcrumbs'][] = ['label' => 'Reader Controls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reader-control-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'isCreate' => Config::ISSET
    ]) ?>

</div>
