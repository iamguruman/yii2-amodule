<?php

namespace app\modules\hat_letter\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class DefaultController extends Controller
{
    
    private $module_path;

    private $module_id = "hat_letter";

    private $object_table_name = "m_hatletter";
    private $object_model_name = "MHatLetter";
    private $object_model_query = "MHatLetterQuery";
    private $object_search_model_name = "MHatLetterSearch";
    private $object_data_provider = "MHatLetterDataProvider";

    private $upload_model_name = "MHatLetterUpload";
    private $upload_model_query = "MHatLetterUploadQuery";
    private $upload_search_model_name = "MHatLetterUploadSearch";
    private $upload_data_provider = "MHatLetterUploadDataProvider";

    public function actionIndex()
    {

        $this->module_path = Yii::getAlias("@app"."/modules/{$this->module_id}");

        $this->text_replace("/Module.php");
        $this->text_replace("/controllers/DefaultController.php");
        $this->text_replace("/controllers/UploadController.php");

        $this->text_replace("/models/MModel.php");
        rename("{$this->module_path}/models/MModel.php", "{$this->module_path}/models/{$this->object_model_name}.php");

        $this->text_replace("/models/MModelQuery.php");
        rename("{$this->module_path}/models/MModelQuery.php", "{$this->module_path}/models/{$this->object_model_query}.php");

        $this->text_replace("/models/MModelSearch.php");
        rename("{$this->module_path}/models/MModelSearch.php", "{$this->module_path}/models/{$this->object_search_model_name}.php");

        $this->object_table_create();
      
        // copy this file to Module path
        
    }

    private function text_replace($file_name){

        $file_path = "{$this->module_path}/controllers/DefaultController.php";

        $file_content = file_get_contents($file_path);

        $file_content = str_replace("{_MODULE_ID_}", $this->module_id, $file_content);

        $file_content = str_replace("{_OBJECT_TABLE_NAME_}", $this->object_table_name, $file_content);
        $file_content = str_replace("{_OBJECT_MODEL_NAME_}", $this->object_model_name, $file_content);
        $file_content = str_replace("{_OBJECT_MODEL_QUERY_}", $this->object_model_query, $file_content);
        $file_content = str_replace("{_OBJECT_SEARCH_MODEL_NAME_}", $this->object_search_model_name, $file_content);
        $file_content = str_replace("{_OBJECT_DATA_PROVIDER_}", $this->object_data_provider, $file_content);

        $file_content = str_replace("{_UPLOAD_MODEL_NAME_}", $this->upload_model_name, $file_content);
        $file_content = str_replace("{_UPLOAD_MODEL_QUERY_}", $this->upload_model_query, $file_content);
        $file_content = str_replace("{_UPLOAD_SEARCH_MODEL_}", $this->upload_search_model_name, $file_content);
        $file_content = str_replace("{_UPLOAD_DATA_PROVIDER_}", $this->upload_data_provider, $file_content);

        file_put_contents($file_path, $file_content);

    }

    private function object_table_create(){

        $sql = "
             CREATE TABLE `{$this->object_table_name}` (
              `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
              `created_at` datetime NULL COMMENT 'Добавлено когда',
              `created_by` int NULL COMMENT 'Добавлено кем',
              `updated_at` datetime NULL COMMENT 'Изменено когда',
              `updated_by` int NULL COMMENT 'Изменено кем',
              `markdel_at` datetime NULL COMMENT 'Удалено когда',
              `markdel_by` int NULL COMMENT 'Удалено кем',
              `name` varchar(255) NULL COMMENT 'Наименование'
            );
        ";

        Yii::$app->db->createCommand($sql);

    }

    private function upload_table_create(){

    }

}
