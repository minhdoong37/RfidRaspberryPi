<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TagControl */

$this->title = 'Create Tag Control';
$this->params['breadcrumbs'][] = ['label' => 'Tag Controls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-control-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
