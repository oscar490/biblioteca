<?php

namespace app\models;

use yii\helpers\Html;

/**
 * This is the model class for table "libros".
 *
 * @property int $id
 * @property string $codigo
 * @property string $titulo
 * @property string $num_pags
 * @property string $autor
 *
 * @property Prestaciones[] $prestaciones
 */
class Libros extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'libros';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['codigo', 'titulo', 'autor'], 'required'],
            [['codigo', 'num_pags'], 'number'],
            [['titulo', 'autor'], 'string', 'max' => 255],
            [['codigo'], 'unique'],
            [['titulo'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'codigo' => 'Código',
            'titulo' => 'Título',
            'num_pags' => 'Número de páginas',
            'autor' => 'Autor',
        ];
    }

    public function getEstaPrestado()
    {
        $prestaciones = $this->getPrestaciones()
            ->where(['devolucion' => null])
            ->all();

        return empty($prestaciones) ? false : true;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrestaciones()
    {
        return $this->hasMany(Prestaciones::className(), ['libro_id' => 'id'])->inverseOf('libro');
    }

    public function getEnlace()
    {
        return Html::a($this->titulo, ['libros/view', 'id' => $this->id]);
    }
}
