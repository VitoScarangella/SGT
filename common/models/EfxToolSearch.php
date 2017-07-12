<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EfxTool;
use backend\models\Tool;

/**
 * EfxToolSearch represents the model behind the search form about `common\models\EfxTool`.
 */
class EfxToolSearch extends EfxTool
{
    public function rules()
    {
        return [
          [['id'], 'integer'],
          [['username'], 'string'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function searchChangeUser($params)
    {
        $session = Yii::$app->session;
        $roles = $session['masterRoles']; //Ruoli del master user
        $idUser = $session["masterUser"]["id"];
 Tool::logd($session['masterRoles']);

        if (Tool::hasRole(Tool::SUPERADMIN, $roles) || $session["masterUser"]["superadmin"]==1)
        {
          $query = EfxTool::find();
        }
        elseif (Tool::hasRole(Tool::CONTABILE, $roles) )
        {
          $subQuery1 = Userdetails::find()->select('id')
          ->where("idContabile=$idUser or id=".$idUser);
           Tool::logd($subQuery1);
          $query = EfxTool::find()->where(['in', 'id', $subQuery1]);
        }
        elseif (Tool::hasRole(Tool::COMMERCIALISTA, $roles) )
        {
          Tool::log(".....".$idUser);
          $subQuery1 = Userdetails::find()->select('id')
          ->where("idCommercialista=$idUser or idContabile=$idUser or id=".$idUser);
          Tool::logd($subQuery1);
          $query = EfxTool::find()->where(['in', 'id', $subQuery1]);
        }
        else
        $query = EfxTool::find();


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'idLingua' => $this->idLingua,
            'idTipodoc' => $this->idTipodoc,
            'idSezione' => $this->idSezione,
            'visibile' => $this->visibile,
            'dataCreazione' => $this->dataCreazione,
            'dataModifica' => $this->dataModifica,
            'dataArticolo' => $this->dataArticolo,
            'ordinamento' => $this->ordinamento,
        ]);

        $query->andFilterWhere(['like', 'titolo', $this->titolo])
            ->andFilterWhere(['like', 'sottotitolo', $this->sottotitolo])
            ->andFilterWhere(['like', 'descrizione', $this->descrizione]);

        return $dataProvider;
    }

    public function search($params)
    {
        $query = EfxTool::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'idLingua' => $this->idLingua,
            'idTipodoc' => $this->idTipodoc,
            'idSezione' => $this->idSezione,
            'visibile' => $this->visibile,
            'dataCreazione' => $this->dataCreazione,
            'dataModifica' => $this->dataModifica,
            'dataArticolo' => $this->dataArticolo,
            'ordinamento' => $this->ordinamento,
        ]);

        $query->andFilterWhere(['like', 'titolo', $this->titolo])
            ->andFilterWhere(['like', 'sottotitolo', $this->sottotitolo])
            ->andFilterWhere(['like', 'descrizione', $this->descrizione]);

        return $dataProvider;
    }
}
