<?php

namespace common\models;

use Yii;
use common\models\Tool;
/**
 * This is the model class for table "fornitore".
 *
 * @property integer $id
 * @property string $ragioneSociale
 * @property string $piva
 * @property string $cf
 * @property string $codCountry
 * @property string $indirizzo
 * @property string $cap
 * @property string $codComune
 * @property integer $codProvincia
 * @property string $banca
 * @property string $indirizzoBanca
 * @property string $iban
 * @property string $mail
 * @property integer $deleted
 * @property string $codPA
 */
class Fornitore extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fornitore';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ragioneSociale', 'piva', 'codCountry'], 'required'],
            [['codProvincia', 'deleted'], 'integer'],
            [['ragioneSociale', 'riferimento', 'indirizzo', 'indirizzoBanca'], 'string', 'max' => 200],
            [['piva', 'cf'], 'string', 'max' => 16],
            [['codCountry', 'codPA'], 'string', 'max' => 6],
            [['cap'], 'string', 'max' => 5],
            [['codComune'], 'string', 'max' => 12],
            [['banca', 'mail'], 'string', 'max' => 100],
            [['iban'], 'string', 'max' => 40],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

          'id' => 'ID',

          'ragioneSociale' => 'Ragione Sociale',

          'riferimento' => 'Riferimento',

          'piva' => 'Partita iva',

          'cf' => 'Codice fiscale',

          'codCountry' => 'Nazione',

          'indirizzo' => 'Indirizzo',

          'cap' => 'Cap',

          'codComune' => 'Comune',

          'codProvincia' => 'Provincia',

          'banca' => 'Banca',

          'indirizzoBanca' => 'Indirizzo Banca',

          'iban' => 'Iban',

          'mail' => 'Mail',

          'deleted' => 'Deleted',

          'codPA' => 'Cod Pa',
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
