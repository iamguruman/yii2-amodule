<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_} */

$this->title = '{_OBJECT_CREATE_TITLE_}';

$this->params['breadcrumbs'][] = app\modules\{_MODULE_ID_}\Module::getBreadcrumbs();

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="mproject-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
