<?php

namespace app\modules\project\models;

/**
 * This is the ActiveQuery class for [[MProject]].
 *
 * @see MProject
 */
class MProjectQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function init()
    {
        parent::init();

        if(aIfHideMarkdel()){
            $this->andWhere(['m_project.markdel_by' => null]);
        }
    }

    /**
     * {@inheritdoc}
     * @return MProject[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MProject|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
