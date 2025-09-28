<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Добавить автора';
$this->params['breadcrumbs'][] = ['label' => 'Авторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="author-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $activeForm = ActiveForm::begin(); ?>

    <?= $activeForm->field($form, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $activeForm->field($form, 'last_name')->textInput(['maxlength' => true]) ?>

    <?= $activeForm->field($form, 'middle_name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
