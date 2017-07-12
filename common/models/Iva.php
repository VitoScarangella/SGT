<?php

namespace common\models;

use Yii;
use common\models\Tool;
/**
 * This is the model class for table "iva".
 *
 * @property integer $id
 * @property string $tipiva
 * @property string $aliquo
 * @property integer $taxstamp
 * @property string $fae_natura
 * @property string $descrizione
 * @property string $status
 * @property string $annota
 * @property string $adminid
 * @property string $lastUpdate
 * @property string $created
 */
class Iva extends \yii\db\ActiveRecord
{
    const IVA = 0;
    const NOIVA = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'iva';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aliquo', 'status'], 'number'],
            //[['taxstamp', 'fae_natura'], 'required'],
            [['taxstamp'], 'integer'],
            [['lastUpdate', 'created'], 'safe'],
            [['tipiva'], 'string', 'max' => 1],
            [['fae_natura'], 'string', 'max' => 2],
            [['descrizione', 'descrizioneLunga', 'annota'], 'string', 'max' => 50],
            [['adminid'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'id' => 'ID',

            'tipiva' => 'Tipiva',

            'aliquo' => 'Aliquo',

            'taxstamp' => 'Taxstamp',

            'fae_natura' => 'Fae Natura',

            'descrizione' => 'Descrizione',

            'descrizioneLunga' => 'Descrizione Estesa',

            'status' => 'Status',

            'annota' => 'Annota',

            'adminid' => 'Adminid',

            'lastUpdate' => 'Last Update',

            'created' => 'Created',
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

    public static function dropdown() {
      $models = static::find()->all();
      foreach ($models as $model) {
          $dropdown[$model->id] = $model->descrizione;
      }
      return $dropdown;
    }

    public static function dropdownStatus($firstEmpty=true) {
            if ($firstEmpty) $dropdown[ "" ] = "....";
            $dropdown["0"] = "IVA";
            $dropdown["1"] = "NO IVA";
            return $dropdown;
    }


}
