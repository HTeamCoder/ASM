<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Thuchi;

/**
 * ThuchiSearch represents the model behind the search form about `backend\models\Thuchi`.
 */
class ThuchiSearch extends Thuchi
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nhapxuatkho_id', 'nhacungcap_khachhang_id'], 'integer'],
            [['maphieu', 'type', 'ngaylap', 'ghichu'], 'safe'],
            [['sotientra', 'tienhoadon'], 'number'],
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


            $query = Thuchi::find()->where(['phatsinh'=> 1]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if(isset($_POST['start']) && isset($_POST['end'])){
            $query->andFilterWhere(['>=','date(ngaylap)', $_POST['start']])
                ->andFilterWhere(['<=','date(ngaylap)',$_POST['end']]);
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'sotientra' => $this->sotientra,
            'ngaylap' => $this->ngaylap,
            'nhapxuatkho_id' => $this->nhapxuatkho_id,
            'nhacungcap_khachhang_id' => $this->nhacungcap_khachhang_id,
            'tienhoadon' => $this->tienhoadon,
        ]);

        $query->andFilterWhere(['like', 'maphieu', $this->maphieu])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'ghichu', $this->ghichu]);

        return $dataProvider;
    }
}
