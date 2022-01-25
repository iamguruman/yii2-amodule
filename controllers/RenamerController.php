<?php

namespace app\modules\hat_letter\controllers;

use app\modules\project\models\MProjectUpload;
use app\modules\project\models\MProjectUploadSearch;
use Yii;
use app\modules\project\models\MProject;
use app\modules\project\models\MProjectSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for MHatLetter model.
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
     * Lists all MHatLetter models.
     * @return mixed
     */
    public function actionIndex()
    {
        $module_path = str_replace(__FILE__, "/controllers/RenamerController.php", "");


    }

}
