<?php

use yii\grid\GridView;

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Socios */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Socios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="socios-view">

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
        <?= Html::a('Gestionar',['prestaciones/gestionar', 'numero'=>$model->numero], [
            'class'=>'btn btn-default',
        ])?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'numero',
            'nombre',
            'direccion',
            'telefono',
        ],
    ]) ?>
    <h3>Últimos prestamos</h3>
    <?= GridView::widget([
        'dataProvider'=>$dataProvider,
        'columns'=>[
            'libro.codigo',
            [
                'attribute'=>'libro.enlace',
                'format'=>'html',
                'label'=>'Título',
            ],
            [
                'attribute'=>'create_at',
                'format'=>'dateTime',
                'label'=>'Fecha de prestamo',
            ],
            'devolucion:dateTime',
            [
                'class'=>'yii\grid\ActionColumn',
                'template'=>'{devolver}',
                'buttons'=> [
                    'devolver'=>function ($url, $model, $key) {

                        if ($model->devolucion === null) {
                            return Html::beginForm([
                                'prestaciones/devolver', 'id'=>$model->id]

                            ) . Html::submitButton('Devolver', ['class'=>'btn-xs btn-danger'])
                            . Html::endForm();
                        }
                    }
                ]
            ],
        ]
    ]) ?>

</div>
