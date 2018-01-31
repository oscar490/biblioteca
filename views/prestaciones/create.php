<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Prestaciones */

$this->title = 'Create Prestaciones';
$this->params['breadcrumbs'][] = ['label' => 'Prestaciones', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prestaciones-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
