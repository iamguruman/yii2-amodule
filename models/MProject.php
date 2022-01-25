<?php

namespace app\modules\{_MODULE_ID_}\models;

use Yii;
use app\modules\users\models\User;
use yii\helpers\Html;

/**
 * This is the model class for table "{_OBJECT_TABLE_NAME_}".
 *
 * @property int $id
 * @property string $created_at Добавлено когда
 *
 * @property int $created_by Добавлено кем
 * @property User $createdBy
 *
 * @property string $updated_at Изменено когда
 *
 * @property int $updated_by Изменено кем
 * @property User $updatedBy
 *
 * @property string $markdel_at Удалено когда
 *
 * @property int $markdel_by Удалено кем
 * @property User $markdelBy
 *
 * @property string $name Наименование
 *
 * @property-read MProjectUpload[] $uploads - вложения, см метод getUploads
 * 
 */
class {_OBJECT_MODEL_NAME_} extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{_OBJECT_TABLE_NAME_}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string'],

            [['created_at', 'updated_at', 'markdel_at'], 'safe'],

            [['created_by', 'updated_by', 'markdel_by'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['markdel_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['markdel_by' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
         
            'urlTo' => 'Проект',
            'urlToBlank' => 'Проект',

            'created_at' => 'Добавлено когда',

            'created_by' => 'Добавлено кем',
            'createdBy.lastNameWithInitials' => 'Добавлено кем',

            'updated_at' => 'Изменено когда',

            'updated_by' => 'Изменено кем',
            'updatedBy.lastNameWithInitials' => 'Изменено кем',

            'markdel_at' => 'Удалено когда',

            'markdel_by' => 'Удалено кем',
            'markdelBy.lastNameWithInitials' => 'Удалено кем',

            'name' => 'Наименование',
        ];
    }

    /**
     * ссылка на просмотр объекта
     * @return array
     */
    public function getUrlView(){
        return ['/{_MODULE_ID_}/default/view', 'id' => $this->id];
    }

    /**
     * ссылка к списку объектов
     * @return array
     */
    public function getUrlIndex(){
        return ['/{_MODULE_ID_}/default/index'];
    }

    public function getUrlTo($target = null){
        return Html::a($this->getTitle(),
            $this->getUrlView(),
            ['target' => $target, 'data-pjax' => 0]);
    }

    /**
     * получить заголовок объекта
     * @return string
     */
    public function getTitle(){

        $ret = [];
        
        $ret [] = $this->name;
        
        return implode(' ', $ret);
    
    }

    public function getUrlToBlank(){
        return $this->getUrlTo('_blank');
    }

    public function getBreadcrumbs(){
        return [
            'label' => $this->getTitle(),
            'url' => $this->getUrlView()
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarkdelBy()
    {
        return $this->hasOne(User::className(), ['id' => 'markdel_by']);
    }

    /**
     * получаем файлы вложения
     * @return \yii\db\ActiveQuery
     */
    public function getUploads()
    {
        return $this->hasMany({_UPLOAD_MODEL_NAME_}::className(), ['object_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return {_OBJECT_MODEL_QUERY_} the active query used by this AR class.
     */
    public static function find()
    {
        return new {_OBJECT_MODEL_QUERY_}(get_called_class());
    }
}
