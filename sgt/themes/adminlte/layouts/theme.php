<?
use backend\assets\AppAsset;
use backend\assets\SmartyThemeAsset;
use backend\assets\Bootswatch;

//flat\FlatAsset::register($this);
//SmartyThemeAsset::register($this);

//http://bootswatch.com/
//cosmo  flatly paper readable

//raoul2000\bootswatch\BootswatchAsset::$theme = 'yeti';

$session = Yii::$app->session;

//con AdminLte non usare altri temi
//raoul2000\bootswatch\BootswatchAsset::$theme = \Yii::$app->params["theme"];
//Bootswatch::register($this);


AppAsset::register($this);



use kartik\icons\Icon;
Icon::map($this, Icon::FA);

?>
