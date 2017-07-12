<?php

namespace common\models;

use Yii;
use app\models\Tool;
/**
 * This is the model class for table "efx_params".
 *
 * @property integer $id
 * @property string $param
 * @property string $label
 */
class EfxParams extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'efx_params';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['param', 'label'], 'string', 'max' => 255],
            [['param'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'id' => 'ID',

            'param' => 'Param',

            'label' => 'Label',
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
