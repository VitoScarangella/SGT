<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\EfxTree;

/**
 * EfxTreeSearch represents the model behind the search form about `common\models\EfxTree`.
 */
class EfxTreeSearch extends EfxTree
{
    public function rules()
    {
        return [
            [['id', 'idObjParent', 'idObj', 'order', 'level'], 'integer'],
            [['name'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {

        $query = EfxTree::findRoot();

        $query->andFilterWhere([
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> ['defaultOrder' => ['path'=>SORT_ASC,'level'=>SORT_ASC,]]
        ]);


        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }


        $query->andFilterWhere([
            'id' => $this->id,
            'idObjParent' => $this->idObjParent,
            'idObj' => $this->idObj,
            'order' => $this->order,
            'level' => $this->level,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
