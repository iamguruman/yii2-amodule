<?php


namespace app\modules\{_MODULE_ID_}\controllers;

use app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_};
use app\modules\{_MODULE_ID_}\models\{_OBJECT_SEARCH_MODEL_NAME_};
use app\modules\users\models\User;
use app\modules\users\models\UserKey;
use kartik\select2\Select2;
use Yii;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use yii\web\JsExpression;
use yii\web\Response;

class ApiController extends \yii\web\Controller
{

    public function behaviors()
    {
        return [

            [
                //'class' => HttpBearerAuth::className()
                'class' => CompositeAuth::className(),
                'authMethods' => [
                    'bearerAuth' => [
                        'class' => HttpBearerAuth::className(),
                        //'class' => MyBearerAuth::className(),
                    ],
                    'basicAuth' => [
                        'class' => HttpBasicAuth::className(),
                        'auth' => function ($username, $password) {
                            return User::checkLogin($username, $password);
                        },
                    ],
                ],

            ],
            [
                'class' => ContentNegotiator::className(),
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                ],
            ],
        ];
    }

    /*
    <?= $form->field($model, '{_MODULE_ID_}_id')->widget(\kartik\select2\Select2::className(), [
        'initValueText' => empty($model->XXXXXX) ? '' : $model->XXXXXXX->name,
        'options' => [
            'placeholder' => 'выбрать {_OBJECT_TITLE_NAME_}',
            //'disabled' => empty($model->warehouse_ibox_id) ? false : true,
        ],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 3,
            'ajax' => [
                'url' => '/{_MODULE_ID_}/api/list/',
                'dataType' => 'json',
                'data' => new \yii\web\JsExpression('function(params) { return {q:params.term}; }'),
            ],
        ],
    ])
    ?>
     */

    public function actionList($q = null)
    {

        $searchModel = new {_OBJECT_SEARCH_MODEL_NAME_}();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, [
            'qname' => $q,
        ]);
        $dataProvider->pagination = false;

        /** @var Nomenclature[] $models */
        $models = $dataProvider->getModels();

        $return = [];

        foreach ($models as $model) {

            $ret = [];

            if(!empty($model->name)){
                $ret [] = $model->name;
            }

            $ret [] = "({$model->id})";

            $return [] = [
                'id' => $model->id,
                'text' => implode(" ", $ret),
            ];
        }

        return ['results' => $return];

    }

}
