<?php

namespace app\models;

use yii\base\Model;

class GestionarLibrosForm extends Model
{
    public $codigo;

    public function rules()
    {
        return [
            [['codigo'], 'required'],
            [['codigo'], 'buscarPelicula'],
            [
                ['codigo'],
                'exist',
                'targetClass' => Libros::className(),
                'skipOnError' => true,
                'targetAttribute' => ['codigo' => 'codigo'],
                'message' => 'No existe un libro con ese código',
            ],
        ];
    }

    public function buscarPelicula($attribute, $params, $validator)
    {
        if (!ctype_digit($this->codigo)) {
            $cadena = mb_strtolower($this->codigo);
            $libroBuscar = Libros::find()
                ->where(['like', 'lower(titulo)', $cadena])
                ->one();

            if ($libroBuscar !== null) {
                $this->codigo = $libroBuscar->codigo;
            } else {
                $this->addError($attribute, 'La película no existe.');
            }
        }
    }

    public function attributeLabels()
    {
        return [
            'codigo' => 'Código del libro:',
        ];
    }

    public function formName()
    {
        return '';
    }
}
