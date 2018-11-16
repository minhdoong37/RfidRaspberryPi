<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ReaderControl */

$this->title = $model->key;
$this->params['breadcrumbs'][] = ['label' => 'Reader Controls', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reader-control-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
//            'reader_code',
            'key',
            'value',
            'comment',
        ],
    ]) ?>

</div>
