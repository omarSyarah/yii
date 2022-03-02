<?php

namespace common\models\query;

/**
 * This is the ActiveQuery class for [[\common\models\Make]].
 *
 * @see \common\models\Make
 */
class MakesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return \common\models\Make[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return \common\models\Make|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
