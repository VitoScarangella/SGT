<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\SocietaForm;

class ClienteTempController extends Controller
{

    public function actionEntry()
    {
        $model = new SocietaForm();

            return $this->render('formTemp', ['model' => $model]);

    }
}
