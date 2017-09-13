<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Bmi */

$this->title = 'Create Bmi';
$this->params['breadcrumbs'][] = ['label' => 'Bmis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bmi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
