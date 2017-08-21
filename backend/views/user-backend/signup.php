<?php
/**
 * Created by PhpStorm.
 * User: lincoln
 * Date: 19/08/2017
 * Time: 21:53
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Create new user backend";
$this->params['breadcrumbs'][] = ['label' => 'User Backends', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title
?>

<div class="site-signup">
    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($model, 'username')->label('Username')->textInput(['autofocus' => true]) ?>
            <?= $form->field($model, 'email')->label('Email') ?>
            <?= $form->field($model, 'password')->label('Password')->passwordInput() ?>
            <?= $form->field($model, 'passwordRepeat')->label('PasswordRepeat')->passwordInput() ?>
            <div class="form-group">
                <?= Html::submitButton('Create new user backend', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
