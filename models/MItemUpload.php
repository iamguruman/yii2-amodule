<?php

namespace app\modules\{_MODULE_ID_}\models;

use Yii;
use app\modules\users\models\User;
use app\modules\teams\models\Team;

/**
 * This is the model class for table "{_OBJECT_MODEL_NAME_}{ITEM_NAME_LOWCASE}Upload".
 *
 * @property int $id
 *
 * @property int $team_by - Команда по умолчанию, используется для возможности работать с группа команд (для распределение ролей)
 * @property Team $teamBy
 *
 * @property int $created_at  Добавлено когда
 *
 * @property User $createdBy Добавлено кем
 * @property int $created_by
 *
 * @property int $updated_at Когда обновлено
 *
 * @property User $updatedBy Кем обновлено
 * @property int $updated_by
 *
 * @property int $markdel_by Кем удалено
 * @property User $markdelBy
 *
 * @property string $markdel_at Когда удалено
 *
 * @property int $isDeleted - удалить... пережиток прошлого
 *
 * @property string $filename_original Оригинальное название файла
 * @property string $md5 - мд5 хеш файла, чтобы проверять на дубликаты на диске не загружать дубликаты,
 *                         если файл является дубликатом, то в контроллере в методе actionCreate файл не загружаем,
 *                         но добавляем запись о том, что файл относится к объекту
 * @property string $ext Расширение файла
 * @property string $mimetype - миме тип файла
 * @property int $size - размер файла
 *
 * ПОЛЕ ИДЕНТИФИКАТОР ОБЪЕКТА, к котором цепляем файл:
 *
 * @property int $object_id
 * @property {_OBJECT_MODEL_NAME_}Item $object
 *
 *
 * СПИСОК ИНДИВИДУАЛЬНЫХ ПОЛЕЙ:
 * @property int $type_xx
 *
 */
class {_OBJECT_MODEL_NAME_}{ITEM_NAME}Upload extends \yii\db\ActiveRecord
{

    public $files;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{_OBJECT_TABLE_NAME_}__{ITEM_NAME_LOWCASE}_upload';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [

            // обязательные поля:
            [['team_by'], 'integer'],

            [['object_id'], 'integer'], // - главный объект к которому привязывается файл
            [['object_id'], 'exist', 'skipOnError' => true, 'targetClass' => {_OBJECT_MODEL_NAME_}Item::className(), 'targetAttribute' => ['object_id' => 'id']],

            [['created_at', 'updated_at', 'markdel_at'], 'string'],

            [['created_by', 'updated_by', 'markdel_by'], 'integer'],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            [['markdel_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['markdel_by' => 'id']],

            [['size'], 'integer'],

            [['markdel_at'], 'safe'],

            [['filename_original', 'md5', 'ext', 'mimetype'], 'string', 'max' => 255],

            [['files'], 'safe'],

            // индивидуальные поля:
            //[['type_xxx'], 'integer', 'max' => 1], // дополнительное поле


        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',

            'object_id' => 'КИЗ Документ',
            'object.urlTo' => 'КИЗ Документ',

            'team_by' => 'Команда',

            'created_at' => 'Добавлено когда',
            'created_by' => 'Добавлено кем',
            'createdBy.lastNameWithInitials' => 'Добавлено кем',

            'updated_at' => 'Изменено когда',
            'updated_by' => 'Изменено кем',
            'updatedBy.lastNameWithInitials' => 'Изменено кем',

            'markdelBy.lastNameWithInitials' => 'Удалено кем',
            'markdel_by' => 'Удалено кем',
            'markdel_at' => 'Удалено когда',

            'files' => 'Выбрать файл(ы)',
            'filename_original' => 'Оригинальное название файла',
            'md5' => 'Md5',
            'ext' => 'Расширение файла',

            'mimetype' => 'Миме-тип файла',
            'size' => 'Размер файла',

            // дополнительные поля:
            'type_xx' => 'доп поле', // объект, к которому прицепятся файлы
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObject()
    {
        return $this->hasOne({_OBJECT_MODEL_NAME_}Item::className(), ['id' => 'object_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTeamBy()
    {
        return $this->hasOne(Team::className(), ['id' => 'team_by']);
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
     * {@inheritdoc}
     * @return {_OBJECT_MODEL_NAME_}ItemUpload the active query used by this AR class.
     */
    public static function find()
    {
        return new {_OBJECT_MODEL_NAME_}ItemUploadQuery(get_called_class());
    }
}
