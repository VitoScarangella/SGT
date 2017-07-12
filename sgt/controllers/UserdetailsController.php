<?php

namespace backend\controllers;

use Yii;
use backend\models\Userdetails;
use backend\models\UserdetailsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\Tool;
use kartik\grid\EditableColumnAction;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;

/**
 * UserdetailsController implements the CRUD actions for Userdetails model.
 */
class UserdetailsController extends Controller
{
public $freeAccess = true;
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['get'],
                ],
            ],
        ];
    }

    /**
     * Lists all Userdetails models.
     * @return mixed
     */
    public function actionIndex()
    {
    		$session = Yii::$app->session;
    		if (!Tool::hasRole(Tool::SUPERADMIN))
    		{
    		$user = \Yii::$app->user->identity;
        return $this->redirect(['update', 'id' => $user->id]);
    		//return $this->actionUpdate($user->id);
    		}


        $searchModel = new UserdetailsSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }




    /**
     * Displays a single Userdetails model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
		$session = Yii::$app->session;
		if (!Tool::hasRole(Tool::SUPERADMIN))
		{
		$user = \Yii::$app->user->identity;
		return $this->actionUpdate($user->id);
		}

        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        return $this->redirect(['view', 'id' => $model->id]);
        } else {
        return $this->render('view', ['model' => $model]);
}
    }

    /**
     * Creates a new Userdetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		$session = Yii::$app->session;
		if (!Tool::hasRole(Tool::SUPERADMIN))
		{
		$user = \Yii::$app->user->identity;
		return $this->actionUpdate($user->id);
		}

        $model = new Userdetails;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Userdetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
    		//Faccio in modo che ci siano sempre tutte le operazioni associate
        $model->validate();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->render('update', [
                'model' => $model, 'esito'=>'ko',
            ]);
        } else {
            return $this->render('update', [
                'model' => $model, 'esito'=>'ko',
            ]);
        }
    }

    /**
     * Deletes an existing Userdetails model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
  		$session = Yii::$app->session;
  		if (!Tool::hasRole(Tool::SUPERADMIN))
  		{
  		$user = \Yii::$app->user->identity;
  		return $this->actionUpdate($user->id);
  		}
      $this->findModel($id)->delete();

      return $this->redirect(['index']);
    }

    public function actions()
    {
        //Userdetails::$tableName = Userdetails::$tableNameTab;
        $ar = ArrayHelper::merge(parent::actions(), [
            'editinline' => [                                      // identifier for your editable action
                'class' => EditableColumnAction::className(),      // action class name
                'modelClass' => Userdetails::className(), // the update model class
                'postOnly' => true,
                'ajaxOnly' => true,
            ]
        ]);
        return $ar;
   }


    public function actionReportExcel() {
        $this->layout='ajax';
        Tool::buildExcel('SELECT * from ' . Userdetails::tableName(),
                         (new Userdetails())->attributeLabels(),
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
     * Finds the Userdetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Userdetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Userdetails::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
