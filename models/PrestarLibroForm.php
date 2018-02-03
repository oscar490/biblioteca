<?php

namespace app\models;

use yii\base\Model;
use app\models\Socios;

class PrestarLibroForm extends Model
{
    public $numero;
    public $codigo;

    public function rules()
    {
        return [
            [['numero', 'codigo'], 'required'],
            [['numero'], 'integer'],
            [['codigo'], 'integer'],
            [
                ['numero'],
                'exist',
                'targetClass'=>Socios::className(),
                'targetAttribute'=>['numero'=>'numero'],
            ],

            [
                ['codigo'],
                'exist',
                'targetClass'=>Libros::className(),
                'targetAttribute'=>['codigo'=>'codigo'],
            ],
            [
                'codigo', function ($attribute, $params, $validator) {
                    if (Libros::findOne(['codigo'=>$this->codigo])->estaPrestado) {
                        $this->addError($attribute, 'El libro está prestado');
                    }
                }],

        ];
    }
}
