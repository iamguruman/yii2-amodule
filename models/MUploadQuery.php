<?php

namespace app\modules\{_MODULE_ID_}\models;

/**
 * This is the ActiveQuery class for [[{_UPLOAD_MODEL_NAME_}]].
 *
 * @see {_UPLOAD_MODEL_NAME_}
 */
class {_UPLOAD_MODEL_QUERY_} extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function init()
    {
        parent::init();

        if(aIfHideMarkdel()){
            $this->andWhere(['markdel_by' => null]);
        }
    }

    /**
     * {@inheritdoc}
     * @return {_UPLOAD_MODEL_NAME_}[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return {_UPLOAD_MODEL_NAME_}|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
