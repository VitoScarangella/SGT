<?php

namespace backend\controllers;

use Yii;
use backend\models\Tool;
use backend\models\ToolSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * ToolController implements the CRUD actions for Tool model.
 */
class ToolController extends \common\controllers\ToolController
{


  public function actionPorting()
  {

      return $this->render('porting', [
      ]);
  }


}
