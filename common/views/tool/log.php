<?php
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\tipodoc */
if (!isset($msg)) $msg="";

$dirlog =  Yii::getAlias('@runtime') . '/logs/';
$dirlog2 =  \Yii::$app->params["php_error_log"];  //'D:/EFXBIZ_KIT/EfxKit0git/xampp2016/php/logs';

$this->title = 'LOG';

function showLog($filelog)
{

  if (file_exists ($filelog))
  {
      $file = file($filelog);
      //$file = array_reverse($file);
      $additionalInfo=false;

      foreach($file as $f){

          if ((strpos($f, '[error]') !== false)
             || (strpos($f, 'Next exception') !== false)
             )
          {
          $additionalInfo=false;
          echo "<b>".$f."</b>" . "<br>";
          }
          elseif (
              (strpos($f, 'Additional Information:') !== false)
             || (strpos($f, '{main}') !== false)
             )
          {
          $additionalInfo=true;
          echo "<i>".$f."</i>" . "<br>";
          }
          elseif ($additionalInfo)
          {
          //echo "<i>".$f."</i>" . "<br>";
          }
          else
          {
              if ((strpos($f, '\\views\\') !== false))
                 echo "<span style='color:darkblue'>".$f."</span>" . "<br>";
              elseif ((strpos($f, '\\models\\') !== false))
                 echo "<span style='color:darkgreen'>".$f."</span>" . "<br>";
              elseif ((strpos($f, '\\controllers\\') !== false))
                 echo "<span style='color:darkred'>".$f."</span>" . "<br>";
              else
                 echo $f."<br>";
          }



      }//foreach

  }
}
?>
<script>
function reload()
{
    window.location=window.location;
}

function deleteLog()
{
<?
//$url = Url::to(['tool/deletelog']) ;
$url = Yii::$app->request->baseUrl. '/tool/deletelog';
?>

   $.ajax({
       url: '<?php echo $url ?>',
       type: 'get',
       data: {
              php_error_log: '<?=$dirlog2?>'
             },
       success: function (data) {
            window.location=window.location;
       },
       error: function (exc) {
          alert(exc);
       }  });

}
function deleteLogTab()
{
<?
//$url = Url::to(['tool/deletelog']) ;
$url = Yii::$app->request->baseUrl. '/tool/deletelogtab';
?>

   $.ajax({
       url: '<?php echo $url ?>',
       type: 'get',
       data: {

             },
       success: function (data) {
            window.location=window.location;
       },
       error: function (exc) {
          alert(exc);
       }  });

}

</script>
<input type=button class="btn btn-primary" value="Reload" onClick="reload()">
<input type=button class="btn btn-danger" value="Delete Log Files" onClick="deleteLog()">
<input type=button class="btn btn-danger" value="Delete Log on DB" onClick="deleteLogTab()">
<div class="tipodoc-view" style="overflow:scroll;height:400px;">
<H3>LOG YII</H3>
<?
showLog($dirlog.\Yii::$app->id.".log");
?>
</div>
<hr>
<H3>PHP ERROR LOG</H3><span class="label label-info"><?=$dirlog2?></span>
<div class="tipodoc-view" style="overflow:scroll;background-color:lightgray; height:400px;">
<?
showLog($dirlog2);
?>
</div>
<hr>
<H3>DB LOG</H3>
<div class="tipodoc-view" style="overflow:scroll;background-color:lightyellow; height:400px;">
<table border=1>
<?
foreach ($logs as $key => $log) {
echo "<tr><td>" . $log->id. "</td><td>" . $log->msg. "</td></tr>";
}
?>
</table>
</div>
<hr>
<H3>DB LOG BATCH</H3>
<div class="tipodoc-view" style="overflow:scroll;background-color:lightgreen; height:400px;">
<table border=1>
<?
foreach ($logsbatch as $key => $log) {
echo "<tr><td>" . $log->id. "</td><td>" . $log->msg. "</td></tr>";
}
?>
</table>
</div>
