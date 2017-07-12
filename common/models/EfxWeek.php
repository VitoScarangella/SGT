<?php

namespace common\models;

use Yii;
use app\models\Tool;
/**
 * This is the model class for table "efx_week".
 *
 * @property integer $id
 * @property integer $idKey
 * @property integer $anno
 * @property integer $week
 * @property integer $presente
 * @property integer $default
 */
class EfxWeek extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'efx_week';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idKey', 'anno', 'week', 'presente', 'default'], 'integer'],
            [['anno'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'id' => 'ID',

            'idKey' => 'Key',

            'anno' => 'Anno',

            'week' => 'Week',

            'presente' => 'Presente',

            'default' => 'Default',
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

    public static function initLoad($idKey)
    {

      $connection = \Yii::$app->db;
      $y = date('Y');
      for ($i=1; $i<=53; $i++)
      {
        $sql = "
        INSERT IGNORE INTO efx_week
        (`id`, `idKey`, anno, week)
        VALUES (NULL, $idKey, $y, $i);
        ";
        $m = $connection->createCommand($sql)->execute();
      }
      $y++;
      for ($i=1; $i<=53; $i++)
      {
        $sql = "
        INSERT IGNORE INTO efx_week
        (`id`, `idKey`, anno, week)
        VALUES (NULL, $idKey, $y, $i);
        ";
        $m = $connection->createCommand($sql)->execute();
      }

    }

}
