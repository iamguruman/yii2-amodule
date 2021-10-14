<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\project\models\MProject */

$this->title = $model->getTitle();

$this->params['breadcrumbs'][] = \app\modules\project\Module::getBreadcrumbs();

$this->params['breadcrumbs'][] = $model->getBreadcrumbs();

$this->params['breadcrumbs'][] = 'Редактирование';

?>
<div class="mproject-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>

        <?= aHtmlButtonDelete($model) ?>

    </p>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
