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
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
      'css/site.css',
      'css/bootstrap-toggle.min.css',
      'css/jquery-ui.min.css',
      'css/font/materialicon.css',
      //'css/themes/default/style.min.css',
      'js/fancytree/skin-bootstrap/ui.fancytree.min.css', //fancytree
      'js/fancytree/skin-bootstrap/ui.fancytree.less' //fancytree

    ];
    public $js = [
      'js/jquery.geocomplete.min.js',    
      'js/efx.js', //
      'js/js.cookie.js', //gestione dei cookies
      'js/jquery.ask-confirm-on-change.js', //chiede conferma per le modifiche
      'js/jquery.mask.js', //https://igorescobar.github.io/jQuery-Mask-Plugin/
      'js/jquery-ui.min.js',
      'js/bootstrap-toggle.min.js', //toggle button
      'js/fancytree/jquery.fancytree-all.min.js',  //fancytree
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        //'yii\bootstrap\BootstrapPluginAsset', // <- using this instead
    ];

    //con POS_HEAD non funziona il geocoding
    /*public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );*/

}
