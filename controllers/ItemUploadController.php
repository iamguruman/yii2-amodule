<?php

namespace app\modules\{_MODULE_ID_}\controllers;

use app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_}{ITEM_NAME};
use app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_}{ITEM_NAME}Upload;
use app\modules\{_MODULE_ID_}\models\{_OBJECT_MODEL_NAME_}UploadSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use Yii;

/**
 * {ITEM_NAME}UploadController implements the CRUD actions for {_OBJECT_MODEL_NAME_}{ITEM_NAME}Upload model.
 */
class {ITEM_NAME}UploadController extends Controller
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
     * Lists all {_OBJECT_MODEL_NAME_}{ITEM_NAME}Upload models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new {_OBJECT_MODEL_NAME_}{ITEM_NAME}UploadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(['defaultOrder' => ['id' => SORT_DESC]]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single {_OBJECT_MODEL_NAME_}{ITEM_NAME}Upload model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new {_OBJECT_MODEL_NAME_}{ITEM_NAME}Upload model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new {_OBJECT_MODEL_NAME_}{ITEM_NAME}Upload();

        $model->team_by = aTeamDefaultId();
        $model->created_at = aDateNow();
        $model->created_by = aUserMyId();

        if($object = {_OBJECT_MODEL_NAME_}{ITEM_NAME}::findOne(aGet('object'))){
            $model->object_id = $object->id;
        }

        $directory = Yii::getAlias('@webroot/_uploads') . DIRECTORY_SEPARATOR;

        if ($model->load(Yii::$app->request->post())) {

            $model->files = UploadedFile::getInstances($model, 'files');

            // перебираю каждый файл из загруженных
            // в данном случае вариант загрузки нескольких файлов
            // иногда бывают случаи когда нельзя несколько файлов грузить сразу
            foreach ($model->files as $uploadedFile){

                $md5 = md5_file($uploadedFile->tempName);

                $fileName = $md5 . '.' . $uploadedFile->extension;

                $filePath = $directory . $fileName;

                if(!file_exists($filePath)){
                    $uploadedFile->saveAs($filePath);
                }

                if({_OBJECT_MODEL_NAME_}{ITEM_NAME}Upload::find()->andWhere(['md5' => $md5, 'object_id' => $object->id])->count() == 0){

                    $uploadModel = new {_OBJECT_MODEL_NAME_}{ITEM_NAME}Upload();  // поменять название модели
                    $uploadModel->object_id = $object->id;

                    $uploadModel->team_by = aTeamDefaultId();
                    $uploadModel->created_at = aDateNow();
                    $uploadModel->created_by = aUserMyId();
                    $uploadModel->md5 = $md5;
                    $uploadModel->filename_original = $uploadedFile->name;
                    $uploadModel->ext = $uploadedFile->extension;
                    $uploadModel->mimetype = $uploadedFile->type;
                    $uploadModel->size = $uploadedFile->size;

                    // добавить свои проверки для массовых расстановок галочек
                    //if($model->type_ustavnoi_doc){
                    //    $uploadModel->type_ustavnoi_doc = $model->type_ustavnoi_doc;
                    //}

                    if($uploadModel->save()){ } else { ddd($uploadModel->errors); }

                }

            }

            aReturnto();
            //if ($model->save()) {
            //    return $this->redirect(['view', 'id' => $model->id]);
            //}
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing {_OBJECT_MODEL_NAME_}{ITEM_NAME}Upload model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())){
            if($model->save()) {
                return $this->redirect(['/{_MODULE_ID_}/{ITEM_NAME_LOWCASE}/view', 'id' => $model->object_id, 'tab' => 'files']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing {_OBJECT_MODEL_NAME_}{ITEM_NAME}Upload model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        return aControllerActionMarkdel($this, $model,
            ['/{_MODULE_ID_}/{ITEM_NAME_LOWCASE}/view', 'id' => $model->object_id, 'tab' => 'files'],
            ['/{_MODULE_ID_}/{ITEM_NAME_LOWCASE}/view', 'id' => $model->object_id, 'tab' => 'files']
        );
    }

    /**
     * Finds the {_OBJECT_MODEL_NAME_}{ITEM_NAME}Upload model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return {_OBJECT_MODEL_NAME_}{ITEM_NAME}Upload the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = {_OBJECT_MODEL_NAME_}{ITEM_NAME}Upload::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
