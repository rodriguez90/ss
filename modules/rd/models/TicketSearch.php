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
    public $containerType = '';
    public $dateTimeTicket = '';
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'process_transaction_id', 'calendar_id', 'status', 'active'], 'integer'],
            [['created_at','register_truck', 'register_driver', 'name_driver', 'processType', 'containerType', 'dateTimeTicket'], 'safe'],
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
            ->innerJoin('container', 'container.id=process_transaction.container_id')
            ->innerJoin('container_type', 'container_type.id=container.type_id')
            ->where(['process_transaction.active'=>1]);

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
            ],
        ]);

        $dataProvider->sort = [
            'attributes' => [
                'calendar_id' => [
                    'asc' => ['calendar.start_datetime' => SORT_ASC],
                    'desc' => ['calendar.start_datetime' => SORT_DESC],
                ],
            ]
        ];

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
            'status' => $this->status,
//            'created_at' => $this->created_at,
            'ticket.active' => $this->active,
        ]);

        $query->andFilterWhere(['like','register_truck',$this->register_truck]);
        $query->andFilterWhere(['like','register_driver',$this->register_driver]);
        $query->andFilterWhere(['like','name_driver',$this->name_driver]);
        $query->andFilterWhere(['process.type'=>$this->processType]);
        $query->andFilterWhere(['like','container_type.name',$this->containerType]);
        if($this->dateTimeTicket !== '')
        {
            $startDate = date_create($this->dateTimeTicket);
            $endDate = date_create($this->dateTimeTicket);

            date_add($endDate,date_interval_create_from_date_string("1 days"));

            $query->andFilterWhere(['>=','calendar.start_datetime', $startDate->format('Y-m-d H:i')]);
            $query->andFilterWhere(['<','calendar.start_datetime', $endDate->format('Y-m-d H:i')]);
        }

        return $dataProvider;
    }
}
