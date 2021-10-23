<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\project\models\MProjectUploadSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$module = app\modules\project\Module::moduleId;
$controller = "upload";
$action = "index";

if(aIfModuleControllerAction($module, $controller, $action)){
    $this->params['breadcrumbs'][] = app\modules\project\Module::getBreadcrumbs();
    $this->title = 'Файлы';
    $this->params['breadcrumbs'][] = $this->title;
}

?>
<div class="mproject-upload-index">

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

            [
                'attribute' => 'id',
                'format' => 'raw',
                'value' => function($model){
                    return aGridVIewColumnId($model);
                }
            ],

            aIfModuleControllerAction($module, "default", "view") ? ['visible' => false] : [
                'attribute' => 'object_id',
                'value' => 'object.urlTo',
                'format' => 'raw',
            ],

            'filename_original',

            'mimetype',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{download} {view}', 'buttons' => [

                'download' => function($url, \app\modules\project\models\MProjectUpload $model, $key){
                    return Html::a("<i class='fas fa-download'></i>",
                        ["/_uploads/{$model->md5}.{$model->ext}"],
                        ['data-pjax' => 0, 'target' => '_blank']);
                },

                'view' => function($url, \app\modules\project\models\MProjectUpload $model, $key){
                    return Html::a("<i class='fas fa-eye'></i>", ['/project/upload/view', 'id' => $model->id], ['data-pjax' => 0]);
                },

            ]],

        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
