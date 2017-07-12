<?php

namespace common\controllers;

use Yii;
use common\models\ToolCombo;
use common\models\ToolComboSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;
use yii\helpers\Json;

use common\models\Tool;
/**
 * ToolComboController implements the CRUD actions for ToolCombo model.
 */
class ToolComboController extends Controller
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
     * Lists all ToolCombo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ToolComboSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('@common/views/tool-combo/index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single ToolCombo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('@common/views/tool-combo/view', ['model' => $model]);
        }
    }

    /**
     * Creates a new ToolCombo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ToolCombo;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('@common/views/tool-combo/create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ToolCombo model.
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
            return $this->render('@common/views/tool-combo/update', [
                'model' => $model,
            ]) . "
            <hr>
            <b>INDEX</b><br>
            <pre>
            Tool::buildEditableColumnCombo('$model->key_id', 'editinline', Tool::dropdown('$model->field_table','$model->field_id','$model->field_descr'), false, '30%', '..'),
            </pre>

            <br><br><b>FORM</b><br>
            <pre>
              [
              'columns'=>1,
          		'attributes' => [
                '$model->key_id'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\Select2','options'=>[
                  'data'=>Tool::dropdown('$model->field_table','$model->field_id','$model->field_descr')
                  ]],
                ]
              ],
            </pre>
            <hr>
            <pre>
              [
              'columns'=>1,
          		'attributes' => [
                '$model->key_id'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\Select2','options'=>[
                  'data'=>Tool::dropdownYN()
                  ]],
                ]
              ],
            </pre>
            <hr>
            <pre>
              [
              'columns'=>1,
          		'attributes' => [
                '$model->key_id'=>['type'=> Form::INPUT_WIDGET, 'widgetClass'=>'\kartik\widgets\Select2','options'=>[
                  'data'=>['0'=>'modificare...','1'=>'modificare...',]
                  ]],
                ]
              ],
            </pre>
            <hr>
            <pre>

          [
        		'columns'=>1,
        		'attributes' => [
        			'$model->key_id'=>['type'=> Form::INPUT_TEXT,
        					'options'=>['placeholder'=>'...', 'maxlength'=>16,
        					'style'=>'width:190px;',  'type'=>'number',
        					]
        				],
        			]
        		]
            </pre>
            <hr>
            <pre>
            [
                'class'=>'kartik\grid\EditableColumn',
                'attribute'=>'publish_date',
                'hAlign'=>'center',
                'vAlign'=>'middle',
                'width'=>'9%',
                'format'=>'date',
                'xlFormat'=>\"mmm\\-dd\\, \\-yyyy\",
                'headerOptions'=>['class'=>'kv-sticky-column'],
                'contentOptions'=>['class'=>'kv-sticky-column'],
                'readonly'=>function(\$model, \$key, \$index, \$widget) {
                    return (!\$model->status); // do not allow editing of inactive records
                },
                'editableOptions'=>[
                    'header'=>'Data',
                    'size'=>'md',
                    'inputType'=>\\kartik\\editable\\Editable::INPUT_WIDGET,
                    'widgetClass'=> 'kartik\\datecontrol\\DateControl',
                    'options'=>[
                        'type'=>\\kartik\\datecontrol\\DateControl::FORMAT_DATE,
                        'displayFormat'=>'dd.MM.yyyy',
                        'saveFormat'=>'php:Y-m-d',
                        'options'=>[
                            'pluginOptions'=>[
                                'autoclose'=>true
                            ]
                        ]
                    ]
                ],
            ],


            </pre>


            <hr>

            "
            ;
        }
    }

    /**
     * Deletes an existing ToolCombo model.
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
        //ToolCombo::$tableName = ToolCombo::$tableNameTab;
        $ar = ArrayHelper::merge(parent::actions(), [
            'editinline' => [                                       // identifier for your editable action
                'class' => EditableColumnAction::className(),       // action class name
                'modelClass' => ToolCombo::className(), // the update model class
                'postOnly' => true,
                'ajaxOnly' => true,
            ]
        ]);
        return $ar;
   }


    public function actionReportExcel() {
        $this->layout='ajax';
        Tool::buildExcel('SELECT * from ' . ToolCombo::tableName(),
                         (new ToolCombo())->attributeLabels(),
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
     * Finds the ToolCombo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ToolCombo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ToolCombo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
