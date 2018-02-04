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
                'numero', function ($attribute, $params, $validator) {
                    if (!ctype_digit($this->numero)) {
                        if (Socios::findOne(['nombre' => $this->numero]) !== null) {
                            $this->numero = Socios::findOne(['nombre' => $this->numero])
                                ->numero;
                        } else {
                            $this->addError($attribute, 'No existe ese socio');
                        }
                    }
                },
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
