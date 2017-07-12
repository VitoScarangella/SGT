<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[backend\models\Log]].
 *
 * @see backend\models\Log
 */
class backend\models\LogQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return backend\models\Log[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return backend\models\Log|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}