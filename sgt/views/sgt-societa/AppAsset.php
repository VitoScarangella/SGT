<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
/*
https://fonts.googleapis.com/css?family=Josefin+Sans|Lobster|Patrick+Hand+SC|Raleway|Syncopate
https://fonts.googleapis.com/css?family=Open+Sans|Ubuntu|Oswald
*/


    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
      'css/font/font.css', //contiene tutti i font disponibili
      'css/site.css',
      'css/mcWidget.css',
      'css/bootstrap-toggle.min.css',
      'css/jquery-ui.min.css',
      'css/font/materialicon.css',
      //'css/themes/default/style.min.css',
      'js/fancytree/skin-bootstrap/ui.fancytree.min.css', //fancytree
      'js/fancytree/skin-bootstrap/ui.fancytree.less' //fancytree

    ];
    public $js = [
      'js/efx.js', //
      'js/js.cookie.js', //gestione dei cookies
      'js/jquery.ask-confirm-on-change.js', //chiede conferma per le modifiche
      'js/jquery.mask.js', //https://igorescobar.github.io/jQuery-Mask-Plugin/
      'js/jquery-ui.min.js',
      'js/bootstrap-toggle.min.js', //toggle button
      'js/fancytree/jquery.fancytree-all.min.js',  //fancytree
      'js/ace/ace.js',
      'js/ace/theme-twilight.js',
      'js/ace/mode-javascript.js',
      'js/ace/mode-json.js',
      'js/ace/worker-javascript.js',
      'js/ace/worker-json.js'


    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        //'yii\bootstrap\BootstrapPluginAsset', // <- using this instead
    ];

    public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );

}
