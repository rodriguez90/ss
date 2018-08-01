<?php

namespace app\modules\rd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\rd\models\Ticket;

/**
 * TicketSearch represents the model behind the search form of `app\modules\rd\models\Ticket`.
 */
class TicketSearch extends Ticket
{
    public $register_truck = '';
    public $register_driver = '';
    public $name_driver = '';
    public $processType = '';
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'process_transaction_id', 'calendar_id', 'status', 'active'], 'integer'],
            [['created_at','register_truck', 'register_driver', 'name_driver', 'processType'], 'safe'],
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
        $query = Ticket::find()
            ->innerJoin('calendar', 'calendar.id=ticket.calendar_id')
            ->innerJoin('process_transaction', 'process_transaction.id=ticket.process_transaction_id')
            ->innerJoin('process', 'process_transaction.process_id=process.id')
            ->innerJoin('container', 'container.id=process_transaction.container_id');
//            ->where(['ticket.active'=>1]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>false,
//            'pagination' => [
//                'pageSize' => 5,
//            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ],
//                'attributes' => [
//                    'process_transaction_id' => [
//                        'asc' => ['processTransaction.register_truck' => SORT_ASC],
//                        'desc' => ['processTransaction.register_truck' => SORT_DESC],
//                    ],
//                ]
            ],
        ]);

        $this->load($params);

//        if(isset($params['agency_id']))
//        {
//            $this->agency_id = $params['agency_id'];
//        }
//
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
            'id' => $this->id,
            'process_transaction_id' => $this->process_transaction_id,
            'calendar_id' => $this->calendar_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'ticket.active' => $this->active,
        ]);

        $query->andFilterWhere(['like','register_truck',$this->register_truck]);
        $query->andFilterWhere(['like','register_driver',$this->register_driver]);
        $query->andFilterWhere(['like','name_driver',$this->name_driver]);
        $query->andFilterWhere(['process.type'=>$this->processType]);


//        if(isset($this->trans_company_id))
//        {
//            $filter = TransCompany::find()->select('id')->where(['like', 'name', $this->trans_company_id]);
//            $query->andFilterWhere(['trans_company_id'=>$filter]);
////            $query->andFilterWhere(['like', 'trans_company.name', $this->trans_company_id]);
//
//        }
////        var_dump($this->agency_id);die;
//        if(isset($this->agency_id))
//        {
//
////            $filter = TransCompany::find()->select('id')->where(['like', 'name', $this->agency_id]);
//            $query->andFilterWhere(['like', 'agency.name', $this->agency_id]);
//
//        }

        return $dataProvider;
    }
}
