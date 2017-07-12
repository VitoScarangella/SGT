<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "operazionedettaglio".
 *
 * @property integer $id
 * @property integer $idOperazione
 * @property integer $segno
 * @property integer $idIva
 * @property string $imponibile
 * @property string $importo
 * @property string $descrizione
 * @property string $lastUpdate
 * @property string $created
 */
class Operazionedettaglio extends \yii\db\ActiveRecord
{
  const DETAIL  = 0;
  const FEE     = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'operazionedettaglio';
    }

    /**
     * @inheritdoc
	 */
    public function rules()
    {
        return [

            [['idOperazione', 'segno', 'idIva', 'cespite', 'quantita', 'idUnitaMisura','type'], 'integer'],
            [['imponibile', 'importo', 'importoUnitario'], 'number'],
            [['descrizione'], 'string'],
            [['imponibile', 'importo', 'importoUnitario', 'lastUpdate', 'created', 'quantita', 'idUnitaMisura'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'idOperazione' => 'Id Operazione',
            'quantita' => 'Quantita',
            'segno' => 'Segno',
            'idIva' => 'Id Iva',
            'idUnitaMisura' => 'Unita Misura',
            'imponibile' => 'Imponibile',
            'importo' => 'Importo',
            'importoUnitario' => 'Importo Unitario',
            'cespite' => 'Cespite',
            'descrizione' => 'Descrizione',
            'lastUpdate' => 'Last Update',
            'created' => 'Created',
        ];
    }

    /**
     * @inheritdoc
     * @return OperazionedettaglioQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OperazionedettaglioQuery(get_called_class());
    }




}
