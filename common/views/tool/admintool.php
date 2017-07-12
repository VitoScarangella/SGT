<?
use common\models\Tool;
$itemsadmin = [];
if (Tool::hasRole(Tool::SUPERADMIN))
  $itemsadmin = [
      [
      'label' => '<span class="fa fa-file-text"></span> Admin Tool',
      'items'=>[
        [
        'label' => 'Db',
        'url' => 'adminer-4.2.5-mysql-en.php',
        'linkOptions' => ['target'=>'blank_db', 'template'=> '<a href="{url}" target="blank_db">...{label}</a>']
      ,  'template'=> '<a href="{url}" target="blank_db">...{label}</a>'
        ],
        [
        'label' => 'Log',
        'url' => ['/tool/log', 'title'=>'Log'],
        'linkOptions' => ['data-method' => 'post', 'target'=>'blank_log'],
        ],
        [
        'label' => 'Crud',
        'url' => ['gii/default/view', 'id'=>'kartikgii-crud'],
        'linkOptions' => ['data-method' => 'post', 'target'=>'blank_crud']
        ],
        [
        'label' => 'Model',
        'url' => ['gii/default/view', 'id'=>'model'],
        'linkOptions' => ['data-method' => 'post', 'target'=>'blank_model']
        ],
        [
        'label' => 'Combo',
        'url' => ['/tool-combo' ],
        'linkOptions' => ['data-method' => 'post', 'target'=>'blank_combo']
        ],
        [
        'label' => 'Tipo Template',
        'url' => ['/efx-tipo-template' ],
        'linkOptions' => ['data-method' => 'post', 'target'=>'blank_combo']
        ],
        [
        'label' => 'Template',
        'url' => ['/efx-template' ],
        'linkOptions' => ['data-method' => 'post', 'target'=>'blank_combo']
        ],
        [
        'label' => '<span class="fa fa-gears"></span> To Do',
        'url' => ['/todo/index'], 'linkOptions' => ['data-method' => 'post']
        ],
        [
        'label' => '<span class="fa fa-gears"></span> DB HELP',
        'url' => ['/tool/dbhelp'], 'linkOptions' => ['data-method' => 'post']
        ],
        [
        'label' => '<span class="fa fa-gears"></span> DB Compare',
        'url' => ['/tool/dbcompare'], 'linkOptions' => ['data-method' => 'post']
        ],

      ],
  ],

  ];
?>
