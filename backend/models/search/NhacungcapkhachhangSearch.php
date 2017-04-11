<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Nhacungcapkhachhang;

/**
 * searchNhacungcapkhachhangSearch represents the model behind the search form about `backend\models\Nhacungcapkhachhang`.
 */
class NhacungcapkhachhangSearch extends Nhacungcapkhachhang
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['ma', 'name', 'diachi', 'masothue', 'dtdoitac', 'dienthoai', 'tknganhang', 'nganhang', 'code', 'type', 'email', 'nguoilienhe', 'chucvu'], 'safe'],
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
        $query = Nhacungcapkhachhang::find();

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
        ]);

        $query->andFilterWhere(['like', 'ma', $this->ma])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'diachi', $this->diachi])
            ->andFilterWhere(['like', 'masothue', $this->masothue])
            ->andFilterWhere(['like', 'dtdoitac', $this->dtdoitac])
            ->andFilterWhere(['like', 'dienthoai', $this->dienthoai])
            ->andFilterWhere(['like', 'tknganhang', $this->tknganhang])
            ->andFilterWhere(['like', 'nganhang', $this->nganhang])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'nguoilienhe', $this->nguoilienhe])
            ->andFilterWhere(['like', 'diachihoadon', $this->diachihoadon])
            ->andFilterWhere(['like', 'chucvu', $this->chucvu]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchKhachhang($params)
    {
        $query = Nhacungcapkhachhang::find();

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
            'type' => 'khachhang'
        ]);


        $query->andFilterWhere(['like', 'ma', $this->ma])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'diachi', $this->diachi])
            ->andFilterWhere(['like', 'masothue', $this->masothue])
            ->andFilterWhere(['like', 'dtdoitac', $this->dtdoitac])
            ->andFilterWhere(['like', 'dienthoai', $this->dienthoai])
            ->andFilterWhere(['like', 'tknganhang', $this->tknganhang])
            ->andFilterWhere(['like', 'nganhang', $this->nganhang])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'nguoilienhe', $this->nguoilienhe])
            ->andFilterWhere(['like', 'diachihoadon', $this->diachihoadon])
            ->andFilterWhere(['like', 'chucvu', $this->chucvu]);

        return $dataProvider;
    }

    public function searchNCC($params)
    {
        $query = Nhacungcapkhachhang::find();

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
            'type' => 'nhacungcap'
        ]);


        $query->andFilterWhere(['like', 'ma', $this->ma])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'diachi', $this->diachi])
            ->andFilterWhere(['like', 'masothue', $this->masothue])
            ->andFilterWhere(['like', 'dtdoitac', $this->dtdoitac])
            ->andFilterWhere(['like', 'dienthoai', $this->dienthoai])
            ->andFilterWhere(['like', 'tknganhang', $this->tknganhang])
            ->andFilterWhere(['like', 'nganhang', $this->nganhang])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'nguoilienhe', $this->nguoilienhe])
            ->andFilterWhere(['like', 'chucvu', $this->chucvu])
            ->andFilterWhere(['like', 'diachihoadon', $this->diachihoadon]);

        return $dataProvider;
    }
}
