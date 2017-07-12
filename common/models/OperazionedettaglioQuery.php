<?php

namespace common\models;

/**
 * This is the ActiveQuery class for [[Operazionedettaglio]].
 *
 * @see Operazionedettaglio
 */
class OperazionedettaglioQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Operazionedettaglio[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Operazionedettaglio|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}