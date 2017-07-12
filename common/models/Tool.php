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
/**
 * Tool
 *
 */
class Tool extends ToolBase
{
    const SUPERADMIN = "superadmin";
    const SWAPUSER = "swapuser";

    public static  $CURRENCY = "#,##0.00_-";
    public static  $CURRENCY_EUR = "[\$EUR ]#,##0.00_-";
    public static  $CURRENCY_USD = "[\$USD ]#,##0.00_-";
    public static  $CURRENCY_GBP = "#,##0.00_-";

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '';
    }


    public static function onBeforeSave($model, $insert)
    {
      if ($insert && isset($model->created)) $model->created = date('Y-m-d H:i:s');
      if (isset($model->lastUpdate)) $model->lastUpdate = date('Y-m-d H:i:s');
    }


    public static function print_r($result)
    {
      print "<pre>";
      print_r($result);
      print "</pre>";
      self::logd($result);
    }

    public static function getDatesOfQuarter($quarter = 'current', $year = null, $format = null)
    {
        if ( !is_int($year) ) {
           $year = (new DateTime)->format('Y');
        }
        $current_quarter = ceil((new DateTime)->format('n') / 3);
        switch (  strtolower($quarter) ) {
        case 'this':
        case 'current':
           $quarter = ceil((new DateTime)->format('n') / 3);
           break;

        case 'previous':
           $year = (new DateTime)->format('Y');
           if ($current_quarter == 1) {
              $quarter = 4;
              $year--;
            } else {
              $quarter =  $current_quarter - 1;
            }
            break;

        case 'first':
            $quarter = 1;
            break;

        case 'last':
            $quarter = 4;
            break;

        default:
            $quarter = (!is_int($quarter) || $quarter < 1 || $quarter > 4) ? $current_quarter : $quarter;
            break;
        }
        if ( $quarter === 'this' ) {
            $quarter = ceil((new DateTime)->format('n') / 3);
        }
        $start = new DateTime($year.'-'.(3*$quarter-2).'-1 00:00:00');
        $end = new DateTime($year.'-'.(3*$quarter).'-'.($quarter == 1 || $quarter == 4 ? 31 : 30) .' 23:59:59');

        return array(
            'start' => $format ? $start->format($format) : $start,
            'end' => $format ? $end->format($format) : $end,
        );
    }

    public static function getUserInfo($idUtente) {
      $s="";
      return $s;
    }

    public static function getCurrencyFormat($cur="")
    {
      if ($cur=="EUR") return self::$CURRENCY_EUR;
      if ($cur=="USD") return self::$CURRENCY_USD;
      return self::$CURRENCY;
    }

    public static function colors()
    {
      return [
        "#00ffff",
         "#f0ffff",
         "#f5f5dc",
         "#000000",
         "#0000ff",
         "#a52a2a",
         "#00ffff",
         "#00008b",
         "#008b8b",
         "#a9a9a9",
         "#006400",
         "#bdb76b",
         "#8b008b",
         "#556b2f",
         "#ff8c00",
         "#9932cc",
         "#8b0000",
         "#e9967a",
         "#9400d3",
         "#ff00ff",
         "#ffd700",
         "#008000",
         "#4b0082",
         "#f0e68c",
         "#add8e6",
         "#e0ffff",
         "#90ee90",
         "#d3d3d3",
         "#ffb6c1",
         "#ffffe0",
         "#00ff00",
         "#ff00ff",
         "#800000",
         "#000080",
         "#808000",
         "#ffa500",
         "#ffc0cb",
         "#800080",
         "#800080",
         "#ff0000",
         "#c0c0c0",
         "#ffffff",
         "#ffff00"
      ];
    }

    public static function colorsName()
    {
      return [
        "aqua",
        "azure",
        "beige",
        "black",
        "blue",
        "brown",
        "cyan",
        "darkblue",
        "darkcyan",
        "darkgrey",
        "darkgreen",
        "darkkhaki",
        "darkmagenta",
        "darkolivegreen",
        "darkorange",
        "darkorchid",
        "darkred",
        "darksalmon",
        "darkviolet",
        "fuchsia",
        "gold",
        "green",
        "indigo",
        "khaki",
        "lightblue",
        "lightgreen",
        "lightcyan",
        "lightgrey",
        "lightpink",
        "lightyellow",
        "lime",
        "magenta",
        "maroon",
        "navy",
        "olive",
        "orange",
        "purple",
        "pink",
        "violet",
        "red",
        "silver",
        "white",
        "yellow"
      ];
    }

    public static function hasRole($role, $roles=[])
    {
      $session = Yii::$app->session;
      $userRoles = [];

      if (count($roles)>0)
        $userRoles = $roles;
      else if (isset($session['roles']))
        $userRoles = $session['roles'];

      if ($role==self::SUPERADMIN && isset(\Yii::$app->user->identity))
        {
          $user = \Yii::$app->user->identity;
          $connection = \Yii::$app->db;
          $model = $connection->createCommand("SELECT superadmin FROM user where id=" . $user->id);
        	$u = $model->queryOne();
          $superadmin = $u['superadmin'];
          if ($superadmin==1)
            return true;
          else
            return false;
        }

      if (count($userRoles)==0) return false;
      foreach ($userRoles as $k => $value) {
        if ( strtolower($value["description"]) == strtolower($role) ){
          return true;
          break;
        }
      }
      return false;
    }

    public static function buildEditableColumnTextArea(
      $field,
      $action,
      $refresh=false,
      $width='',
      $pluginEvents=[],
      $valueIfNull='..',
      $asPopover=true,
      $popalign=\kartik\popover\PopoverX::ALIGN_LEFT)
    {
        if ($width!="" && !Tool::endsWith($width, 'px')) $width = $width . "px";
        return
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute'=>$field,
                'contentOptions' => ['style' => 'width:'.$width.';  min-width:'.$width.';  '],
                'vAlign' => 'middle',
                //'headerOptions' => ['class' => 'kv-sticky-column'],
                //'contentOptions' => ['class' => 'kv-sticky-column'],
                'refreshGrid'=>$refresh,
                'editableOptions' => [
                    'asPopover'=>$asPopover,
                    'placement' => $popalign,
                    'format'=> \kartik\editable\Editable::FORMAT_LINK,
                    'submitOnEnter' => false,
                    //'size'=>'lg',
                    'options' => ['class'=>'form-control', 'rows'=>5, 'placeholder'=>'...'],
                    'inputType'=>\kartik\editable\Editable::INPUT_TEXTAREA,
                    'formOptions'=>['action' => [$action]],
                    'pluginEvents' => $pluginEvents,
                    'buttonsTemplate'=>"{submit}",
                ],
            ];
    }

    public static function buildColumnDate($field,$format='')
    {
    if ($format=='') $format = (isset(Yii::$app->modules['datecontrol']['displaySettings']['date'])) ? Yii::$app->modules['datecontrol']['displaySettings']['date'] : 'd-m-Y';

    return [
      'attribute'=>$field,
      'format'=>['date',$format],
      'vAlign' => 'middle',
      'width' => '90px',
      'filterType' => GridView::FILTER_DATE,
      'filterWidgetOptions' => [
      'pluginOptions'=>[
      'format' => 'yyyy-mm-dd',
      'autoWidget' => true,
      'autoclose' => true,
      'todayBtn' => true,
      ],],
    ];
    }

    public static function buildColumnTime($field,$format='')
    {
    if ($format=='') $format = (isset(Yii::$app->modules['datecontrol']['displaySettings']['time'])) ? Yii::$app->modules['datecontrol']['displaySettings']['time'] : 'H:i:s A';
    return [
      'attribute'=>$field,
      'format'=>['time',$format],
      'vAlign' => 'middle',
      'width' => '80px',
    ];
    }

    public static function buildColumnDatetime($field,$format='')
    {
    if ($format=='') $format = (isset(Yii::$app->modules['datecontrol']['displaySettings']['datetime'])) ? Yii::$app->modules['datecontrol']['displaySettings']['datetime'] : 'd-m-Y H:i:s A';
    return [
      'attribute'=>$field,
      'format'=>['datetime',$format],
      'vAlign' => 'middle',
      'width' => '110px',
    ];
    }

    public static function buildEditableColumnDateNoPop($field, $action, $refresh=false,
    $width='200px',
    $pluginEvents=[],
    $valueIfNull='..',
    $asPopover=true,
    $popalign=\kartik\popover\PopoverX::ALIGN_LEFT,
    $format='php:Y-m-d')
  {
    if ($width!="" && !Tool::endsWith($width, 'px')) $width = $width . "px";
    return
        [
        'class'=>'\kartik\grid\EditableColumn',
        'attribute'=>$field,
        'vAlign' => 'middle',
        'refreshGrid'=>$refresh,
        'contentOptions' => ['style' => 'width:'.$width.';  min-width:'.$width.';  '],
        'editableOptions'=>[
          'options' => ['style' => 'color:darkblue !important;',

          'onkeyup '=>"
              var date = this.value;
              if (this.value.length>10) this.value=this.value.substring(0,10);
              date = date.replace(/[-]/ig,'');

              //Verifico correttezza anno
              if (date.length>=4)
              {
                y = date.substring(0,4);
                if (y<1900) date='1900'+date.substring(4);
                if (y>2017) date='2017'+date.substring(4);
              }
              if (date.length>=6)
              {
                y = date.substring(0,4);
                m = date.substring(4,6);
                if (m>12) date = y + '12' + date.substring(6);
                if (m<1)  date = y + '01' + date.substring(6);
              }
              if (date.length>=7)
              {
                y = date.substring(0,4);
                m = date.substring(4,6);
                d = date.substring(6);

                //Anno bisestile
                gfeb=28;
                if ((y % 4) == 0) gfeb=29;
                if ((y % 100) == 0 && (y % 400) != 0) gfeb=28;

                if (m<1)  date = y + m + '01';
                if (m=='11'||m=='04'||m=='06'||m=='09')
                   {if (d>30) date = y + m + '30';}
                else if (m=='02')
                      {if (d>29) date = y + m + gfeb;}
                else
                      {if (d>31) date = y + m + '31';}
              }
              if (date.length>6)
                this.value = date.substring(0,4) + '-' + date.substring(4,6) + '-' + date.substring(6,8);
              else if (date.length>4)
                  this.value = date.substring(0,4) + '-' + date.substring(4,6);
          ",

          'onkeydown '=>"
              var k = event.which;
              if (k==46) return true; //delete
              if (k==220) return true; //back slash
              if (k==8) return true; //back slash
              if (  (k < 48 || k > 57)
                    &&
                    (k < 96 || k > 105)
                    &&
                    (k < 37 || k > 40)
                 ) {
                  event.preventDefault();
                  return false;
              }
              return true;
          "
            ],
            'asPopover'=>true,
            'placement' => $popalign,
            'formOptions'=>['action' => [$action]], // point to the new action
            'valueIfNull' =>$valueIfNull,
            'pluginEvents' => [],//["editableBeforeSubmit"=>"function(event, jqXHR) { alert('Before submit triggered'); }",],
            'buttonsTemplate'=>"{submit}",
            'header' => 'YYYY-MM-DD',
            ],
        ];
      }

    public static function buildEditableColumnDate(
          $field,
          $action,
          $refresh=false,
          $width='200px',
          $pluginEvents=[],
          $valueIfNull='..',
          $asPopover=true,
          $popalign=\kartik\popover\PopoverX::ALIGN_LEFT,
          $format='php:Y-m-d')
    {

        if ($width!="" && !Tool::endsWith($width, 'px')) $width = $width . "px";
        return
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute'=>$field,
                'contentOptions' => ['style' => 'width:'.$width.';  min-width:'.$width.';  '],
                'vAlign' => 'middle',
                'format' => ['date', $format], //Formato del LINK
               // 'headerOptions' => ['class' => 'kv-sticky-column'],
               // 'contentOptions' => ['class' => 'kv-sticky-column'],
                'refreshGrid'=>$refresh,
                'filterType' => GridView::FILTER_DATE,
                'filterWidgetOptions' => [
                    'pluginOptions'=>[
                    'format' => 'd/m/yyyy',
                    'autoWidget' => true,
                    'autoclose' => true,
                    'todayBtn' => true,
                    ],
                  ],
                'editableOptions' => [
                    'asPopover'=>$asPopover,
                    'placement' => $popalign,
                    'size' => 'md',
                    'inputType'=>\kartik\editable\Editable::INPUT_WIDGET,
                    'widgetClass'=> 'kartik\datecontrol\DateControl',
                    'formOptions'=>['action' => [$action]],
                    'pluginEvents' => $pluginEvents,
                    'buttonsTemplate'=>"{submit}",
                    'valueIfNull'=>$valueIfNull,
                    'options'=>[
                        'type'=>\kartik\datecontrol\DateControl::FORMAT_DATE,
                        'displayFormat' => $format, //Formato dopo apertura popup
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
                                'format' =>$format, //Formato dopo selezione data
                                'saveFormat' => 'php:Y-m-d', //Formato salvataggio
                            ]
                        ]
                    ]
                ],
            ];
    }





    ////////////////////////////////////////////////////////////////////////
    // '..',[],\kartik\popover\PopoverX::ALIGN_LEFT,true
    ////////////////////////////////////////////////////////////////////////
    public static function buildEditableColumn($field,
      $action,
      $refresh=false,
      $width='',
      $valueIfNull='..',
      $pluginEvents=[],
      $popalign=\kartik\popover\PopoverX::ALIGN_LEFT,
      $pageSummary=false,
      $asPopover=true)
    {
        if ($width!="" && !Tool::endsWith($width, 'px')) $width = $width . "px";
        return
            [
            'class'=>'\kartik\grid\EditableColumn',
            'attribute'=>$field,
            'vAlign' => 'middle',
            'pageSummary'=>$pageSummary,
            'contentOptions' => ['style' => 'width:'.$width.';  min-width:'.$width.';  '],
            'refreshGrid'=>$refresh,
            'editableOptions'=>[
                'asPopover'=>$asPopover,
                'placement' => $popalign,
                'formOptions'=>['action' => [$action]], // point to the new action
                'valueIfNull' =>$valueIfNull,
                'pluginEvents' => $pluginEvents,
                'buttonsTemplate'=>"{submit}",
                ],
            ];

    }

    public static function buildColumnCombo($field, $data, $width='120px', $valueIfNull='..', $filter=[])
    {
        if ($width!="" && !Tool::endsWith($width, 'px')) $width = $width . "px";
        if ($filter==[]) $filter=$data;
        return
            [
            'attribute'=>$field,
            'vAlign'=>'middle',
            'value'=>function ($model, $key, $index, $widget) use ($field, $data) {
                if (isset($model->$field) && isset( $data[$model->$field]))
                  return $data[$model->$field];
                else {
                  return "";
                }
                },
            'filterType'=>GridView::FILTER_SELECT2,
            'filter'=>$data,
            'filterWidgetOptions'=>[
                'pluginOptions'=>['allowClear'=>true,//necessita combo con prima riga vuota
                'placeholder'=>['id'=>'idp_'.$field, 'placeholder'=>'']
                ],
            ],
            'filterInputOptions'=>['placeholder'=>$valueIfNull],
            'format'=>'raw',
            'width' => $width,
            ];
    }

    public static function buildEditableColumnCombo($field, $action, $data, $refresh=true,
        $width='180px', $valueIfNull='..', $filter=[], $pluginEvents=[], $popalign=\kartik\popover\PopoverX::ALIGN_LEFT)
    {
        if ($width!="" && !Tool::endsWith($width, 'px')) $width = $width . "px";
        if ($filter===[]) $filter=$data;
        return
            [
                'class'=>'\kartik\grid\EditableColumn',
                'attribute'=>$field,
                'vAlign'=>'middle',
                //'contentOptions' => ['style' => 'width:'.$width.';  min-width:'.$width.';  '],
                'refreshGrid'=>$refresh,
                'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>$filter,
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true,//necessita combo con prima riga vuota
                    'placeholder'=>['id'=>'idp_'.$field, 'placeholder'=>'']
                    ],
                ],
                'format'=>'raw',
                'width' => $width,
                'editableOptions'=>[
                    'asPopover'=>true,
                    'placement' => $popalign,
                    'formOptions'=>['action' => [$action]], // point to the new action
                    'valueIfNull' =>$valueIfNull,
                    'format' => Editable::FORMAT_LINK, //Editable::FORMAT_BUTTON,
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'data'=> $data,
                    'displayValueConfig' => $data,
                    'buttonsTemplate'=>"{submit}",
                    'pluginEvents' => $pluginEvents,
                    ],
            ];
    }

    public static function buildEditableColumnColor(
        $field,
        $action,
        $data,
        $dataColor,
        $refresh=false,
        $width='',
        $pluginEvents=[],
        $valueIfNull='..',
        $contentOptions=[],
        $asPopover=true,
        $popalign=\kartik\popover\PopoverX::ALIGN_LEFT)
    {

        if ($width!="" && !Tool::endsWith($width, 'px')) $width = $width . "px";
        return
            [
                'class'=>'\kartik\grid\EditableColumn',
                'attribute'=>$field,
                'contentOptions' => ['style' => 'width:'.$width.';  min-width:'.$width.';  '],
                'refreshGrid'=>$refresh,
                    //'header'=>'<span class="glyphicon glyphicon-book" title="Gestisce Booking"></span>',
                'editableOptions'=>[
                    'asPopover'=>$asPopover,
                    'placement' => $popalign,
                    'formOptions'=>['action' => [$action]], // point to the new action
                    'valueIfNull' =>$valueIfNull,
                    'format' => Editable::FORMAT_LINK,  //FORMAT_BUTTON
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'data'=> $data,
                    'displayValueConfig' => $dataColor,
                    'pluginEvents' => $pluginEvents,
                    'buttonsTemplate'=>"{submit}",
                    ],
                    'contentOptions' => $contentOptions ,
                'format'=>'raw',

            ];



    }


    public static function buildButton($text, $tooltip, $class, $onclick="")
    {
        return Html::button($text,
           ['type'=>'button',
            'title'=>Yii::t('app', $tooltip),
            'class'=>$class,
            'onclick'=>$onclick]) ;
    }

    public static function buildA($text, $tooltip, $class, $onclick="", $classIcon="glyphicon glyphicon-plus", $action="")
    {

      return Html::button($text,
         ['type'=>'button',
          'title'=>Yii::t('app', $tooltip),
          'class'=>$class,
          'onclick'=>$onclick]) ;

    }


    public static function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
    {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);

        $interval = date_diff($datetime1, $datetime2);

        return $interval->format($differenceFormat);

    }

    public static function dropdownYN($firstEmpty=true) {
            if ($firstEmpty) $dropdown[ "" ] = "....";
            $dropdown["0"] = "NO";
            $dropdown["1"] = "SI";
            return $dropdown;
    }

    public static function dropdownSegno($firstEmpty=true) {
            if ($firstEmpty) $dropdown[ "" ] = "....";
            $dropdown["-1"] = "Uscita";
            $dropdown["1"] = "Entrata";
            return $dropdown;
    }

    public static function dropdownPriorita($firstEmpty=true) {
            if ($firstEmpty) $dropdown[ "" ] = "....";
            $dropdown[0] = "Alta";
            $dropdown[1] = "Media";
            $dropdown[2] = "Bassa";
            return $dropdown;
	}


    /////////////////////////////////////////////////////////////////////////
    // dropdown
    /////////////////////////////////////////////////////////////////////////
    public static function dropdownNumber($da, $a, $step=1) {
      for($i=$da; $i<=$a; $i=$i+$step)
      $dropdown[$i] = $i;
  		return $dropdown;
  	}

    /////////////////////////////////////////////////////////////////////////
    // dropdownDedrop
    //
    /////////////////////////////////////////////////////////////////////////
    public static function dropdownDedrop($models) { //$idUtente="" togliere da light e ricavare da sessione
      $dropdown = [];
      foreach ($models as $key => $value) {
        $dropdown[] = ["id"=>$key, "name"=>$value];
      }
      return $dropdown;
    }

    /////////////////////////////////////////////////////////////////////////
    // dropdownSql
    /////////////////////////////////////////////////////////////////////////
    public static function dropdownSql($sql, $firstEmpty=true) { //$idUtente="" togliere da light e ricavare da sessione

    $connection = \Yii::$app->db;
    $session = Yii::$app->session;
    $dropdown = [];
    $m = $connection->createCommand( $sql );
    $models = $m->query();
    if ($firstEmpty) $dropdown[ "" ] = "....";
    foreach ($models as $model) {
      $model = array_values($model);
      $dropdown[ $model[0] ] = $model[1];
    }
    return $dropdown;
    }

    /////////////////////////////////////////////////////////////////////////
    // dropdown
    /////////////////////////////////////////////////////////////////////////
    public static function dropdown($table, $id, $descr, $condition="", $firstEmpty=true) { //$idUtente="" togliere da light e ricavare da sessione
		$connection = \Yii::$app->db;
		$session = Yii::$app->session;
		$dropdown = [];
        $sql = "select distinct $id, $descr from $table ";
		if ($condition!="") $sql .= " where $condition ";
    else
     $sql .= " order by 2 ";

		$m = $connection->createCommand( $sql );
		$models = $m->query();
    if ($firstEmpty==true) $dropdown[ "" ] = "....";
		foreach ($models as $model) {
			$dropdown[ $model[ $id ] ] = $model[ $descr ];
		}
		return $dropdown;
	}

  /////////////////////////////////////////////////////////////////////////
  // dropdown
  /////////////////////////////////////////////////////////////////////////
  public static function dropdownAss($table, $id, $descr, $condition="", $firstEmpty=true) { //$idUtente="" togliere da light e ricavare da sessione
  $connection = \Yii::$app->db;
  $session = Yii::$app->session;
  $dropdown = [];
      $sql = "select distinct $id, $descr from $table ";
  if ($condition!="") $sql .= " where $condition ";

  $m = $connection->createCommand( $sql );
  $models = $m->query();
  if ($firstEmpty) $dropdown[ "" ] = "....";
  foreach ($models as $model) {
    $dropdown[] = [$model[$id] => $model[ $descr ]];
  }
  return $models;
}

	/////////////////////////////////////////////////////////////////////////
	// dropdownValue
	/////////////////////////////////////////////////////////////////////////
    public static function dropdownValue($table, $id, $descr, $key, $condition="") { //$idUtente="" togliere da light e ricavare da sessione
		$connection = \Yii::$app->db;
		$session = Yii::$app->session;
		$dropdown = [];
        $sql = "select distinct $id, $descr from $table ";
		$sql .= " where $id='$key' ";
        if ($condition!="") $sql .= " and $condition ";
		$m = $connection->createCommand( $sql );
		$models = $m->query();
		foreach ($models as $model) {
			return $model[ $descr ];
		}
		return "";
	}

    /////////////////////////////////////////////////////////////////////////
    // buildExcel
    /////////////////////////////////////////////////////////////////////////
    public static function buildExcel($sql, $labels=[], $titolo="...", $formats=[], $formatters=[], $sum=[], $header="") {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand($sql);
        $model = $command->queryAll();
        $dropdowns = [];
        foreach ($labels as $field=>$label) {
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
                if ($count==0) $titles[] = isset($labels[$k])?$labels[$k]:$k;
            }
            $count++;
            $data[] = $data_row;
        }

        self::buildExcel_($data, $titles, $count, $titolo, $formats, $formatters, $sum);
    }


    public static function buildStyle($tag, $class="")
    {

    //  $fg = str_replace("#","", $GLOBALS["cssProperties"][".text-".$class]["color"]);
      $bold = strtoupper($tag)=="TH"?true:false;

      $style = [];

      $style['font'] = [];
      $style['font']['bold'] = $bold;

      if ($class=="") return $style;

      $bg = str_replace("#","", $GLOBALS["cssProperties"][".bg-".$class]["background-color"]);
      $style['fill'] = [];
      $style['fill']['type'] = \PHPExcel_Style_Fill::FILL_SOLID;
      $style['fill']['color'] = array('rgb' => $bg);

      return $style;


    }


    public static function buildExcelFromHtml($table, $sheetName="Report", $fileName="report.xls") {

      $session = Yii::$app->session;
      $theme = \Yii::$app->params["theme"];
      $path = Yii::$app->assetManager->getPublishedPath(Yii::getAlias('@vendor/thomaspark/bootswatch')) . "/$theme/bootstrap.min.css";
      $GLOBALS["cssProperties"] = \backend\models\Tool::parseCss($path);


      $pos1 = strpos($table, \Yii::$app->params["START_REPORT"]) + strlen(\Yii::$app->params["START_REPORT"]);
      $table = substr($table, $pos1);
      $pos2 = strpos($table, \Yii::$app->params["END_REPORT"]);
      //Tool::clear($table);
      //Tool::log($table);
      //Tool::log($pos2);
      $table = substr($table, 0, $pos2);
      //Tool::log($table);

      $table = '<html lang="it"><head><meta charset="UTF-8"></head><body>' . $table . '</body></html>';

      // save $table inside temporary file that will be deleted later
      $tmpfile = tempnam(sys_get_temp_dir(), 'html');
      file_put_contents($tmpfile, $table);

      // insert $table into $objPHPExcel's Active Sheet through $excelHTMLReader
      $objPHPExcel     = new \PHPExcel();
      $excelHTMLReader = \PHPExcel_IOFactory::createReader('HTML');
      $excelHTMLReader->setInputEncoding('ISO-8859-1');
      $excelHTMLReader = new \PHPExcel_Reader_HTML();
      $excelHTMLReader->loadIntoExisting($tmpfile, $objPHPExcel);
      $objPHPExcel->getActiveSheet()->setTitle($sheetName); // Change sheet's title if you want

      //Tool::log($tmpfile);
//      unlink($tmpfile); // delete temporary file because it isn't needed anymore

      header('Content-type: application/vnd.ms-excel');
      header('Content-Disposition: attachment; filename="'.$fileName . '_' . Date('Ymd Hi').'.xlsx"');
      header("Cache-Control: max-age=0");

      // Creates a writer to output the $objPHPExcel's content
      $writer = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
      return $writer;

    }


    public static function buildExcel_($data, $titles, $count, $titolo="...", $formats=[], $formatters=[], $sum=[], $header="") {

        $titolo = substr($titolo,0,25);
        $file = \Yii::createObject([
        'class' => 'codemix\excelexport\ExcelFile',
        'sheets' => [
            // Array keys are used as Sheet names in the final excel file
            $titolo => [
                'data' => $data,
                'titles' => $titles,
                'formats' => $formats,
                'formatters' => $formatters,
                ],
            ]
        ]);

        $phpExcel = $file->getWorkbook();

        $highestColumnIndex = count($titles);
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

            if (in_array($column, $sum))
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
        $titolo = substr($titolo,0,15);
        //header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header('Content-Disposition: attachment; filename="'.$titolo . '_' . Date('Ymd Hi').'.xlsx"');
        header("Cache-Control: max-age=0");
        $file->saveAs('php://output');

    }

    public static function xlsNextCell($col, $step=0)
    {
        $idx = \PHPExcel_Cell::columnIndexFromString($col);
        $idx = $idx + $step;
        $col = \PHPExcel_Cell::stringFromColumnIndex($idx);
        return $col;
    }

    public static function xlsMerge($sheet, $from="A1", $to="A20")
    {
        $sheet->mergeCells($from . ':' . $to);
    }

    public static function xlsCenter($sheet, $from="A1", $to="A20")
    {
        $style = array(
            'alignment' => array(
                'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $sheet->getStyle($from . ':' . $to)->applyFromArray($style);
    }

    public static function xlsStyleDanger($sheet, $from, $to)
    {
        $bgcolor="f2dede";
        $color="777777";
        self::xlsStyle($sheet, $from, $to, $bgcolor, $color);
    }
    public static function xlsStyleSuccess($sheet, $from, $to)
    {
        $bgcolor="d0e9c6";
        $color="777777";
        self::xlsStyle($sheet, $from, $to, $bgcolor, $color);
    }
    public static function xlsStyleInfo($sheet, $from, $to)
    {
        $bgcolor="c4e3f3";
        $color="777777";
        self::xlsStyle($sheet, $from, $to, $bgcolor, $color);
    }

    public static function xlsStyleWarning($sheet, $from, $to)
    {
        $bgcolor="fcf8e3";
        $color="777777";
        self::xlsStyle($sheet, $from, $to, $bgcolor, $color);
    }

    public static function xlsStyleGray($sheet, $from, $to)
    {
        $bgcolor="D8D8D8";
        $color="000000";
        self::xlsStyle($sheet, $from, $to, $bgcolor, $color);
    }

    public static function xlsStyle($sheet, $from="A1", $to="A20", $bgcolor="D8D8D8", $color="000000")
    {
          $sheet->getStyle($from . ':' . $to)->applyFromArray(
            array(
                'fill' => array(
                    'type' => \PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => $bgcolor)
                ),
                'font'  => array(
                    'bold'  => true,
                    'color' => array('rgb' => $color),
                    //'size'  => 15,
                    //'name'  => 'Verdana'
                )
            )
        );
    }

 	public static function startsWith($haystack, $needle) {
		// search backwards starting from haystack length characters from the end
		return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
	}

 	public static function endsWith($haystack, $needle) {
		// search forward starting from end minus needle length characters
		return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== false);
	}



    public static function logValidate($model)
    {

     if ($model->validate()) {
        self::log("logValidate OK");
        return true;
    } else {
        $data = $model->getErrors();
        self::log("logValidate KO" . print_r($data,true));
        return false;
    }
    }

    public static function logModelErrors($model)
    {
        $data = $model->getErrors();
        self::log("logModelErrors" . print_r($data,true));
        return false;
    }

    public static $starttime_batch =0;
    public static function clear_batch($idKey="")
    {
    self::$starttime_batch = self::getmicrotime();
  	$connection = \Yii::$app->db;
  	$connection->createCommand("delete from efx_log_batch")->execute();
    }

    public static function logd_batch($idKey,$s)
    {
      self::log_batch($idKey, print_r($s,true));
    }


    public static function log_batch($idKey,$s)
    {
    $endtime =  self::getmicrotime();
    $timediff = round(($endtime - self::$starttime_batch));
	  $connection = \Yii::$app->db;
    try{
		$connection->createCommand("insert into efx_log_batch (idKey, lastUpdate, msg) values ('$idKey', now(), :msg) ")->bindValue(':msg', $timediff.": ".$s)->execute();       }
    catch (\Exception $e) {
		$s = substr($s, 0,555);
		Yii::$app->db->close();
		Yii::$app->db->open();
		$connection = \Yii::$app->db;
		//$connection->createCommand("SET @@global.max_allowed_packet=16777216")->execute();
		$connection->createCommand("insert into efx_log_batch (idKey, lastUpdate, msg) values ('$idKey', now(), :msg) ")->bindValue(':msg', $timediff."== ".$s)->execute();		}
    catch (\yii\db\Exception $e) {
		$s = substr($s, 0,555);
		Yii::$app->db->close();
		Yii::$app->db->open();
		$connection = \Yii::$app->db;
		//$connection->createCommand("SET @@global.max_allowed_packet=16777216")->execute();
		$connection->createCommand("insert into efx_log_batch (idKey, lastUpdate, msg) values ('$idKey', now(), :msg) ")->bindValue(':msg', $timediff."== ".$s)->execute();		}
    }

    public static $starttime =0;
    public static function clear()
    {
    self::$starttime = self::getmicrotime();
  	$connection = \Yii::$app->db;
  	$connection->createCommand("delete from log")->execute();
    }

    public static function clarLog()
    {
    self::$starttime =  self::getmicrotime();
    $connection = \Yii::$app->db;
    $connection->createCommand("delete from log")->execute();
    }

    public static function logd($s)
    {
      self::log(print_r($s,true));
    }


    public static function log($s)
    {

    $endtime =  self::getmicrotime();
    $timediff = round(($endtime - self::$starttime));
	   $connection = \Yii::$app->db;
    //$s =  str_replace("'", "", $s);
    //$s = substr($s, 0,255);
    //$connection->createCommand("insert into log  (lastUpdate, msg) values(now(),'".$timediff.": ".$s."')")->execute();
    try{
		$connection->createCommand("insert into log (lastUpdate, msg) values (now(), :msg) ")->bindValue(':msg', $timediff.": ".$s)->execute();       }
    catch (\Exception $e) {
		$s = substr($s, 0,555);
		Yii::$app->db->close();
		Yii::$app->db->open();
		$connection = \Yii::$app->db;
		//$connection->createCommand("SET @@global.max_allowed_packet=16777216")->execute();
		$connection->createCommand("insert into log (lastUpdate, msg) values (now(), :msg) ")->bindValue(':msg', $timediff."== ".$s)->execute();		}
    catch (\yii\db\Exception $e) {
		$s = substr($s, 0,555);
		Yii::$app->db->close();
		Yii::$app->db->open();
		$connection = \Yii::$app->db;
		//$connection->createCommand("SET @@global.max_allowed_packet=16777216")->execute();
		$connection->createCommand("insert into log (lastUpdate, msg) values (now(), :msg) ")->bindValue(':msg', $timediff."== ".$s)->execute();		}
    }

    public static function getmicrotime(){
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
    }

    public static function fmtCurrency($value, $fmt="EUR", $locale="de_DE"){
    if (trim($value)=="") return "";
    $f = numfmt_create( $locale, \NumberFormatter::CURRENCY );
    return numfmt_format_currency($f, $value, $fmt);
    }

    public static function fmtCurrencyAbs($value, $fmt="EUR", $locale="de_DE"){
    if (trim($value)=="") return "";
    $value = abs($value);
    $f = numfmt_create( $locale, \NumberFormatter::CURRENCY );
    return numfmt_format_currency($f, $value, $fmt);
    }


    public static function buildActonButtons($controller){

      return
      [
      	'view' => function ($url, $model, $key) use ($controller) {
      		$options = [
      			'title' => Yii::t('yii', 'Dettaglio'),
      			'aria-label' => Yii::t('yii', 'Detail'),
      			'data-pjax' => '#ajaxCrudDatatable1',
      		];
      		return GhostHtml::a('<span class="glyphicon glyphicon-eye-open fa-2x"></span>',
                                  [$controller."/update", 'id' => $key], $options);

      	},
      	'update' => function ($url, $model, $key) use ($controller) {
      		$options = [
      			'title' => Yii::t('yii', 'Modifica'),
      			'aria-label' => Yii::t('yii', 'Update'),
      			'data-pjax' => '#ajaxCrudDatatable1',
      		];
      		return GhostHtml::a('<span class="glyphicon glyphicon-pencil fa-2x"></span>',
                                  [$controller."/update", 'id' => $key], $options);
      	},
      	'delete' => function ($url, $model, $key) use ($controller) {
      		$options = [
      			'title' => Yii::t('yii', 'Cancella'),
      			'aria-label' => Yii::t('yii', 'Delete'),
      			'data-pjax' => '#ajaxCrudDatatable1',

                  'data-confirm' => \Yii::t('yii', 'Are you sure to delete this item?'),
      		];

      		return GhostHtml::a('<span class="glyphicon glyphicon-trash fa-2x"></span>',
                                  [$controller."/delete", 'id' => $key], $options);
      	},
      ];


    }

    public static function getStartAndEndDate($year, $week, $format="d/m/Y") {
        $from = date($format,strtotime($year.'W'.str_pad($week, 2, 0, STR_PAD_LEFT)));
        $to = date($format,strtotime($year.'W'.str_pad($week, 2, 0, STR_PAD_LEFT).'7'));
        return array($from, $to);
    }



}
