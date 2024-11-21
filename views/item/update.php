<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_}{ITEM_NAME} */

$this->title = $model->getTitle();

$this->params['breadcrumbs'][] = \app\modules\{_MODULE_ID_}\Module::getBreadcrumbs();

$this->params['breadcrumbs'][] = $model->getBreadcrumbs();

$this->params['breadcrumbs'][] = 'Редактирование';

?>
<div class="{_MODULE_ID_}-{ITEM_NAME_LOWCASE}-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

        <?= aHtmlButtonDelete($model) ?>

    </p>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
