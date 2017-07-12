<?php

namespace backend\models;

use Yii;
use backend\models\Tool;
/**
 * This is the model class for table "sgt_societa".
 *
 * @property integer $id
 * @property string $ente
 * @property string $societa
 * @property integer $numeroIscrizioneEnte
 * @property string $dataIscrizioneEnte
 * @property string $codiceFiscale
 * @property string $regione
 * @property string $affiliazione
 * @property string $codiceAffiliazione
 * @property string $tipoSocieta
 * @property string $cap
 * @property string $comune
 * @property string $provincia
 * @property string $password
 * @property string $referente
 * @property string $url
 * @property string $telefono1
 * @property string $telefono2
 */
class SgtSocieta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sgt_societa';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //'regione','password',
            //[['ente', 'societa', 'numeroIscrizioneEnte', 'dataIscrizioneEnte', 'codiceFiscale', 'regione', 'affiliazione', 'codiceAffiliazione', 'tipoSocieta','indirizzo', 'cap', 'comune', 'provincia', 'password', 'referente', 'telefono1', 'email'], 'required'],
            [['societa',    'indirizzo',   'comune', 'provincia',   ], 'required'],//'telefono1', 'email'
            [['legale_indirizzo', 'legale_comune', 'legale_provincia',   'legale_cap'], 'string'],
            [['societa'], 'string'],
            [['idUser', 'numeroIscrizioneEnte', 'geo'], 'integer'],
            [['dataIscrizioneEnte'], 'safe'],
            [['ente', 'regione', 'provincia'], 'string', 'max' => 50],
            [['codiceFiscale', 'codiceAffiliazione', 'civico'], 'string', 'max' => 20],
            [['affiliazione', 'tipoSocieta', 'comune'], 'string', 'max' => 255],
            [['cap'], 'string', 'max' => 12],
            [['password'], 'string', 'max' => 12],
            [['telefono1'], 'string', 'max' => 12],
            [['telefono2'], 'string', 'max' => 12],
            [['piva', 'cf'], 'string', 'max' => 16],
            [['url', 'fb'], 'string', 'max' => 250],
            [['referente'], 'string', 'max' => 20],
            [['X', 'Y'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [

            'id' => 'ID',

            'ente' => 'Ente',

            'indirizzo' => 'Indirizzo',

            'civico' => 'Civico',

            'societa' => 'Società',

            'numeroIscrizioneEnte' => 'Numero Iscrizione Ente',

            'dataIscrizioneEnte' => 'Data Iscrizione Ente',

            'codiceFiscale' => 'Codice Fiscale',

            'regione' => 'Regione',

            'affiliazione' => 'Affiliazione',

            'codiceAffiliazione' => 'Codice Affiliazione',

            'tipoSocieta' => 'Tipo Societa',

            'cap' => 'Cap',

            'comune' => 'Comune',

            'provincia' => 'Provincia',

            'password' => 'Password',

            'url' => 'Sito web',

            'referente' => 'Persona di riferimento',

            'telefono1' => 'Numero di telefono',

            'telefono2' => 'Altro numero di telefono',

            'email' => 'Email',
        ];
    }


    public function save($runValidation = true, $attributeNames = NULL)
    {

        $ris = parent::save($runValidation, $attributeNames);

        return $ris;
    }

    public function delete()
    {

        parent::delete();
    }


    public function beforeSave($insert)
    {

    //$this->addError('field', "xxxxxxxxxxxxx");

        if (parent::beforeSave($insert)) {
            return true;
        } else {
            return false;
        }
    }

    function geolocate($address)
  	{
  		$lat = 0;
  		$lng = 0;
      $key="AIzaSyD1IvJcVnhEMHKpZ-LDuMZ9VESSk1hBTcg";

  		$data_location = "https://maps.google.com/maps/api/geocode/json?address=".str_replace(" ", "+", $address)."&sensor=false&key=".$key;

  		//if ($this->region!="" && strlen($this->region)==2) { $data_location .= "&region=".$this->region; }
  		$data = file_get_contents($data_location);

  		// turn this on to see if we are being blocked
  		// echo $data;

  		$data = json_decode($data);

  		if ($data->status=="OK") {
  			$lat = $data->results[0]->geometry->location->lat;
  			$lng = $data->results[0]->geometry->location->lng;
        $this->X = $lat;
    		$this->Y = $lng;
        $this->geo = 1;
  		}
      else {
        Tool::logd($data);
        $this->geo = 0;
        if ($data->status == "ZERO_RESULTS") return true;
        return false;
      }
  		// concatenate lat/long coordinates
  		$coords['lat'] = $lat;
  		$coords['lng'] = $lng;

  		return true;
  	}

}
