<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_}ItemUpload */
/* @var $form yii\widgets\ActiveForm */

$module = app\modules\{_MODULE_ID_}\Module::moduleId;

?>

<div class="{_MODULE_ID_}-item-upload-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= aIfModuleControllerAction($module, "item-upload", "update") ? $form->field($model, 'object_id')->textInput() : null ?>

    <?= (aIfModuleControllerAction($module, "item-upload", "update")) ? $form->field($model, 'filename_original')->textInput(['maxlength' => true]) : null ?>

    <?= aIfModuleControllerAction($module, "item-upload", "create") ?
        $form->field($model, 'files[]')
            ->fileInput(['multiple' => true])
        //->fileInput(['multiple' => true])
        : null ?>

    <? /* aIfModuleControllerAction($module, "upload", "update") ?
        $form->field($model, 'type_screenshot')->checkbox()
        : null */ ?>

    <? /* $form->field($model, 'type_xxx')->textInput() */ ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
