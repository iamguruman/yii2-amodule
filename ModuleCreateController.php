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

    private $module_path;

    private $module_id = "hat_letter";

    private $module_title = "Шляпы письма";

    private $object_table_name = "m_hatletter";
    private $object_model_name = "MHatLetter";
    private $object_model_query = "MHatLetterQuery";
    private $object_search_model_name = "MHatLetterSearch";
    private $object_data_provider = "MHatLetterDataProvider";
    private $object_create_title = "Создать шляпу";

    private $upload_table_name = "m_hatletter__upload";
    private $upload_model_name = "MHatLetterUpload";
    private $upload_model_query = "MHatLetterUploadQuery";
    private $upload_search_model_name = "MHatLetterUploadSearch";
    private $upload_data_provider = "MHatLetterUploadDataProvider";

    public function actionIndex()
    {

        $this->module_path = Yii::getAlias("@app"."/modules/{$this->module_id}");

        foreach ($this->getFiles($this->module_path) as $file){
            $this->text_replace($file);
        }

//        $this->text_replace("/Module.php");
//        $this->text_replace("/controllers/DefaultController.php");
//        $this->text_replace("/controllers/UploadController.php");

//        $this->text_replace("/models/MModel.php");
        rename("{$this->module_path}/models/MModel.php", "{$this->module_path}/models/{$this->object_model_name}.php");

//        $this->text_replace("/models/MModelQuery.php");
        rename("{$this->module_path}/models/MModelQuery.php", "{$this->module_path}/models/{$this->object_model_query}.php");

//        $this->text_replace("/models/MModelSearch.php");
        rename("{$this->module_path}/models/MModelSearch.php", "{$this->module_path}/models/{$this->object_search_model_name}.php");

//        $this->text_replace("/models/MUpload.php");
        rename("{$this->module_path}/models/MUpload.php", "{$this->module_path}/models/{$this->upload_model_name}.php");

//        $this->text_replace("/models/MUploadQuery.php");
        rename("{$this->module_path}/models/MUploadQuery.php", "{$this->module_path}/models/{$this->upload_model_query}.php");

//        $this->text_replace("/models/MUploadSearch.php");
        rename("{$this->module_path}/models/MUploadSearch.php", "{$this->module_path}/models/{$this->upload_search_model_name}.php");

//        $this->text_replace("/models/MUploadSearch.php");
        rename("{$this->module_path}/models/MUploadSearch.php", "{$this->module_path}/models/{$this->upload_search_model_name}.php");

//        $this->text_replace("/models/MUploadSearch.php");

        $this->object_table_create();
        $this->upload_table_create();

    }

    private function text_replace($file_path){

        $file_content = file_get_contents($file_path);

        $file_content = str_replace("{_MODULE_ID_}", $this->module_id, $file_content);

        $file_content = str_replace("{_MODULE_TITLE_}", $this->module_title, $file_content);

        $file_content = str_replace("{_OBJECT_TABLE_NAME_}", $this->object_table_name, $file_content);
        $file_content = str_replace("{_OBJECT_MODEL_NAME_}", $this->object_model_name, $file_content);
        $file_content = str_replace("{_OBJECT_MODEL_QUERY_}", $this->object_model_query, $file_content);
        $file_content = str_replace("{_OBJECT_SEARCH_MODEL_NAME_}", $this->object_search_model_name, $file_content);
        $file_content = str_replace("{_OBJECT_DATA_PROVIDER_}", $this->object_data_provider, $file_content);
        $file_content = str_replace("{_OBJECT_CREATE_TITLE_}", $this->object_create_title, $file_content);

        $file_content = str_replace("{_UPLOAD_TABLE_NAME_}", $this->upload_table_name, $file_content);
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

        $sql = "
        
        DROP TABLE IF EXISTS `{$this->upload_table_name}`;
        CREATE TABLE `{$this->upload_table_name}` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `object_id` int(11) DEFAULT NULL COMMENT 'Объект, к которому крепится файл',
            `team_by` int(11) DEFAULT NULL COMMENT 'Команда',
            `created_at` datetime DEFAULT NULL COMMENT 'Добавлено когда',
            `created_by` int(11) DEFAULT NULL COMMENT 'Добавлено кем',
            `updated_at` datetime DEFAULT NULL COMMENT 'Изменено когда',
            `updated_by` int(11) DEFAULT NULL COMMENT 'Изменено кем',
            `markdel_by` int(11) DEFAULT NULL COMMENT 'Удалено кем',
            `markdel_at` datetime DEFAULT NULL COMMENT 'Удалено когда',
            `filename_original` varchar(255) DEFAULT NULL COMMENT 'Оригинальное название файла',
            `md5` varchar(255) DEFAULT NULL,
            `ext` varchar(255) DEFAULT NULL COMMENT 'Расширение файла',
            `mimetype` varchar(255) DEFAULT NULL COMMENT 'Тип файла',
            `size` int(11) DEFAULT NULL COMMENT 'Размер файла',
            `type_anketa` int(11) DEFAULT NULL COMMENT 'Тип файла Анкета для нового покупателя',
            PRIMARY KEY (`id`),
            KEY `object_id` (`object_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        
        ";

        Yii::$app->db->createCommand($sql);

    }

    private function getFiles(string $directory, array $allFiles = []): array
    {
        $files = array_diff(scandir($directory), ['.', '..']);

        foreach ($files as $file) {
            $fullPath = $directory. DIRECTORY_SEPARATOR .$file;

            if( is_dir($fullPath) )
                $allFiles += getFiles($fullPath, $allFiles);
            else
                $allFiles[] = $file;
        }

        return $allFiles;
    }

}
