<?php

namespace app\modules\rd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\rd\models\Process;

/**
 * ProcessSearch represents the model behind the search form of `app\modules\rd\models\Process`.
 */
class ProcessSearch extends Process
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'active', ], 'integer'],
            [['bl', 'type', 'agency_id', 'delivery_date', 'created_at'], 'safe'],
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
        $query = Process::find()->innerJoin('agency', 'agency.id = process.agency_id');

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

        if(isset($params['agency_id']))
        {
            $this->agency_id = $params['agency_id'];
        }

//        if(isset($params['trans_company_id']))
//        {
//            $this->trans_company_id = $params['trans_company_id'];
//        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'process.id' => $this->id,
            'process.agency_id' => $this->agency_id,
            'process.active' => $this->active,
            'process.type' => $this->type,
            'process.delivery_date' => $this->delivery_date,
            'process.created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'bl', $this->bl]);

        if(isset($this->agency_id))
        {

            $query->andFilterWhere(['like', 'agency.name', $this->agency_id]);
        }

        return $dataProvider;
    }
}
