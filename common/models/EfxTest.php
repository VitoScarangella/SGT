<?php

namespace common\models;

use Yii;
use common\models\Tool;
/**
 * This is the model class for table "efx_test".
 *
 * @property integer $id
 * @property integer $idLingua
 * @property string $testo
 * @property string $testogrande
 * @property integer $idPippo
 * @property integer $numero
 * @property string $data
 * @property string $dataora
 * @property string $tempo
 * @property string $timest
 */
class EfxTest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'efx_test';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'idLingua', 'idPippo', 'numero'], 'integer'],
            [['testogrande'], 'string'],
            [['data', 'dataora', 'tempo', 'timest'], 'safe'],
            [['testo'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'id' => 'ID',

            'idLingua' => 'Lingua',

            'testo' => 'Testo',

            'testogrande' => 'Testogrande',

            'idPippo' => 'Pippo',

            'numero' => 'Numero',

            'data' => 'Data',

            'dataora' => 'Dataora',

            'tempo' => 'Tempo',

            'timest' => 'Timest',
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
