<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_}ItemUpload */

$this->title = $model->filename_original;

$this->params['breadcrumbs'][] = \app\modules\{_MODULE_ID_}\Module::getBreadcrumbs();

$this->params['breadcrumbs'][] = $model->object->getBreadcrumbs();

$this->params['breadcrumbs'][] = 'Редактирование';

?>
<div class="_MODULE_ID_-item-upload-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

        <?= aHtmlButtonDelete($model) ?>

    </p>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
