<?php

namespace app\modules\rd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\rd\models\Process;

/**
 * This is the model class for table "process search".
 *
 * @property string $id trans_company
 */

/**
 * ProcessSearch represents the model behind the search form of `app\modules\rd\models\Process`.
 */
class ProcessSearch extends Process
{
    public $agencyId = null;
    public $transCompanyId = null;
    public $warehouseCompanyId = null;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'active', ], 'integer'],
            [['bl', 'type', 'agency_id', 'delivery_date', 'created_at', 'agencyId', 'transCompanyId', 'warehouseCompanyId'], 'safe'],
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
        $query = Process::find()
            ->innerJoin('agency', 'agency.id = process.agency_id')
//            ->innerJoin("process_transaction","process_transaction.process_id = process.id")
//            ->innerJoin("trans_company","process_transaction.trans_company_id = trans_company.id")
            ->where(['process.active'=>1]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
//            'pagination' => [
//                'pageSize' => 5,
//            ],
//            'sort' => [
//                'defaultOrder' => [
//                    'created_at' => SORT_ASC,
//                ]
//            ],
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'bl',
                'agency_id' => [
                    'asc' => [
                        'agency.name' => SORT_ASC,
                    ],
                    'desc' => [
                        'agency.name' => SORT_DESC,
                    ],
                    'label' => 'Cliente',
                    'default' => SORT_ASC
                ],
                'delivery_date',
                'country_id'
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'process.id' => $this->id,
            'process.active' => $this->active,
            'process.type' => $this->type,
            'process.created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'bl', $this->bl]);

        if(isset($this->agencyId))
        {
           $query->andFilterWhere(['agency_id'=>$this->agencyId]);
        }
        if(isset($this->agency_id))
        {
            $results = Agency::find()
                ->select('id')
                ->where(['active'=>1])
                ->andFilterWhere(['like', 'name', $this->agency_id])
                ->asArray();

            $query->andFilterWhere(['agency_id'=>$results]);
        }

        if(isset($this->transCompanyId))
        {
            $results = Process::find()->select('process.id')
                                        ->innerJoin("process_transaction","process_transaction.process_id = process.id")
                                        ->innerJoin("trans_company","process_transaction.trans_company_id = trans_company.id")
                                         ->where(['process.active'=>1])
                                         ->andFilterWhere(['trans_company.id'=>$this->transCompanyId])
                                         ->groupBy(['process.id'])
                                         ->asArray();

            $query->andWhere(['process.id'=>$results]);
        }

//        if(isset($params['warehouse_id']))
//        {
//
//            $results = Process::find()->select('process.id')
//                ->innerJoin("process_transaction","process_transaction.process_id = process.id")
//                ->innerJoin("trans_company","process_transaction.trans_company_id = trans_company.id")
//                ->innerJoin("ticket","ticket.process_transaction_id = process_transaction.id")
//                ->innerJoin("calendar","calendar.id = ticket.calendar_id")
//                ->where(['process.active'=>1])
//                ->andWhere(['process_transaction.active'=>1])
//                ->andWhere(['ticket.active'=>1])
//                ->andFilterWhere(['calendar.id_warehouse'=>$params['warehouse_id']])
//                ->groupBy(['process.id'])
//                ->asArray();
//
//            $query->andWhere(['process.id'=>$results]);
//        }

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchReport($params)
    {
        $query = Process::find()->innerJoin('agency', 'agency.id = process.agency_id')
            ->innerJoin("process_transaction","process_transaction.process_id = process.id")
            ->innerJoin("trans_company","process_transaction.trans_company_id = trans_company.id")
            ->where(['process.active'=>1])
            ->andWhere(["process_transaction.active"=>1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_ASC,
                ]
            ],
        ]);


        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['bl'=>$params['bl']]);
        $query->andFilterWhere(['agency.id'=>$params['agency_id']]);
        $query->andFilterWhere(['trans_company.id'=>$params['trans_company_id']]);

        return $dataProvider;
    }
}
