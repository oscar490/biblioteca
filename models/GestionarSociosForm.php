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
            [
                'numero', 'buscarSocio'
            ],
            [
                ['numero'],
                'exist',
                'targetClass' => Socios::className(),
                'skipOnError' => true,
                'targetAttribute' => ['numero' => 'numero'],
                'message' => 'No existe ningún socio con ese número',
            ],
        ];
    }

    public function buscarSocio($attribute, $params, $validator)
    {
        if (!ctype_digit($this->numero)) {
            $cadena = mb_strtolower($this->numero);
            $socioBuscar = Socios::find()
                ->where(['like', 'lower(nombre)', $cadena])
                ->one();

            if ($socioBuscar !== null) {
                $this->numero = $socioBuscar->numero;
            } else {
                $this->addError($attribute, 'No existe ese socio');
            }
        }
    }

    public function formName()
    {
        return '';
    }

    public function attributeLabels()
    {
        return [
            'numero' => 'Número de socio:',
        ];
    }
}
