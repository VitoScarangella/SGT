<?php

namespace common\models;

use Yii;
use common\models\Tool;
/**
 * This is the model class for table "efx_template".
 *
 * @property integer $id
 * @property integer $idTipotemplate
 * @property string $descrizione
 * @property string $template
 */
class EfxTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'efx_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idTipotemplate'], 'integer'],
            [['descrizione', 'template'], 'required'],
            [['template'], 'string'],
            [['descrizione'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'id' => 'ID',

            'idTipotemplate' => 'Tipo Template',

            'descrizione' => 'Descrizione',

            'template' => 'Template',
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
