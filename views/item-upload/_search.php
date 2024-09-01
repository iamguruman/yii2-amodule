<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_}ItemUploadSearch */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="{_MODULE_ID_}-item-upload-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'object_id') ?>

    <?= $form->field($model, 'team_by') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'markdel_by') ?>

    <?php // echo $form->field($model, 'markdel_at') ?>

    <?php // echo $form->field($model, 'filename_original') ?>

    <?php // echo $form->field($model, 'md5') ?>

    <?php // echo $form->field($model, 'ext') ?>

    <?php // echo $form->field($model, 'mimetype') ?>

    <?php // echo $form->field($model, 'size') ?>

    <?php // echo $form->field($model, 'type_xxx') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
