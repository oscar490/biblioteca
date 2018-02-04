<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\grid\DataColumn;

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

            'codigo',
            'titulo',
            'num_pags',
            'autor',
        ],
    ]) ?>

    <hr>

    <h3>Últimos prestamos</h3>
    <?= GridView::widget([
        'dataProvider'=>$dataProvider,
        'columns' => [
            'socio.numero',
            [
                'label'=>'Nombre',
                'attribute'=>'socio.enlace',
                'format'=>'html',
            ],
            // 'create_at:dateTime',
            [
                'attribute'=>'create_at',
                'format'=>'dateTime',
                'label'=>'Fecha de prestamo',
            ],
            'devolucion:dateTime',
        ]

    ]) ?>

</div>
