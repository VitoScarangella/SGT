<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property string $lastUpdate
 * @property string $msg
 */
class Tool extends \common\models\Tool
{
  const COMMERCIALISTA = "commercialista";
  const CLIENTE = "cliente";





 	public static function dropdownModalitaPagamentoUtente($idUtente) {
		$connection = \Yii::$app->db;
		$session = Yii::$app->session;
		$dropdown = [];

		$m = $connection->createCommand(
		"select id, modalita, descrizione1, descrizione2 from modalita_pagamento_utente where idUtente= " . $idUtente
		);
		$models = $m->query();
		foreach ($models as $model) {
			$dropdown[$model["id"]] = $model["modalita"] . " " . $model["descrizione1"] . " " . $model["descrizione2"];
		}
		return $dropdown;
	}

 	public static function dropdownModalitaPagamento() {
		$connection = \Yii::$app->db;
		$session = Yii::$app->session;
		$dropdown = [];

		$m = $connection->createCommand(
		"select id, descrizione from modalita_pagamento "
		);
		$models = $m->query();
		foreach ($models as $model) {
			$dropdown[$model["id"]] = $model["descrizione"];
		}
		return $dropdown;
	}

public static function dropdownCategorie() {
		$connection = \Yii::$app->db;
		$session = Yii::$app->session;
		$dropdown = [];

		$m = $connection->createCommand(
		"select id, categoria from csp_categoria "
		);
		$models = $m->query();
		foreach ($models as $model) {
			$dropdown[$model["id"]] = $model["categoria"];
		}
		return $dropdown;
	}

public static function dropdownTipodoc($segno) {
		$connection = \Yii::$app->db;
		$session = Yii::$app->session;
		$dropdown = [];

		$m = $connection->createCommand(
		"select id, descrizione from tipodoc where tipo=0 or tipo=$segno "
		);
		$models = $m->query();
		foreach ($models as $model) {
			$dropdown[$model["id"]] = $model["descrizione"];
		}
		return $dropdown;
	}

  public static function canDeleteUser($idUser) {
    return true;
      $connection = \Yii::$app->db;
  $m = $connection->createCommand(
    "select count(*) conta from gs_evento_user where idUser= " . $idUser);
  $model = $m->queryOne();
      if ($model["conta"]==0) return true;
      else
          return false;
}

}
