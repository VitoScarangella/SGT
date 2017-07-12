<?php

namespace backend\models;

use Yii;
use backend\models\Tool;
/**
 *
 * @property integer $id
 * @property integer $idAccount
 * @property string $name
 * @property string $descr
 * @property string $params
 */
class Sgt
{
    const  SYS_NULL_VALUE       = "4.9E-324";   //1.79E308;
    const  SYS_ERROR_VALUE      = "1.78E308";

    //NOTA iconClass deve terminare con la classe dell'icona (viene aggiunto un eventuale post-fisso)
    static $params = [
      'a'           => ['colw'=>[12,4,2,1], 'colors'=>'success',  'iconClass'=>'material-icons fa-2x iconGpio',    'class'=>'zgpio'     ],
      ];
    public static function objectParams($obj="")
    {
      return ($obj==""?self::$params:self::$params[$obj]);
    }


}
