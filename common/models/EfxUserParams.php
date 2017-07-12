<?php

namespace common\models;

use Yii;
use app\models\Tool;
/**
 * This is the model class for table "efx_user_params".
 *
 * @property integer $id
 * @property string $idUser
 * @property string $param
 * @property string $value
 * @property string $valueExt
 */
class EfxUserParams extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'efx_user_params';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idUser'], 'required'],
            [['idUser'], 'integer'],
            [['valueExt'], 'string'],
            [['param', 'value'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'id' => 'ID',

            'idUser' => 'User',

            'param' => 'Param',

            'value' => 'Value',

            'valueExt' => 'Value Ext',
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
