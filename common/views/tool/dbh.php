<?php
use yii\helpers\Url;
use yii\widgets\DetailView;

$connection = \Yii::$app->db;
/* @var $this yii\web\View */
/* @var $model backend\models\tipodoc */
if (!isset($msg)) $msg="";

$tab="";
$prefix="";
$schema="";
if (isset($_REQUEST["tab"]))    $tab    = $_REQUEST["tab"];
if (isset($_REQUEST["prefix"])) $prefix = $_REQUEST["prefix"];
if (isset($_REQUEST["schema"])) $schema = $_REQUEST["schema"];

$this->title = 'Db Help';

?>
<script>
function reload()
{
  url = '<?=Yii::$app->urlManager->createUrl('tool/dbhelp')?>';
  tab=$("#tab").val();
  prefix=$("#prefix").val();
  schema=$("#schema").val();

  window.location=url+"?tab="+tab+"&prefix="+prefix+"&schema="+schema;
}
</script>
<b>SCHEMA:</b><input type="text" size="50" id="schema" value="<?=$schema?>" >
<b>TABLE:</b><input type="text" size="50" id="tab" value="<?=$tab?>" >
<b>PREFIX:</b><input type="text" size="50" id="prefix" value="<?=$prefix?>" >

<input type="button" class="btn btn-primary" value="Reload" onClick="reload()">

<H3>DB HELP</H3>
<?
if ( !isset($_REQUEST["tab"]) ) return;


$sql = "
SELECT
        table_schema,table_name, column_name,ordinal_position,
        data_type,column_type
    FROM information_schema.columns
    WHERE table_name='".$tab."'
";

if (trim($schema)!="")
  $sql .= " and table_schema ='" . $schema . "'";
echo $sql;
$m = $connection->createCommand($sql);
$models = $m->query();
echo "<pre>";
$k=0;
foreach ($models as $model) {
  if( $model["column_name"] == "lastUpdate") continue;
  if( $model["column_name"] == "created") continue;
  if ($prefix!="") echo $prefix.".";
  echo $model["column_name"].", ";
  if ($k % 4==0) echo "\r\n";
  $k++;
}
echo "from $tab";
echo "</pre>";


?>
