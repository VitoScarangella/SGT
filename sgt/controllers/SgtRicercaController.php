<?php

namespace backend\controllers;

use Yii;
use backend\models\SgtRicerca;
use backend\models\SgtRicercaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;
use yii\helpers\Json;

use common\models\Tool;
/**
 * SgtRicercaController implements the CRUD actions for SgtRicerca model.
 */
class SgtRicercaController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post','get'],
                ],
            ],
        ];
    }

    /**
     * Lists all SgtRicerca models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SgtRicercaSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single SgtRicerca model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('view', ['model' => $model]);
        }
    }

    /**
     * Creates a new SgtRicerca model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SgtRicerca;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Creates a new SgtRicerca model.
     * If creation is successful, the grid will be refreshed.
     * @return mixed
     */
    public function actionCreateDiv()
    {
        $modelNew = new SgtRicerca;
        //$modelNew->idAccount = Yii::$app->user->id;
        //$modelNew->name = "<change this inserted on " . date('Y-m-d h:i:s') . " >";
        $modelNew->save();
        //Tool::logValidate($modelNew);
        return $this->actionIndex();
    }




    /**
     * Updates an existing SgtRicerca model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SgtRicerca model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    public function actions()
    {
        //SgtRicerca::$tableName = SgtRicerca::$tableNameTab;
        $ar = ArrayHelper::merge(parent::actions(), [
            'editinline' => [                                       // identifier for your editable action
                'class' => EditableColumnAction::className(),       // action class name
                'modelClass' => SgtRicerca::className(), // the update model class
                'postOnly' => true,
                'ajaxOnly' => true,
            ]
        ]);
        return $ar;
   }


    public function actionReportExcel() {
        $this->layout='ajax';
        Tool::buildExcel('SELECT * from ' . SgtRicerca::tableName(),
                         (new SgtRicerca())->attributeLabels(),
                         "Excel Report",
                          ['D' => 'dd/mm/yyyy',],
                          [
                            // Dates and datetimes must be converted to Excel format
                            'D' => function ($value, $row, $data) {
                                return \PHPExcel_Shared_Date::PHPToExcel(strtotime($value));
                                },
                          ]
                         );
    }

    /**
     * Finds the SgtRicerca model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SgtRicerca the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SgtRicerca::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
