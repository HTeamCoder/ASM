<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Donhang;

/**
 * DonhangSearch represents the model behind the search form about `backend\models\Donhang`.
 */
class DonhangSearch extends Donhang
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'vunglamviec_id', 'nghiepdoan_id', 'xinghiep_id', 'noidaotaosautrungtuyen_id', 'donvicungcapnguon_id'], 'integer'],
            [['name', 'code', 'thoigiantaptrung', 'ngaythi', 'diachilienhe', 'noilamviec', 'ghichu', 'ngaydo', 'ngayxuatcanh', 'ngayvevietnam','ngaychotcv'], 'safe'],
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
        $query = Donhang::find();

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
            'thoigiantaptrung' => $this->thoigiantaptrung,
            'ngaythi' => $this->ngaythi,
            'ngaydo' => $this->ngaydo,
            'vunglamviec_id' => $this->vunglamviec_id,
            'nghiepdoan_id' => $this->nghiepdoan_id,
            'xinghiep_id' => $this->xinghiep_id,
            'noidaotaosautrungtuyen_id' => $this->noidaotaosautrungtuyen_id,
            'donvicungcapnguon_id' => $this->donvicungcapnguon_id,
            'ngayxuatcanh' => $this->ngayxuatcanh,
            'ngayvevietnam' => $this->ngayvevietnam,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'diachilienhe', $this->diachilienhe])
            ->andFilterWhere(['like', 'noilamviec', $this->noilamviec])
            ->andFilterWhere(['like', 'ghichu', $this->ghichu]);

        return $dataProvider;
    }
}
