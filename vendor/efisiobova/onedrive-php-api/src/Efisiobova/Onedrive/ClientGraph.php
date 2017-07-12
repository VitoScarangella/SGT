<?php

namespace Efisiobova\Onedrive;
use Yii;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

/**
 * @class Client
 *
 * A Client instance allows communication with the OneDrive API and perform
 * operations programmatically.

 */
class ClientGraph
{
  const ITEMS = 'drive/items';
  const THE_ROOT = 'drive/root';
  const CHILDREN = '/children'; //self::THE_ROOT;

  //FREE
  /*
  define("LC_CLIENT_ID", "56d7d15e-29b5-46cc-99a9-1de6326c3f86");
  define("LC_CLIENT_SECRET", "Qupso8KuuhA6M4nYHsYYBwE");
  define("LC_CALLBACK_URL", "https://localhost/index.php?r=documentale/testms");
  //BIZ
  define("LC_CLIENT_ID", "18665388-d1a4-4619-92f1-ef800bb1812d");
  define("LC_CLIENT_SECRET", "Dmvgx7wTFUvgeWHsDt6PG3A");
  define("LC_CALLBACK_URL", "https://localhost/index.php?r=documentale/testms");
  */
  //Office 365
  const CLIENT_ID = '18665388-d1a4-4619-92f1-ef800bb1812d';
  const CLIENT_SECRET = 'Dmvgx7wTFUvgeWHsDt6PG3A';
  const REDIRECT_URI = 'https://localhost/ms.php';

  const SCOPES='openid  user.read mail.send Files.Read Files.Read.All Files.ReadWrite Directory.ReadWrite.All Directory.AccessAsUser.All'; //profile Files.Read Files.Read.All
  //const SCOPES= 'profile openid email offline_access https://graph.microsoft.com/User.Read ' .
  //                           'https://graph.microsoft.com/Mail.Send ';


  const AUTHORITY_URL = 'https://login.microsoftonline.com/common';
  const AUTHORIZE_ENDPOINT = '/oauth2/v2.0/authorize';
  const TOKEN_ENDPOINT = '/oauth2/v2.0/token';
  const RESOURCE_ID = 'https://graph.microsoft.com';
  const SENDMAIL_ENDPOINT = '/v1.0/me/sendmail';
  const RESOURCE_OWNER_DETAILS_ENDPOINT = '/v1.0/me';


  private $_graph = false;

  public function __construct(array $options = array())
  {

  }


  public function init(array $options = array())
  {
    $session = Yii::$app->session;
    $provider = new \League\OAuth2\Client\Provider\GenericProvider([
        'clientId'                => ClientGraph::CLIENT_ID,
        'clientSecret'            => ClientGraph::CLIENT_SECRET,
        'redirectUri'             => ClientGraph::REDIRECT_URI,
        'urlAuthorize'            => ClientGraph::AUTHORITY_URL . ClientGraph::AUTHORIZE_ENDPOINT,
        'urlAccessToken'          => ClientGraph::AUTHORITY_URL . ClientGraph::TOKEN_ENDPOINT,
        'urlResourceOwnerDetails' => ClientGraph::RESOURCE_ID . ClientGraph::RESOURCE_OWNER_DETAILS_ENDPOINT,
        'scopes'                  => ClientGraph::SCOPES
    ]);

    if (isset($_SESSION['access_token']))
    {
    if ($_SESSION['state'] != $provider->getState())
        {
          unset($_SESSION['state']);
          unset($_SESSION['access_token']);
          $_SESSION['state'] = $provider->getState();
          $authorizationUrl = $provider->getAuthorizationUrl();
          header('Location: ' . $authorizationUrl);
          exit();
        }

      $this->initGraph();
      return array(true,"Access Token presente");
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && !isset($_GET['code'])) {
        $authorizationUrl = $provider->getAuthorizationUrl();
        // The OAuth library automaticaly generates a state value that we can
        // validate later. We just save it for now.
        $_SESSION['state'] = $provider->getState();
        header('Location: ' . $authorizationUrl);
        exit();
    } elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['code'])) {
        // Validate the OAuth state parameter
        if (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['state'])) {
            unset($_SESSION['state']);

            $_SESSION['state'] = $provider->getState();
            //echo('State value does not match the one initially sent');
            //return array(false,"State value does not match the one initially sent");
        }
        // With the authorization code, we can retrieve access tokens and other data.
        try {
            // Get an access token using the authorization code grant
            $accessToken = $provider->getAccessToken('authorization_code', [
                'code'     => $_GET['code'],
                //'resource' => ClientBase::RESOURCE_ID
            ]);
            $_SESSION['access_token'] = $accessToken->getToken();

            // The access token is a JWT token that contains information about the user
            // It's a base64 coded string that has a header and payload
            $decodedAccessTokenPayload = base64_decode(
                explode('.', $_SESSION['access_token'])[1]
            );
            $jsonAccessTokenPayload = json_decode($decodedAccessTokenPayload, true);
            // The following user properties are needed in the next page
            $_SESSION['unique_name'] = $jsonAccessTokenPayload['unique_name'];
            $_SESSION['given_name'] = $jsonAccessTokenPayload['given_name'];
            $this->initGraph();
            return array(true,"Access Token creato");
            //header('Location: sendmail.php');
        } catch (\League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
          echo 'Something went wrong, couldn\'t get tokens: ' . $e->getMessage() ;
            print_r($e->getResponseBody());
            return array(false, 'Something went wrong, couldn\'t get tokens: ' . $e->getMessage());

        }
      }
  }

  public function initGraph(array $options = array())
  {
    $session = Yii::$app->session;
    $this->_graph = new Graph();
    $this->_graph
    ->setBaseUrl("https://graph.microsoft.com/")
    ->setApiVersion("V1.0")
    ->setAccessToken($session['access_token']);
  }

  public function fetchRoot(array $options = array())
  {
    $docs = $this->fetchObjects();
    return $docs;
  }

  public function fetchObjects(array $options = array('id'=>'/me/drive/root/children', 'deep'=>true, 'level'=>0))
  {
    /*$docs = $graph->createCollectionRequest("GET", "/me/drive/root/children")
                            ->setReturnType(Model\DriveItem::class)
                            ->setPageSize(1)->execute();*/

     /*$graph->createRequest("PUT", "/me/drive/root/children/befana.jpg/content")
                                  ->upload('D:/befana.jpg');*/
    $docGrabber = $this->_graph->createCollectionRequest("GET", $options["id"])
                            ->setReturnType(Model\DriveItem::class)
                            ->setPageSize(2)
                            ;
    $docs = $docGrabber->getPage();
    $docsall=[];
    foreach ($docs as $key => $doc) {
      $doc->setId( $doc->getProperties()["id"] );//PATCH
      $doc->level = $options["level"];
      $docsall[]=$doc;

      if ($doc->getFolder()!==null && $options["level"]<4)
          {
            \common\models\Tool::logd($doc);
            \common\models\Tool::log($doc->getName()."-".$doc->getId());
            $docs2 = $this->fetchObjects(
                    array(
                         'id'   => '/me/drive/items/'.$doc->getId().'/children', //$doc->getId(),
                         'deep' => true,
                         'level'=> ($options["level"]+1)
                         )
                    );
            foreach ($docs2 as $key2 => $doc2) {
              $doc2->setId( $doc2->getProperties()["id"] );//PATCH
              $docsall[]=$doc2;
            }
          }
      }

    return $docsall;
  }

  public function fetchUser(array $options = array())
  {
      $user = $this->_graph->createRequest("GET", "/me")
                    ->setReturnType(Model\User::class)
                    ->execute();
      return $user;
  }


  public function addPermission(array $options = array('id'=>false))
  {

    $body = array(
        "requireSignIn" => true,
          "sendInvitation" => true,
          "roles" => ["write"],
          "recipients" => [
            ["email" => "efisio.bova@gmail.com"],
            ["email" => "efisio.bova@gmail.com"],
            ["email" => "efisio.bova.biz@outlook.it"],
          ],
          "message" => "ECCOLO22 Here's the document I was talking about yesterday.",
    );

    $res =  $this->_graph->createRequest("POST", "/me/drive/items/".$options["id"]."/invite")
            ->attachBody($body)
            ->execute();

    \common\models\Tool::logd($res);

  }



}
