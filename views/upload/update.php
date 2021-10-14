<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

/* @var $model app\modules\project\models\MProjectUpload */

$this->title = $model->filename_original;

$this->params['breadcrumbs'][] = \app\modules\project\Module::getBreadcrumbs();

$this->params['breadcrumbs'][] = $model->object->getBreadcrumbs();

$this->params['breadcrumbs'][] = 'Редактирование';

?>
<div class="mproject-upload-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

        <?= aHtmlButtonDelete($model) ?>

    </p>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
