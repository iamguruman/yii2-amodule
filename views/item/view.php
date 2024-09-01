<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_}Item */

/* @var $uploadSearchModel \app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_}ItemUploadSearch */
/* @var $uploadDataProvider \yii\data\ActiveDataProvider */

if(aIfModuleControllerAction("{_MODULE_ID_}", "item", "view")){
    $this->title = $model->getTitle();

    $this->params['breadcrumbs'][] = app\modules\{_MODULE_ID_}\Module::getBreadcrumbs();

    if($model->parentObject){
        $this->params['breadcrumbs'][] = $model->parentObject->getBreadcrumbs();
    }

    $this->params['breadcrumbs'][] = $this->title;

    \yii\web\YiiAsset::register($this);
}
?>
<div class="{_MODULE_ID_}-item-view">

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

        !empty($uploadDataProvider) ? [
            'label' => "Файлы ({$uploadDataProvider->totalCount})",
            'active' => aGet('tab') == 'files' ? true : null,
            'content' => "<br>".$this->render("../item-upload/index.php", [
                    'searchModel' => $uploadSearchModel,
                    'dataProvider' => $uploadDataProvider,
                ]),
        ] : ['visible' => false],


    ]]) ?>

</div>
