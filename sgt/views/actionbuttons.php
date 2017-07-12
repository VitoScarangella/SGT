<?
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\icons\Icon;
use webvimark\modules\UserManagement\components\GhostHtml;
return
[
	'view' => function ($url, $model, $key) {
		$options = [
			'title' => Yii::t('yii', 'Dettaglio'),
			'aria-label' => Yii::t('yii', 'Detail'),
		];
		return GhostHtml::a('<span class="glyphicon glyphicon-eye-open fa-2x"></span>',
                            [Yii::$app->controller->id."/update", 'id' => $key], $options);

	},
	'update_blank' => function ($url, $model, $key) {
		$options = [
			'title' => Yii::t('yii', 'Modifica'),
			'aria-label' => Yii::t('yii', 'Update'),
			'target'=>'_NEW',
			'data-pjax'=>'0'
		];
		return GhostHtml::a('<span class="glyphicon glyphicon-pencil fa-2x"></span>',
                            [Yii::$app->controller->id."/update", 'id' => $key, ], $options);
	},
	'update' => function ($url, $model, $key) {
		$options = [
			'title' => Yii::t('yii', 'Modifica'),
			'aria-label' => Yii::t('yii', 'Update'),
		];
		return GhostHtml::a('<span class="glyphicon glyphicon-pencil fa-2x"></span>',
                            [Yii::$app->controller->id."/update", 'id' => $key, ], $options);
	},
	'delete' => function ($url, $model, $key) {
		$options = [
			'title' => Yii::t('yii', 'Cancella'),
			'aria-label' => Yii::t('yii', 'Delete'),
			'data-pjax' => '#ajaxCrudDatatable1',
      'data-confirm' => \Yii::t('yii', 'Are you sure to delete this item?'),
		];

		return GhostHtml::a('<span class="glyphicon glyphicon-trash fa-2x"></span>',
                            [Yii::$app->controller->id."/delete", 'id' => $key], $options);
	},
];

?>
