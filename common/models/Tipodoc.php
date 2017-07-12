<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tipocosto".
 *
 * @property integer $id
 * @property string $descrizione
 */
class Tipodoc extends \yii\db\ActiveRecord
{
    const FATTURA = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tipodoc';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['descrizione'], 'required'],
            [['descrizione'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descrizione' => 'Descrizione',
        ];
    }

	public static function dropdown($segno) {
		$models = static::find()->all();
		foreach ($models as $model) {
			$dropdown[$model->id] = $model->descrizione;
		}
		return $dropdown;
	}



}
