<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

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
            [['id', 'libro_id', 'socio_id', 'libro.codigo', 'socio.numero'], 'integer'],
            [
                [
                    'create_at',
                    'devolucion',
                    'libro.titulo',
                    'socio.numero',
                    'socio.nombre',
                ],
                'safe', ],
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

    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'libro.codigo',
            'libro.titulo',
            'socio.numero',
            'socio.nombre',
        ]);
    }


    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Prestaciones::find()
            ->joinWith(['libro', 'socio']);


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);
        $atributos = [
            'libro.codigo' => 'codigo',
            'libro.titulo' => 'titulo',
            'socio.numero' => 'numero',
            'socio.nombre' => 'nombre',
        ];

        $dataProvider->sort->defaultOrder = ['create_at' => SORT_DESC];

        foreach ($atributos as $k => $v) {
            $dataProvider->sort->attributes[$k] = [
                'asc' => [$v => SORT_ASC],
                'desc' => [$v => SORT_DESC],
            ];
        }


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'libros.codigo' => $this->getAttribute('libro.codigo'),
            'devolucion' => $this->devolucion,
            'socios.numero' => $this->getAttribute('socio.numero'),
        ]);

        $query->andFilterWhere([
            'like',
            'lower(libros.titulo)',
            mb_strtolower($this->getAttribute('libro.titulo')),
        ]);

        $query->andFilterWhere([
            'like',
            'lower(socios.nombre)',
            mb_strtolower($this->getAttribute('socio.nombre')),
        ]);

        return $dataProvider;
    }
}
