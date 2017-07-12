<?php

namespace common\controllers;

use Yii;
use common\models\EfxUserParams;
use common\models\EfxUserParamsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;
use yii\helpers\Json;

use common\models\Tool;
/**
 * EfxUserParamsController implements the CRUD actions for EfxUserParams model.
 */
class EfxUserParamsController extends Controller
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
     * Lists all EfxUserParams models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EfxUserParamsSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Lists all EfxUserParams models.
     * @return mixed
     */
    public function actionIndexupd($id)
    {
        $connection = \Yii::$app->db;
        $sql = "insert ignore into efx_user_params (idUser, param, value) select $id,param,'' from efx_params ";
        $m = $connection->createCommand($sql)->execute();
        $sql = "delete from  efx_user_params  where param not in (select param from efx_params) ";
        $m = $connection->createCommand($sql)->execute();

        $searchModel = new EfxUserParamsSearch;
        $dataProvider = $searchModel->searchById($id);

        return $this->render('indexupd', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }



    /**
     * Displays a single EfxUserParams model.
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
     * Creates a new EfxUserParams model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EfxUserParams;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing EfxUserParams model.
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
     * Deletes an existing EfxUserParams model.
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
        //EfxUserParams::$tableName = EfxUserParams::$tableNameTab;
        $ar = ArrayHelper::merge(parent::actions(), [
            'editinline' => [                                       // identifier for your editable action
                'class' => EditableColumnAction::className(),       // action class name
                'modelClass' => EfxUserParams::className(), // the update model class
                'postOnly' => true,
                'ajaxOnly' => true,
            ]
        ]);
        return $ar;
   }


    public function actionReportExcel() {
        $this->layout='ajax';
        Tool::buildExcel('SELECT * from ' . EfxUserParams::tableName(),
                         (new EfxUserParams())->attributeLabels(),
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
     * Finds the EfxUserParams model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EfxUserParams the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EfxUserParams::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
