<?php

use yii\helpers\Html;

$this->title = $book->title;
$this->params['breadcrumbs'][] = ['label' => 'Книги', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="book-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-md-4">
            <?php if ($book->cover_image): ?>
                <img src="<?= Yii::$app->get('fileService')->getImageUrl($book->cover_image) ?>" 
                     class="img-fluid" alt="Обложка" style="max-width: 200px;">
            <?php else: ?>
                <div class="text-muted">Обложка не загружена</div>
            <?php endif; ?>
        </div>
        <div class="col-md-8">
            <p><strong>Год выпуска:</strong> <?= $book->getFormattedYear() ?></p>
            <p><strong>ISBN:</strong> <?= Html::encode($book->isbn) ?></p>
            <p><strong>Авторы:</strong> <?= Html::encode($book->getAuthorsNames()) ?></p>
            <p><strong>Описание:</strong></p>
            <p><?= nl2br(Html::encode($book->description)) ?></p>
        </div>
    </div>

    <div class="form-group">
        <?= Html::a('Редактировать', ['update', 'id' => $book->id], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $book->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить эту книгу?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Назад к списку', ['index'], ['class' => 'btn btn-default']) ?>
    </div>
</div>
