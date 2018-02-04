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
            ],
        ];
    }
}
