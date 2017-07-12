<?php

if ($_SERVER['HTTP_HOST']=="sportgrandtour.local:8011"
|| $_SERVER['HTTP_HOST']=="sgt:8011"
)
require_once("params_svil.php");

if ($_SERVER['HTTP_HOST']=="svil.sportgrandtour.it")
require_once("params_prod.php");



return $params;




//Yii::$app->params['upload_path']
