<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SocietaForm extends Model
{
    public $nomeSocieta;


    public function rules()
    {
        return [
            [['nomeSocieta'], 'required']
        ];
    }
}
