<?php

use yii\helpers\Html;
//use yii\grid\GridView;

use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ReaderControlSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reader Controls';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="reader-control-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Reader Control', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    $gridColumns = [
        [
            'class' => 'kartik\grid\SerialColumn',
            'width' => '3%',
            'headerOptions' => ['class' => 'header-table-audit-mdl-serial'],
            'contentOptions' => ['class' => 'mdl-serial'],
            'vAlign' => 'top',
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'key',
            'format' => 'raw',
            'headerOptions' => ['class' => 'header-table-audit-mdl'],
            'vAlign' => 'middle',
            'value' => function ($model) {
                return '<div class="reader-code">' . Html::encode($model['key']) . '</div>';
            },
            'width' => '40%'
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'value',
            'format' => 'raw',
            'headerOptions' => ['class' => 'header-table-audit-mdl'],
            'vAlign' => 'middle',
            'value' => function ($model) {
                return '<div class="reader-code">' . Html::encode($model['value']) . '</div>';
            },
            'width' => '10%'
        ],
        [
            'class' => 'kartik\grid\DataColumn',
            'attribute' => 'comment',
            'label' => 'Action',
            'format' => 'raw',
            'headerOptions' => ['class' => 'header-table-audit-mdl'],
            'vAlign' => 'middle',
            'value' => function ($model) {
                return '<div class="reader-code">' . Html::encode($model['comment']) . '</div>';
            },
            'width' => '30%'
        ],
        [
            'class' => 'yii\grid\ActionColumn',
             'headerOptions' => ['class' => 'header-table-audit'],
            'contentOptions' => ['style' => 'text-align:center'],
           // 'vAlign' => 'top',
        ],
        ]
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns
//         [
//            ['class' => 'yii\grid\SerialColumn'],
//            'key',
//            'value',
//            'comment',
//
//            ['class' => 'yii\grid\ActionColumn'],
//        ],
    ]); ?>
</div>
