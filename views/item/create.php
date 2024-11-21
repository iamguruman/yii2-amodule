<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_}{ITEM_NAME} */

$this->title = 'Добавить';

$this->params['breadcrumbs'][] = app\modules\{_MODULE_ID_}\Module::getBreadcrumbs();

if($model->parentObject){
    $this->params['breadcrumbs'][] = $model->parentObject->getBreadcrumbs();
}

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="{_MODULE_ID_}-{ITEM_NAME_LOWCASE}-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
