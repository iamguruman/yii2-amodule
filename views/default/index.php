<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\modules\project\models\MProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$module = app\modules\project\Module::moduleId;
$controller = "default";
$action = "index";

if(aIfModuleControllerAction($module, $controller, $action)){

    $this->title = \app\modules\project\Module::moduleTitle;

    $this->params['breadcrumbs'][] = $this->title;
}

?>
<div class="mproject-index">

    <?= aHtmlHeader($this->title, $module, $controller, $action) ?>

    <p>
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

            ['attribute' => 'id', 'format' => 'raw', 'value' => function($model) { return aGridVIewColumnId($model); }],

            //'created_at',
            //'markdel_at',
            //'markdel_by',
            'name',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {files}', 'buttons' => [
                'view' => function($url, $model, $key){
                    return aGridViewActionColumnViewButton($model, $model->getUrlView());
                },

                'files' => function($url, \app\modules\project\models\MProject $model, $key){

                    $count = count($model->uploads);

                    if($count > 0){
                        return Html::a("<i class='fas fa-paperclip'>{$count}</i>",
                            ["/project/default/view", 'id' => $model->id, 'tab' => 'files'],
                            ['data-pjax' => 0]);
                    }

                }
            ]],        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
