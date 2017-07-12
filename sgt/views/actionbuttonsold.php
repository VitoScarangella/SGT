<?
use yii\helpers\Url;
use yii\helpers\Html;
use kartik\icons\Icon;
return
[
	'view' => function ($url, $model) {
		$options = [
			'title' => Yii::t('yii', 'Dettaglio'),
			'aria-label' => Yii::t('yii', 'Dettaglio'),
			'data-pjax' => '0',
		];
		return Html::a('<span class="glyphicon glyphicon-eye-open fa-2x"></span>', $url, $options);
	},
	'update' => function ($url, $model) {
		$options = [
			'title' => Yii::t('yii', 'Modifica'),
			'aria-label' => Yii::t('yii', 'Modifica'),
			'data-pjax' => '0',
		];
		return Html::a('<span class="glyphicon glyphicon-pencil fa-2x"></span>', $url, $options);
	},
	'delete' => function ($url, $model) {
		$options = [
			'title' => Yii::t('yii', 'Cancella'),
			'aria-label' => Yii::t('yii', 'Cancella'),
			'data-pjax' => '0',
		];
		return Html::a('<span class="glyphicon glyphicon-trash fa-2x"></span>', $url, $options);
	},
];

?>