<?php

namespace backend\controllers;

use Yii;
use backend\models\Positions;
use backend\models\PositionsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PositionsController implements the CRUD actions for Positions model.
 */
class PositionsController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Positions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PositionsSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Positions model.
     * @param string $accountId
     * @param string $ticker
     * @param string $positionId
     * @param string $wideOrderId
     * @return mixed
     */
    public function actionView($accountId, $ticker, $positionId, $wideOrderId)
    {
        $model = $this->findModel($accountId, $ticker, $positionId, $wideOrderId);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->accountId]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new Positions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Positions;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'accountId' => $model->accountId, 'ticker' => $model->ticker, 'positionId' => $model->positionId, 'wideOrderId' => $model->wideOrderId]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Positions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $accountId
     * @param string $ticker
     * @param string $positionId
     * @param string $wideOrderId
     * @return mixed
     */
    public function actionUpdate($accountId, $ticker, $positionId, $wideOrderId)
    {
        $model = $this->findModel($accountId, $ticker, $positionId, $wideOrderId);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'accountId' => $model->accountId, 'ticker' => $model->ticker, 'positionId' => $model->positionId, 'wideOrderId' => $model->wideOrderId]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Positions model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $accountId
     * @param string $ticker
     * @param string $positionId
     * @param string $wideOrderId
     * @return mixed
     */
    public function actionDelete($accountId, $ticker, $positionId, $wideOrderId)
    {
        $this->findModel($accountId, $ticker, $positionId, $wideOrderId)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Positions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $accountId
     * @param string $ticker
     * @param string $positionId
     * @param string $wideOrderId
     * @return Positions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($accountId, $ticker, $positionId, $wideOrderId)
    {
        if (($model = Positions::findOne(['accountId' => $accountId, 'ticker' => $ticker, 'positionId' => $positionId, 'wideOrderId' => $wideOrderId])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
