<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\{_MODULE_ID_}\models\{_UPLOAD_SEARCH_MODEL_} */
/* @var $dataProvider yii\data\ActiveDataProvider */

$module = app\modules\{_MODULE_ID_}\Module::moduleId;
$controller = "upload";
$action = "index";

if(aIfModuleControllerAction($module, $controller, $action)){
    $this->params['breadcrumbs'][] = app\modules\{_MODULE_ID_}\Module::getBreadcrumbs();
    $this->title = 'Файлы';
    $this->params['breadcrumbs'][] = $this->title;
}

?>
<div class="m{_MODULE_ID_}-upload-index">

    <?= aHtmlHeader($this->title, $module, $controller, $action) ?>

    <p>

        <?= aIfModuleControllerAction($module, 'default', 'view') ?
            Html::a('Добавить',
                ["/{$module}/{$controller}/create",
                    'returnto' => urlencode($_SERVER['REQUEST_URI']."&tab=files"),
                    'object' => aGet('id')
                ],
                ['class' => 'btn btn-success'])
            : null  ?>

    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            ['attribute' => 'id',
                'headerOptions' => ['style' => 'width:100px;'],
                'format' => 'raw', 'value' => function($model) { return aGridVIewColumnId($model); }],  

            aIfModuleControllerAction($module, "default", "view") ? ['visible' => false] : [
                'attribute' => 'object_id',
                'value' => 'object.urlTo',
                'format' => 'raw',
            ],

            'filename_original',

            'mimetype',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{download} {view}', 'buttons' => [

                'download' => function($url, \app\modules\{_MODULE_ID_}\models\{_UPLOAD_MODEL_NAME_} $model, $key){
                    return Html::a("<i class='fas fa-download'></i>",
                        ["/_uploads/{$model->md5}.{$model->ext}"],
                        ['data-pjax' => 0, 'target' => '_blank']);
                },

                'view' => function($url, \app\modules\{_MODULE_ID_}\models\{_UPLOAD_MODEL_NAME_} $model, $key){
                    return Html::a("<i class='fas fa-eye'></i>", ['/{_MODULE_ID_}/upload/view', 'id' => $model->id], ['data-pjax' => 0]);
                },

            ]],

        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
