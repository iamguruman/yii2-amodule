<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\web\Controller;
use ZipArchive;

class AmoduleWithItemController extends Controller
{

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

    private $module_id = "solution";

    private $module_title = "Решение";

    //
    // OBJECT
    //
    private $object_table_name = "m_"."solution";

    private $object_model_name = "MSolution";
    private $object_model_query;
    private $object_search_model_name;
    private $object_data_provider;

    private $object_title_name = "Решение";
    private $object_list_title = "Список";
    private $object_create_title = "Добавить";

    private $object_name_label = "Наименование";

    //
    // UPLOAD
    //
    private $upload_table_name;
    private $upload_model_name;
    private $upload_model_query;
    private $upload_search_model_name;
    private $upload_data_provider;

    // ITEM

    private $create_item_crud = true;

    private $item_item_name = "Product";
    private $item_title = "Продукт";
    private $item_table_name;
    private $item_model_query;
    private $item_search_model_name;
    private $item_data_provider;
    private $item_upload_table_name;
    private $item_upload_model_name;
    private $item_upload_model_query;
    private $item_upload_search_model_name;
    private $item_upload_data_provider;
    private $item_table__path_to_parent_id_field;

    /**
     * Контроллер отвечает за обнолвение всех файлов
     */
    public function actionIndex()
    {

        /*shell_exec("rm -rf /var/www/erp3.babiev.com/public_html/modules/{$this->module_id}");
        $this->aecho("shell_exec: rm -rf /var/www/erp3.babiev.com/public_html/modules/{$this->module_id}");

        $sql = "
            DROP TABLE IF EXISTS `erp`.`{$this->object_table_name}`;
            DROP TABLE IF EXISTS `erp`.`{$this->object_table_name}__upload`;
            DROP TABLE IF EXISTS `erp`.`{$this->object_table_name}__{}`;
            DROP TABLE IF EXISTS `erp`.`{$this->object_table_name}__item_upload`;
        ";
        Yii::$app->db->createCommand($sql)->execute();
        $this->aecho($sql);
        ddd();*/

        $this->downloading_source_from_github();

        $this->object_model_query = "{$this->object_model_name}Query";
        $this->object_search_model_name = "{$this->object_model_name}Search";
        $this->object_data_provider = "{$this->object_model_name}DataProvider";

        $this->upload_table_name = "{$this->object_table_name}__upload";

        $this->upload_model_name = "{$this->object_model_name}Upload";
        $this->upload_model_query = "{$this->upload_model_name}Query";
        $this->upload_search_model_name = "{$this->upload_model_name}Search";
        $this->upload_data_provider = "{$this->upload_model_name}DataProvider";

        $module_path = Yii::getAlias("@app"."/modules/{$this->module_id}");


        if($this->create_item_crud){

            $this->item_table_name = "m_testcrud__item"; //todo ??????

            $this->item_model_query = "{$this->object_model_name}{$this->item_item_name}Query";
            $this->item_search_model_name = "{$this->object_model_name}{$this->item_item_name}Search";
            $this->item_data_provider = "{$this->object_model_name}{$this->item_item_name}DataProvider";

            $this->item_upload_table_name = "{$this->item_table_name}_upload";

            $this->item_upload_model_name = "{$this->object_model_name}{$this->item_item_name}Upload";
            $this->item_upload_model_query = "{$this->item_upload_model_name}Query";
            $this->item_upload_search_model_name = "{$this->item_upload_model_name}Search";
            $this->item_upload_data_provider = "{$this->item_upload_model_name}DataProvider";

            $this->item_table__path_to_parent_id_field = str_replace("m_", "", $this->object_table_name)."_id";
            $this->item_table_create();
            $this->item_upload_table_create();
        }

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

        if($this->create_item_crud){
            $this->rename_file("{$module_path}/models/MItem.php", "{$module_path}/models/{$this->object_model_name}{$this->item_item_name}.php");
            $this->rename_file("{$module_path}/models/MItemQuery.php", "{$module_path}/models/{$this->object_model_name}{$this->item_item_name}Query.php");
            $this->rename_file("{$module_path}/models/MItemSearch.php", "{$module_path}/models/{$this->object_model_name}{$this->item_item_name}Search.php");

            $this->rename_file("{$module_path}/models/MItemUpload.php", "{$module_path}/models/{$this->object_model_name}{$this->item_item_name}Upload.php");
            $this->rename_file("{$module_path}/models/MItemUploadQuery.php", "{$module_path}/models/{$this->object_model_name}{$this->item_item_name}UploadQuery.php");
            $this->rename_file("{$module_path}/models/MItemUploadSearch.php", "{$module_path}/models/{$this->object_model_name}{$this->item_item_name}UploadSearch.php");

            $this->rename_file("{$module_path}/controllers/ItemController.php", "{$module_path}/controllers/{$this->item_item_name}Controller.php");
            $this->rename_file("{$module_path}/controllers/ItemUploadController.php", "{$module_path}/controllers/{$this->item_item_name}UploadController.php");

        } else {
            unlink("{$module_path}/controllers/ItemController.php");
            unlink("{$module_path}/controllers/ItemUploadController.php");

            unlink("{$module_path}/models/MItem.php");
            unlink("{$module_path}/models/MItemQuery.php");
            unlink("{$module_path}/models/MItemSearch.php");

            unlink("{$module_path}/models/MItemUpload.php");
            unlink("{$module_path}/models/MItemUploadQuery.php");
            unlink("{$module_path}/models/MItemUploadSearch.php");

            unlink("{$module_path}/views/item/create.php");
            unlink("{$module_path}/views/item/_form.php");
            unlink("{$module_path}/views/item/index.php");
            unlink("{$module_path}/views/item/_search.php");
            unlink("{$module_path}/views/item/update.php");
            unlink("{$module_path}/views/item/view.php");
            rmdir("{$module_path}/views/item");

            unlink("{$module_path}/views/item-upload/create.php");
            unlink("{$module_path}/views/item-upload/_form.php");
            unlink("{$module_path}/views/item-upload/index.php");
            unlink("{$module_path}/views/item-upload/_search.php");
            unlink("{$module_path}/views/item-upload/update.php");
            unlink("{$module_path}/views/item-upload/view.php");
            rmdir("{$module_path}/views/item-upload");
        }

        $this->object_table_create();
        $this->upload_table_create();

        echo Html::a('Перейти в модуль', ["/{$this->module_id}"], ['']);

    }

    private function aecho($text){
        echo $text;
        echo "<br><br>";
    }

    private function unzip_file($file, $destination){
        // create object
        $zip = new ZipArchive() ;
        // open archive
        if ($zip->open($file) !== TRUE) {
            return false;
        }
        // extract contents to destination directory
        $zip->extractTo($destination);
        // close archive
        $zip->close();
        return true;
    }

    private function copyfiles($source_folder, $target_folder, $move=false) {
        //$source_folder=trim($source_folder, '/').'/';
        //$target_folder=trim($target_folder, '/').'/';
        $files = scandir($source_folder);
        foreach($files as $file) {
            if($file != '.' && $file != '..') {
                if ($move) {
                    rename($source_folder.$file, $target_folder.$file);
                } else {
                    copy($source_folder.$file, $target_folder.$file);
                }
            }
        }

        return true;
    }

    private function movefiles($source_folder, $target_folder) {
        if($this->copyfiles($source_folder, $target_folder, $move=true)){
            return true;
        } else {
            return false;
        }
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
        $file_content = str_replace("{_OBJECT_NAME_LABEL_}", $this->object_name_label, $file_content);

        $file_content = str_replace("{_OBJECT_CREATE_TITLE_}", $this->object_create_title, $file_content);
        $file_content = str_replace("{_OBJECT_LIST_TITLE_}", $this->object_list_title, $file_content);

        $file_content = str_replace("{_UPLOAD_TABLE_NAME_}", $this->upload_table_name, $file_content);
        $file_content = str_replace("{_UPLOAD_MODEL_NAME_}", $this->upload_model_name, $file_content);
        $file_content = str_replace("{_UPLOAD_MODEL_QUERY_}", $this->upload_model_query, $file_content);
        $file_content = str_replace("{_UPLOAD_SEARCH_MODEL_}", $this->upload_search_model_name, $file_content);
        $file_content = str_replace("{_UPLOAD_DATA_PROVIDER_}", $this->upload_data_provider, $file_content);

        $file_content = str_replace("{_ITEM_TABLE_PARENT_ID_FIELD_}", $this->item_table__path_to_parent_id_field, $file_content);

        $file_content = str_replace("{_OBJECT_ITEM_MODEL_NAME_}", "{$this->object_model_name}{$this->item_item_name}", $file_content);
        $file_content = str_replace("{ITEM_NAME_LOWCASE}", mb_strtolower($this->item_item_name), $file_content);
        $file_content = str_replace("{ITEM_NAME}", $this->item_item_name, $file_content);

        $file_content = str_replace("{ITEM_TITLE}", $this->item_title, $file_content);

        if($this->create_item_crud){
            $file_content = str_replace("{DEFAULT_CONTROLLER_USE_ITEM_SEARCH}", 'use app\modules\\'.$this->module_id.'\models\\'.$this->object_model_name.$this->item_item_name.'Search;', $file_content);
        } else {
            $file_content = str_replace("{DEFAULT_CONTROLLER_USE_ITEM_SEARCH}", "", $file_content);
        }

        $file_content = str_replace("        {DEFAULT_CONTROLLER_VIEW_ACTION__ITEMS_DATA_PROVIDER}", $this->itemSearcModelAndDataProviderForDefaultController(), $file_content);
        $file_content = str_replace("        {VIEW_ACTION_TABS_WIDGET_ITEMS}", $this->viewActionTabsWidgetItems(), $file_content);
        $file_content = str_replace("{DEFAULT_CONTROLLER_VIEW_ACTION__ITEMS_PARAMS}", $this->viewActionTabsWidgetItemsParams(), $file_content);

        file_put_contents($file_path, $file_content);

    }
    private function object_table_create(){
        $sql = $this->sql_object_table($this->object_table_name);
        Yii::$app->db->createCommand($sql)->execute();
    }

    private  function sql_object_table($table_name, $extra_field = null)
    {
        if($extra_field){
            $extra_fiel_sql = "`{$extra_field}` int NULL COMMENT 'Поле id из таблицы {$this->object_table_name}',";
        } else {
            $extra_fiel_sql = "";
        }

        // DROP TABLE IF EXISTS `{$this->object_table_name}`;
        $sql = "
             CREATE TABLE IF NOT EXISTS `{$table_name}` (
              `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
              `created_at` datetime NULL COMMENT 'Добавлено когда',
              `created_by` int NULL COMMENT 'Добавлено кем',
              `updated_at` datetime NULL COMMENT 'Изменено когда',
              `updated_by` int NULL COMMENT 'Изменено кем',
              `markdel_at` datetime NULL COMMENT 'Удалено когда',
              `markdel_by` int NULL COMMENT 'Удалено кем',
              {$extra_fiel_sql}
              `name` varchar(255) NULL COMMENT 'Наименование'
            );
        ";

        return $sql;
    }

    private function upload_table_create(){
        $sql = $this->sql_upload_table($this->upload_table_name);
        Yii::$app->db->createCommand($sql)->execute();
    }

    private function sql_upload_table($table_name){

        // DROP TABLE IF EXISTS `{$this->upload_table_name}`;
        $sql = "
            CREATE TABLE IF NOT EXISTS `{$table_name}` (
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

        return $sql;

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

    private function downloading_source_from_github()
    {

        $mlink = Html::a("open module webpage", "/{$this->module_id}");
        $this->aecho("Creatin new module, module name: {$this->module_id} ({$mlink})");

        $newModulePath = Yii::getAlias("@app")."/modules/".$this->module_id;

        if(file_exists($newModulePath)){
            $this->aecho("Directory {$newModulePath} exists. Please check you module directory. Cannot continue creating new module. Please change module name.");
            die();
        } else {
            $this->aecho("Directory {$newModulePath} is not exist. Creating directory...");
            if(mkdir($newModulePath)){
                $this->aecho("Director {$newModulePath} is created");
            } else {
                $this->aecho("Error while creating directory {$newModulePath}");
            }
        }

        $repo_url = "https://github.com/iamguruman/yii2-amodule/archive/master.zip";
        $this->aecho("Downloading last version of amodule source coude as zip from GitHub {$repo_url}");

        if($zipContent = file_get_contents($repo_url)){
            $this->aecho("Zip file is downloaded.");
        } else {
            $this->aecho("Error while downloading zip file.");
        }

        $zipFileName = "amodule_source_".date("Y_m_d_H_i_s");
        if(file_put_contents($newModulePath."/{$zipFileName}", $zipContent)){
            $this->aecho("Zip file is saved as ".$newModulePath."/{$zipFileName}");
        } else {
            $this->aecho("Error while saving zip file as ".$newModulePath."/{$zipFileName}");
        }

        if($this->unzip_file($newModulePath."/{$zipFileName}", $newModulePath)){
            $this->aecho("Unzip is success to {$newModulePath}/yii2-amodule-main.");
        } else {
            $this->aecho("Error while unzip file. Please check ZipArchive.");
        }

        $amodulecontrollerphp = "{$newModulePath}/yii2-amodule-main/AmoduleController.php";
        if(file_exists($amodulecontrollerphp)){
            if(unlink($amodulecontrollerphp)){
                $this->aecho("File {$amodulecontrollerphp} is removed");
            } else {
                $this->aecho("Error wile deleting file {$amodulecontrollerphp}");
            }
        }

        $amodulecontrollerphp = "{$newModulePath}/yii2-amodule-main/AmoduleWithItemController.php";
        if(file_exists($amodulecontrollerphp)){
            if(unlink($amodulecontrollerphp)){
                $this->aecho("File {$amodulecontrollerphp} is removed");
            } else {
                $this->aecho("Error wile deleting file {$amodulecontrollerphp}");
            }
        }

        if($this->movefiles("{$newModulePath}/yii2-amodule-main/", "{$newModulePath}/")){
            $this->aecho("Files from {$newModulePath}/yii2-amodule-main} are moved to {$newModulePath}");
        } else {
            $this->aecho("Error wile moving file from {$newModulePath}/yii2-amodule-main} to {$newModulePath}.");
        }

        if(file_exists("{$newModulePath}/yii2-amodule-main")){
            if(rmdir("{$newModulePath}/yii2-amodule-main")){
                $this->aecho("Directory {$newModulePath}/yii2-amodule-main is removed");
            } else {
                $this->aecho("Error wile deleting directory {$newModulePath}/yii2-amodule-main");
            }
        }

    }

    private function item_table_create()
    {
        $sql = $this->sql_object_table("{$this->object_table_name}__".mb_strtolower($this->item_item_name), $this->item_table__path_to_parent_id_field);
        Yii::$app->db->createCommand($sql)->execute();
    }
    private function item_upload_table_create()
    {
        $sql = $this->sql_upload_table("{$this->object_table_name}__".mb_strtolower($this->item_item_name)."_upload");
        Yii::$app->db->createCommand($sql)->execute();
    }

    private function itemSearcModelAndDataProviderForDefaultController()
    {
$ret = '        ${ITEM_NAME_LOWCASE}SearchModel = new {_OBJECT_MODEL_NAME_}{ITEM_NAME}Search();
        ${ITEM_NAME_LOWCASE}DataProvider = ${ITEM_NAME_LOWCASE}SearchModel->search(Yii::$app->request->queryParams, [
            "{_ITEM_TABLE_PARENT_ID_FIELD_}" => $model->id
        ]);
        $itemDataProvider->setSort(["defaultOrder" => ["id" => SORT_DESC]]);
';

        $ret = str_replace("{ITEM_NAME}", $this->item_item_name, $ret);
        $ret = str_replace("{ITEM_NAME_LOWCASE}", mb_strtolower($this->item_item_name), $ret);
        $ret = str_replace("{_OBJECT_MODEL_NAME_}", $this->object_model_name, $ret);
        $ret = str_replace("{_ITEM_TABLE_PARENT_ID_FIELD_}", $this->item_table__path_to_parent_id_field, $ret);

        if($this->create_item_crud){
            return $ret;
        } else {
            return "";
        }
    }

    private function viewActionTabsWidgetItems()
    {
        $ret = '        !empty(${ITEM_NAME_LOWCASE}DataProvider) ? [
            "label" => "{ITEM_TITLE} ({${ITEM_NAME_LOWCASE}DataProvider->totalCount})",
            //"active" => aGet("tab") == "?????" ? true : null,
            "content" => "<br>".$this->render("../{ITEM_NAME_LOWCASE}/index.php", [
                    "searchModel" => ${ITEM_NAME_LOWCASE}SearchModel,
                    "dataProvider" => ${ITEM_NAME_LOWCASE}DataProvider,
                ]),
        ] : ["visible" => false],';

        $ret = str_replace("{ITEM_NAME_LOWCASE}", mb_strtolower($this->item_item_name), $ret);
        $ret = str_replace("{ITEM_TITLE}", $this->item_title, $ret);

        return $ret;
    }

    private function viewActionTabsWidgetItemsParams()
    {
        if(!$this->create_item_crud){
            return null;
        }

        $ret = '"{ITEM_NAME_LOWCASE}SearchModel" => ${ITEM_NAME_LOWCASE}SearchModel,
            "{ITEM_NAME_LOWCASE}DataProvider" => ${ITEM_NAME_LOWCASE}DataProvider,';

        $ret = str_replace("{ITEM_NAME_LOWCASE}", mb_strtolower($this->item_item_name), $ret);

        return $ret;
    }

}
