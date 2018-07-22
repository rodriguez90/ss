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

    public $trans_company;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'active', ], 'integer'],
            [['trans_company', ], 'string'],
            [['bl', 'type', 'agency_id', 'delivery_date', 'created_at', 'trans_company'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        $attributeLabels = parent::attributeLabels();
        $attributeLabels[] = ['trans_company'=>"Empresa de Transpote"];
        return $attributeLabels;
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'trans_company';

        return $fields;
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
        $query = Process::find()->innerJoin('agency', 'agency.id = process.agency_id')
            ->innerJoin("process_transaction","process_transaction.process_id = process.id")
            ->innerJoin("trans_company","process_transaction.trans_company_id = trans_company.id")
            ->where(['process.active'=>1]);

//        $query = Process::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
//            'pagination' => [
//                'pageSize' => 5,
//            ],
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
//        var_dump($this->type);die;

        // grid filtering conditions
        $query->andFilterWhere([
            'process.id' => $this->id,
//            'process.agency_id' => $this->agency_id,
            'process.active' => $this->active,
            'process.type' => $this->type,
            'process.created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['like', 'bl', $this->bl]);

//        if(isset($this->agency_id))
//        {
//
//            $query->andFilterWhere(['like', 'agency.name', $this->agency_id]);
//        }

        if(isset($params['agency_id']))
        {
            $query->andFilterWhere(['agency.name'=>$params['agency_id']]);
        }

        if(isset($params['trans_company_id']))
        {
            $query->andWhere(['trans_company.name'=>$params['trans_company_id']]) ;
        }

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
            ->where(['process.active'=>1]);

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
        $query->andFilterWhere(['trans_company.id'=>$params['trans_company_id']]) ;

        return $dataProvider;
    }
}
