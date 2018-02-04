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
            [['codigo'], 'integer'],
            [
                ['codigo'],
                'exist',
                'targetClass' => Libros::className(),
                'targetAttribute' => ['codigo' => 'codigo'],
                'message' => 'No existe un libro con ese código',
            ],
        ];
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
