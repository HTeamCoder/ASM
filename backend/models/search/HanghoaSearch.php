<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Hanghoa;

/**
 * HanghoaSearch represents the model behind the search form about `backend\models\Hanghoa`.
 */
class HanghoaSearch extends Hanghoa
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nhomloaihang_id', 'donvitinh_id'], 'integer'],
            [['ma', 'name', 'code'], 'safe'],
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
        $query = Hanghoa::find();

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
            'nhomloaihang_id' => $this->nhomloaihang_id,
            'donvitinh_id' => $this->donvitinh_id,
        ]);

        $query->andFilterWhere(['like', 'ma', $this->ma])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code]);

        return $dataProvider;
    }
}
