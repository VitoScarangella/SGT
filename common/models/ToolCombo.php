<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "efx_tool_combo".
 *
 * @property integer $id
 * @property string $key_id
 * @property string $field_id
 * @property string $field_descr
 * @property string $field_table
 * @property string $type
 * @property string $note
 */
class ToolCombo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'efx_tool_combo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['field_descr', 'field_table'], 'string'],
            [['key_id', 'field_id', 'type', 'note'], 'string', 'max' => 50],
            [['key_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'id' => 'ID',

            'key_id' => 'Key ID',

            'field_id' => 'Field ID',

            'field_descr' => 'Field Descr',

            'field_table' => 'Field Table',

            'type' => 'Type',

            'note' => 'Note',
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
