<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_}{ITEM_NAME} */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="{_MODULE_ID_}-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, '{_ITEM_TABLE_PARENT_ID_FIELD_}')->textInput() ?>

    <?= $form->field($model, 'name')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
