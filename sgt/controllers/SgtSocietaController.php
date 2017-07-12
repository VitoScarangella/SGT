<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Html;
use backend\models\SgtSocieta;
use backend\models\SgtSocietaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use kartik\grid\EditableColumnAction;
use yii\helpers\Json;
use webvimark\modules\UserManagement\models\User;
use webvimark\modules\UserManagement\models\forms\ConfirmEmailForm;
use common\models\Tool;
/**
 * SgtSocietaController implements the CRUD actions for SgtSocieta model.
 */
class SgtSocietaController extends Controller
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
     * Lists all SgtSocieta models.
     * @return mixed
     */
    public function actionIndexute()
    {
        $searchModel = new SgtSocietaSearch;
        $dataProvider = $searchModel->searchute(Yii::$app->request->getQueryParams());

        return $this->render('indexute', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }


    /**
     * Lists all SgtSocieta models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SgtSocietaSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionGeo()
    {
        $searchModel = new SgtSocietaSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('geo', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }




    /**
     * Displays a single SgtSocieta model.
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
     * Creates a new SgtSocieta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SgtSocieta;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionTakeControl($id)
    {
        $this->layout="external"; //per visualizzare pagina in iframe
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
          $User = $this->handleUser();
          $model->idUser = $User->id;
          $model->save();
          return $this->redirect(['update-after-take', 'id' => $model->id]);
        } else {
            return $this->render('take', [
                'model' => $model,
            ]);
        }
    }

    public function actionTakeUpdate($id)
    {
        $this->layout="external";
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['take-update', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionTakeLogin($id)
    {
      //return $this->redirect(['user-management/auth/login','layout'=>'external']);
      return $this->redirect(['sgt-societa/take-update','id'=>$id]);
    }

    public function actionUpdateAfterTake($id)
    {
      $this->layout="external"; //per visualizzare pagina in iframe
      $model = $this->findModel($id);

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
          return $this->render('updateaftertake', [
              'model' => $model,
          ]);
      } else {
          return $this->render('updateaftertake', [
              'model' => $model,
          ]);
      }

    }


    public function handleUser()
    {
      $user=false;
      if (isset($_REQUEST["SgtSocieta"]))
      {
        $email    = $_REQUEST["SgtSocieta"]["email"];
        $user = User::find()
          ->where(['=', 'username', $email])
          ->one();
        if (empty($user))
            {
            $user = new User();
            $user->password = "provvisoria";
            $user->email = $email;
            $user->username = $email;
            $user->save(false);

            //Se devo richiedere la conferma dell'abilitazione dell'utenza
            /*
            $modelConfirm = new ConfirmEmailForm([
            'email'=>$user->email,
            'user'=>$user,
              ]);
          $modelConfirm->sendEmail(false);
          */

              //Se creo l'utenza abilitata e devo inviare mail di conferma
              Yii::$app->mailer->compose('afterregistration',['user'=>$user ]) // a view rendering result becomes the message body here
                  ->setFrom(Yii::$app->getModule('user-management')->mailerOptions['from'])
                  ->setTo($user->email)
                  ->setSubject('Benvenuto in Sport Grand Tour')
                  ->send();

              User::assignRole($user->id, "SOCIETA");
              Yii::$app->user->login($user);
              $model = new SgtSocieta;
              $model->idUser = $user->id;
            }
         else
            {
               //utente già esistente
               //return $this->redirect(['user-management/auth/login-welcome','layout'=>'external']);
            }
          Yii::$app->user->login($user);

      }
      return $user;

    }



    /**
     * Creates a new SgtSocieta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateStep1()
    {
        $this->layout="external"; //per visualizzare pagina in iframe
        $model = new SgtSocieta;
        $user=false;

        if (isset($_REQUEST["SgtSocieta"]))
        {
    	    $societa  = $_REQUEST["SgtSocieta"]["societa"];
    	    $email    = $_REQUEST["SgtSocieta"]["email"];

    		$user = User::find()
    			->where(['=', 'username', $email])
    			->one();

    	    if (empty($user))
        	    {
        	    $user = new User();
        	    $user->password = "provvisoria";
        	    $user->email = $email;
        	    $user->username = $email;
        		  $user->save(false);

        	    //Se devo richiedere la conferma dell'abilitazione dell'utenza
        	    /*
        	    $modelConfirm = new ConfirmEmailForm([
			        'email'=>$user->email,
			        'user'=>$user,
		            ]);
		        $modelConfirm->sendEmail(false);
		        */

		        //Se creo l'utenza abilitata e devo inviare mail di conferma
                Yii::$app->mailer->compose('afterregistration',['user'=>$user ]) // a view rendering result becomes the message body here
                    ->setFrom(Yii::$app->getModule('user-management')->mailerOptions['from'])
                    ->setTo($user->email)
                    ->setSubject('Benvenuto in Sport Grand Tour')
                    ->send();

          	    User::assignRole($user->id, "SOCIETA");
          	    Yii::$app->user->login($user);
                $model = new SgtSocieta;
                $model->idUser = $user->id;
        	    }
        	 else
        	    {
        	       //utente già esistente
                 return $this->redirect(['user-management/auth/login-welcome','layout'=>'external']);

        	    }
        }

        //EFX-1 passiamo false al metodo salva per bypassare le validazioni che impedirebbero l'inserimento del record
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {

            //EFX-2 se l'inserimento è andato a buon fine richiamiamo actionCreateStep2 passando l'id
            return $this->redirect(['create-step2', 'id' => $model->id]);
        } else {
            return $this->render('createstep1', [
                'model' => $model,
            ]);
        }
    }

    //email e password
    public function actionCreateStep1b()
    {
        $this->layout="external"; //per visualizzare pagina in iframe
        $model = new SgtSocieta;
        $user=false;

        if (isset($_REQUEST["SgtSocieta"]))
        {
    	    $societa  = $_REQUEST["SgtSocieta"]["societa"];
    	    $email    = $_REQUEST["SgtSocieta"]["email"];
    	    $password = $_REQUEST["SgtSocieta"]["password"];

    		$user = User::find()
    			->where(['=', 'username', $email])
    			->one();

    	    if (empty($user))
        	    {
        	    $user = new User();
        	    $user->password = $password;
        	    $user->email = $email;
        	    $user->username = $email;
        		$user->save(false);

        	    User::assignRole($user->id, "SOCIETA");
        	    Yii::$app->user->login($user);
                $model = new SgtSocieta;
        	    }
        	 else
        	    {
        	       Yii::$app->user->login($user);
        	       $model = SgtSocieta::find()
            			->where(['=', 'idUser', $user->id])
            			->one();
            	   if (empty($model))	$model = new SgtSocieta;


        	    }
	    $model->idUser = $user->id;
        }


        //EFX  Inserire controllo di mail già inserita. In questo caso richiedere password e poi redirigere su videata modifica

        //EFX-1 passiamo false al metodo salva per bypassare le validazioni che impedirebbero l'inserimento del record
        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {

            //EFX-2 se l'inserimento è andato a buon fine richiamiamo actionCreateStep2 passando l'id
            return $this->redirect(['create-step2', 'id' => $model->id]);
        } else {
            return $this->render('createstep1b', [
                'model' => $model,
            ]);
            //return $this->redirect('http://www.yiiframework.com');
        }
    }

    public function actionCreateStep2($id)
    {
        $this->layout="external"; //per visualizzare pagina in iframe
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //EFX-3 se anche l'inserimento della seconda parte dei dati è andato a buon fine redirigo verso la pagina di saluto
            return $this->redirect(['create-step3', 'id' => $model->id]);
        } else {
            return $this->render('createstep2', [
                'model' => $model,
            ]);
        }
    }


    public function actionCreateStep3($id)
    {
        $this->layout="external"; //per visualizzare pagina in iframe
        Tool::clear();
        //$model = $this->findModel($id);
        $model = new SgtSocieta;
        Tool::logValidate($model);

        return $this->render('createstep3', [
            'model' => $model]);
    }



    /**
     * Creates a new SgtSocieta model.
     * If creation is successful, the grid will be refreshed.
     * @return mixed
     */
    public function actionCreateDiv()
    {
        $modelNew = new SgtSocieta;
        //$modelNew->idAccount = Yii::$app->user->id;
        //$modelNew->name = "<change this inserted on " . date('Y-m-d h:i:s') . " >";
        $modelNew->save();
        //Tool::logValidate($modelNew);
        return $this->actionIndex();
    }




    /**
     * Updates an existing SgtSocieta model.
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
    public function actionRicerca()
    {
        $this->layout="external";
        return $this->actionRicercaBase();

    }

    public function actionRicercaBase()
    {

      if (!isset($_REQUEST["page"])) $_REQUEST["page"]=1;
      if (!isset($_REQUEST["pagesize"])) $_REQUEST["pagesize"]=10;
      if (!isset($_REQUEST["societa"])) $_REQUEST["societa"]="";
      if (!isset($_REQUEST["comune"])) $_REQUEST["comune"]="";

      $societa=$_REQUEST["societa"];
      $comune = $_REQUEST["comune"];
      $p=$_REQUEST["page"];
      $pagesize=$_REQUEST["pagesize"];

      $session = Yii::$app->session;
      $session["societa"] = $societa;
      $session["comune"] = $comune;
      $session["page"] = $p;



      $searchModel = new SgtSocietaSearch;
      list($dataProvider, $excluded) = $searchModel->searchFull($societa, $comune, $pagesize, $p);


        return $this->render('ricerca1', [
            'societa'=>$societa,
            'comune'=>$comune,
            'excluded'=>$excluded,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);


    }

    /**
     * Deletes an existing SgtSocieta model.
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
        //SgtSocieta::$tableName = SgtSocieta::$tableNameTab;
        $ar = ArrayHelper::merge(parent::actions(), [
            'editinline' => [                                       // identifier for your editable action
                'class' => EditableColumnAction::className(),       // action class name
                'modelClass' => SgtSocieta::className(), // the update model class
                'postOnly' => true,
                'ajaxOnly' => true,
            ]
        ]);
        return $ar;
   }


    public function actionReportExcel() {
        $this->layout='ajax';
        ini_set('memory_limit', '2048M'); //solo per debug

        Tool::buildExcel('SELECT * from ' . SgtSocieta::tableName(),
                         (new SgtSocieta())->attributeLabels(),
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
     * Finds the SgtSocieta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SgtSocieta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SgtSocieta::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
