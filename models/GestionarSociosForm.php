<?php

namespace app\models;

use yii\base\Model;

class GestionarSociosForm extends Model
{
    public $numero;

    public function rules()
    {
        return [
            [['numero'], 'required'],
            [['numero'], 'integer'],
            [
                ['numero'],
                'exist',
                'targetClass' => Socios::className(),
                'targetAttribute' => ['numero' => 'numero'],
                'message' => 'No existe ningún socio con ese número',
            ],
        ];
    }

    public function formName()
    {
        return '';
    }
}
