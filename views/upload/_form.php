<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\{_MODULE_ID_}\models\{_UPLOAD_MODEL_NAME_} */
/* @var $form yii\widgets\ActiveForm */

$module = app\modules\{_MODULE_ID_}\Module::moduleId;

?>

<div class="m{_MODULE_ID_}-upload-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= (aIfModuleControllerAction($module, "upload", "view") &&
        aUserMyId() == 1) ? $form->field($model, 'kp_id')->textInput() : null ?>

    <?= (aIfModuleControllerAction($module, "upload", "update")) ? $form->field($model, 'filename_original')->textInput(['maxlength' => true]) : null ?>

    <?= aIfModuleControllerAction($module, "upload", "create") ?
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
