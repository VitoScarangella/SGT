<?php

namespace common\models;

use Yii;
use backend\models\Tool;
/**
 * This is the model class for table "todo".
 *
 * @property integer $id
 * @property string $note
 * @property string $note2
 * @property string $stato
 * @property string $priorita
 */
class Todo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'todo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['note', 'note2'], 'string'],
            [['stato', 'priorita'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'id' => 'ID',

            'note' => 'Ambito',

            'note2' => 'Descrizione',

            'stato' => 'Stato',

            'priorita' => 'Priorita',
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
