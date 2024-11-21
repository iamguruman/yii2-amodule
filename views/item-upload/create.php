<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_}Upload */

$module = app\modules\{_MODULE_ID_}\Module::moduleId;

$this->title = 'Добавить файл';

$this->params['breadcrumbs'][] = \app\modules\{_MODULE_ID_}\Module::getBreadcrumbs();

if($model->object){
    $this->params['breadcrumbs'][] = $model->object->getBreadcrumbs();

    $this->params['breadcrumbs'][] = ['label' => 'Файлы',
        'url' => ["/{$module}/default/view", 'id' => $model->object->id, 'tab' => 'files']];
}

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="{_MODULE_ID_}-{ITEM_NAME_LOWCASE}-upload-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
