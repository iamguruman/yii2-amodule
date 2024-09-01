<?php

namespace app\modules\{_MODULE_ID_}\controllers;

use app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_}Item;
use app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_}ItemSearch;
use app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_}ItemUploadSearch;
use app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_};
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * DefaultController implements the CRUD actions for {_OBJECT_MODEL_NAME_}Item model.
 */
class ItemController extends Controller
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
     * Lists all {_OBJECT_MODEL_NAME_}Item models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new {_OBJECT_MODEL_NAME_}ItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(['defaultOrder' => ['name' => SORT_ASC]]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single {_OBJECT_MODEL_NAME_}Item model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {

        $model =  $this->findModel($id);

        $uploadSearchModel = new {_OBJECT_MODEL_NAME_}ItemUploadSearch();
        $uploadDataProvider = $uploadSearchModel->search(Yii::$app->request->queryParams, [
            'object_id' => $model->id
        ]);
        $uploadDataProvider->setSort(['defaultOrder' => ['id' => SORT_DESC]]);

        return $this->render('view', [

            'uploadSearchModel' => $uploadSearchModel,
            'uploadDataProvider' => $uploadDataProvider,

            'model' => $model,

        ]);
    }

    /**
     * Creates a new {_OBJECT_MODEL_NAME_}Item model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new {_OBJECT_MODEL_NAME_}Item();

        $model->created_at = aDateNow();
        $model->created_by = aUserMyId();

        $model->kizdoc_id = aGet('kizdoc_id');

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
     * Updates an existing {_OBJECT_MODEL_NAME_}Item model.
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
     * Deletes an existing {_OBJECT_MODEL_NAME_}Item model.
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
     * Finds the {_OBJECT_MODEL_NAME_}Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return {_OBJECT_MODEL_NAME_}Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = {_OBJECT_MODEL_NAME_}Item::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
