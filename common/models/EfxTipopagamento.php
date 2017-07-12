<?php

namespace common\models;

use Yii;
use common\models\Tool;
/**
 * This is the model class for table "efx_tipopagamento".
 *
 * @property integer $id
 * @property string $codice
 */
class EfxTipopagamento extends \yii\db\ActiveRecord
{
  const TRANSFER  = 1;
  const CC        = 2;
  const CASH      = 3;
  const PAYPAL    = 4;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'efx_tipopagamento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['codice'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'id' => 'ID',

            'codice' => 'Codice',
        ];
    }


    public function save($runValidation = true, $attributeNames = NULL)
    {

        $ris = parent::save($runValidation, $attributeNames);

        return $ris;
    }

    public function delete()
    {

        parent::delete();
    }


    public function beforeSave($insert)
    {

    //$this->addError('field', "xxxxxxxxxxxxx");

        if (parent::beforeSave($insert)) {
            return true;
        } else {
            return false;
        }
    }



}
