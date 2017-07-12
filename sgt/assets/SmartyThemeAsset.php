<?
namespace backend\assets;
 
use skeeks\template\smarty\SmartyAsset;

/**
 * Class SmartyThemeAsset
 * @package frontend\assets
 */
class SmartyThemeAsset extends SmartyAsset
{
    public $css = [
        'https://fonts.googleapis.com/css?family=Open+Sans:300,400%7CRaleway:300,400,500,600,700%7CLato:300,400,400italic,600,700',
        'css/essentials.css',
        'css/layout.css',
        'css/header-1.css',
        'css/color_scheme/green.css',
    ];
 
    public $js = [
        //'js/scripts.js',
    ];
}
?>