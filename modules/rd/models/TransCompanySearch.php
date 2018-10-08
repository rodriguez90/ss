<?php

namespace app\modules\rd\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\rd\models\TransCompany;

/**
 * TransCompanySearch represents the model behind the search form of `app\modules\rd\models\TransCompany`.
 */
class TransCompanySearch extends TransCompany
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'ruc', 'address','active'], 'safe'],
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
        $query = TransCompany::find()->where(['<>', 'active',-1]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>false,
//            'pagination' => [
//                'pageSize' => 5,
//            ],
            'sort' => [
                'defaultOrder' => [
                    'name' => SORT_ASC,
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
            //'active' => $this->active,
        ]);

        if(isset($this->active) && !empty($this->active)){

            if(strstr("activo",strtolower($this->active)) == true)
            {
                $query->andFilterWhere(['active' =>1]);
            }else if(strstr("inactivo",strtolower($this->active)) == true)
            {
                $query->andFilterWhere(['active' =>0]);
            }

        }

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'ruc', $this->ruc])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
