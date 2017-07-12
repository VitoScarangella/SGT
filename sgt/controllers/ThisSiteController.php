<?php

namespace backend\controllers;

use Yii;
use backend\models\Tool;
use backend\models\ToolSearch;
use backend\models\ZzigtoAccount;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use kartik\tabs\TabsX;
use webvimark\modules\UserManagement\UserManagementModule;
/**
 * Specifico per il sito corrente.
 */
class ThisSiteController extends Controller
{

  /*
  * beforeLogin
  */
  public static function beforeLogin()
  {
    $session = Yii::$app->session;
    $session["isExpert"] = 0;
    unset($session["masterRoles"]);
    unset($session["masterUser"]);
  }

  /*
  * afterLogin
  */
  public static function afterLogin()
  {
  \backend\models\Userdetails::loadUserData();
  }

  /*
  * beforeLogout
  */
  public static function beforeLogout()
  {
    $session = Yii::$app->session;
    $session["isExpert"] = 0;
    unset($session["masterRoles"]);
    unset($session["masterUser"]);
    unset($session["user"]);
    unset($session["canChangeUser"]);
    unset($session["esercizio"]);
  }

  /*
  * afterLogout
  */
  public static function afterLogout()
  {
  $session = Yii::$app->session;
  $session["isExpert"] = 0;
  unset($session["masterRoles"]);
  unset($session["masterUser"]);
  unset($session["user"]);
  unset($session["canChangeUser"]);
  unset($session["esercizio"]);
  }


public static function footerFornitore($model)
{

}

public static function canDeleteUser(\webvimark\modules\UserManagement\models\User  $user)
{
  return true; //Tool::canDeleteUser($user->id);
}


public static function beforeUserDelete($caller, \webvimark\modules\UserManagement\models\User  $user)
{

  //EFX Aggiungo cancellazione dei dettagli
  $userDetails = \common\models\Userdetails::find()->where(['=', "id", $user->id])->one();
  if (!empty($userDetails)) $userDetails->delete();

}

public static function afterUserSave(
  \webvimark\modules\UserManagement\models\User  $user)
{
    ////////////////////////////////////////////////////
    // USERDETAILS
    ////////////////////////////////////////////////////
    \common\models\Userdetails::$VALIDATION_TYPE="WORLD";
    $userDetails = \common\models\Userdetails::find()->where(['=', "id", $user->id])->one();

    if (empty($userDetails)) $userDetails = new \common\models\Userdetails;

    $userDetails->id = $user->id;
    if (trim($userDetails->mail)=="") $userDetails->mail = $user->email;
    if (trim($userDetails->nome)=="") $userDetails->nome = $user->username;
    if (trim($userDetails->cognome)=="") $userDetails->cognome = $user->username;
    $userDetails->save();
}

public static function afterUserInsert(
  $caller,
  \webvimark\modules\UserManagement\models\User  $user)
{
    ////////////////////////////////////////////////////
    // USERDETAILS
    ////////////////////////////////////////////////////
    \common\models\Userdetails::$VALIDATION_TYPE="WORLD";
    $userDetails = \common\models\Userdetails::find()->where(['=', "id", $user->id])->one();

    if (empty($userDetails)) $userDetails = new \common\models\Userdetails;

    $userDetails->id = $user->id;
    $userDetails->mail = $user->email;
    $userDetails->nome = $caller->nome;
    $userDetails->cognome = $caller->cognome;
    $userDetails->ragioneSociale = $caller->ragioneSociale;
    $userDetails->codiceFiscale = $caller->codiceFiscale;
    $userDetails->partitaIva = $caller->partitaIva;
    $userDetails->idProfilo = $caller->idProfilo;
    $userDetails->save();

    ////////////////////////////////////////////////////
    // CLIENTE
    ////////////////////////////////////////////////////
    $cliente = new \common\models\Cliente();
    if ( empty($userDetails->ragioneSociale) || trim($userDetails->ragioneSociale)=="")
       $cliente->ragioneSociale = $userDetails->nome . " " . $userDetails->cognome;
    else
       $cliente->ragioneSociale = $userDetails->ragioneSociale;

    //:trim($userdetails->ragioneSociale);
    $cliente->piva = $userDetails->partitaIva;
    $cliente->cf = $userDetails->codiceFiscale;
    $cliente->idUtente = $userDetails->id;
    $isValid = Tool::logValidate($cliente);

    if (!$isValid)
      {
        $caller->addError('nome', "Errore in fase di creazione del cliente:" . print_r($cliente->getErrors(),true));
        return false;
      }

    $cliente->save();
    $userDetails->idCliente=$cliente->id;
    $userDetails->save();

}

}
