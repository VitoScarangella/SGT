<?php

namespace backend\models;
use Yii;

class Userdetails extends \common\models\Userdetails
{

  public function rules()
  {
      return [
          [['roles'], 'string'],
          [['id',  'nome', 'cognome',  ], 'required'],
          [['periodicita', 'id', 'idLingua', 'idProfilo', 'idIvaVendite', 'idCommercialista'], 'integer'],
          [['note','ragioneSociale'], 'string'],
          [['gmail'], 'email', 'message' => 'Indirizzo mail non valido'],
          [['mail'], 'email', 'message' => 'Indirizzo mail non valido'],
          [['pec'], 'email', 'message' => 'Indirizzo mail non valido'],
          [['regime', 'codiceProvincia', 'codiceProvinciaDefault',
            'idModalitaPagamento', 'indirizzo', 'cap', 'dataNascita',
            'lastUpdate', 'created'], 'safe'],

          [['partitaIva'], 'string', 'min' => 11, 'tooShort' => 'Digitare 11 caratteri numerici.'],
          [['partitaIva'], 'string', 'max' => 11, 'tooLong' => 'Digitare 11 caratteri numerici.'],
          [['partitaIva'], 'match', 'pattern' => '/^[0-9]+$/', 'message' => 'Sono ammessi solo caratteri numerici.'],

          //[['codiceFiscale'], 'string', 'min' => 16, 'tooShort' => 'Digitare 16 caratteri.'],
          //[['codiceFiscale'], 'string', 'max' => 16, 'tooLong' => 'Digitare 16 caratteri.'],
          //[['codiceFiscale'], 'match', 'pattern' => '/^[A-Z0-9]+$/', 'message' => 'Sono ammessi solo numeri e lettere'],
          [['codiceFiscale'], 'string', 'max' => 16, 'tooLong' => 'Digitare 16 caratteri.'],

          [['codiceProvincia'], 'string', 'max' => 10],
          [['codiceProvinciaDefault'], 'string', 'max' => 10],
          [['idComune'], 'string', 'max' => 20],
          [['idComuneDefault'], 'string', 'max' => 20],

          [['banca'], 'string', 'max' => 100],
          [['indirizzoBanca'], 'string', 'max' => 200],
          [['iban'], 'string', 'max' => 40],
          [['idCliente'], 'integer'],




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
              'idIvaVendite' => 'Iva Vendite',
            ];
  }

  public static function loadUserData()
	{
    parent::loadUserData_();
    $session = Yii::$app->session;

    //
    $session["isExpert"] = 0;
    if (Tool::hasRole(Tool::SUPERADMIN, $session["masterRoles"])
        )
      {
      $session["isExpert"] = 1;
      }
    //
    if (Tool::hasRole(Tool::SUPERADMIN)
        )
      {
      $session["isExpert"] = 1;
      }
    //
  }


}
