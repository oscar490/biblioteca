<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Prestar un libro';

$this->params['breadcrumbs'][] = ['label' => 'Libros', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
 ?>
 <h1><?= $this->title ?></h1>

 <?php if ($confirmacion): ?>
        <div class='alert alert-success' role='alert'>
            Se ha completado la operación
        </div>
        <?php unset($confirmacion) ?>
<?php endif ?>

 <?php $form = ActiveForm::begin() ?>

    <?= $form->field($modelo, 'numero') ?>
    <?= $form->field($modelo, 'codigo') ?>

    <?= Html::submitButton('Prestar', ['class'=>'btn btn-success']) ?>
 <?php ActiveForm::end() ?>
