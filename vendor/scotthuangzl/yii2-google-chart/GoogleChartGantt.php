<?php

namespace scotthuangzl\googlechart;

use yii\base\Widget;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\View;


/**
 * An widget to wrap google chart for Yii Framework 2
 * by Scott Huang
 *
 * @see https://github.com/ScottHuangZL/yii2-google-chart
 * @author Scott Huang <zhiliang.huang@gmail.com>
 * @since 0.2
 * @Xiamen China
 */
class GoogleChartGantt extends Widget
{
    public $message;
    /**
     * @var string $containerId the container Id to render the visualization to
     */
    public $containerId;

    /**
     * @var string $visualization the type of visualization -ie PieChart
     * @see https://google-developers.appspot.com/chart/interactive/docs/gallery
     */
    public $visualization;

 
    
    
    /**
     * @var string $packages the type of packages, default is corechart
     * @see https://google-developers.appspot.com/chart/interactive/docs/gallery
     */
    public $packages = 'gantt';  // such as 'orgchart' and so on.

    public $loadVersion = "1"; //such as 1 or 1.1  Calendar chart use 1.1.  Add at Sep 16

    /**
     * @var array $data the data to configure visualization
     * @see https://google-developers.appspot.com/chart/interactive/docs/datatables_dataviews#arraytodatatable
     */
    public $data = array();

    /**
     * @var array $options additional configuration options
     * @see https://google-developers.appspot.com/chart/interactive/docs/customizing_charts
     */
    public $options = array();
    
    /**
     * @var string $scriptAfterArrayToDataTable additional javascript to execute after arrayToDataTable is called
     */
    public $scriptAfterArrayToDataTable = '';

    /**
     * @var array $htmlOption the HTML tag attributes configuration
     */
    public $htmlOptions = array();

    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = 'Hello World';
        }
    }

    public function run()
    {

        $id = $this->getId();
        if (isset($this->options['id']) and !empty($this->options['id'])) $id = $this->options['id'];
        // if no container is set, it will create one
        if ($this->containerId == null) {
            $this->htmlOptions['id'] = 'div-chart' . $id;
            $this->containerId = $this->htmlOptions['id'];
            echo '<div ' . Html::renderTagAttributes($this->htmlOptions) . '></div>';
        }
        $this->registerClientScript($id);
        //return Html::encode($this->message);
    }

    /**
     * Registers required scripts
     */
    public function registerClientScript($id)
    {

   
        
        $jsData = Json::encode($this->data);
        $jsOptions = Json::encode($this->options);
        
        $jsData = str_replace("\"#","",$jsData);
        $jsData = str_replace("#\"","",$jsData);

        $script = '
			//EFX google.setOnLoadCallback(drawChart' . $id . ');
            
            google.charts.setOnLoadCallback(drawChart' . $id . ');  
            
			var ' . $id . '=null;
			function drawChart' . $id . '() {
            
            
var data = new google.visualization.DataTable();
      data.addColumn("string", "Task ID");
      data.addColumn("string", "Task Name");
      data.addColumn("string", "Resource");
      data.addColumn("date", "Start Date");
      data.addColumn("date", "End Date");
      data.addColumn("number", "Duration");
      data.addColumn("number", "Percent Complete");
      data.addColumn("string", "Dependencies");

      data.addRows([
        ["2014Spring", "Spring 2014", "spring",
         new Date(2014, 2, 22), new Date(2014, 5, 20), null, 100, null],
        ["2014Summer", "Summer 2014", "summer",
         new Date(2014, 5, 21), new Date(2014, 8, 20), null, 100, null],
        ["2014Autumn", "Autumn 2014", "autumn",
         new Date(2014, 8, 21), new Date(2014, 11, 20), null, 100, null],
        ["2014Winter", "Winter 2014", "winter",
         new Date(2014, 11, 21), new Date(2015, 2, 21), null, 100, null]
 
      ]);
      
      
      data.addRows([
      ["2014Spring","aaa 2014","spring",
       new Date(2014, 4, 20),new Date(2014, 5, 20),null,100,null],
       ["2015Spring","bbb 2015","spring",new Date(2014, 3, 20),new Date(2014, 5, 20),null,100,null]
       ]);

      
      
      
      //data.addRows(' . $jsData . ');
            
 
            
            
		//		var data = google.visualization.arrayToDataTable(' . $jsData . ',true);

				' . $this->scriptAfterArrayToDataTable . '

				var options = ' . $jsOptions . ';

				' . $id . ' = new google.visualization.' . $this->visualization . '(document.getElementById("' . $this->containerId . '"));
				' . $id . '.draw(data, options);
			}';

        $view = $this->getView();
        //$view->registerJsFile('https://www.google.com/jsapi',['position' => View::POS_HEAD]);
        $view->registerJsFile('https://www.gstatic.com/charts/loader.js',['position' => View::POS_HEAD]);
        
        //$view->registerJs('google.load("visualization", "' . $this->loadVersion . '", {packages:["' . $this->packages . '"]});', View::POS_HEAD, __CLASS__ . '#' . $id);
        
        //EFX counter serve per fare eseguire solo la prima volta google.charts.load (nel caso di piu' grafici sulla stessa pagina)
        if ($this->options['counter']==0) $view->registerJs('google.charts.load("current",  {"packages":["' . $this->packages . '"]});', View::POS_HEAD, __CLASS__ . '#' . $id);
  

        
        $view->registerJs($script, View::POS_HEAD, $id);
    }

}
