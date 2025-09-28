<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Редактировать книгу: ' . $form->title;
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $form->title, 'url' => ['view', 'id' => $book->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>

<div class="book-update">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php $activeForm = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $activeForm->field($form, 'title')->textInput(['maxlength' => true]) ?>

    <?= $activeForm->field($form, 'year')->textInput(['type' => 'number']) ?>

    <?= $activeForm->field($form, 'description')->textarea(['rows' => 6]) ?>

    <?= $activeForm->field($form, 'isbn')->textInput(['maxlength' => true]) ?>

    <?php if ($book->cover_image): ?>
        <div class="form-group">
            <label class="control-label">Текущая обложка:</label>
            <div>
                <img src="<?= Yii::$app->get('fileService')->getImageUrl($book->cover_image) ?>" 
                     alt="Обложка" style="max-width: 200px; max-height: 300px;">
            </div>
        </div>
    <?php endif; ?>

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
