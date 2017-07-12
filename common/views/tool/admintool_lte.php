<?
use common\models\Tool;
$itemsadmin = [];
if (Tool::hasRole(Tool::SUPERADMIN))
  $itemsadmin = [
      [
      'label' => 'Admin Tool',
      'items'=>[
        [
        'label' => 'Db',
        'icon' => 'fa fa-gears',
        'url' => 'adminer-4.2.5-mysql-en.php',
        'linkOptions' => ['target'=>'blank_db', 'template'=> '<a href="{url}" target="blank_db">...{label}</a>'],
         'template'=> '<a href="{url}" target="blank_db">{label}</a>'
        ],
        [
        'label' => 'Log',
        'icon' => 'fa fa-gears',
        'url' => ['/tool/log', 'title'=>'Log'],
        'linkOptions' => ['data-method' => 'post', 'target'=>'blank_log'],
        ],
        [
        'label' => 'Crud',
        'icon' => 'fa fa-gears',
        'url' => ['gii/default/view', 'id'=>'kartikgii-crud'],
        'linkOptions' => ['data-method' => 'post', 'target'=>'blank_crud']
        ],
        [
        'label' => 'Model',
        'icon' => 'fa fa-gears',
        'url' => ['gii/default/view', 'id'=>'model'],
        'linkOptions' => ['data-method' => 'post', 'target'=>'blank_model']
        ],
        [
        'label' => 'Combo',
        'icon' => 'fa fa-gears',
        'url' => ['/tool-combo' ],
        'linkOptions' => ['data-method' => 'post', 'target'=>'blank_combo']
        ],
        [
        'label' => 'Tipo Template',
        'icon' => 'fa fa-gears',
        'url' => ['/efx-tipo-template' ],
        'linkOptions' => ['data-method' => 'post', 'target'=>'blank_combo']
        ],
        [
        'label' => 'Template',
        'icon' => 'fa fa-gears',
        'url' => ['/efx-template' ],
        'linkOptions' => ['data-method' => 'post', 'target'=>'blank_combo']
        ],
        [
        'label' => ' To Do',
        'icon' => 'fa fa-gears',
        'url' => ['/todo/index'], 'linkOptions' => ['data-method' => 'post']
        ],
        [
        'label' => ' DB HELP',
        'icon' => 'fa fa-gears',
        'url' => ['/tool/dbhelp'], 'linkOptions' => ['data-method' => 'post']
        ],
        [
        'label' => ' DB Compare',
        'icon' => 'fa fa-gears',
        'url' => ['/tool/dbcompare'], 'linkOptions' => ['data-method' => 'post']
        ],

      ],
  ],

  ];
?>
