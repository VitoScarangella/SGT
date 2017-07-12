<?php
namespace common\models;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use kartik\editable\Editable;
use kartik\icons\Icon;
use webvimark\modules\UserManagement\components\GhostHtml;
use kartik\grid\GridView;;
use common\models\ToolCombo;
use webvimark\modules\UserManagement\models\rbacDB\Role;
use webvimark\modules\UserManagement\models\User;
use yii\rbac\DbManager;
use kartik\widgets\Select2;
/**
 * Tool
 *
 */
class ToolBase extends ActiveRecord
{

  /////////////////////////////////////////////////////////////////////////
  // generateRandomString
  /////////////////////////////////////////////////////////////////////////
  public static function generateRandomString($length = 32) {
      $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $charactersLength = strlen($characters);
      $randomString = '';
      for ($i = 0; $i < $length; $i++) {
          $randomString .= $characters[rand(0, $charactersLength - 1)];
      }
      return $randomString;
  }

  /////////////////////////////////////////////////////////////////////////
  // parseCss
  // da utilizzare come tool
  /////////////////////////////////////////////////////////////////////////
  public static function parseCss($file){
      $css = file_get_contents($file);
      preg_match_all( '/(?ims)([a-z0-9\s\.\:#_\-@,]+)\{([^\}]*)\}/', $css, $arr);
      $result = array();
      foreach ($arr[0] as $i => $x){
          $selector = trim($arr[1][$i]);
          $rules = explode(';', trim($arr[2][$i]));
          $rules_arr = array();
          foreach ($rules as $strRule){
              if (!empty($strRule)){
                  $rule = explode(":", $strRule);
                  $rules_arr[trim($rule[0])] = trim($rule[1]);
              }
          }

          $selectors = explode(',', trim($selector));
          foreach ($selectors as $strSel){
              $result[$strSel] = $rules_arr;
          }
      }
      return $result;
  }


  /////////////////////////////////////////////////////////////////////////
  // XLSbuild
  /////////////////////////////////////////////////////////////////////////
  public static function XLSbuild($params=[]) {

      $default = [
        'sql'=>'select * from user',
        'labels'=>[],
        'titolo'=>"...",
        'header'=>"...",
        'formats'=>[],
        'formatters'=>[],
        'sum'=>[],
        'data'=>[],
      ];
      $p = \yii\helpers\ArrayHelper::merge($default,$params);


      $connection = Yii::$app->getDb();
      $command = $connection->createCommand($p["sql"]);
      $model = $command->queryAll();
      $dropdowns = [];
      foreach ($p["labels"] as $field=>$label) {
        $combo = ToolCombo::find()->andFilterWhere([
            'key_id' => $field])->one();
        if (!empty($combo))
        $dropdowns[$field] = self::dropdown($combo->field_table, $combo->field_id, $combo->field_descr);
      }

      $data = [];
      $titles = [];
      $count=0;
      foreach($model as $row)
      {
          $data_row = [];
          foreach($row as $k=>$t)
          {
              if (isset($dropdowns[$k])) {
                if (isset($dropdowns[$k][$t]))
                    $data_row[] = $dropdowns[$k][$t];
                else
                    $data_row[] = $t;
              }
              else {
                $data_row[] = $t;
              }
              if ($count==0) $titles[] = isset($p["labels"][$k])?$p["labels"][$k]:$k;
          }
          $count++;
          $data[] = $data_row;
      }

      $params["data"]=$data;

      self::XLSbuild_($params);
  }


  public static function XLSbuild_($params) {
    $default = [
      'data'=>[],
      'labels'=>[],
      'titolo'=>"...",
      'header'=>"...",
      'formats'=>[],
      'formatters'=>[],
      'sum'=>[],
    ];
    $p = \yii\helpers\ArrayHelper::merge($default,$params);

      $count = count($p["data"]);

      //$p["titolo"] = substr($p["titolo"],0,25);
      $file = \Yii::createObject([
      'class' => 'codemix\excelexport\ExcelFile',
      'sheets' => [
          // Array keys are used as Sheet names in the final excel file
          substr($p["titolo"],0,15) => [
              'data' => $p["data"],
              'titles' => $p["labels"],
              'formats' => $p["formats"],
              'formatters' => $p["formatters"],
              ],
          ]
      ]);

      $phpExcel = $file->getWorkbook();

      $highestColumnIndex = count($p["labels"]);
      $lastColumn = 'A';
      for($i=0;$i<$highestColumnIndex; $i++)  $lastColumn++;

      $phpExcel->getSheet(0)->getStyle('A1:'.$lastColumn.'1')->applyFromArray(
          array(
              'fill' => array(
                  'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                  'color' => array('rgb' => 'D8D8D8')
              ),
              'font'  => array(
                  'bold'  => true,
                  'color' => array('rgb' => '000000'),
                  //'size'  => 15,
                  //'name'  => 'Verdana'
              )
          )
      );

      $cellw = array(
              'width' => 300
          );

      $sheet = $phpExcel->getSheet(0);
      $highestRow = $count; //count($data)-1; //$sheet->getHighestRow();



      for ($column = 'A'; $column != $lastColumn; $column++) {
          $sheet->getColumnDimension($column)->setAutoSize(true);

          if (in_array($column, $p["sum"]))
          {
            $sheet->setCellValue(
                $column.($highestRow+2),
                "=SUM(" . $column . "2:" . $column .  ($highestRow+1) . ")"
                );

                if (isset($formats[$column]))
                  $sheet
                      ->getStyle($column.($highestRow+2).":".$column.($highestRow+2))
                      ->getNumberFormat()
                      ->setFormatCode(
                        $formats[$column]
                      );
          }



      }

        $phpExcel->getSheet(0)->getStyle('A'.($highestRow+2).':'.$lastColumn.''.($highestRow+2))->applyFromArray(
          array(
              'fill' => array(
                  'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                  'color' => array('rgb' => 'D8D8D8')
              ),
              'font'  => array(
                  'bold'  => true,
                  'color' => array('rgb' => '000000'),
                  //'size'  => 15,
                  //'name'  => 'Verdana'
              )
          )
      );


      ob_end_clean();
      header('Content-type: application/vnd.ms-excel');
      //$p["titolo"] = substr($p["titolo"],0,15);
      //header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
      header('Content-Disposition: attachment; filename="'.$p["titolo"] . '_' . Date('Ymd Hi').'.xlsx"');
      header("Cache-Control: max-age=0");
      $file->saveAs('php://output');

  }



  ////////////////////////////////////////////////////////////////////////
  // verifica se esiste un ruolo
  ////////////////////////////////////////////////////////////////////////
  public static function RBACexistRole($params=[])
  {
    $default = [
      'name'=>'',
    ];
    $p = \yii\helpers\ArrayHelper::merge($default,$params);

    $allRoles = Role::find()
      //  ->asArray()
      ->andWhere('name = :current_name', [':current_name'=>$p["name"]])
      //->andWhere('enabled = :en', [':en'=>1])
      ->all();
    return count($allRoles)>0?true:false;
  }

  ////////////////////////////////////////////////////////////////////////
  // aggiunge un ruolo
  //https://github.com/yiisoft/yii2/blob/master/docs/guide/security-authorization.md#building-authorization-data
  ////////////////////////////////////////////////////////////////////////
  public static function RBACaddRole($params=[])
  {
    $default = [
      'name'=>'',
      'description'=>'',
    ];
    $p = \yii\helpers\ArrayHelper::merge($default,$params);

    $model = new Role;
    $model->name = $p["name"];
    $model->description = $p["description"];
    $model->save();
  }




////////////////////////////////////////////////////////////////////////
// assegna un ruolo
////////////////////////////////////////////////////////////////////////
public static function RBAChaseRole($params=[])
{
  $default = [
    'name'=>'',
    'role'=>'',
    'idUser'=>'',
  ];
  $p = \yii\helpers\ArrayHelper::merge($default,$params);

  $modelUser = User::find()->select('id')->where(['=', 'username', $p["name"]])->one();


  $roles = Role::getUserRoles($modelUser["id"]);
  foreach ($roles as  $role) {
    if ($role->name==$p["role"]) return true;
  }
  return false;


}


  ////////////////////////////////////////////////////////////////////////
  // assegna un ruolo
  ////////////////////////////////////////////////////////////////////////
  public static function RBACassignRole($params=[])
  {
    $default = [
      'name'=>'',
      'role'=>'',
      'idUser'=>'',
    ];
    $p = \yii\helpers\ArrayHelper::merge($default,$params);

    $modelUser = User::find()->select('id')->where(['=', 'username', $p["name"]])->one();

    \webvimark\modules\UserManagement\models\User::assignRole($modelUser["id"], $p["role"]);

  }

  ////////////////////////////////////////////////////////////////////////
  // verifica se esiste un utente
  ////////////////////////////////////////////////////////////////////////
  public static function RBACexistUser($params=[])
  {
    $default = [
      'name'=>'',
    ];
    $p = \yii\helpers\ArrayHelper::merge($default,$params);

    $modelU = \webvimark\modules\UserManagement\models\User::findOne(['username' => $p["name"]]);
    if (empty($modelU)) return false;
    else return true;
  }

  ////////////////////////////////////////////////////////////////////////
  // aggiunge un utente
  ////////////////////////////////////////////////////////////////////////
  public static function RBACaddUser($params=[])
  {
    $default = [
      'name'=>'',
    ];
    $p = \yii\helpers\ArrayHelper::merge($default,$params);

    $model = new \webvimark\modules\UserManagement\models\User();
    $model->username = $p["user"];
    $model->setPassword($p["pwd"]);

    if (isset($p["id"]))
    {
      $model->id = $p["id"];
    }

    $model->save();

    return $model->id;
  }


  ////////////////////////////////////////////////////////////////////////
  // '..',[],\kartik\popover\PopoverX::ALIGN_LEFT,true
  ////////////////////////////////////////////////////////////////////////
  public static function XbuildEditableColumn($field, $params=[])
  {
    $default = [
      'action'=>'editinline',
      'refresh'=>false,
      'width'=>'80px',
      'valueIfNull'=>'..',
      'pluginEvents'=>[],
      'refresh'=>false, //default... verificare impatti
      'popalign'=>\kartik\popover\PopoverX::ALIGN_LEFT,
      'pageSummary'=>false,
      'asPopover'=>true,
      'format'=>'text' // Currency  ['decimal',2]  integer percent  size shortSize raw text ntext email url boolean
    ];
    $p = \yii\helpers\ArrayHelper::merge($default,$params);
    //$p["refresh"] = true; //Patch: il refresh fa sparire le altre righe

      if ($p["width"]!="" && !Tool::endsWith($p["width"], 'px')) $p["width"] = $p["width"] . "px";
      return
          [
          'class'=>'\kartik\grid\EditableColumn',
          'attribute'=>$field,
          'vAlign' => 'middle',
          'pageSummary'=>$p["pageSummary"],
          'contentOptions' => ['style' => 'width:'.$p["width"].';  min-width:'.$p["width"].';  '],
          'refreshGrid'=>$p["refresh"],
          'format' => $p["format"],
          'editableOptions'=>[
              'asPopover'=>$p["asPopover"],
              'placement' => $p["popalign"],
              'formOptions'=>['action' => [$p["action"]]], // point to the new action
              'valueIfNull' =>$p["valueIfNull"],
              'pluginEvents' => $p["pluginEvents"],
              'buttonsTemplate'=>"{submit}",
              ],
          ];

  }

  ////////////////////////////////////////////////////////////////////////
  // '..',[],\kartik\popover\PopoverX::ALIGN_LEFT,true
  ////////////////////////////////////////////////////////////////////////
  public static function XbuildEditableColumnComboInput($field, $params=[], $model)
  {
    $default = [
      'action'=>'editinline',
      'refresh'=>false,
      'width'=>'80px',
      'label1'=>'...',
      'label2'=>'...',
      'valueIfNull'=>'..',
      'pluginEvents'=>[],
      'refresh'=>false, //default... verificare impatti
      'popalign'=>\kartik\popover\PopoverX::ALIGN_LEFT,
      'pageSummary'=>false,
      'asPopover'=>true,
      'format'=>'text' // Currency  ['decimal',2]  integer percent  size shortSize raw text ntext email url boolean
    ];
    $p = \yii\helpers\ArrayHelper::merge($default,$params);
    //$p["refresh"] = true; //Patch: il refresh fa sparire le altre righe

      if ($p["width"]!="" && !Tool::endsWith($p["width"], 'px')) $p["width"] = $p["width"] . "px";
      return
          [
          'class'=>'\kartik\grid\EditableColumn',
          'attribute'=>$field,
          'vAlign' => 'middle',
          'pageSummary'=>$p["pageSummary"],
          'contentOptions' => ['style' => 'width:'.$p["width"].';  min-width:'.$p["width"].';  '],
          'refreshGrid'=>$p["refresh"],
          'format' => $p["format"],
          'editableOptions'=> function ($model, $key, $index) use($p)  {
              return [
              'asPopover'=>$p["asPopover"],
              'placement' => $p["popalign"],
              'formOptions'=>['action' => [$p["action"]]], // point to the new action
              'valueIfNull' =>$p["valueIfNull"],
              'pluginEvents' => $p["pluginEvents"],
              'buttonsTemplate'=>"{submit}",
              'beforeInput'=> function ($form, $widget) use ($model, $index, $p) {
                return
                "<label>".$p["label1"]."</label>"
                . Select2::widget([
                    'name' => 'descr',
                    'options'=>['id'=>"descr-{$index}",    ],
                    'data'=>$p["data"],
                    'pluginEvents' => [
                      "change" => "function() {
                        destname='".Html::getInputId($model, '['.$index.']descrizione')."';
                        $('#'+destname).val(this.value);
                        }
                        ",
                    ]
                    ])
                . "<br><label>".$p["label2"]."</label>";
                  }
            ]; }
          //
          ];

  }



  public static function XbuildEditableColumnDate($field, $params=[])
  {
    $default = [
      'action'=>'editinline',
      'refresh'=>false,
      'width'=>'190px',
      'valueIfNull'=>'..',
      'pluginEvents'=>[],
      'popalign'=>\kartik\popover\PopoverX::ALIGN_LEFT,
      'asPopover'=>true,
      'format'=>\Yii::$app->params["dateFormatLanguage"][\Yii::$app->language],
      'formatLink'=>\Yii::$app->params["dateFormatDisplayLanguage"][\Yii::$app->language]
    ];
    $p = \yii\helpers\ArrayHelper::merge($default,$params);
    $p["refresh"] = false; //Patch: il refresh fa sparire le altre righe

    if ($p["width"]!="" && !Tool::endsWith($p["width"], 'px')) $p["width"] = $p["width"] . "px";

      return
          [
              'class' => 'kartik\grid\EditableColumn',
              'attribute'=>$field,
              'contentOptions' => ['style' => 'width:'.$p["width"].';  min-width:'.$p["width"].';  '],
              'vAlign' => 'middle',
              'format' => ['date', $p["format"]], //Formato del LINK
              'refreshGrid'=>$p["refresh"],
              'filterType' => GridView::FILTER_DATE,
              'filterWidgetOptions' => [
                  'pluginOptions'=>[
                    'format' =>  $p["formatLink"], //formato della data selezionata
                    'saveFormat' => 'php:Y-m-d', //Formato salvataggio
                    'convertFormat' => true,
                    'autoWidget' => true,
                    'autoclose' => true,
                    'todayBtn' => true,
                  ],
                  'options' => ['id'=>'idp_'.$field, 'placeholder'=>' ', ],
                ],

              'editableOptions' => [
                  'asPopover'=> $p["asPopover"],
                  'placement' => $p["popalign"],
                  'inputType'=> \kartik\editable\Editable::INPUT_WIDGET,
                  'widgetClass'=> 'kartik\datecontrol\DateControl',
                  'formOptions'=>['action' => [$p["action"]]],
                  'pluginEvents' => $p["pluginEvents"],
                  'buttonsTemplate'=> "{submit}",
                  'valueIfNull'=> $p["valueIfNull"],
                  'options'=>[
                      'type'=>\kartik\datecontrol\DateControl::FORMAT_DATE,
                      'displayFormat' => $p["format"], //Formato dopo apertura popup
                      'saveFormat' => 'php:Y-m-d', //Formato salvataggio
                      'options' => [
                          'convertFormat' => true,
                          'pluginOptions' => [
                              'type'=>\kartik\datecontrol\Module::FORMAT_DATE,
                              'ajaxConversion' => false,
                              //'widgetClass' => 'yii\widgets\MaskedInput',
                              'autoWidget' => true,
                              'autoclose' => true,
                              'todayBtn' => true,
                              'displayFormat' =>$p["format"], //Formato dopo selezione data
                              'saveFormat' => 'php:Y-m-d', //Formato salvataggio
                          ]
                      ]
                  ]
              ],
          ];
  }

  public static function XbuildColumnDatetime($field,$params=[])
  {
    $default = [
      'width'=>'90px',
      'pluginEvents'=>[],
      'format'=>\Yii::$app->params["dateFormatLanguage"][\Yii::$app->language],
      'formatLink'=>\Yii::$app->params["dateFormatDisplayLanguage"][\Yii::$app->language]
    ];
    $p = \yii\helpers\ArrayHelper::merge($default,$params);
  if ($p["format"]=='') $p["format"] = (isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A';
  return [
    'attribute'=>$field,
    'format'=>['datetime',$p["format"]],
    'vAlign' => 'middle',
    'width' => '110px',
  ];
  }


  public static function XbuildColumnDate($field, $params=[])
  {
    $default = [
      'width'=>'90px',
      'pluginEvents'=>[],
      'format'=>\Yii::$app->params["dateFormatLanguage"][\Yii::$app->language],
      'formatLink'=>\Yii::$app->params["dateFormatDisplayLanguage"][\Yii::$app->language]
    ];
    $p = \yii\helpers\ArrayHelper::merge($default,$params);

  return [
    'attribute'=>$field,
    'format'=>['date',$p["format"]],
    'vAlign' => 'middle',
    'width' => $p["width"],
    'filterType' => GridView::FILTER_DATE,
    'filterWidgetOptions' => [
        'pluginOptions'=>[
          'format' =>  $p["formatLink"], //formato della data selezionata
          'saveFormat' => 'php:Y-m-d', //Formato salvataggio
          'convertFormat' => true,
          'autoWidget' => true,
          'autoclose' => true,
          'todayBtn' => true,
        ],
        'options' => ['id'=>'idp_'.$field, 'placeholder'=>' ', ],
      ],
  ];
  }

  public static function XbuildColumnTime($field, $params=[])
  {
    $default = [
      'width'=>'60px',
      'pluginEvents'=>[],
      'format'=>'php:h:i:s',
      'formatLink'=>'php:h:i:s'
    ];
    $p = \yii\helpers\ArrayHelper::merge($default,$params);

  return [
    'attribute'=>$field,
    'format'=>['time',$p["format"]],
    'vAlign' => 'middle',
    'width' => $p["width"],
    'filterType' => GridView::FILTER_TIME,
    'filterWidgetOptions' => [
        'pluginOptions'=>[
          'format' =>  $p["formatLink"], //formato della data selezionata
          'saveFormat' => 'php:h:i:s', //Formato salvataggio
          'convertFormat' => true,
          'autoWidget' => true,
          'autoclose' => true,
          'todayBtn' => true,
        ],
        'options' => ['id'=>'idp_'.$field, 'placeholder'=>' ', ],
      ],
  ];
  }


  public static function XbuildSerialColumn($params=[])
  {
    $default = [
      'width'=>'30px',
      'class'=>'kartik\grid\SerialColumn',
    ];
    $p = \yii\helpers\ArrayHelper::merge($default,$params);

  return [
    'class' => $p["class"],
    'width' => $p["width"],
  ];
  }

  public static function XbuildColumn($field, $params=[])
  {
    $default = [
      'width'=>'auto',
      'pluginEvents'=>[],
      'format'=>'text',
      'hAlign'=>'left',
      'vAlign' => 'middle',
      'pageSummary'=>false,
      'footer'=>false, //Tool::pageTotal($provider->models,'saldo_in'),
    ];
    $p = \yii\helpers\ArrayHelper::merge($default,$params);

  return [
    'attribute'=>$field,
    'format'=>$p["format"],
    'vAlign' => $p["vAlign"],
    'hAlign' => $p["hAlign"],
    'width' => $p["width"],
    'pageSummary' => $p["pageSummary"],
    'footer'=> $p["footer"],
  ];
  }

  public static function XbuildColumnCurrency($field, $params=[])
  {
    $default = [
      'width'=>'90px',
      'pluginEvents'=>[],
      'format'=>'Currency',
      'hAlign'=>'right',
      'pageSummary'=>true,
      'footer'=>false, //Tool::pageTotal($provider->models,'saldo_in'),
    ];
    $p = \yii\helpers\ArrayHelper::merge($default,$params);

  return [
    'attribute'=>$field,
    'format'=>$p["format"],
    'vAlign' => 'middle',
    'hAlign' => $p["hAlign"],
    'width' => $p["width"],
    'pageSummary' => $p["pageSummary"],
    'footer'=> $p["footer"],
  ];
  }


  public static function XbuildEditableColumnTextArea($field, $params=[])
  {
    $default = [
      'action'=>'editinline',
      'data'=>[],
      'filter'=>[],
      'refresh'=>true,
      'width'=>'200px',
      'valueIfNull'=>'..',
      'pluginEvents'=>[],
      'popalign'=>\kartik\popover\PopoverX::ALIGN_LEFT,
      'asPopover'=>true,
    ];
    $p = \yii\helpers\ArrayHelper::merge($default,$params);
    if ($p["width"]!="" && !Tool::endsWith($p["width"], 'px')) $p["width"] = $p["width"] . "px";

      return
          [
              'class' => 'kartik\grid\EditableColumn',
              'attribute'=>$field,
              'contentOptions' => ['style' => 'width:'.$p["width"].';  min-width:'.$p["width"].';  '],
              'vAlign' => 'middle',
              'refreshGrid'=>$p["refresh"],
              'editableOptions' => [
                  'asPopover'=>$p["asPopover"],
                  'placement' => $p["popalign"],
                  'format'=> \kartik\editable\Editable::FORMAT_LINK,
                  'submitOnEnter' => false,
                  //'size'=>'lg',
                  'options' => ['class'=>'form-control', 'rows'=>5, 'placeholder'=>'...'],
                  'inputType'=>\kartik\editable\Editable::INPUT_TEXTAREA,
                  'formOptions'=>['action' => [$p["action"]]],
                  'pluginEvents' => $p["pluginEvents"],
                  'buttonsTemplate'=>"{submit}",
              ],
          ];
  }


  public static function XbuildColumnCombo($field,$params=[])
  {
    $default = [
      'data'=>[],
      'filter'=>[],
      'refresh'=>true,
      'width'=>'120px',
      'valueIfNull'=>'..',
      'pluginEvents'=>[],
      'pageSummary'=>false,
    ];
    $p = \yii\helpers\ArrayHelper::merge($default,$params);
    if ($p["width"]!="" && !Tool::endsWith($p["width"], 'px')) $p["width"] = $p["width"] . "px";
      if ($p["filter"]==[]) $p["filter"]=$p["data"];
      $data = $p["data"];
      return
          [
          'attribute'=>$field,
          'vAlign'=>'middle',
          'value'=>function ($model, $key, $index, $widget) use ($field, $data) {
              $f = isset($model->$field) ? $model->$field : $model[$field];
              if (isset($f) && isset( $data[$f]))
                return $data[$f];
              else {
                return "";
              }
              },
          'filterType'=>GridView::FILTER_SELECT2,
          'filter'=>$p["data"],
          'filterWidgetOptions'=>[
              'pluginOptions'=>['allowClear'=>true,//necessita combo con prima riga vuota
              'placeholder'=>['id'=>'idp_'.$field, 'placeholder'=>'']
              ],
          ],
          'filterInputOptions'=>['placeholder'=>$p["valueIfNull"]],
          'format'=>'raw',
          'pageSummary' => $p["pageSummary"],
          'width' => $p["width"],
          ];
  }

  public static function XbuildEditableColumnCombo($field, $params=[])
  {
      $default = [
        'action'=>'editinline',
        'data'=>[],
        'filter'=>[],
        'refresh'=>true,
        'width'=>'200px',
        'valueIfNull'=>'..',
        'pluginEvents'=>[],
        'popalign'=>\kartik\popover\PopoverX::ALIGN_LEFT,
        'asPopover'=>true,
        'header'=>'',
      ];
      $p = \yii\helpers\ArrayHelper::merge($default,$params);
      //$p["refresh"] = false; //Patch: il refresh fa sparire le altre righe

      if ($p["width"]!="" && !Tool::endsWith($p["width"], 'px')) $p["width"] = $p["width"] . "px";
      if ($p["filter"]===[]) $p["filter"]=$p["data"];

      return
          [
              'class'=>'\kartik\grid\EditableColumn',
              'attribute'=>$field,

              'contentOptions' => [],
              'vAlign'=>'middle',
              'refreshGrid'=>$p["refresh"],
              'filterType'=>GridView::FILTER_SELECT2,
              'filter'=>$p["filter"],
              'filterWidgetOptions'=>[
                  'pluginOptions'=>[
                    'allowClear'=>true,
                  ],
                  'options' => ['id'=>'idp_'.$field, 'placeholder'=>' ', 'style' => 'width:'.$p["width"].';  min-width:'.$p["width"].'; '],
                ],
              'format'=>'raw',
              'width' => $p["width"],

              'editableOptions'=>[
                  'asPopover'=> $p["asPopover"],
                  'placement' => $p["popalign"],
                  'formOptions'=>['action' => [$p["action"]]], // point to the new action
                  'valueIfNull' =>$p["valueIfNull"],
                  'format' => Editable::FORMAT_LINK, //Editable::FORMAT_BUTTON,
                  'inputType' => Editable::INPUT_DROPDOWN_LIST,
                  'data'=> $p["data"],
                  'displayValueConfig' => $p["data"],
                  'buttonsTemplate' => "{submit}",
                  'pluginEvents' => $p["pluginEvents"]
                  ],
          ];
  }




  public static function XbuildColumnRaw($field, $params=[])
  {
      $default = [
        'filter'=>[],
        'refresh'=>true,
        'width'=>'200px',
        'valueIfNull'=>'..',
        'pluginEvents'=>[],
        'pageSummary'=>false,
        'value'=>function ($model, $key, $index, $widget) { return "???";} ,
      ];
      $p = \yii\helpers\ArrayHelper::merge($default,$params);
      //$p["refresh"] = false; //Patch: il refresh fa sparire le altre righe

      if ($p["width"]!="" && !Tool::endsWith($p["width"], 'px')) $p["width"] = $p["width"] . "px";
      return
      [
          'class'=>'\kartik\grid\DataColumn',
          'attribute'=>$field,
          'vAlign'=>'middle',
          'value'=>$p["value"],
          'format'=>'raw',
      		'filterType'=>GridView::FILTER_SELECT2,
      		'filter'=>$p["filter"],
      		'filterWidgetOptions'=>[
  			       'pluginOptions'=>['allowClear'=>true],
  		    ],
  		    'filterInputOptions'=>['placeholder'=>'...'],
  		    'format'=>'raw',
          'width' => $p["width"],
          'pageSummary' => $p["pageSummary"],
      ];


    }





  public static function toMySqlDate($date, $format="Y-m-d") {
    if (!$date || trim($date)=="") return trim($date);
    $d = \DateTime::createFromFormat(str_replace('php:','',\Yii::$app->params["dateFormatLanguage"][\Yii::$app->language]), $date);
    return \Yii::$app->formatter->asDate( $d, 'php:' . $format);
  }

  public static function pageTotal($provider, $fieldName)
  {
      $total=0;
      foreach($provider as $item){
          $total+=$item[$fieldName];
      }
      return $total+555;
  }


}
