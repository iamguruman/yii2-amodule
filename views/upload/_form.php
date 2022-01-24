<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\project\models\MProjectUpload */
/* @var $form yii\widgets\ActiveForm */

$module =app\modules\project\Module::moduleId;

?>

<div class="mproject-upload-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= (aIfModuleControllerAction($module, "upload", "view") &&
        aUserMyId() == 1) ? $form->field($model, 'kp_id')->textInput() : null ?>

    <?= (aIfModuleControllerAction($module, "upload", "update") &&
        aUserMyId() == 1) ? $form->field($model, 'filename_original')->textInput(['maxlength' => true]) : null ?>

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
