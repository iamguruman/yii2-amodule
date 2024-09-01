<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_} */

/* @var $uploadSearchModel \app\modules\{_MODULE_ID_}\models\{_UPLOAD_SEARCH_MODEL_} */
/* @var $uploadDataProvider \yii\data\ActiveDataProvider */

if(aIfModuleControllerAction("{_MODULE_ID_}", "default", "view")){
    $this->title = $model->getTitle();

    $this->params['breadcrumbs'][] = app\modules\{_MODULE_ID_}\Module::getBreadcrumbs();

    $this->params['breadcrumbs'][] = $this->title;

    \yii\web\YiiAsset::register($this);
}
?>
<div class="m{_MODULE_ID_}-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= aHtmlButtonUpdate($model) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
        ],
    ]) ?>

    <?= \yii\bootstrap\Tabs::widget(['items' => [

        [
            'label' => 'ID',
            'active' => false,
            'content' => DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'created_at',
                    'createdBy.lastNameWithInitials',
                    'updated_at',
                    'updatedBy.lastNameWithInitials',
                    'markdel_at',
                    'markdelBy.lastNameWithInitials',
                ],
            ])
        ],

        {VIEW_ACTION_TABS_WIDGET_ITEMS}

        !empty($uploadDataProvider) ? [
            'label' => "Файлы ({$uploadDataProvider->totalCount})",
            'active' => aGet('tab') == 'files' ? true : null,
            'content' => "<br>".$this->render("../upload/index.php", [
                    'searchModel' => $uploadSearchModel,
                    'dataProvider' => $uploadDataProvider,
                ]),
        ] : ['visible' => false],


    ]]) ?>

</div>
