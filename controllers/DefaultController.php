<?php

namespace app\modules\{_MODULE_ID_}\controllers;

{DEFAULT_CONTROLLER_USE_ITEM_SEARCH}                       
use app\modules\{_MODULE_ID_}\models\{_UPLOAD_MODEL_NAME_};
use app\modules\{_MODULE_ID_}\models\{_UPLOAD_SEARCH_MODEL_};
use app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_};
use app\modules\{_MODULE_ID_}\models\{_OBJECT_SEARCH_MODEL_NAME_};
//use app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_}{ITEM_NAME}Search;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * DefaultController implements the CRUD actions for {_OBJECT_MODEL_NAME_} model.
 */
class DefaultController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ],
        ];
    }


    /**
     * Lists all {_OBJECT_MODEL_NAME_} models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new {_OBJECT_SEARCH_MODEL_NAME_}();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(['defaultOrder' => ['name' => SORT_ASC]]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single {_OBJECT_MODEL_NAME_} model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $model =  $this->findModel($id);

        $uploadSearchModel = new {_UPLOAD_SEARCH_MODEL_}();
        $uploadDataProvider = $uploadSearchModel->search(Yii::$app->request->queryParams, [
            'object_id' => $model->id
        ]);
        $uploadDataProvider->setSort(['defaultOrder' => ['id' => SORT_DESC]]);
        
        {DEFAULT_CONTROLLER_VIEW_ACTION__ITEMS_DATA_PROVIDER}

        return $this->render('view', [

            {DEFAULT_CONTROLLER_VIEW_ACTION__ITEMS_PARAMS}

            'uploadSearchModel' => $uploadSearchModel,
            'uploadDataProvider' => $uploadDataProvider,

            'model' => $model,

        ]);
    }

    /**
     * Creates a new {_OBJECT_MODEL_NAME_} model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new {_OBJECT_MODEL_NAME_}();

        $model->created_at = aDateNow();
        $model->created_by = aUserMyId();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                aReturnto();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing {_OBJECT_MODEL_NAME_} model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->updated_by = aUserMyId();
        $model->updated_at = aDateNow();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                aReturnto();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing {_OBJECT_MODEL_NAME_} model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        return aControllerActionMarkdel($this, $model, $model->getUrlView(), $model->getUrlIndex());

        return $this->redirect(['index']);
    }

    /**
     * Finds the {_OBJECT_MODEL_NAME_} model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return {_OBJECT_MODEL_NAME_} the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = {_OBJECT_MODEL_NAME_}::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
