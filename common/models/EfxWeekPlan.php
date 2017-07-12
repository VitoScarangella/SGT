<?php

namespace common\models;

use Yii;
use app\models\Tool;
/**
 * This is the model class for table "efx_week_plan".
 *
 */
class EfxWeekPlan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'efx_week_plan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idKey', 'anno', 'week'], 'integer'],
            [['anno'], 'required'],
            [[
              'lun_da1', 'lun_a1', 'lun_da2', 'lun_a2', 'lun_da3', 'lun_a3', 'lun_da4', 'lun_a4', 'lun_da5', 'lun_a5', 'lun_da6', 'lun_a6',
              'mar_da1', 'mar_a1', 'mar_da2', 'mar_a2', 'mar_da3', 'mar_a3', 'mar_da4', 'mar_a4', 'mar_da5', 'mar_a5', 'mar_da6', 'mar_a6',
              'mer_da1', 'mer_a1', 'mer_da2', 'mer_a2', 'mer_da3', 'mer_a3', 'mer_da4', 'mer_a4', 'mer_da5', 'mer_a5', 'mer_da6', 'mer_a6',
              'gio_da1', 'gio_a1', 'gio_da2', 'gio_a2', 'gio_da3', 'gio_a3', 'gio_da4', 'gio_a4', 'gio_da5', 'gio_a5', 'gio_da6', 'gio_a6',
              'ven_da1', 'ven_a1', 'ven_da2', 'ven_a2', 'ven_da3', 'ven_a3', 'ven_da4', 'ven_a4', 'ven_da5', 'ven_a5', 'ven_da6', 'ven_a6',
              'sab_da1', 'sab_a1', 'sab_da2', 'sab_a2', 'sab_da3', 'sab_a3', 'sab_da4', 'sab_a4', 'sab_da5', 'sab_a5', 'sab_da6', 'sab_a6',
              'dom_da1', 'dom_a1', 'dom_da2', 'dom_a2', 'dom_da3', 'dom_a3', 'dom_da4', 'dom_a4', 'dom_da5', 'dom_a5', 'dom_da6', 'dom_a6'
            ],
              'safe'],
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

            'lun_da1' => 'Lun Da1',

            'lun_a1' => 'Lun A1',

            'lun_da2' => 'Lun Da2',

            'lun_a2' => 'Lun A2',

            'lun_da3' => 'Lun Da3',

            'lun_a3' => 'Lun A3',

            'mar_da1' => 'Mar Da1',

            'mar_a1' => 'Mar A1',

            'mar_da2' => 'Mar Da2',

            'mar_a2' => 'Mar A2',

            'mar_da3' => 'Mar Da3',

            'mar_a3' => 'Mar A3',

            'mer_da1' => 'Mer Da1',

            'mer_a1' => 'Mer A1',

            'mer_da2' => 'Mer Da2',

            'mer_a2' => 'Mer A2',

            'mer_da3' => 'Mer Da3',

            'mer_a3' => 'Mer A3',

            'gio_da1' => 'Gio Da1',

            'gio_a1' => 'Gio A1',

            'gio_da2' => 'Gio Da2',

            'gio_a2' => 'Gio A2',

            'gio_da3' => 'Gio Da3',

            'gio_a3' => 'Gio A3',

            'ven_da1' => 'Ven Da1',

            'ven_a1' => 'Ven A1',

            'ven_da2' => 'Ven Da2',

            'ven_a2' => 'Ven A2',

            'ven_da3' => 'Ven Da3',

            'ven_a3' => 'Ven A3',

            'sab_da1' => 'Sab Da1',

            'sab_a1' => 'Sab A1',

            'sab_da2' => 'Sab Da2',

            'sab_a2' => 'Sab A2',

            'sab_da3' => 'Sab Da3',

            'sab_a3' => 'Sab A3',

            'dom_da1' => 'Dom Da1',

            'dom_a1' => 'Dom A1',

            'dom_da2' => 'Dom Da2',

            'dom_a2' => 'Dom A2',

            'dom_da3' => 'Dom Da3',

            'dom_a3' => 'Dom A3',
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
