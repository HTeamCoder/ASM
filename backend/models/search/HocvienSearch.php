<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Hocvien;

/**
 * HocvienSearch represents the model behind the search form about `backend\models\Hocvien`.
 */
class HocvienSearch extends Hocvien
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'tuoi', 'thiluc', 'lop_id', 'benhvien_id', 'nhommau_id', 'trinhdohocvan_id', 'congtacvien_id', 'loaidanhsach_id', 'khuvuc_id', 'noicap', 'noihoctap', 'noisinh'], 'integer'],
            [['ma', 'name', 'code', 'tentiengnhat', 'gioitinh', 'ngaysinh', 'diachi', 'dienthoai', 'dienthoaikhancap', 'tinhtranghonnhan', 'cmnd', 'ngaycap', 'kinhnghiemcv', 'sothich', 'chieucao', 'cannang', 'taythuan', 'daunguon', 'hinhxam', 'ngaynhaptruong', 'ngaykham', 'ghichuthetrang'], 'safe'],
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
        $query = Hocvien::find();

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
            'ngaysinh' => $this->ngaysinh,
            'tuoi' => $this->tuoi,
            'ngaycap' => $this->ngaycap,
            'thiluc' => $this->thiluc,
            'ngaynhaptruong' => $this->ngaynhaptruong,
            'ngaykham' => $this->ngaykham,
            'lop_id' => $this->lop_id,
            'benhvien_id' => $this->benhvien_id,
            'nhommau_id' => $this->nhommau_id,
            'trinhdohocvan_id' => $this->trinhdohocvan_id,
            'congtacvien_id' => $this->congtacvien_id,
            'loaidanhsach_id' => $this->loaidanhsach_id,
            'khuvuc_id' => $this->khuvuc_id,
            'noicap' => $this->noicap,
            'noihoctap' => $this->noihoctap,
            'noisinh' => $this->noisinh,
        ]);

        $query->andFilterWhere(['like', 'ma', $this->ma])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'tentiengnhat', $this->tentiengnhat])
            ->andFilterWhere(['like', 'gioitinh', $this->gioitinh])
            ->andFilterWhere(['like', 'diachi', $this->diachi])
            ->andFilterWhere(['like', 'dienthoai', $this->dienthoai])
            ->andFilterWhere(['like', 'dienthoaikhancap', $this->dienthoaikhancap])
            ->andFilterWhere(['like', 'tinhtranghonnhan', $this->tinhtranghonnhan])
            ->andFilterWhere(['like', 'cmnd', $this->cmnd])
            ->andFilterWhere(['like', 'kinhnghiemcv', $this->kinhnghiemcv])
            ->andFilterWhere(['like', 'sothich', $this->sothich])
            ->andFilterWhere(['like', 'chieucao', $this->chieucao])
            ->andFilterWhere(['like', 'cannang', $this->cannang])
            ->andFilterWhere(['like', 'taythuan', $this->taythuan])
            ->andFilterWhere(['like', 'daunguon', $this->daunguon])
            ->andFilterWhere(['like', 'hinhxam', $this->hinhxam])
            ->andFilterWhere(['like', 'ghichuthetrang', $this->ghichuthetrang]);

        return $dataProvider;
    }
}
