<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ReaderControl */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reader-control-form">

    <?php $form = ActiveForm::begin(); ?>

<!--    --><?//= $form->field($model, 'reader_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'value')->textInput(['maxlength' => true]) ?>


    <?= $form->field($model, 'comment')->textInput(['maxlength' => true]) ?>

    <span class="form-group">
        <?= Html::submitButton('Save', ['name'=>'save','class' => 'btn btn-success']) ?>
        <?php if(isset($isCreate)){?>
        <?= Html::submitButton('Save & Continue', ['value'=>'previous_four','name'=>'save-continue','class' => 'btn btn-success']) ?>
    	<?php }?>
        <a href="cancel" class="btn btn-secondary" role="button">Cancel</a>
    </span>
    
    <?php ActiveForm::end(); ?>

</div>

