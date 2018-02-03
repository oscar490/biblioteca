<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prestaciones".
 *
 * @property int $id
 * @property int $libro_id
 * @property int $socio_id
 * @property string $create_at
 * @property string $devolucion
 *
 * @property Libros $libro
 * @property Socios $socio
 */
class Prestaciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prestaciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['libro_id', 'socio_id'], 'default', 'value' => null],
            [['libro_id', 'socio_id'], 'integer'],
            [['create_at', 'devolucion'], 'safe'],
            [['libro_id'], 'exist', 'skipOnError' => true, 'targetClass' => Libros::className(), 'targetAttribute' => ['libro_id' => 'id']],
            [['socio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Socios::className(), 'targetAttribute' => ['socio_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'libro_id' => 'Libro ID',
            'socio_id' => 'Socio ID',
            'create_at::dateTime' => 'Create At',
            'devolucion' => 'Devolucion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLibro()
    {
        return $this->hasOne(Libros::className(), ['id' => 'libro_id'])->inverseOf('prestaciones');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocio()
    {
        return $this->hasOne(Socios::className(), ['id' => 'socio_id'])->inverseOf('prestaciones');
    }
}
