<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PrestacionesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Prestaciones';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prestaciones-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Prestaciones', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'libro.codigo',
            'libro.titulo',
            'socio.numero',
            'socio.nombre',
            'create_at:dateTime',
            'devolucion:dateTime',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
