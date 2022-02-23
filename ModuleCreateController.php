<?php

namespace app\modules\modules\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 */
class ModuleCreateController extends Controller
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

    //
    // MODULE
    //

    private $module_id = "op_kp";

    private $module_title = "Предварительный расчет";

    //
    // OBJECT
    //
    private $object_table_name = "m_op_kp";

    private $object_model_name = "MOpKp";
    private $object_model_query;
    private $object_search_model_name;
    private $object_data_provider;

    private $object_title_name = "Кассовый чек";
    private $object_list_title = "Список начислений и выплат";
    private $object_create_title = "Создать операцию";

    //
    // UPLOAD
    //
    private $upload_table_name;
    private $upload_model_name;
    private $upload_model_query;
    private $upload_search_model_name;
    private $upload_data_provider;

    /**
     * Контроллер отвечает за обнолвение всех файлов
     */
    public function actionIndex()
    {

        $this->object_model_query = "{$this->object_model_name}Query";
        $this->object_search_model_name = "{$this->object_model_name}Search";
        $this->object_data_provider = "{$this->object_model_name}DataProvider";

        $this->upload_table_name = "{$this->object_table_name}__upload";

        $this->upload_model_name = "{$this->object_model_name}Upload";
        $this->upload_model_query = "{$this->upload_model_name}Query";
        $this->upload_search_model_name = "{$this->upload_model_name}Search";
        $this->upload_data_provider = "{$this->upload_model_name}DataProvider";

        $module_path = Yii::getAlias("@app"."/modules/{$this->module_id}");

        foreach ($this->getFiles($module_path) as $file){
            $this->text_replace($file);
        }

        $this->rename_file("{$module_path}/models/MModel.php", "{$module_path}/models/{$this->object_model_name}.php");
        $this->rename_file("{$module_path}/models/MModelQuery.php", "{$module_path}/models/{$this->object_model_query}.php");
        $this->rename_file("{$module_path}/models/MModelSearch.php", "{$module_path}/models/{$this->object_search_model_name}.php");
        $this->rename_file("{$module_path}/models/MUpload.php", "{$module_path}/models/{$this->upload_model_name}.php");
        $this->rename_file("{$module_path}/models/MUploadQuery.php", "{$module_path}/models/{$this->upload_model_query}.php");
        $this->rename_file("{$module_path}/models/MUploadSearch.php", "{$module_path}/models/{$this->upload_search_model_name}.php");
        $this->rename_file("{$module_path}/models/MUploadSearch.php", "{$module_path}/models/{$this->upload_search_model_name}.php");

        $this->object_table_create();
        $this->upload_table_create();

        echo Html::a('Перейти в модуль', ["/{$this->module_id}"], ['']);

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

        $file_content = str_replace("{_OBJECT_TITLE_NAME_}", $this->object_title_name, $file_content);
        $file_content = str_replace("{_OBJECT_CREATE_TITLE_}", $this->object_create_title, $file_content);
        $file_content = str_replace("{_OBJECT_LIST_TITLE_}", $this->object_list_title, $file_content);

        $file_content = str_replace("{_UPLOAD_TABLE_NAME_}", $this->upload_table_name, $file_content);
        $file_content = str_replace("{_UPLOAD_MODEL_NAME_}", $this->upload_model_name, $file_content);
        $file_content = str_replace("{_UPLOAD_MODEL_QUERY_}", $this->upload_model_query, $file_content);
        $file_content = str_replace("{_UPLOAD_SEARCH_MODEL_}", $this->upload_search_model_name, $file_content);
        $file_content = str_replace("{_UPLOAD_DATA_PROVIDER_}", $this->upload_data_provider, $file_content);

        file_put_contents($file_path, $file_content);

    }

    private function object_table_create(){

        // DROP TABLE IF EXISTS `{$this->object_table_name}`;
        $sql = "
             CREATE TABLE IF NOT EXISTS `{$this->object_table_name}` (
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

        Yii::$app->db->createCommand($sql)->execute();

    }

    private function upload_table_create(){

        // DROP TABLE IF EXISTS `{$this->upload_table_name}`;
        $sql = "
            CREATE TABLE IF NOT EXISTS `{$this->upload_table_name}` (
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

        Yii::$app->db->createCommand($sql)->execute();

    }

    private function getFiles(string $directory, array $allFiles = []): array
    {
        $files = array_diff(scandir($directory), ['.', '..']);

        foreach ($files as $file) {
            $fullPath = $directory. DIRECTORY_SEPARATOR .$file;

            if( is_dir($fullPath) )
                $allFiles += $this->getFiles($fullPath, $allFiles);
            else
                $allFiles[] = $directory. DIRECTORY_SEPARATOR .$file;
        }

        return $allFiles;
    }

    private function rename_file($from, $to){
        if(file_exists($from)){
            rename($from, $to);
        }
    }

}
