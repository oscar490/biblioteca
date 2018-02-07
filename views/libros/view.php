<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $model app\models\Libros */

$this->title = $model->titulo;
$this->params['breadcrumbs'][] = ['label' => 'Libros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="libros-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'codigo',
            'titulo',
            'num_pags',
            'autor',
        ],
    ]) ?>

    <?= GridView::widget([
        'dataProvider'=>$dataProvider,
        'columns'=>[
            'socio.numero',
            'socio.nombre',
            'create_at:dateTime',
            'devolucion:dateTime',
            [
                'class'=>'yii\grid\ActionColumn',
                'template'=>'{Gestionar}',
                'header'=>'Aciones',
                'buttons'=>[
                    'Gestionar'=> function ($url, $model, $params) {
                        return Html::beginForm(['prestaciones/gestionar',
                            'numero'=>$model->socio->numero, 'codigo'=>$model->libro->codigo
                        ])
                        . Html::submitButton('Gestionar', ['class'=>'btn-xs btn-success'])
                        . Html::endForm();

                    }
                ]

            ],
        ],

    ]) ?>


</div>
