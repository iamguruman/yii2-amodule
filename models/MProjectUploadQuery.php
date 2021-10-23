<?php

namespace app\modules\project\models;

/**
 * This is the ActiveQuery class for [[MProjectUpload]].
 *
 * @see MProjectUpload
 */
class MProjectUploadQuery extends \yii\db\ActiveQuery
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
     * @return MProjectUpload[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MProjectUpload|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
