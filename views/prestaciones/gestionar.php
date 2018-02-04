<?php

use app\models\Libros;
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
    <h3>Libros prestados a <?= $socio->enlace ?></h3>

    <?= GridView::widget([
        'dataProvider'=>$dataProvider,
        'columns'=> [
            ['class'=>'yii\grid\SerialColumn'],
            'libro.codigo',
            [
                'label'=>'Título',
                'attribute'=>'libro.enlace',
                'format'=>'html',
            ],
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
    <?php $form = ActiveForm::begin([
        'method'=>'get',
        'action'=>['prestaciones/gestionar'],
        ]) ?>
        <?= $form->field($modelLibro, 'codigo') ?>
        <?= Html::hiddenInput('numero', $modelSocio->numero) ?>
        <?= Html::submitButton('Buscar libro', ['class'=>'btn btn-success']) ?>
    <?php ActiveForm::end() ?>

    <?php if (isset($libro)): ?>
        <h4><?= $libro->titulo ?></h4>
        <?php if ($libro->estaPrestado):?>
            <?php
                $socio = Libros::findOne(['codigo'=>$libro->codigo])
                    ->getPrestaciones()
                    ->where(['devolucion'=>null])
                    ->one()->socio;
            ?>
            <h4>está prestada a <?= $socio->enlace?></h4>
        <?php else: ?>
            <?= Html::beginForm(
                ['prestaciones/prestar', 'numero'=>$socio->numero]
                ) ?>
                <?= Html::hiddenInput('codigo', $libro->codigo)?>
                <?= Html::submitButton('Prestar', ['class'=>'btn btn-primary']) ?>
            <?= Html::endForm() ?>
        <?php endif ?>
    <?php endif ?>
<?php endif ?>
