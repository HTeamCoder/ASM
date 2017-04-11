<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Nhapxuatkho;

/**
 * NhapxuatkhoSearch represents the model behind the search form about `backend\models\Nhapxuatkho`.
 */
class NhapxuatkhoSearch extends Nhapxuatkho
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'nhacungcap_khachhang_id', 'nhanviengiaodich'], 'integer'],
            [['type', 'ngaygiaodich', 'maphieu', 'dienthoai', 'diachi', 'congtrinh_id', 'nguoinhap','hinhthuc','phuongthuc','datra','conlai'], 'safe'],
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
        $query = Nhapxuatkho::find()->orderBy(['id'=>SORT_DESC]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if (isset($_GET['NhapxuatkhoSearch']['type'])&&$_GET['NhapxuatkhoSearch']['type'] == 'xuattheoct')
        {
            $query->where(['type'=>'xuatkho']);
            $query->andFilterWhere(['<>','congtrinh_id','NULL']);
        }else if(isset($_GET['NhapxuatkhoSearch']['type'])&&$_GET['NhapxuatkhoSearch']['type'] == 'xuatkho')
        {
            $query->where(['type'=>'xuatkho']);
            $query->andWhere('congtrinh_id IS NULL');
        }else
        {
            $query->andFilterWhere(['type'=>$this->type]);
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'ngaygiaodich' => $this->ngaygiaodich,
            'nhacungcap_khachhang_id' => $this->nhacungcap_khachhang_id,
            'nhanviengiaodich' => $this->nhanviengiaodich,
            'chietkhau' => $this->chietkhau,
            'tongtien' => $this->tongtien,
            'thanhtien' => $this->thanhtien,
        ]);

        $query->andFilterWhere(['like', 'maphieu', $this->maphieu])
            ->andFilterWhere(['like', 'dienthoai', $this->dienthoai])
            ->andFilterWhere(['like', 'diachi', $this->diachi])
            ->andFilterWhere(['like', 'ghichu', $this->ghichu])
            ->andFilterWhere(['like', 'nguoinhap', $this->nguoinhap]);

        return $dataProvider;
    }

    public function search_congno($params)
    {
        $query = Nhapxuatkho::find()->where(['phuongthuc'=>'congno'])->andWhere('thanhtien <> datra');

        // add conditions that should always apply here

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
            $query->andFilterWhere(['>=','date(ngaygiaodich)', $_POST['start']])
                ->andFilterWhere(['<=','date(ngaygiaodich)',$_POST['end']]);
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'ngaygiaodich' => $this->ngaygiaodich,
            'nhacungcap_khachhang_id' => $this->nhacungcap_khachhang_id,
            'nhanviengiaodich' => $this->nhanviengiaodich,
            'chietkhau' => $this->chietkhau,
            'tongtien' => $this->tongtien,
            'thanhtien' => $this->thanhtien,
            'phuongthuc' => $this->phuongthuc,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'maphieu', $this->maphieu])
            ->andFilterWhere(['like', 'dienthoai', $this->dienthoai])
            ->andFilterWhere(['like', 'diachi', $this->diachi])
            ->andFilterWhere(['like', 'ghichu', $this->ghichu])
            ->andFilterWhere(['like', 'nguoinhap', $this->nguoinhap]);

        return $dataProvider;
    }
    public function thuchi($params)
    {
        $query = Nhapxuatkho::find()->where(['type'=>'nhapkho']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'ngaygiaodich' => $this->ngaygiaodich,
            'nhacungcap_khachhang_id' => $this->nhacungcap_khachhang_id,
            'nhanviengiaodich' => $this->nhanviengiaodich,
            'chietkhau' => $this->chietkhau,
            'tongtien' => $this->tongtien,
            'thanhtien' => $this->thanhtien,
        ]);

        if(isset($_POST['start']) && isset($_POST['end'])){
            $query->andFilterWhere(['>=','date(ngaygiaodich)', $_POST['start']])
                ->andFilterWhere(['<=','date(ngaygiaodich)',$_POST['end']]);
        }

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'maphieu', $this->maphieu])
            ->andFilterWhere(['like', 'dienthoai', $this->dienthoai])
            ->andFilterWhere(['like', 'diachi', $this->diachi])
            ->andFilterWhere(['like', 'ghichu', $this->ghichu])
            ->andFilterWhere(['like', 'nguoinhap', $this->nguoinhap]);


        return $dataProvider;
    }
    public function thuchikhachhang($params)
    {
        $query = Nhapxuatkho::find()->where(['type'=>'xuatkho']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'ngaygiaodich' => $this->ngaygiaodich,
            'nhacungcap_khachhang_id' => $this->nhacungcap_khachhang_id,
            'nhanviengiaodich' => $this->nhanviengiaodich,
            'chietkhau' => $this->chietkhau,
            'tongtien' => $this->tongtien,
            'thanhtien' => $this->thanhtien,
        ]);

        if(isset($_POST['start']) && isset($_POST['end'])){
            $query->andFilterWhere(['>=','date(ngaygiaodich)', $_POST['start']])
                ->andFilterWhere(['<=','date(ngaygiaodich)',$_POST['end']]);
        }

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'maphieu', $this->maphieu])
            ->andFilterWhere(['like', 'dienthoai', $this->dienthoai])
            ->andFilterWhere(['like', 'diachi', $this->diachi])
            ->andFilterWhere(['like', 'ghichu', $this->ghichu])
            ->andFilterWhere(['like', 'nguoinhap', $this->nguoinhap]);


        return $dataProvider;
    }
}
