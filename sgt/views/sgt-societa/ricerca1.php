<?php
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use common\models\Tool;
use kartik\editable\Editable;
use webvimark\modules\UserManagement\components\GhostHtml;

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\builder\FormGrid;
use kartik\widgets\Select2;
use kartik\widgets\FileInput;
use yii\web\JsExpression;
use backend\assets\GeocodAsset;
GeocodAsset::register($this);


/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var backend\models\SgtSocietaSearch $searchModel
 */

$this->title = 'Societa';
$this->params['breadcrumbs'][] = $this->title;
?>
<style type="text/css">
    body{
        background:none transparent;
    }
    .sgt-societa-form{

        margin: 50px;
    }
    .textField{
        border-radius: 5px;
    }
    .btn-primary{
        width: 100%;
    }

</style>


<?

$models = $dataProvider->getModels();
// Tool::logd(print_r($models));
?>
<div class="container">
            <form class="form-horizontal" action="<?=Yii::$app->controller->action->id?>">
              <fieldset>
                <div class="form-group">
                  <label for="societa" class="control-label">Comune</label>
                  <div class="col-lg-12">
                    <input type="text" class="form-control" id="comune" name="comune" placeholder="Comune" value="<?=$comune?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="societa" class="control-label">Società</label>
                  <div class="col-lg-12">
                    <input type="text" class="form-control" id="societa" name="societa" placeholder="Società" value="<?=$societa?>">
                  </div>
                </div>
                <div class="form-group">
                  <div class="col-lg-2 col-lg-offset-0">
                    <button type="submit" class="btn btn-primary">Cerca</button>
                  </div>
                </div>
              </fieldset>
            </form>
</idv>
<div class="container" style="padding:0px">
  <div class="col-xs-12 col-sm-12 col-md-4" style="padding:0px;border:0px solid red">
    <hgroup class="mb20">
        <?
        if (trim($comune)!="" || trim($societa)!="")
        {
        ?>
		<h1>Risultati della ricerca</h1>
		<h2 class="lead">Sono state trovate <strong class="text-danger"><?=$dataProvider->totalCount?></strong> società.</h2>

		<?
        }

		if (count($excluded)>0)
		echo "<h2 class='lead'>Filtri esclusi dalla ricerca:<strong class='text-danger'>".implode(",", $excluded)."</strong>";
		?>



	</hgroup>

    <section class="col-xs-12 col-sm-6 col-md-12" style="padding-left:0px">
        <?
        foreach ($models as  $model) {
        ?>
		<article class="search-result row">
			<div class="col-xs-12 col-sm-12 col-md-12 excerpet">
				<h4><a href="#" title=""><?=$model["societa"]?></a></h4>
				<p><?=$model["indirizzo"]?> <?=$model["civico"]?> <?=$model["cap"]?><br>
				<?=$model["comune"]?> (<?=$model["provincia"]?>)     </p>
        <p>
        <?
        if ($model["idUser"]==0)
        {
        ?>
        <a href="<?=Yii::$app->request->baseUrl?>/sgt-societa/take-control?id=<?=$model["id"]?>" >
        <i class="fa fa-edit fa-2x" title="Aggiorna i dati"></i>
        </a>
        <?
        }
        else
        {
        ?>
        <a href="<?=Yii::$app->request->baseUrl?>/sgt-societa/take-login?id=<?=$model["id"]?>" >
        <i class="fa fa-key fa-2x" title="Gestisci la società"></i>
        </a>
        <?
        }
        if ($model["x"]!=0)
        {
        ?>
        <i class="fa fa-map-marker fa-2x text-danger" title="Posiziona aulla mappa"
          onClick="highlightMap(<?=$model["x"]?>, <?=$model["y"]?>);"
        ></i>
        <?
        }
        ?>
        </p>
			</div>

			<span class="clearfix borda"></span>
		</article>
		<?
       }
		?>

	</section>
</div>
<div class="col-xs-12 col-sm-12 col-md-8" style="border:0px solid red">
  <div id="map"></div>
<style>
#map {
	height: 600px;
}
</style>
	<script>
  var map;
  var rectangle=false;

  function highlightMap(x,y)
  {

  map.panTo(new google.maps.LatLng(x, y));
  // Define the LatLng coordinates for the polygon's path.

    // Construct the polygon.
    if (rectangle) rectangle.setMap(null);
    rectangle = new google.maps.Rectangle();
    var bounds = map.getBounds().toJSON();
    rectangle.setOptions({
      strokeColor: '#0000FF',
      strokeOpacity: 0.2,
      strokeWeight: 1,
      fillColor: '#0000FF',
      fillOpacity: 0.2,
      map: map,
      bounds: {
        north: x-Math.abs(bounds.north-bounds.south)/12,
        south: x+Math.abs(bounds.north-bounds.south)/12,
        east: y+Math.abs(bounds.east-bounds.west)/12,
        west: y-Math.abs(bounds.east-bounds.west)/12
      }
    });
    /*
var bounds = map.getBounds().toJSON();
rectangle.setOptions({bounds: {
  north: bounds.north-Math.abs(bounds.north-bounds.south)/12,
  south: bounds.north+Math.abs(bounds.north-bounds.south)/12,
  east: bounds.east+Math.abs(bounds.east-bounds.west)/12,
  west: bounds.east-Math.abs(bounds.east-bounds.west)/12
}});*/

  }

  function initMap() {

    var locations = [
        <?
        $i=0;
        $X=45.0679379;
        $Y=7.6827538;
        foreach ($models as  $model) {
          if ($model["x"]==0) continue;
          $X=$model["x"];
          $Y=$model["y"];
        ?>
        ["<?=$model["societa"]?>", <?=$model["x"]?>, <?=$model["y"]?>, <?=$i?>],
        <?
        $i++;
        }
        ?>
      ];

      if (locations.length==0)
      locations[locations.length] = ["Piazza San Carlo",<?=$X?>,<?=$Y?>,locations.length];

      map = new google.maps.Map(document.getElementById('map'), {
    		zoom: 13,
    		center: new google.maps.LatLng(<?=$X?>, <?=$Y?>),
    		mapTypeId: google.maps.MapTypeId.ROADMAP
    	});

    	var infowindow = new google.maps.InfoWindow({});

    	var marker, i;

    	for (i = 0; i < locations.length; i++) {
    		marker = new google.maps.Marker({
    			position: new google.maps.LatLng(locations[i][1], locations[i][2]),
    			map: map
    		});

    		google.maps.event.addListener(marker, 'click', (function (marker, i) {
    			return function () {
    				infowindow.setContent(locations[i][0]);
    				infowindow.open(map, marker);
    			}
    		})(marker, i));
    	}


  }
  </script>
	<script async defer
					src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBAgIHwDktgkEvRN9I1mHpRxY6Bl3-L_xg&callback=initMap"></script>

</div>

</div>

<?



echo \yii\widgets\LinkPager::widget([
    'pagination'=>$dataProvider->pagination,
]);
?>
