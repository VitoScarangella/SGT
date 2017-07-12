<?php

namespace common\models;

use Yii;
use app\models\Tool;
/**
 * This is the model class for table "efx_pagamenti".
 *
 * @property integer $id
 * @property string $idPagamento
 * @property integer $idTipopagamento
 * @property integer $idKey
 * @property integer $idOperazione
 * @property integer $idUtente
 * @property integer $idCliente
 * @property string $mediatore
 * @property string $importo
 * @property string $valuta
 * @property integer $statoPagamento
 */
class EfxPagamenti extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'efx_pagamenti';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idTipopagamento', 'idKey', 'idOperazione', 'idUtente', 'idCliente', 'statoPagamento'], 'integer'],
            [['importo'], 'number'],
            [['idPagamento', 'mediatore'], 'string', 'max' => 250],
            [['valuta'], 'string', 'max' => 6],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'id' => 'ID',

            'idPagamento' => 'Pagamento',

            'idTipopagamento' => 'Tipopagamento',

            'idKey' => 'Key',

            'idOperazione' => 'Operazione',

            'idUtente' => 'Utente',

            'idCliente' => 'Cliente',

            'mediatore' => 'Mediatore',

            'importo' => 'Importo',

            'valuta' => 'Valuta',

            'statoPagamento' => 'Stato Pagamento',
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
