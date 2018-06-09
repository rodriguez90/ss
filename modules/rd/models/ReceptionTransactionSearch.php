<?php
/**
 * Created by PhpStorm.
 * User: pedro
 * Date: 08/06/2018
 * Time: 13:31
 */

namespace app\modules\rd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\rd\models\ReceptionTransaction;


class ReceptionTransactionSearch extends  ReceptionTransaction
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['reception_id', 'container_id', 'active'], 'integer'],
            [['regiter_truck', 'register_driver'], 'string'],
            [['delivery_date'], 'safe'],
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
        $query = ReceptionTransaction::find()->where(['active'=>true]);

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
            'reception_id' => $this->reception_id,
            'container_id' => $this->container_id,
            'regiter_truck' => $this->regiter_truck,
            'register_driver' => $this->register_driver,
            'active' => $this->active,
            'delivery_date' => $this->delivery_date,
        ]);

        return $dataProvider;
    }
}