<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EfxWeekPlanDefault;

/**
 * EfxWeekPlanDefaultSearch represents the model behind the search form about `common\models\EfxWeekPlanDefault`.
 */
class EfxWeekPlanDefaultSearch extends EfxWeekPlanDefault
{
    public function rules()
    {
        return [
            [['id', 'idKey'], 'integer'],
            [[
              'lun_da1', 'lun_a1', 'lun_da2', 'lun_a2', 'lun_da3', 'lun_a3', 'lun_da4', 'lun_a4', 'lun_da5', 'lun_a5', 'lun_da6', 'lun_a6',
              'mar_da1', 'mar_a1', 'mar_da2', 'mar_a2', 'mar_da3', 'mar_a3', 'mar_da4', 'mar_a4', 'mar_da5', 'mar_a5', 'mar_da6', 'mar_a6',
              'mer_da1', 'mer_a1', 'mer_da2', 'mer_a2', 'mer_da3', 'mer_a3', 'mer_da4', 'mer_a4', 'mer_da5', 'mer_a5', 'mer_da6', 'mer_a6',
              'gio_da1', 'gio_a1', 'gio_da2', 'gio_a2', 'gio_da3', 'gio_a3', 'gio_da4', 'gio_a4', 'gio_da5', 'gio_a5', 'gio_da6', 'gio_a6',
              'ven_da1', 'ven_a1', 'ven_da2', 'ven_a2', 'ven_da3', 'ven_a3', 'ven_da4', 'ven_a4', 'ven_da5', 'ven_a5', 'ven_da6', 'ven_a6',
              'sab_da1', 'sab_a1', 'sab_da2', 'sab_a2', 'sab_da3', 'sab_a3', 'sab_da4', 'sab_a4', 'sab_da5', 'sab_a5', 'sab_da6', 'sab_a6',
              'dom_da1', 'dom_a1', 'dom_da2', 'dom_a2', 'dom_da3', 'dom_a3', 'dom_da4', 'dom_a4', 'dom_da5', 'dom_a5', 'dom_da6', 'dom_a6'
            ],
              'safe'],        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = EfxWeekPlanDefault::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'idKey' => $this->idKey,
            'lun_da1' => $this->lun_da1,
            'lun_a1' => $this->lun_a1,
            'lun_da2' => $this->lun_da2,
            'lun_a2' => $this->lun_a2,
            'lun_da3' => $this->lun_da3,
            'lun_a3' => $this->lun_a3,
            'mar_da1' => $this->mar_da1,
            'mar_a1' => $this->mar_a1,
            'mar_da2' => $this->mar_da2,
            'mar_a2' => $this->mar_a2,
            'mar_da3' => $this->mar_da3,
            'mar_a3' => $this->mar_a3,
            'mer_da1' => $this->mer_da1,
            'mer_a1' => $this->mer_a1,
            'mer_da2' => $this->mer_da2,
            'mer_a2' => $this->mer_a2,
            'mer_da3' => $this->mer_da3,
            'mer_a3' => $this->mer_a3,
            'gio_da1' => $this->gio_da1,
            'gio_a1' => $this->gio_a1,
            'gio_da2' => $this->gio_da2,
            'gio_a2' => $this->gio_a2,
            'gio_da3' => $this->gio_da3,
            'gio_a3' => $this->gio_a3,
            'ven_da1' => $this->ven_da1,
            'ven_a1' => $this->ven_a1,
            'ven_da2' => $this->ven_da2,
            'ven_a2' => $this->ven_a2,
            'ven_da3' => $this->ven_da3,
            'ven_a3' => $this->ven_a3,
            'sab_da1' => $this->sab_da1,
            'sab_a1' => $this->sab_a1,
            'sab_da2' => $this->sab_da2,
            'sab_a2' => $this->sab_a2,
            'sab_da3' => $this->sab_da3,
            'sab_a3' => $this->sab_a3,
            'dom_da1' => $this->dom_da1,
            'dom_a1' => $this->dom_a1,
            'dom_da2' => $this->dom_da2,
            'dom_a2' => $this->dom_a2,
            'dom_da3' => $this->dom_da3,
            'dom_a3' => $this->dom_a3,
        ]);

        return $dataProvider;
    }
}
