<?php

namespace app\modules\rd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\rd\models\Reception;

/**
 * ReceptionSearch represents the model behind the search form of `app\modules\rd\models\Reception`.
 */
class ReceptionSearch extends Reception
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'active'], 'integer'],
            [['bl','trans_company_id', 'agency_id'], 'safe'],
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
        $query = Reception::find()->where(['active'=>true]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_ASC,
                ]
            ],
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
//            'trans_company_id' => $this->trans_company_id,
//            'agency_id' => $this->agency_id,
            'active' => $this->active,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'bl', $this->bl]);
        if(isset($this->trans_company_id))
        {
            $filter = TransCompany::find()->select('id')->where(['like', 'name', $this->trans_company_id]);
            $query->andFilterWhere(['trans_company_id'=>$filter]);
//            $query->andFilterWhere(['like', 'trans_company.name', $this->trans_company_id]);

        }

        if(isset($this->agency_id))
        {
//            $filter = TransCompany::find()->select('id')->where(['like', 'name', $this->agency_id]);
            $query->andFilterWhere(['like', 'agency.name', $this->agency_id]);


        }

        return $dataProvider;
    }
}
