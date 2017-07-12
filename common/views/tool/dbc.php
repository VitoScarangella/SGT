<?php
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\tipodoc */
if (!isset($msg)) $msg="";


$this->title = 'Db Compare';

$connection = \Yii::$app->db;
$sql = "SELECT DISTINCT table_schema FROM information_schema.columns";
$m = $connection->createCommand($sql);
?>
<script>
function reload()
{
  url = '<?=Yii::$app->urlManager->createUrl('tool/dbcompare')?>';
  db1=$("#db1").val();
  db2=$("#db2").val();

    window.location=url+"&db1="+db1+"&db2="+db2;
}
</script>
<b>FIRST DB:</b><select id="db1">
<?
$models = $m->query();
foreach ($models as $model) {
 $sel =  ( isset($_REQUEST["db1"]) && $_REQUEST["db1"]==$model["table_schema"])?" selected ":" ";
  echo "<option value='" . $model["table_schema"] ."' "
     . $sel . " >"
     . $model["table_schema"];
}
?>
</select>
<b>SECOND DB:</b><select id="db2">
<?
$models = $m->query();
foreach ($models as $model) {
$sel =  ( isset($_REQUEST["db2"]) && $_REQUEST["db2"]==$model["table_schema"])?" selected ":" ";
  echo "<option value='" . $model["table_schema"] ."' "
     . $sel . " >"
     . $model["table_schema"];
}

?>
</select>

<input type=button class="btn btn-primary" value="Reload" onClick="reload()">

<H3>DB COMPARE</H3>


<?
if (!isset($_REQUEST["db1"]) || !isset($_REQUEST["db2"])) return;
if ($_REQUEST["db1"]==$_REQUEST["db2"])
{
  echo "<h2>I due db devono essere diversi</h2>";
  return;
}

$table=[];
$alter=[];

$sql = "
SELECT
        table_schema,table_name, column_name,ordinal_position,
        data_type,column_type
    FROM information_schema.columns
    WHERE table_schema='".$_REQUEST["db1"]."'
";
$m = $connection->createCommand($sql);
$models = $m->query();
echo "<table>";
foreach ($models as $model) {

  $sql2 = "
  SELECT
      table_schema,table_name, column_name,ordinal_position,
          data_type,column_type
      FROM information_schema.columns
      WHERE table_schema='".$_REQUEST["db2"]."'
      and table_name  = '".$model["table_name"]."'
      and column_name = '".$model["column_name"]."'
  ";

  $m2 = $connection->createCommand($sql2);
  $models2 = $m2->queryOne();
  if (!$models2)
  {
    $alter[] = "alter table " . $model["table_name"] . " add column " . $model["column_name"] . " " . $model["column_type"] . ";";
    $table[ $model["table_name"] ] = "";
    echo "<tr>";
    echo "<td>" . $model["table_name"] . "</td>";
    echo "<td>" . $model["column_name"] . "</td>";
    echo "<td>" . $model["data_type"] . "</td>";
    echo "<td>" . $model["column_type"] . "</td>";
    echo "<td>...</td>";
    echo "<td>...</td>";
    echo "</tr>";
  }
  else if (
    ($models2["data_type"] != $model["data_type"])
    ||
    ($models2["column_type"] != $model["column_type"])
    )
    {
      $alter[] = "alter table " . $model["table_name"] . " change column "
      . $model["column_name"] . " " . $model["column_name"] . " ". $model["column_type"] . ";";
      $table[ $model["table_name"] ] = "";
      echo "<tr>";
      echo "<td>" . $model["table_name"] . "</td>";
      echo "<td>" . $model["column_name"] . "</td>";
      echo "<td>" . $model["data_type"] . "</td>";
      echo "<td>" . $model["column_type"] . "</td>";
      echo "<td>" . $models2["data_type"] . "</td>";
      echo "<td>" . $models2["column_type"] . "</td>";
      echo "</tr>";
    }
}
echo "</table>";

foreach ($table as $key => $value) {
  $sql2 = "show create table ".$key;
  $m2 = $connection->createCommand($sql2);
  $models2 = $m2->queryOne();
  //print_r($models2);
  if (isset($models2["Create Table"]))
  {
    $table[$key] = $models2["Create Table"];
  }
  else if (isset($models2["Create View"]))
  {
    $table[$key] = $models2["Create View"];
  }
}

echo "<table>";
foreach ($alter as   $value) {
  echo "<tr>";
  echo "<td><pre>" . $value . "</pre></td>";
  echo "</tr>";
}
echo "</table>";

echo "<table>";
foreach ($table as $key => $value) {
  echo "<tr>";
  echo "<td><pre>" . $value . "</pre></td>";
  echo "</tr>";
}
echo "</table>";


?>
