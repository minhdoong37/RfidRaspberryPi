<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ReaderControl */

$this->title = 'Update Reader Control: ' . $model->key;
$this->params['breadcrumbs'][] = ['label' => 'Reader Controls', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->reader_code , 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="reader-control-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
