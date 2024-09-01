<?php

namespace app\modules\{_MODULE_ID_}\models;

/**
 * This is the ActiveQuery class for {_OBJECT_MODEL_NAME_}ItemUpload.
 *
 * @see {_OBJECT_MODEL_NAME_}ItemUpload
 */
class {_OBJECT_MODEL_NAME_}ItemUploadQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function init()
    {
        parent::init();

        if(aIfHideMarkdel()){
            $this->andWhere([{_OBJECT_MODEL_NAME_}ItemUpload::tableName().'.markdel_by' => null]);
        }
    }

    /**
     * {@inheritdoc}
     * @return {_OBJECT_MODEL_NAME_}ItemUpload[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return {_OBJECT_MODEL_NAME_}ItemUpload|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
