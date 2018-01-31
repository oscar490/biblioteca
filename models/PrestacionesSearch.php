<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Prestaciones;

/**
 * PrestacionesSearch represents the model behind the search form of `app\models\Prestaciones`.
 */
class PrestacionesSearch extends Prestaciones
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'libro_id', 'socio_id'], 'integer'],
            [['create_at', 'devolucion'], 'safe'],
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
        $query = Prestaciones::find();

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
            'libro_id' => $this->libro_id,
            'socio_id' => $this->socio_id,
            'create_at' => $this->create_at,
            'devolucion' => $this->devolucion,
        ]);

        return $dataProvider;
    }
}
