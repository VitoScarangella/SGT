<?php

namespace common\models;

use Yii;
/**
 * This is the model class for table "efx_tree".
 *
 * @property integer $id
 * @property integer $idParent
 * @property integer $idObj
 * @property integer $idKey
 * @property integer $order
 * @property integer $level
 * @property string $name
 */
class EfxTree extends \kartik\tree\models\Tree
{
  public static $tableName     = 'efx_tbl_tree';// 'efx_tree';
  public static $tableNameTab  = 'efx_tbl_tree';// 'efx_tree';
  public static $tableNameView = 'efx_tbl_tree';// 'v_efx_tree';

  /**
   * @inheritdoc
   */
   /**
    * @inheritdoc
    */
   public static function tableName()
   {
       return EfxTree::$tableName;
   }

  /**
   * Essendo una view devo mettere questo metodo
   */
  public static function primaryKey()
  {
      return ['id'];
  }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
          [['idObj', 'idKey', 'idParent', 'removable', 'enabled' ], 'integer'],
          //  [['idObj', 'idKey', 'name'], 'required'],
          [['name'], 'string'],
          [['removable_all'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'id' => 'ID',

            'idParent' => 'Parent',

            'idObj' => 'Tipo',

            'idKey' => 'Key',

            'order' => 'Order',

            'level' => 'Level',

            'name' => 'Nome',
            'rowstyle' => 'rowstyle',
        ];
    }

    public static function findRoot()
    {
      $session = Yii::$app->session;
      $sessionKey = $session[Yii::$app->params['sessionKey']];
      $connection = \Yii::$app->db;
      $sql = "select root from efx_tbl_tree where lvl=0 and idObj=".Yii::$app->params['tree_root_id']." and idKey=".$sessionKey;
      $m = $connection->createCommand( $sql );
      $tree = $m->queryOne();

        return self::find()->where(['and',['idKey'=>$sessionKey,  'root'=>$tree["root"]] ])->addOrderBy('root, lft');
    }

    public static function deleteRoot()
    {
      $session = Yii::$app->session;
      $sessionKey = $session[Yii::$app->params['sessionKey']];
      $connection = \Yii::$app->db;
      $sql = "select root from efx_tbl_tree where lvl=0 and idObj=".Yii::$app->params['tree_root_id']." and idKey=".$sessionKey;
      $m = $connection->createCommand( $sql );
      $tree = $m->queryOne();
      $connection->createCommand( "delete from efx_tbl_tree where root='" . $tree["root"]."'" )->execute(); //where root=37 modificare di volta in volta
    }


/*
    public function save($runValidation = true, $attributeNames = NULL)
    {

        $ris = parent::save($runValidation, $attributeNames);

        return $ris;
    }*/

    public function delete()
    {

        parent::delete();
    }

/*
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            return true;
        } else {
            return false;
        }
    }*/



}
