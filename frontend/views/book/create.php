<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Добавить книгу';
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="book-create">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $activeForm = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $activeForm->field($form, 'title')->textInput(['maxlength' => true]) ?>

    <?= $activeForm->field($form, 'year')->textInput(['type' => 'number']) ?>

    <?= $activeForm->field($form, 'description')->textarea(['rows' => 6]) ?>

    <?= $activeForm->field($form, 'isbn')->textInput(['maxlength' => true]) ?>

    <?= $activeForm->field($form, 'cover_image')->fileInput() ?>

    <?php
    $authorsList = [];
    foreach ($authors as $author) {
        $authorsList[$author->id] = $author->fullName;
    }
    ?>
    <?= $activeForm->field($form, 'authorIds')->checkboxList(
        $authorsList,
        ['separator' => '<br>']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
