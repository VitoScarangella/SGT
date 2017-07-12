<?php

namespace common\models;

use Yii;
use common\models\Tool;
/**
 * This is the model class for table "efx_log_batch".
 *
 * @property integer $id
 * @property string $idKey
 * @property string $elabDdate
 * @property string $lastUpdate
 * @property string $msg
 */
class Logbatch extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'efx_log_batch';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['elabDdate', 'lastUpdate'], 'safe'],
            [['msg'], 'string'],
            [['idKey'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'id' => 'ID',

            'idKey' => 'Key',

            'elabDdate' => 'Elab Ddate',

            'lastUpdate' => 'Last Update',

            'msg' => 'Msg',
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
