<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Tuyendung;

/**
 * HocvienSearch represents the model behind the search form about `backend\models\Hocvien`.
 */
class TUyendungSearch extends Tuyendung
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idhocvien', 'idhoadon','tenhocvien', 'mahocvien', 'tendonhang','ngaythi', 'ngaydo','anhdaidien'], 'safe'],
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
        $query = Tuyendung::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
          
        ]);

        $query->andFilterWhere(['like', 'tenhocvien', $this->tenhocvien])
            ->andFilterWhere(['like', 'tendonhang', $this->tendonhang])
            ->andFilterWhere(['like', 'ngaythi', $this->ngaythi])
            ->andFilterWhere(['like', 'ngaydo', $this->ngaydo])
            ->andFilterWhere(['like', 'mahocvien', $this->mahocvien]);

        return $dataProvider;
    }
    
}
