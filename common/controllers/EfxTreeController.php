<?php

namespace common\controllers;

use Yii;
use common\models\EfxTree;
use common\models\EfxTreeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;
use yii\helpers\Json;
use yii\data\ArrayDataProvider;
use common\models\Tool;
use Closure;
use Exception;
use yii\db\Exception as DbException;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\base\NotSupportedException;
use yii\web\Response;
use yii\base\InvalidCallException;
use yii\web\View;
use yii\base\Event;
use kartik\tree\TreeView;
use kartik\tree\models\Tree;
use backend\controllers\DocumentaleController;
/**
 * EfxTreeController implements the CRUD actions for EfxTree model.
 */
class EfxTreeController extends \kartik\tree\controllers\NodeController
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
     * Add row in the  Plan.
     * @param integer $id
     * @return mixed
     */
    public function actionAddchild($id)
    {
        $session = Yii::$app->session;

        EfxTree::$tableName = EfxTree::$tableNameTab;
        $modelCurrent = $this->findModel($id);
        $model = new EfxTree;

        $model->name = ".....";
        $model->level = 0;
        $model->order = 0;
        $model->idParent = $id;
        $model->idObj = 0;
        $model->idKey = 0; //da rivedere
        $model->save();

        return "OK"; //$this->redirect(['indexplan']);
    }

    /**
     * Lists all EfxTree models.
     * @return mixed
     */
    public function actionIndex()
    {
      EfxTree::$tableName = EfxTree::$tableNameView;
      $searchModel = new EfxTree;
      $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

      return $this->render('index', [
          'dataProvider' => $dataProvider,
          'searchModel' => $searchModel,
      ]);
    }

    /**
     * Displays a single EfxTree model.
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
     * Creates a new EfxTree model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        EfxTree::$tableName = EfxTree::$tableNameTab;
        $model = new EfxTree;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing EfxTree model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        EfxTree::$tableName = EfxTree::$tableNameTab;
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
          return $this->redirect(['index']);
        } else {
            EfxTree::$tableName = EfxTree::$tableNameView;
            $modelView = $this->findModel($id);
            return $this->render('update', [
              'model' => $model,
              'modelView' => $modelView,
            ]);
        }
    }

    /**
     * Saves a node once form is submitted
     */
    public function actionSave()
    {
        $treeNodeModify = $parentKey = $currUrl = null;
        $modelClass = '\common\models\EfxTree';
        extract(static::getPostData());
        $module = TreeView::module();
        $keyAttr = $module->dataStructure['keyAttribute'];
        $session = Yii::$app->session;
        /**
         * @var Tree $modelClass
         * @var Tree $node
         * @var Tree $parent
         */
        if ($treeNodeModify) {
            $node = new $modelClass;

            $session = Yii::$app->session;
            $sessionKeyType = DocumentaleController::EVENTO;
            $sessionKey  = $session[Yii::$app->params['sessionKey']];
            $node->idKey = $sessionKey;
            $node->idObj = DocumentaleController::OBJ_FOLDER;

            $successMsg = Yii::t('kvtree', 'The node was successfully created.');
            $errorMsg = Yii::t('kvtree', 'Error while creating the node. Please try again later.');
        } else {
            $tag = explode("\\", $modelClass);
            $tag = array_pop($tag);
            $id = $_POST[$tag][$keyAttr];
            $node = $modelClass::findOne($id);

            $successMsg = Yii::t('kvtree', 'Saved the node details successfully.');
            $errorMsg = Yii::t('kvtree', 'Error while saving the node. Please try again later.');
        }
        $node->activeOrig = $node->active;
        $isNewRecord = $node->isNewRecord;
        $loaded = $node->load($_POST);
        if ($treeNodeModify) {
            if ($parentKey == 'root') {
                $node->makeRoot();
            } else {
                $parent = $modelClass::findOne($parentKey);
                $node->appendTo($parent);
            }
        }
        $errors = $success = false;

        $node->removable_all = true;

        if ($node->enabled==0) $node->icon="ban-circle";
        else $node->icon="";

        if ($node->save()) {
            // check if active status was changed
            if (!$isNewRecord && $node->activeOrig != $node->active) {
                if ($node->active) {
                    $success = $node->activateNode(false);
                    $errors = $node->nodeActivationErrors;
                } else {
                    $success = $node->removeNode(true, false); // only deactivate the node(s)
                    $errors = $node->nodeRemovalErrors;
                }
            } else {
                $success = true;
            }
            if (!empty($errors)) {
                $success = false;
                $errorMsg = "<ul style='padding:0'>\n";
                foreach ($errors as $err) {
                    $errorMsg .= "<li>" . Yii::t('kvtree', "Node # {id} - '{name}': {error}", $err) . "</li>\n";
                }
                $errorMsg .= "</ul>";
            }
        } else {
            $errorMsg = '<ul style="margin:0"><li>' . implode('</li><li>', $node->getFirstErrors()) . '</li></ul>';
        }
        $session->set('kvNodeId', $node->$keyAttr);
        if ($success) {
            $session->setFlash('success', $successMsg);
        } else {
            $session->setFlash('error', $errorMsg);
        }
        return $this->redirect($currUrl);
    }

    /**
     * View, create, or update a tree node via ajax
     *
     * @return string json encoded response
     */
    public function actionManage()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        static::checkValidRequest();
        $parentKey = $action = null;
        $modelClass = '\common\models\EfxTree';
        $isAdmin = $softDelete = $showFormButtons = $showIDAttribute = false;
        $currUrl = $nodeView = $formOptions = $formAction = $breadCrumbs = '';
        $iconsList = $nodeAddlViews = [];
        extract(static::getPostData());
        /**
         * @var Tree $modelClass
         * @var Tree $node
         */
        if (!isset($id) || empty($id)) {
            $node = new $modelClass;
            $node->initDefaults();
            $node->idParent = $_REQUEST["parentKey"]=='root'?0:$_REQUEST["parentKey"];

        } else {
            $node = $modelClass::findOne($id);
        }
        $module = TreeView::module();
        $params = $module->treeStructure + $module->dataStructure + [
                'node' => $node,
                'parentKey' => $parentKey,
                'action' => $formAction,
                'formOptions' => empty($formOptions) ? [] : $formOptions,
                'modelClass' => $modelClass,
                'currUrl' => $currUrl,
                'isAdmin' => $isAdmin,
                'iconsList' => $iconsList,
                'softDelete' => $softDelete,
                'showFormButtons' => $showFormButtons,
                'showIDAttribute' => $showIDAttribute,
                'nodeView' => $nodeView,
                'nodeAddlViews' => $nodeAddlViews,
                'breadcrumbs' => empty($breadcrumbs) ? [] :$breadcrumbs,
            ];
        if (!empty($module->unsetAjaxBundles)) {
            Event::on(View::className(), View::EVENT_AFTER_RENDER, function ($e) use ($module) {
                foreach ($module->unsetAjaxBundles as $bundle) {
                    unset($e->sender->assetBundles[$bundle]);
                }
            });
        }
        $callback = function () use ($nodeView, $params) {
            return $this->renderAjax($nodeView, ['params' => $params]);
        };
        return self::process(
            $callback,
            Yii::t('kvtree', 'Error while viewing the node. Please try again later.'),
            null
        );
    }

    /**
     * Updates an existing EfxTree model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateajax()
    {
        $id = $_REQUEST['expandRowKey'];
        EfxTree::$tableName = EfxTree::$tableNameView;
        $modelView = $this->findModel($id);
        EfxTree::$tableName = EfxTree::$tableNameTab;
        $model = $this->findModel($id);


        return $this->renderAjax('_form', [
            'model' => $model,
            'modelView' => $modelView,
        ]);


    }


    /**
     * Updates an existing EfxTree model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdatedet($id)
    {
        EfxTree::$tableName = EfxTree::$tableNameTab;
        $model = $this->findModel($id);
        $model->load(Yii::$app->request->post());
        $model->save();
        return 1;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing EfxTree model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        EfxTree::$tableName = EfxTree::$tableNameView; //per avere il campo leafs
        $model = $this->findModel($id);
        $todel = $model->leafs;
        $ar = split(',',$todel);
        EfxTree::$tableName = EfxTree::$tableNameTab;
        foreach ($ar as $key => $value) {
          if (trim($value)=='') continue;
          $m = $this->findModel($value);
          $m->delete();
        }
        $model = $this->findModel($id);
        $model->delete();

        return "OK";
    }


    public function actions()
    {
        //EfxTree::$tableName = EfxTree::$tableNameTab;
        $ar = ArrayHelper::merge(parent::actions(), [
            'editinline' => [                                       // identifier for your editable action
                'class' => EditableColumnAction::className(),       // action class name
                'modelClass' => EfxTree::className(), // the update model class
                'postOnly' => true,
                'ajaxOnly' => true,
            ]
        ]);
        return $ar;
   }


    public function actionReportExcel() {
        $this->layout='ajax';
        Tool::buildExcel('SELECT * from ' . EfxTree::tableName(),
                         (new EfxTree())->attributeLabels(),
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

    public function actionInsertrowroot($idObj, $idKey=0){
      $session = Yii::$app->session;
      EfxTree::$tableName = EfxTree::$tableNameTab;

      $model = new EfxTree;
      $model->name = "[...]";
      $model->idParent=0;
      $model->level=0;
      $model->idObj = $idObj;
      $model->idKey = $idKey;

      $model->save();

      return "OK";
  }

    public function actionInsertrows($id, array $rows){
        $session = Yii::$app->session;
        EfxTree::$tableName = EfxTree::$tableNameTab;
        $modelStart = $this->findModel($id);

        $request = Yii::$app->request;
        foreach ($rows as $row) {
             $model = new EfxTree;
             $modelCopy = $this->findModel($row);

             $model->idParent    = $id;
             $model->idObj       = $modelCopy->idObj;
             $model->idKey       = $modelCopy->idKey;
             $model->order       = $modelCopy->order;
             $model->name        = $modelCopy->name;
             $model->level       = $modelCopy->level;
             $model->save();
        }
        return "OK";
    }

    public function actionInsertrowstree($id, array $rows){
        $session = Yii::$app->session;
        EfxTree::$tableName = EfxTree::$tableNameTab;
        $modelStart = $this->findModel($id);

        $request = Yii::$app->request;
        foreach ($rows as $row) {
             $model = new EfxTree;
             $modelCopy = $this->findModel($row);

             $model->idParent    = $id;
             $model->idObj       = $modelCopy->idObj;
             $model->idKey       = $modelCopy->idKey;
             $model->order       = $modelCopy->order;
             $model->name        = $modelCopy->name;
             $model->level       = $modelCopy->level;
             $model->save();
        }
        return "OK";
    }


    ///////////////////////////////////////////////////////////////////
    // actionRefreshtree
    ///////////////////////////////////////////////////////////////////
    public function actionRefreshtree()
    {
      DocumentaleController::loaddefault();
      $this->redirect(['index',]);
    }

    ///////////////////////////////////////////////////////////////////
    // actionRefreshgdrive
    ///////////////////////////////////////////////////////////////////
    public function actionRefreshgdrive()
    {
        $session = Yii::$app->session;
        $sessionKeyType = DocumentaleController::EVENTO;
        $sessionKey = $session[Yii::$app->params['sessionKey']];

        $drive = DocumentaleController::checkGDrive();

        $folders = $drive->searchFolder($session['eventotitolo'], "", $sessionKeyType, $sessionKey);
        $this->redirect(['index',]);
    }

    ///////////////////////////////////////////////////////////////////
    // actionRefreshgdrivefolder
    ///////////////////////////////////////////////////////////////////
    public function actionRefreshgdrivefolder($folder)
    {
        $session = Yii::$app->session;
        $sessionKeyType = DocumentaleController::EVENTO;
        $sessionKey = $session[Yii::$app->params['sessionKey']];


        $drive = DocumentaleController::checkGDrive("",$folder);

        $folders = $drive->searchFolder($session['eventotitolo'], "", $sessionKeyType, $sessionKey);
        $this->redirect(['index',]);
    }


    function buildTree($elements, $IDP, $ID, $NAME)
    {
      $idP=-1;
      $nameP=-1;
      $result=array();
      foreach ($elements as $key => $elem) {
        if ($elem[$IDP]!=$idP)
            {
              $result[$elem[$NAME]] = array();
            }
        else
        {
        //  $result[$elem[$NAME]] = array();
        }
        //  $result[$elem[$NAME]] = array();

        $idP=$elem[$ID];
        $nameP=$elem[$NAME];
        //$last=
        }
        return $result;
    }


    public function actionDeleteselected(array $rows){

        EfxTree::$tableName = EfxTree::$tableNameTab;
        $request = Yii::$app->request;
        foreach ($rows as $row) {
            $this->actionDelete($row); //cancello anche i figli
            //$model = $this->findModel($row);
            //$model->delete();
        }
        return "OK";
        //     return $this->actionIndexplan();
     }

    /**
     * Finds the EfxTree model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EfxTree the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EfxTree::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
