<?php

use yii\grid\GridView;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Gestionar prestaciones';
$this->params['breadcrumbs'][] = 'Gestionar';

?>
<h1><?= $this->title ?></h1>
<?php $form = ActiveForm::begin([
    'method'=>'get',
    'action'=>['prestaciones/gestionar'],
    ]) ?>

    <?= $form->field($modelSocio, 'numero') ?>
    <?= Html::submitButton('Buscar socio', ['class'=>'btn btn-success']) ?>

<?php ActiveForm::end() ?>

<?php if (isset($socio)): ?>
    <h3>Libros prestados a <?= $socio->nombre ?></h3>

    <?= GridView::widget([
        'dataProvider'=>$dataProvider,
        'columns'=> [
            ['class'=>'yii\grid\SerialColumn'],
            'libro.codigo',
            'libro.titulo',
            'libro.num_pags',
            [
                'label'=>'Fecha de prestación',
                'attribute'=>'create_at',
                'format'=>'dateTime',
            ],
            [
                'class'=> ActionColumn::className(),
                'template'=> '{devolver}',
                'header'=>'Acciones',
                'buttons'=>[
                    'devolver'=> function ($url, $model, $key) {
                        return Html::beginForm(
                            ['prestaciones/devolver',
                            'id'=>$model->id],'post') .
                            Html::submitButton('Devolver', [
                                'class'=>'btn-xs btn-danger'
                            ]) . Html::endForm();
                    }
                ]
            ]

        ],

    ]) ?>
    <?php $form = ActiveForm::begin() ?>
        <?= $form->field($modelLibro, 'codigo') ?>
        <?= Html::submitButton('Buscar libro', ['class'=>'btn btn-success']) ?>
    <?php ActiveForm::end() ?>

<?php endif ?>
