<?php

namespace app\modules\administracion\models;

use Yii;

use yii\data\ActiveDataProvider;


/**
 * UserSearch represents the model behind the search form of `app\modules\administracion\models\User`.
 */
class UserSearch extends AdmUser
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key', 'password', 'email', 'nombre', 'apellidos', 'creado_por', 'password_reset_token', 'cedula','status'], 'safe'],
        ];
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
        $query = AdmUser::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            //'status' => $this->status,
            'created_at' => $this->created_at,
        ]);

        if(isset($this->status) && !empty($this->status)){

            if(strstr("activo",strtolower($this->status)) == true)
            {
                $query->andFilterWhere(['status' =>1]);
            }else if(strstr("inactivo",strtolower($this->status)) == true)
            {
                $query->andFilterWhere(['status' =>0]);
            }

        }

        $query->andFilterWhere(['like', 'username', $this->username])



            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'apellidos', $this->apellidos]);


        return $dataProvider;
    }
}
