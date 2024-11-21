<?php

namespace app\modules\{_MODULE_ID_}\models;

/**
 * This is the ActiveQuery class for {_OBJECT_MODEL_NAME_}{ITEM_NAME}Upload.
 *
 * @see {_OBJECT_MODEL_NAME_}{ITEM_NAME}Upload
 */
class {_OBJECT_MODEL_NAME_}{ITEM_NAME}UploadQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function init()
    {
        parent::init();

        if(aIfHideMarkdel()){
            $this->andWhere([{_OBJECT_MODEL_NAME_}{ITEM_NAME}Upload::tableName().'.markdel_by' => null]);
        }
    }

    /**
     * {@inheritdoc}
     * @return {_OBJECT_MODEL_NAME_}{ITEM_NAME}Upload[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return {_OBJECT_MODEL_NAME_}{ITEM_NAME}Upload|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
