<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property string $lastUpdate
 * @property string $msg
 */
class Log extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lastUpdate'], 'safe'],
            [['msg'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lastUpdate' => 'Last Update',
            'msg' => 'Msg',
        ];
    }
}
