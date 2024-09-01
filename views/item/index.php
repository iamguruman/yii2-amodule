<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\modules\fileserver\components\FileServerGetLink;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_}ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$module = app\modules\{_MODULE_ID_}\Module::moduleId;
$controller = "item";
$action = "index";

if(aIfModuleControllerAction($module, $controller, $action)){

    $this->title = "{ITEM_TITLE}";

    $this->params['breadcrumbs'][] = $this->title;
}

?>
<div class="{_MODULE_ID_}-item-index">

    <?= aHtmlHeader($this->title, $module, $controller, $action) ?>

    <p>
        <?= aIfModuleControllerAction($module, 'default', 'view') ?
            Html::a('Добавить', ["/{$module}/{$controller}/create",
                '{_ITEM_TABLE_PARENT_ID_FIELD_}' => aGet('id'),
                'returnto' => $_SERVER['REQUEST_URI']],
                    ['class' => 'btn btn-success'])
            : null  ?>

        <?= aIfModuleControllerAction($module, $controller, $action) ?
            Html::a('Добавить', ["/{$module}/{$controller}/create"], ['class' => 'btn btn-success'])
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
            
            //'created_at',
            //'markdel_at',
            //'markdel_by',
            'name',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {files}', 'buttons' => [
                'view' => function($url, \app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_}Item $model, $key){
                    return aGridViewActionColumnViewButton($model, $model->getUrlView());
                },

                'files' => function($url, \app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_}Item $model, $key){

                    $count = count($model->uploads);

                    if($count == 1){
                        
                        $upload = $model->uploads[0];
                        return Html::a("<i class='fas fa-paperclip'>{$count}</i>",
                            FileServerGetLink::http($upload->md5, $upload->ext),
                            ['data-pjax' => 0, 'target' => '_blank']
                        );
                        
                    } elseif($count > 1){
                        
                        return Html::a("<i class='fas fa-paperclip'>{$count}</i>",
                            ["/{_MODULE_ID_}/item/view", 'id' => $model->id, 'tab' => 'files'],
                            ['data-pjax' => 0]);
                        
                    }

                }
            ]],        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
