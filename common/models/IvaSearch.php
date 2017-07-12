<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Iva;

/**
 * IvaSearch represents the model behind the search form about `\Iva`.
 */
class IvaSearch extends Iva
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'taxstamp'], 'integer'],
            [['tipiva', 'fae_natura', 'descrizione', 'descrizioneLunga', 'status', 'annota', 'adminid', 'lastUpdate', 'created'], 'safe'],
            [['aliquo'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Iva::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'aliquo' => $this->aliquo,
            'taxstamp' => $this->taxstamp,
            'lastUpdate' => $this->lastUpdate,
            'created' => $this->created,
        ]);

        $query->andFilterWhere(['like', 'tipiva', $this->tipiva])
            ->andFilterWhere(['like', 'fae_natura', $this->fae_natura])
            ->andFilterWhere(['like', 'descrizione', $this->descrizione])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'annota', $this->annota])
            ->andFilterWhere(['like', 'adminid', $this->adminid]);

        return $dataProvider;
    }
}
