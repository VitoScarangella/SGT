<?php

namespace common\models;

use Yii;
use common\models\Tool;
/**
 * This is the model class for table "efx_layout".
 *
 * @property integer $id
 * @property integer $idLingua
 * @property integer $idTipodoc
 * @property integer $idSezione
 * @property string $titolo
 * @property string $sottotitolo
 * @property string $descrizione
 * @property integer $visibile
 * @property string $dataCreazione
 * @property string $dataModifica
 * @property string $dataArticolo
 * @property integer $ordinamento
 */
class EfxLayout extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'efx_layout';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idLingua', 'idTipodoc', 'idSezione', 'visibile', 'ordinamento'], 'integer'],
            [['titolo', 'descrizione', 'idLingua','idTipodoc'], 'required'],
            [['descrizione'], 'string'],
            [['dataCreazione', 'dataModifica', 'dataArticolo'], 'safe'],
            [['titolo'], 'string', 'max' => 150],
            [['sottotitolo'], 'string', 'max' => 250],
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

            'idTipodoc' => 'Tipo',

            'idSezione' => 'Sezione',

            'titolo' => 'Titolo',

            'sottotitolo' => 'Sottotitolo',

            'descrizione' => 'Descrizione',

            'visibile' => 'Visibile',

            'dataCreazione' => 'Data Creazione',

            'dataModifica' => 'Data Modifica',

            'dataArticolo' => 'Data Articolo',

            'ordinamento' => 'Ordinamento',
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
      Tool::onBeforeSave($this, $insert);
    //$this->addError('field', "xxxxxxxxxxxxx");

        if (parent::beforeSave($insert)) {
            return true;
        } else {
            return false;
        }
    }



}
