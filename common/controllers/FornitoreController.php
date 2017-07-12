<?php

namespace common\controllers;

use Yii;
use common\models\Fornitore;
use common\models\FornitoreSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;
use yii\helpers\Json;

use common\models\Tool;
/**
 * FornitoreController implements the CRUD actions for Fornitore model.
 */
class FornitoreController extends Controller
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
     * Lists all Fornitore models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FornitoreSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('@common/views/fornitore/index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Fornitore model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('@common/views/fornitore/view', ['model' => $model]);
        }
    }

    /**
     * Creates a new Fornitore model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Fornitore;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('@common/views/fornitore/create', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Updates an existing Fornitore model.
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
            return $this->render('@common/views/fornitore/update', [
                'model' => $model,
            ]);
        }
    }



    /**
     * @param integer $id
     * @return mixed
     */
    public function actionViewext($id)
    {
        $model = $this->findModel($id);

        return $this->render('@common/views/fornitore/viewext', [
            'model' => $model,
        ]);


    }

    /**
     * Deletes an existing Fornitore model.
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
        //Fornitore::$tableName = Fornitore::$tableNameTab;
        $ar = ArrayHelper::merge(parent::actions(), [
            'editinline' => [                                       // identifier for your editable action
                'class' => EditableColumnAction::className(),       // action class name
                'modelClass' => Fornitore::className(), // the update model class
                'postOnly' => true,
                'ajaxOnly' => true,
            ]
        ]);
        return $ar;
   }


    public function actionReportExcel() {
        $this->layout='ajax';
        Tool::buildExcel('SELECT * from ' . Fornitore::tableName(),
                         (new Fornitore())->attributeLabels(),
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
     * Finds the Fornitore model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Fornitore the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Fornitore::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
