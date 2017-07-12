<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comuniistat".
 *
 * @property integer $CodiceRegione
 * @property string $CodiceCittaMetropolitana
 * @property integer $codiceProvincia
 * @property integer $ProgressivoComune
 * @property string $CodiceComune
 * @property string $DenominazioneItaliano
 * @property string $DenominazioneTedesco
 * @property integer $CodiceRipartizioneGeografica
 * @property string $RipartizioneGeografica
 * @property string $Regione
 * @property string $CittaMetropolitana
 * @property string $Provincia
 * @property integer $FlagCapoluogo
 * @property string $SiglaAutomobilistica
 * @property integer $CodiceComuneNumerico
 * @property integer $CodiceComuneNumerico_2006_2009
 * @property integer $CodiceComunenumerico_1995_2005
 * @property string $CodiceCatastale
 * @property integer $Popolazione_2011
 * @property string $CodiceNUTS1_2010
 * @property string $CodiceNUTS2_2010
 * @property string $CodiceNUTS3_2010
 * @property string $CodiceNUTS1_2006
 * @property string $CodiceNUTS2_2006
 * @property string $CodiceNUTS3_2006
 */
class Comuniistat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comuniistat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['CodiceRegione', 'CodiceCittaMetropolitana', 'CodiceProvincia', 'ProgressivoComune', 'CodiceComune', 'DenominazioneItaliano', 'CodiceRipartizioneGeografica', 'RipartizioneGeografica', 'Regione', 'CittaMetropolitana', 'Provincia', 'FlagCapoluogo', 'SiglaAutomobilistica', 'CodiceComuneNumerico', 'CodiceComuneNumerico_2006_2009', 'CodiceComunenumerico_1995_2005', 'CodiceCatastale', 'Popolazione_2011', 'CodiceNUTS1_2010', 'CodiceNUTS2_2010', 'CodiceNUTS3_2010', 'CodiceNUTS1_2006', 'CodiceNUTS2_2006', 'CodiceNUTS3_2006'], 'required'],
            [['CodiceRegione',  'ProgressivoComune', 'CodiceRipartizioneGeografica', 'FlagCapoluogo', 'CodiceComuneNumerico', 'CodiceComuneNumerico_2006_2009', 'CodiceComunenumerico_1995_2005', 'Popolazione_2011'], 'integer'],
            [['CodiceCittaMetropolitana', 'CodiceProvincia','CodiceComune'], 'string', 'max' => 12],
            [['DenominazioneItaliano', 'DenominazioneTedesco', 'RipartizioneGeografica', 'Regione', 'CittaMetropolitana', 'Provincia', 'SiglaAutomobilistica', 'CodiceCatastale', 'CodiceNUTS1_2010', 'CodiceNUTS2_2010', 'CodiceNUTS3_2010', 'CodiceNUTS1_2006', 'CodiceNUTS2_2006', 'CodiceNUTS3_2006'], 'string', 'max' => 80]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'CodiceRegione' => 'Codice Regione',
            'CodiceCittaMetropolitana' => 'Codice Citta Metropolitana',
            'CodiceProvincia' => 'Codice Provincia',
            'ProgressivoComune' => 'Progressivo Comune',
            'CodiceComune' => 'Codice Comune',
            'DenominazioneItaliano' => 'Denominazione Italiano',
            'DenominazioneTedesco' => 'Denominazione Tedesco',
            'CodiceRipartizioneGeografica' => 'Codice Ripartizione Geografica',
            'RipartizioneGeografica' => 'Ripartizione Geografica',
            'Regione' => 'Regione',
            'CittaMetropolitana' => 'Citta Metropolitana',
            'Provincia' => 'Provincia',
            'Prov' => 'Provincia',
            'FlagCapoluogo' => 'Flag Capoluogo',
            'SiglaAutomobilistica' => 'Sigla Automobilistica',
            'CodiceComuneNumerico' => 'Codice Comune Numerico',
            'CodiceComuneNumerico_2006_2009' => 'Codice Comune Numerico 2006 2009',
            'CodiceComunenumerico_1995_2005' => 'Codice Comunenumerico 1995 2005',
            'CodiceCatastale' => 'Codice Catastale',
            'Popolazione_2011' => 'Popolazione 2011',
            'CodiceNUTS1_2010' => 'Codice Nuts1 2010',
            'CodiceNUTS2_2010' => 'Codice Nuts2 2010',
            'CodiceNUTS3_2010' => 'Codice Nuts3 2010',
            'CodiceNUTS1_2006' => 'Codice Nuts1 2006',
            'CodiceNUTS2_2006' => 'Codice Nuts2 2006',
            'CodiceNUTS3_2006' => 'Codice Nuts3 2006',
        ];
    }

	/*
	Formato per combo \kartik\widgets\Select2
	*/
	public static function dropdown() {
		$models = static::find()->all();
		foreach ($models as $model) {
			$dropdown[$model->CodiceComune] = $model->DenominazioneItaliano;
		}
		return $dropdown;
	}

	/*
	Formato per combo \kartik\widgets\Select2
	*/
	public static function dropdownProv() {
		$models = static::find()->where(['FlagCapoluogo'=>1])->all();
			$dropdown[""] = "";
		foreach ($models as $model) {
			$dropdown[$model->CodiceProvincia] = $model->DenominazioneItaliano;
		}
		return $dropdown;
	}

	/*
	Formato per combo kartik\widgets\DepDrop
             * [
             *    ['id'=>'<sub-cat-id-1>', 'name'=>'<sub-cat-name1>'],
             *    ['id'=>'<sub-cat_id_2>', 'name'=>'<sub-cat-name2>']
             * ]
	*/
	public static function dropdownComuniDedrop($prov) {
		$models = static::find()->where(['CodiceProvincia'=>$prov])->orderBy(['flagCapoluogo' => SORT_DESC , 'DenominazioneItaliano' => SORT_ASC ])->all();
    $dropdown = [];
		foreach ($models as $model) {
			$dropdown[] = ['id'=>$model->CodiceComune, 'name'=>$model->DenominazioneItaliano];
		}
		return $dropdown;
	}


}
