<?php

namespace backend\models;

use Yii;
use backend\models\Tool;
/**
 * This is the model class for table "sgt_ricerca".
 *
 * @property integer $id
 * @property integer $tipo
 * @property string $lemma
 * @property string $sinonimo
 */
class SgtRicerca extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sgt_ricerca';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tipo'], 'integer'],
            [['lemma', 'sinonimo'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'id' => 'ID',

            'tipo' => 'Tipo',

            'lemma' => 'Lemma',

            'sinonimo' => 'Sinonimo',
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
