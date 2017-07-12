<?php

namespace common\models;
use Yii;
use webvimark\modules\UserManagement\models\User;
use common\models\Tool;

class Userdetails extends \yii\db\ActiveRecord
{
  public static $VALIDATION_TYPE = "IT"; //IT/WORLD

    public $_roles = "....";

    //Ruoli dell'utente //EFXERR
    public function getRoles()
    {
        return self::getUserRoles($this->id);
    }


    //Ruoli dell'utente //EFXERR
    public static function getUserRoles($id)
    {
        $s="";
        $connection = \Yii::$app->db;

        $m = $connection->createCommand(
        "select description from user_roles_view where user_id= " . $id);
        $rows = $m->query();
        foreach ($rows as $row) {
            if ($s!="") $s .= ",";
            $s .= $row["description"];
        }
        return $s;
    }

    public static function getUserRolesArray($id)
    {
        $connection = \Yii::$app->db;
        $m = $connection->createCommand(
        "select description from user_roles_view where user_id= " . $id);
        $rows = $m->query();
        $roles=[];
        foreach ($rows as $row) {
            $roles[] = $row["description"];
        }
        return $roles;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        $connection = \Yii::$app->db;
        $session = Yii::$app->session;
        $m = $connection->createCommand("insert into user_details (id,cognome)
        select id,username from user where superadmin=0 and id not in (select id from user_details )")->execute();
        return 'user_details';
    }

    /**
     * @inheritdoc  'dataNascita'
     */
    public function rules()
    {
      if (self::$VALIDATION_TYPE=="IT")
        return [
            [['roles'], 'string'],
            [['id',  'nome', 'cognome',  ], 'required'],
            [['periodicita', 'id', 'idProfilo', 'idCliente', 'idCommercialista', 'idContabile'], 'integer'],
            [['note','ragioneSociale'], 'string'],
            [['gmail'], 'email', 'message' => 'Indirizzo mail non valido'],
            [['mail'], 'email', 'message' => 'Indirizzo mail non valido'],
            [['pec'], 'email', 'message' => 'Indirizzo mail non valido'],
            [['telefonoFisso', 'telefonoCellulare', 'partitaIva', 'codiceFiscale', 'regime', 'codiceProvincia', 'codiceProvinciaDefault', 'idComuneDefault', 'idModalitaPagamento', 'indirizzo', 'cap', 'dataNascita', 'lastUpdate', 'created'], 'safe'],

            [['partitaIva'], 'string', 'min' => 11, 'tooShort' => 'Digitare 11 caratteri numerici.'],
            [['partitaIva'], 'string', 'max' => 11, 'tooLong' => 'Digitare 11 caratteri numerici.'],
            [['partitaIva'], 'match', 'pattern' => '/^[0-9]+$/', 'message' => 'Sono ammessi solo caratteri numerici.'],

            [['codiceFiscale'], 'string', 'min' => 16, 'tooShort' => 'Digitare 16 caratteri.'],
            [['codiceFiscale'], 'string', 'max' => 16, 'tooLong' => 'Digitare 16 caratteri.'],
            [['codiceFiscale'], 'match', 'pattern' => '/^[A-Z0-9]+$/', 'message' => 'Sono ammessi solo numeri e lettere'],

            [['telefonoCellulare', 'telefonoFisso', 'mail', 'gmail', 'nome', 'cognome'], 'string', 'max' => 50],

            [['codiceProvincia'], 'string', 'max' => 10],
            [['codiceProvinciaDefault'], 'string', 'max' => 10],
            [['idComune'], 'string', 'max' => 20],
            [['idComuneDefault'], 'string', 'max' => 20]

        ];
        else
        return [
            [['roles'], 'string'],
            [['id',  'nome', 'cognome',  ], 'required'],
            [['periodicita', 'id', 'idProfilo', 'idCliente'], 'integer'],
            [['note','ragioneSociale'], 'string'],
            [['gmail'], 'email', 'message' => 'Indirizzo mail non valido'],
            [['mail'], 'email', 'message' => 'Indirizzo mail non valido'],
            [['telefonoFisso', 'telefonoCellulare', 'partitaIva', 'codiceFiscale', 'regime', 'codiceProvincia', 'codiceProvinciaDefault', 'idComuneDefault', 'idModalitaPagamento', 'indirizzo', 'cap', 'dataNascita', 'lastUpdate', 'created'], 'safe'],

            [['telefonoCellulare', 'telefonoFisso', 'mail', 'gmail', 'nome', 'cognome'], 'string', 'max' => 50],

            [['codiceProvincia'], 'string', 'max' => 10],
            [['codiceProvinciaDefault'], 'string', 'max' => 10],
            [['idComune'], 'string', 'max' => 20],
            [['idComuneDefault'], 'string', 'max' => 20]

        ];


    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'idLingua' => 'Lingua',
            'idCliente' => 'Cliente',
            'partitaIva' => 'Partita Iva',
            'codiceFiscale' => 'Codice Fiscale',
            'idComune' => 'Comune',
            'idProfilo' => 'idProfilo',
            'note' => 'Note',
            'telefonoCellulare' => 'Telefono Cellulare',
            'telefonoFisso' => 'Telefono Fisso',
            'mail' => 'Mail',
            'gmail' => 'Google Mail',
            'nome' => 'Nome',
            'cognome' => 'Cognome',
            'ragioneSociale' => 'Ragione Sociale',
            'dataNascita' => 'Data Nascita',
            'idCommercialista' => 'Commercialista',
            'idContabile' => 'Contabile',
            'lastUpdate' => 'Last Update',
            'created' => 'Created',
            'codiceProvincia' => 'Provincia',
            'indirizzo' => 'Indirizzp',
            'cap' => 'Cap',
            'roles' => 'Ruoli',
            'codiceProvinciaDefault' => 'Provincia Default',
            'idComuneDefault' => 'Comune Default',
            'periodicita' => 'Periodicita',
            'regime' => 'Regime',
            'idModalitaPagamento' => 'Modalita Pagamento',
        ];
    }

	/**
	 * Dati di dettaglio utente
	 *
	 * @return array
	 */
	public static function loadUserData_()
	{
    	$user = \Yii::$app->user->identity;
      if (empty($user)) return;
    	$connection = \Yii::$app->db;
    	$connection->createCommand("insert ignore into user_details (id) values (" . $user->id . ")")->execute();
    	$sql = "SELECT u.username, u.email, u.status, u.superadmin, ud.*, ci.* FROM user_details ud left  join comuniistat ci on idComune = ci.CodiceComune join user u on ud.id=u.id where u.id=" . $user->id;
      $model = $connection->createCommand($sql);

      $u = $model->queryOne();
    	$session = Yii::$app->session;
      $session["user"] = $u;

    	$model = $connection->createCommand("select item_name, description from auth_assignment a, auth_item i where a.item_name=i.name and user_id=" . $user->id);
      $u = $model->queryAll();
      $session['roles'] = $u;

      //Estraggo i ruoli in formato lista
      $s = Userdetails::getUserRoles($user->id);
      $session['rolesList'] = $s;

      $session["canChangeUser"] = 0;
      //la variabile canChangeUser viene immpostata solo se mi loggo come superadmin
			if (Tool::hasRole(Tool::SWAPUSER) || Tool::hasRole(Tool::SUPERADMIN))
			{
				$session["canChangeUser"] = 1;
				$session["masterUser"] = $session["user"];
				$session["masterRoles"] = $session["roles"];
			}
	}

  /**
	 * Dropdown
	 *
	 * @return array
	 */
	public static function dropdown() {
		$models = static::find()->all();
		foreach ($models as $model) {
			$dropdown[$model->id] = "(" . $model->id . ") " . $model->cognome . " " . $model->nome;
		}
		return $dropdown;
	}

}
