<?php

namespace backend\models\search;

use backend\models\Thongkekho;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Donvitinh;

/**
 */
class ThongkekhoSearch extends Thongkekho
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tenhang', 'mahang'], 'safe'],
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
        $query = Thongkekho::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $db = \Yii::$app->getDb()->createCommand();
        $query->groupBy(['idhanghoa']);
        $query->select(['mahang', 'tenhang','sum(soluongtondauky) as soluongtondauky', 'sum(soluongnhapkho) as soluongnhapkho', 'sum(soluongxuatkho) as soluongxuatkho, sum(tongtiendauky) as tongtiendauky, sum(tongtiennhapkho) as tongtiennhapkho, sum(tongtienxuatkho) as tongtienxuatkho']);
        if(isset($_POST['start']) && isset($_POST['end'])){
            $query->andFilterWhere(['>=','date(ngaygiaodich)', $_POST['start']])
                ->andFilterWhere(['<=','date(ngaygiaodich)',$_POST['end']]);
        }

        $query->andFilterWhere(['like', 'tenhang', $this->tenhang])
            ->andFilterWhere(['like', 'mahang', $this->mahang]);

        return $dataProvider;
    }
    public function lichsuhanghoa($params){
        $query = Thongkekho::find()->select('mahang,idhanghoa,tenhang');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->groupBy(['idhanghoa']);
        $query->andFilterWhere(['like', 'tenhang', $this->tenhang])
            ->andFilterWhere(['like', 'mahang', $this->mahang]);

        return $dataProvider;
    }
}
