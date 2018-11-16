<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ReaderControl;
use common\constant\Config;

/**
 * ReaderControlSearch represents the model behind the search form of `common\models\ReaderControl`.
 */
class ReaderControlSearch extends ReaderControl
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [[ 'key', 'value', 'comment'], 'safe'],
            [
                ['key'],
                'match',
                'pattern' => '#^[a-zA-Z0-9\-\_\.]+$#',
                'message' => Yii::t('app', 'This value must consist only of alpha-numerical characters plus hyphen ( - ), underscore ( _ ) or period ( . ).')
            ],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = ReaderControl::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'key' => 'id',
            'pagination' => ['pagesize' => Config::PAGE_SIZE_INDEX],
            'sort' => ['defaultOrder' => ['id' => SORT_ASC]]

        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query
            ->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}
