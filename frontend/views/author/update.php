<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактировать автора: ' . $form->last_name . ' ' . $form->first_name;
$this->params['breadcrumbs'][] = ['label' => 'Авторы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $form->last_name . ' ' . $form->first_name, 'url' => ['view', 'id' => $author->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>

<div class="author-update">
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
